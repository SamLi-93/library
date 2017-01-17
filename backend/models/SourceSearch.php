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


class SourceSearch extends Source
{

    public function rules()
    {
        return [
            [['id', 'digest', 'show_cover_pic', 'status'], 'integer'],
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
        $list = Source::find()->andFilterWhere([
            'digest' => $this->digest,
            'show_cover_pic' => $this->show_cover_pic,
            'status' => $this->status,
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