<?php
/**
 * Created by PhpStorm.
 * User: PZW
 * Date: 2017/1/5
 * Time: 16:26
 */

namespace backend\controllers;


use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use app\models\UploadForm;
use yii\data\SqlDataProvider;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use app\models\Source;
use app\models\Material;
//微信框架引入方式
include dirname(dirname(__FILE__)).'/libs/LaneWeChat/lanewechat.php';
include dirname(dirname(__FILE__)).'/libs/LaneWeChat/core/source.lib.php';
include dirname(dirname(__FILE__)).'/libs/LaneWeChat/core/templatemessage.lib.php';
include dirname(dirname(__FILE__)).'/libs/LaneWeChat/core/advancedbroadcast.lib.php';
include dirname(dirname(__FILE__)).'/libs/LaneWeChat/core/responseinitiative.lib.php';
include dirname(dirname(__FILE__)).'/libs/LaneWeChat/core/usermanage.lib.php';
class SourceController extends Controller
{

    public function behaviors()
    {
        return [
        ];
    }
    public $enableCsrfValidation = false;

    function actionIndex(){
        $this->layout = 'main';
        $query = Yii::$app->request->queryParams;
        $sql = "select * from wechat_source where isdeleted = 0 order by id desc";

        $command = Yii::$app->db->createCommand('SELECT COUNT(*) FROM wechat_source  order by id desc');
        $count = $command->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 15,
            ],
            'sort' => [
                'attributes' => [
                    'id',
                ],
            ],
        ]);

        GridView::widget([
            'dataProvider' => $dataProvider,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'query' => $query
        ]);
    }

    public function actionCreate()
    {
        $this->layout = 'main';
        $model = new Source();
        $type = "image";
        $offset = "0";//开始取的地址
        $count = "10";//获取数量个数
        $data = [];
        /*$list = \LaneWeChat\Core\Media::getmateriallist($type,$offset,$count);
        $data = ['-1'=>'暂无'];
        if(!empty($list['item'])){
            $data = [];
            foreach ($list['item'] as $key => $value) {
                # code...
                $mediaid = $value['media_id'];
                $name = $value['name'];
                $data[$mediaid] = $name;
            }
        }*/
        if (!empty(Yii::$app->request->post())) {
            $params = Yii::$app->request->post();
            //$media_id = $params['Source']['thumb_media_id'];
            //如果缩略图不为空，就生成永久素材
            if(!empty($_FILES['Source']['name']['file'])){
                $model->file = UploadedFile::getInstance($model, 'file');
                if ($model->file && $model->validate()) {
                    //文件绝对地址
                    $url = Yii::$app->basePath .'/uploads/' . $model->file->baseName .'-'.time(). '.' . $model->file->extension;
                    $model->file->saveAs($url);
                    $type = 'image';//图片（image）、语音（voice）、视频（video）和缩略图（thumb）
                    $upload = \LaneWeChat\Core\Media::addmaterial($url,$type);
                    //$media_id = $upload['media_id'];
                    if(is_file($url)){
                        //删除上传的图片
                        unlink($url);
                    }
                    if(!empty($upload['url'])){
                        //return $this->redirect(['/source/index']);
                        $media_id = $upload['media_id'];
                    }

                }
                $sql = "INSERT  INTO wechat_source (title,author,thumb_media_id,show_cover_pic,content,content_source_url,time)
                    values('".$params['Source']['title']."','".$params['Source']['author']."','".$media_id."','".$params['Source']['show_cover_pic']."','".$params['Source']['content']."','".$params['Source']['content_source_url']."',".time().")";

                $command = Yii::$app->db->createCommand($sql);
                $count = $command->execute();
                if($count){
                    return $this->redirect(['/source/index']);
                }
            }
        }
        return $this->render('create', [
            'model' => $model,
            'list' => $data
        ]);
    }
    public function actionCreate2()
    {
        $this->layout = 'main';
        $model = new Source();
        $conn = Yii::$app->db;
        $command = $conn->createCommand("select * from wechat_source where isdeleted=0 order by id desc");
        $data = $command->queryAll();
        foreach ($data as $key => $value) {
            $array[$value['id']] = $value;
        }
        if (!empty(Yii::$app->request->post())) {
            $params = Yii::$app->request->post();
            $list = [];
            foreach ($params['id'] as $key => $value) {
                $list[] = $array[$value];
            }
            $id_str = implode($params['id'], ',');
            if(count($list)>0){
                $news = \LaneWeChat\Core\Media::addnews($list);
                if(!empty($news['media_id'])&&$params['type']==1){
                    $users = \LaneWeChat\Core\UserManage::getFansList();
                    $userlist = $users['data']['openid'];
                    $result = \LaneWeChat\Core\AdvancedBroadcast::sentNewsByOpenId($userlist,$news['media_id']);
                    //if($result)
                    if($result['errcode']==0){
                        $id_str = implode($params['id'], ',');
                        $command = $conn->createCommand("update wechat_source set status = 1 where id in(".$id_str.")");
                        $data = $command->execute();
                    }
                }
                return $this->redirect(['/source/index',]);
            }
        }
        return $this->render('create2', [
            'model' => $model,
            'list' => $data
        ]);
    }
    public function actionDelete()
    {
        $query = Yii::$app->request->queryParams;
        $id = $query['id'];
        $data = Source::findOne($id);
        $data->isdeleted = 1;
        $data->save();
        return $this->redirect(['/source/index']);
    }
    //发送给所有用户消息
    public function actionSend()
    {
        $query = Yii::$app->request->queryParams;
        $id = $query['id'];
        //根据openid发送图文消息
        if(!empty($id)){
            $users = \LaneWeChat\Core\UserManage::getFansList();
            $userlist = $users['data']['openid'];
            \LaneWeChat\Core\AdvancedBroadcast::sentNewsByOpenId($userlist,$id);
        }
        //群发所有人图文消息，测试账号无此功能
        /*if(!empty($id)){
            \LaneWeChat\Core\AdvancedBroadcast::sentNewsByGroup('',$id,true);
        }*/
        return $this->redirect(['/source/index']);
    }
    function actionAdd(){
        $model = new UploadForm();
        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file && $model->validate()) {
                //文件绝对地址
                $url = Yii::$app->basePath .'/uploads/' . $model->file->baseName .'-'.time(). '.' . $model->file->extension;
                $model->file->saveAs($url);
                $type = "images";//图片（image）、语音（voice）、视频（video）和缩略图（thumb）
                $upload = \LaneWeChat\Core\Media::upload($url,$type);
                print_r($upload);
                $media_id = $upload['media_id'];
                if(is_file($url)&&!empty($upload['type'])){
                    unlink($url);
                }
            }

        }

        return $this->render('upload', ['model' => $model]);
        exit;
    }
    //获取永久素材列表
    function actionList()
    {
        $type = "image";
        $offset = "0";//开始取的地址
        $count = "10";//获取数量个数
        $list = \LaneWeChat\Core\Media::getmateriallist($type,$offset,$count);
        print_r($list);
        return $this->render('list', ['list' => $list]);
    }
    
    function actionGetcount(){
        
        $list = \LaneWeChat\Core\Media::getmaterialcount();
        print_r($list);
    }
    //上传永久素材
    function actionUpload(){
        $model = new UploadForm();
        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file && $model->validate()) {
                //文件绝对地址
                $url = Yii::$app->basePath .'/uploads/' . $model->file->baseName .'-'.time(). '.' . $model->file->extension;
                $model->file->saveAs($url);
                $type = "images";//图片（image）、语音（voice）、视频（video）和缩略图（thumb）
                $upload = \LaneWeChat\Core\Media::addmaterial($url,$type);
                print_r($upload);
                $media_id = $upload['media_id'];
                if(is_file($url)&&!empty($upload['type'])){
                    unlink($url);
                }
            }

        }

        return $this->render('upload', ['model' => $model]);
        exit;
    }
    //新增图文素材
    function actionAddnew(){
        //AdvancedBroadcast方法uploadNews应该也行,各个文档出入不一样，之前没找到
        $arr['title'] = "今天下雨怎么办？";
        $arr['thumb_media_id'] = "MioxTj3w38DfGqtyX8xzxZ070mBsYUFiiFDVrgWQQBk";
        $arr['author'] = "潘智伟";
        $arr['digest'] = "";
        $arr['show_cover_pic'] = "1";
        $arr['content'] = "<html><a href='http://www.baidu.com'>这是一个链接</a></html>";
        $arr['content_source_url'] = "http://www.baidu.com";
        $list[] = $arr;
        $arr['title'] = "今天晴天怎么办？";
        $arr['thumb_media_id'] = "MioxTj3w38DfGqtyX8xzxZ070mBsYUFiiFDVrgWQQBk";
        $arr['author'] = "潘智伟";
        $arr['digest'] = "";
        $arr['show_cover_pic'] = "1";
        $arr['content'] = "<html><a href='http://www.baidu.com'>这是一个链接</a></html>";
        $arr['content_source_url'] = "http://www.baidu.com";
        $list[] = $arr;
        $news = \LaneWeChat\Core\Media::addnews($list);
        print_r($news);
        exit;
    }
    //发送图文消息，目前只能对列表群发送，测试账号没有全部发送的权限
    function actionSendall(){
        $mediaId = "MioxTj3w38DfGqtyX8xzxbD_zOnDu0KrFkj12TjEKPs -bE";
        $isToAll = true;
        $userlist = array("oNN3kvk_ZDt9hqa8L7cYUw23pk58","oNN3kvk_ZDt9hqa8L7cYUw23pk58");
        $news = \LaneWeChat\Core\AdvancedBroadcast::sentNewsByOpenId($userlist,$mediaId);
        print_r($news);
        exit;
    }
    function actionSendimage(){
       $result = \LaneWeChat\Core\ResponseInitiative::image('oNN3kvp7ENO9WZtJzRah2iy3N6rU','MioxTj3w38DfGqtyX8xzxZ070mBsYUFiiFDVrgWQQBk');
        print_r($result);
    }
}