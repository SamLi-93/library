<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2016/9/29
 * Time: 16:19
 */

namespace backend\controllers;


use app\models\LoginForm;
use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{
    public $defaultAction = 'login';

    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        var_dump($user); exit;
    }

    public function actionLogin()
    {
        $this->layout = "default";

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['project/index']);
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }

    }

    public function actionLogout()
    {
        Yii::$app->cache->flush();
        Yii::$app->user->logout();

        echo json_encode(array('ok' => 1));
        return $this->redirect(['login']);

    }
}