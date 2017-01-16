<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2017/1/4
 * Time: 下午9:11
 */

namespace backend\controllers;


use app\models\LectureBook;
use app\models\SmsAdmin;
use Yii;
use app\models\Teacher;
use app\models\VideoMaking;
use app\models\Project;
use app\models\ProjectSearch;
use yii\data\SqlDataProvider;
use yii\web\Controller;
use yii\grid\GridView;

class LectureorderController extends Controller
{

    public function init()
    {
        parent::init();
    }

    public function actionIndex()
    {
        $this->layout = 'main';
        $model = new LectureBook();
        $query = Yii::$app->request->queryParams;
        $sql_parms = '';
        if (!empty($query['LectureBook'])) {
            $query_parms = array_filter($query['LectureBook']);
            $sql_parms = 'where true';
        }

        if (isset($query_parms['lecture_id'])) {
            $sql_parms .= " and id = '" . $query_parms['lecture_id'] . "'";
        }

        $sql = "select id,lecture_id,readercode,datetime from lecture_book " . $sql_parms . " order by id desc";

        $command = Yii::$app->db->createCommand('SELECT COUNT(id) FROM lecture_book ' . $sql_parms);
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
        $model = new LectureBook();
        if (!empty(Yii::$app->request->post())) {
        $params = Yii::$app->request->post();
        //如果缩略图不为空，就生成永久素材
        $model->setAttributes([
            'lecture_id' => $params['LectureBook']['lecture_id'],
            'readercode' => $params['LectureBook']['readercode'],
            'datetime' => $params['LectureBook']['datetime'],
            'is_delete' => 0,
        ]);
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
        $model = Project::findOne($id);
        $model['time'] = date('Y-m-d',$model['time']);
        $model['endtime'] = date('Y-m-d',$model['endtime']);

        if (!empty(Yii::$app->request->post())) {
            $params = Yii::$app->request->post();
            $model->setAttributes([
                'projectname' => $params['Project']['projectname'],
                'school' => $params['Project']['school'],
                'over' => $params['Project']['over'],
                'free' => $params['Project']['free'],
                'teacher' => $params['Project']['teacher'],
                'time' => strtotime($params['Project']['time']),
                'endtime' => strtotime($params['Project']['endtime']),
                'original_path' => $params['Project']['original_path'],
                'making_path' => $params['Project']['making_path'],
                'uploadname' => $params['Project']['uploadname'],
                'is_neibu' => $params['Project']['is_neibu'],
            ]);
        }

        if (!empty(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->cache->delete('index');
            return $this->redirect(['index']);
        } else {
            return $this->render('edit', [
                'model' => $model,
                'person_list' => $this->person_list,
            ]);
        }
    }

    public function actionDelete()
    {
        $query = Yii::$app->request->queryParams;
        $id = $query['id'];
        $data = Project::findOne($id);
        $data->delete();

        Yii::$app->cache->delete('index');
        return $this->redirect(['index']);
    }

    public function actionChangeover()
    {
        $query = Yii::$app->request->post();
        $id = $query['id'];
        $value = $query['value'];
        $model = Project::findOne($id);
        $model->over = $value;
        if ($model->save()) {
            Yii::$app->cache->delete('index');
            return $this->redirect(['index']);
        } else {
            return \Yii::$app->getSession()->setFlash('error', '修改失败');
        }
    }

    public function actionChangefree()
    {
        $query = Yii::$app->request->post();
        $id = $query['id'];
        $value = $query['value'];
        $model = Project::findOne($id);
        $model->free = $value;
        if ($model->save()) {
            Yii::$app->cache->delete('index');
            return $this->redirect(['index']);
        } else {
            return \Yii::$app->getSession()->setFlash('error', '修改失败');
        }
    }
}