<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pic".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $pid
 * @property string $name
 * @property string $path
 * @property integer $check1
 */
class Pic extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pic';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'pid', 'check1','cid'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['path'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'pid' => 'Pid',
            'name' => 'Name',
            'path' => 'Path',
            'check1' => 'Check1',
        ];
    }
}
