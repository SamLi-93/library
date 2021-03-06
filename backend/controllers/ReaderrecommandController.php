<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2017/1/4
 * Time: 下午9:07
 */

namespace backend\controllers;


use app\models\SmsAdmin;
use Yii;
use app\models\Teacher;
use app\models\VideoMaking;
use app\models\Project;
use app\models\ProjectSearch;
use yii\data\SqlDataProvider;
use yii\web\Controller;
use yii\grid\GridView;

class ReaderrecommandController extends Controller
{

    public function beforeAction($action)
    {
        if (empty(Yii::$app->user->identity)) {
            return $this->redirect(['/default/login']);
        }
        echo $test;exit;
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    public function init()
    {
        parent::init();
    }

    public function actionTest()
    {


    }

    public function actionIndex()
    {
        $this->layout = 'main';
        $searchModel = new ProjectSearch();
        $query = Yii::$app->request->queryParams;
        $sql_parms = '';
        if (!empty($query['ProjectSearch'])) {
            $query_parms = array_filter($query['ProjectSearch']);
            $sql_parms = 'where true';
//            var_dump($query_parms);
        }

        if (isset($query_parms['projectname'])) {
            $sql_parms .= " and id = '" . $query_parms['projectname'] . "'";
        }

        if (isset($query_parms['school'])) {
            $sql_parms .= " and school = '" . $query_parms['school'] . "'";
        }

        if (isset($query_parms['teacher'])) {
            $sql_parms .= " and teacher = '" . $query_parms['teacher'] . "'";
        }

        if (isset($query_parms['is_neibu'])) {
            if ($query_parms['is_neibu'] == 2) {
                $query_parms['is_neibu'] = 0;
            }
            $sql_parms .= " and is_neibu = '" . $query_parms['is_neibu'] . "'";
        }

        if (isset($query_parms['over'])) {
            if ($query_parms['over'] == 2) {
                $query_parms['over'] = 0;
            }
            $sql_parms .= " and over = '" . $query_parms['over'] . "'";
        }

        $sql = "select * from project " . $sql_parms . " order by id desc";

        $command = Yii::$app->db->createCommand('SELECT COUNT(*) FROM project ' . $sql_parms);
        $command->bindParam(':projectname', $projectname);
        $command->bindParam(':school', $school);
        $command->bindParam(':teacher', $teacher);
        $command->bindParam(':over', $over);
        $count = $command->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
//            'params' => [':status' => 1],
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
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pro_projectname' => $this->pro_projectname,
            'pro_school' => $this->pro_school,
            'pro_teacher' => $this->teacher_list,
            'pro_over' => $this->pro_over,
            'query' => $query,
        ]);
    }

    public function actionCreate()
    {
        $this->layout = 'main';
        $model = new Project();
        $model->uploadname = Yii::$app->user->identity->name;
//        $list = SmsAdmin::findBySql("SELECT name FROM sms_admin")->all();
//        foreach ($list as $k => $v) {
//            $key = $v['name'];
//            $uploadname_list[$key] = $v['name'];
//        }
//        print_r($uploadname_list);exit;
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
            return $this->render('create', [
                'model' => $model,
                'pro_projectname' => $this->pro_projectname,
                'pro_school' => $this->pro_school,
                'pro_teacher' => $this->teacher_list,
                'pro_over' => $this->pro_over,
                'uploadname_list' => $this->person_list,
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