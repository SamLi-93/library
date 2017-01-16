<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "shoot_pic".
 *
 * @property integer $id
 * @property string $name
 * @property string $path
 * @property integer $shoot_id
 */
class ShootPic extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shoot_pic';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'path', 'shoot_id'], 'required'],
            [['shoot_id'], 'integer'],
            [['name', 'path'], 'string', 'max' => 100],
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
            'path' => 'Path',
            'shoot_id' => 'Shoot ID',
        ];
    }
}
