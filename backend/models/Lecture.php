<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lecture".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $speaker
 * @property integer $datetime
 * @property string $address
 */
class Lecture extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lecture';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['datetime'], 'required'],
            [['title', 'address'], 'string', 'max' => 255],
            [['speaker'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'content' => '描述',
            'speaker' => '讲座人',
            'datetime' => '讲座时间',
            'address' => '讲座地点',
        ];
    }
}
