<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lecture_book".
 *
 * @property integer $id
 * @property integer $lecture_id
 * @property string $readercode
 * @property integer $datetime
 */
class LectureBook extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lecture_book';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lecture_id', 'readercode', 'datetime'], 'required'],
            [['lecture_id', 'datetime'], 'integer'],
            [['readercode'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lecture_id' => '讲座标题',
            'readercode' => '预定人的读者证',
            'datetime' => '预定时间',
        ];
    }
}
