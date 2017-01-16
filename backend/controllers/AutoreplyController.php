<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2017/1/4
 * Time: 下午9:16
 */

namespace backend\controllers;

use app\models\IndexKeywords;
use app\models\SmsAdmin;
use Yii;
use yii\base\Exception;
use yii\data\SqlDataProvider;
use yii\web\Controller;
use yii\grid\GridView;
use yii\web\UploadedFile;

include dirname(dirname(__FILE__)).'/libs/LaneWeChat/lanewechat.php';
include dirname(dirname(__FILE__)).'/libs/LaneWeChat/core/source.lib.php';
include dirname(dirname(__FILE__)).'/libs/LaneWeChat/core/templatemessage.lib.php';
include dirname(dirname(__FILE__)).'/libs/LaneWeChat/core/advancedbroadcast.lib.php';
include dirname(dirname(__FILE__)).'/libs/LaneWeChat/core/usermanage.lib.php';

class AutoreplyController extends Controller
{
//    public function beforeAction($action)
//    {
//        if (empty(Yii::$app->user->identity)) {
//            return $this->redirect(['/default/login']);
//        }
//        return parent::beforeAction($action); // TODO: Change the autogenerated stub
//    }

    public function init()
    {
        parent::init();
    }

    public function actionIndex()
    {
        $this->layout = 'main';
        $model = new IndexKeywords();
        $query = Yii::$app->request->queryParams;
        $sql_parms = '';
        if (!empty($query['IndexKeywords'])) {
            $query_parms = array_filter($query['IndexKeywords']);
            $sql_parms = 'where true';
        }

        if (isset($query_parms['keyword'])) {
            $sql_parms .= " and id = '" . $query_parms['keyword'] . "'";
        }

        $sql = "select * from index_keywords " . $sql_parms . " order by id desc";

        $command = Yii::$app->db->createCommand('SELECT COUNT(*) FROM index_keywords ' . $sql_parms);
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
            'searchModel' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $this->layout = 'main';
        $model = new IndexKeywords();
        if (!empty(Yii::$app->request->post())) {
            $params = Yii::$app->request->post();
            //如果缩略图不为空，就生成永久素材
            $url = null;
            $media_id = null;
            $model->imageFiles = UploadedFile::getInstance($model, 'imageFiles');
            if (!empty($model->imageFiles)){
                if ($model->imageFiles && $model->validate()) {
                    //文件绝对地址
                    $url = Yii::$app->basePath .'/uploads/' . $model->imageFiles->baseName.'-'.time(). '.' . $model->imageFiles->extension;
                    $model->imageFiles->saveAs($url);
                    $type = 'image';//图片（image）、语音（voice）、视频（video）和缩略图（thumb）
                    $upload = \LaneWeChat\Core\Media::addmaterial($url,$type);
                    //$media_id = $upload['media_id'];
//                    if(is_file($url)){
//                        //删除上传的图片
//                        unlink($url);
//                    }
                    if(!empty($upload['url'])){
                        //return $this->redirect(['/source/index']);
                        $media_id = $upload['media_id'];
                    }
                    $model->setAttributes([
                        'keyword' => $params['IndexKeywords']['keyword'],
                        'reply_type' => $params['IndexKeywords']['reply_type'],
                        'content' => $params['IndexKeywords']['content'],
                        'pic_path' => $url,
                        'title' => $params['IndexKeywords']['title'],
                        'summary' => $params['IndexKeywords']['summary'],
                        'url' => $params['IndexKeywords']['content'],
                        'media_id' => $media_id,
                        'is_delete' => 0,
                    ]);
                }
            } else {
                $model->setAttributes([
                    'keyword' => $params['IndexKeywords']['keyword'],
                    'reply_type' => $params['IndexKeywords']['reply_type'],
                    'content' => $params['IndexKeywords']['content'],
                    'is_delete' => 0,
                ]);
            }
        }

        if (!empty(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->cache->delete('index');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');
        $model = IndexKeywords::findOne($id);
        $model['imageFiles'] = $model['pic_path'];
        $pic_old_path = $model['pic_path'];

        if (!empty(Yii::$app->request->post())) {
            $params = Yii::$app->request->post();
            //如果缩略图不为空，就生成永久素材
            $url = null;
            $media_id = null;
            $is_unlink = null;
            $reply_type = null;
            $is_unlink = $model->imageFiles = UploadedFile::getInstance($model, 'imageFiles');
            if (!empty($model->imageFiles)){
                if ($model->imageFiles && $model->validate()) {
                    //文件绝对地址
                    $url = Yii::$app->basePath .'/uploads/' . $model->imageFiles->baseName.'-'.time(). '.' . $model->imageFiles->extension;
                    $model->imageFiles->saveAs($url);
                    $type = 'image';//图片（image）、语音（voice）、视频（video）和缩略图（thumb）
                    $upload = \LaneWeChat\Core\Media::addmaterial($url,$type);
                    if(!empty($upload['url'])){
                        $media_id = $upload['media_id'];
                    }
                    $reply_type = $params['IndexKeywords']['reply_type'];
                    $model->setAttributes([
                        'keyword' => $params['IndexKeywords']['keyword'],
                        'reply_type' => $params['IndexKeywords']['reply_type'],
                        'content' => $params['IndexKeywords']['content'],
                        'pic_path' => $url,
                        'url' => $params['IndexKeywords']['content'],
                        'title' => $params['IndexKeywords']['title'],
                        'summary' => $params['IndexKeywords']['summary'],
                        'media_id' => $media_id,
                        'is_delete' => 0,
                    ]);
//                    print_r($model);exit;
                }
            } else {
                $model->setAttributes([
                    'keyword' => $params['IndexKeywords']['keyword'],
                    'reply_type' => $params['IndexKeywords']['reply_type'],
                    'content' => $params['IndexKeywords']['content'],
                    'is_delete' => 0,
                ]);
//                var_dump(33);exit;
            }
        }

        if (!empty(Yii::$app->request->post()) && $model->save()) {
            if ($reply_type == 2 || $reply_type == 3 && $is_unlink && file_exists($pic_old_path)) {
                unlink($pic_old_path);
            }
            Yii::$app->cache->delete('index');
            return $this->redirect(['index']);
        } else {
            return $this->render('edit', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete()
    {
        $query = Yii::$app->request->queryParams;
        $id = $query['id'];
        $data = IndexKeywords::findOne($id);
        if(file_exists($data['pic_path'])) {
            unlink($data['pic_path']);
        }
        $data->delete();
        Yii::$app->cache->delete('index');
        return $this->redirect(['index']);
    }
}