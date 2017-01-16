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
class MaterialController extends Controller
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
        $post = Yii::$app->request->post();
        $type = "image";
        if(!empty($post['type'])) $type = $post['type'];
        $offset = "0";//开始取的地址
        $count = "10";//获取数量个数
        $list = \LaneWeChat\Core\Media::getmateriallist($type,$offset,$count);
        $data = [];
        $type_arr = ['image'=>'图片','video'=>'视频','voice'=>'语音','news'=>'图文消息'];
        $error = "";
        if(!empty($list['errcode'])&&$list['errcode']==45009){
            $error = "请求次数过多";
        }else{
            $data = $list['item'];
        }
        switch ($type) {
            case 'image':
                return $this->render('image', [
                    'data' => $data,
                    'query' => $query,
                    'type_arr' => $type_arr,
                    'type' => $type,
                    'error' => $error
                ]);
                break;
            case 'news':
                return $this->render('news', [
                    'data' => $data,
                    'query' => $query,
                    'type_arr' => $type_arr,
                    'type' => $type,
                    'error' => $error
                ]);
                break;
            default:
                # code...
                break;
        }
        
    }
    public function actionCreate()
    {
        $this->layout = 'main';
        $model = new Material();
        $type_arr = ['image'=>'图片','voice'=>'语音','video'=>'视频'];
        $error = "";
        if (!empty(Yii::$app->request->post())) {
            $params = Yii::$app->request->post();
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file && $model->validate()) {
                //文件绝对地址
                $url = Yii::$app->basePath .'/uploads/' . $model->file->baseName .'-'.time(). '.' . $model->file->extension;
                $model->file->saveAs($url);
                $type = $params['Material']['type'];//图片（image）、语音（voice）、视频（video）和缩略图（thumb）
                $upload = \LaneWeChat\Core\Media::addmaterial($url,$type);
                //$media_id = $upload['media_id'];
                if(is_file($url)){
                    //删除上传的图片
                    unlink($url);
                }
                if(!empty($upload['url'])){
                    return $this->redirect(['/source/index']);
                }else{
                    $error = "<script>alert('上传失败')</script>";
                }

            }
        }

     
        return $this->render('create', [
            'model' => $model,
            'type_arr' => $type_arr,
            'error' => $error
        ]);
    }

    public function actionDelete()
    {
        $query = Yii::$app->request->queryParams;
        $id = $query['id'];
        echo $id;
        $result = \LaneWeChat\Core\Media::delete($id);
        print_r($result);
        //return $this->redirect(['/source/index']);
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
        $mediaId = "MioxTj3w38DfGqtyX8xzxbfpwO_Fzo2BDWqxP7L_jzw";
        $isToAll = true;
        $userlist = array("oNN3kvk_ZDt9hqa8L7cYUw23pk58","oNN3kvp7ENO9WZtJzRah2iy3N6rU");
        $news = \LaneWeChat\Core\AdvancedBroadcast::sentNewsByOpenId($userlist,$mediaId);
        print_r($news);
        exit;
    }
    //发送图片给所有用户消息
    public function actionSendimage()
    {
        $query = Yii::$app->request->queryParams;
        $id = $query['id'];
        //根据openid发送图文消息
        if(!empty($id)){
            $users = \LaneWeChat\Core\UserManage::getFansList();
            $userlist = $users['data']['openid'];
            \LaneWeChat\Core\AdvancedBroadcast::sentImageByOpenId($userlist,$id);
        }
        //群发所有人图片消息，测试账号无此功能
        /*if(!empty($id)){
            \LaneWeChat\Core\AdvancedBroadcast::sentImageByGroup('',$id,true);
        }*/
        return $this->redirect(['/source/index']);
    }

}