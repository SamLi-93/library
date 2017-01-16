<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project".
 *
 * @property integer $id
 * @property string $projectname
 * @property string $school
 * @property integer $over
 * @property integer $free
 * @property string $teacher
 * @property integer $time
 * @property integer $is_neibu
 * @property integer $endtime
 * @property string $original_path
 * @property string $making_path
 * @property string $uploadname
 * @property integer $pid
 */
class Material extends \yii\db\ActiveRecord
{
    public $file;
    public $type;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wechat_material';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file' => '文件',
            'type' => '类型'
        ];
    }

}
