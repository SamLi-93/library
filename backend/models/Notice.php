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
class Notice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wechat_notice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'date'], 'integer'],
            [['memo','title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'date',
            'memo' => 'memo',
            'title' => 'title',
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $this->load($params);
        $list = Notice::find()->andFilterWhere([
            'title' => $this->title
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
