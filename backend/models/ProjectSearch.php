<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2016/9/30
 * Time: 10:46
 */

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;


class ProjectSearch extends Project
{

    public function rules()
    {
        return [
            [['id', 'over', 'free', 'time', 'endtime'], 'integer'],
            [['projectname', 'school', 'teacher'], 'safe'],
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
        $list = Project::find()->andFilterWhere([
            'projectname' => $this->projectname,
            'school' => $this->school,
            'teacher' => $this->teacher,
            'over' => $this->over,
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