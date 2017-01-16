<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2016/10/11
 * Time: 14:06
 */

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

class VideoShootSearch extends VideoShoot
{
    public function rules()
    {
        return [
            [['id',  'time', 'time1','capture_time', 'seat', ], 'integer'],
            [['projectname', 'school', 'courcename'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        //$query = Menu::find();
        $this->load($params);
        $list = VideoShoot::find()->andFilterWhere([
            'projectname' => $this->projectname,
            'school' => $this->school,
            'teacher' => $this->teacher,
        ]);
        //print_r($list);
        $dataProvider = new ArrayDataProvider([
            'allModels' => $list,
        ]);


        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        return $dataProvider;
    }

}