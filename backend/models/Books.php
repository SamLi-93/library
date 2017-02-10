<?php

namespace app\models;

use Yii;
use yii\base\Model;
/**
 * This is the model class for table "wechat_books".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $type
 * @property integer $push
 * @property integer $status
 * @property integer $s_id
 */
class Books extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wechat_books';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'push', 'status', 's_id', 'time'], 'integer'],
            [['name', 'description'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'type' => 'Type',
            'push' => 'Push',
            'status' => 'Status',
            's_id' => 'S ID',
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
        $list = Books::find()->andFilterWhere([
            'name' => $this->name,
            'status' => $this->status
        ]);
        $dataProvider = new ArrayDataProvider([
            'allModels' => $list,
        ]);
        if (!$this->validate()) {
            return $dataProvider;
        }
        return $dataProvider;
    }
}
