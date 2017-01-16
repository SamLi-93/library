<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "teacher".
 *
 * @property integer $id
 * @property string $college
 * @property string $teacher
 * @property integer $sex
 * @property string $phone
 * @property string $qq
 * @property string $mail
 * @property string $remarks
 * @property string $uploadname
 */
class Teacher extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'teacher';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sex'], 'integer'],
            [['college', 'teacher', 'qq', 'mail', 'remarks', 'uploadname'], 'string', 'max' => 100],
            ['phone', 'string', 'length'=> 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'college' => '学校 *',
            'teacher' => '讲师 *',
            'sex' => '性别 *',
            'phone' => '电话号码',
            'qq' => 'qq或邮箱',
            'mail' => 'Mail',
            'remarks' => '备注',
            'uploadname' => 'Uploadname',
        ];
    }

    public function getTeacherList()
    {
        $list = self::findBySql('select DISTINCT teacher from teacher')->all();
        $teacher_list = [];
        foreach ($list as $k => $v) {
            $key = $v['teacher'];
            $teacher_list[$key] = $v['teacher'] ;
        }
        return $teacher_list;
    }

}
