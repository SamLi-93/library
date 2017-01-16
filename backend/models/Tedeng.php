<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tedeng".
 *
 * @property integer $id
 * @property string $openid
 * @property integer $activity_id
 */
class Tedeng extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tedeng';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activity_id'], 'required'],
            [['activity_id'], 'integer'],
            [['openid'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'openid' => 'Openid',
            'activity_id' => 'Activity ID',
        ];
    }
}
