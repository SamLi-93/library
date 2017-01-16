<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sms_admin".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $name
 * @property integer $gender
 * @property integer $orgid
 * @property integer $update_date
 * @property integer $isdelete
 */
class SmsAdminNoAuth extends \yii\db\ActiveRecord
{
    public $passwordRepeat;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sms_admin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gender', 'orgid', 'isdelete'], 'integer'],
            [['username', 'name'], 'string', 'max' => 30],
            [['password'], 'string', 'max' => 32,'min'=>6],
            ['passwordRepeat', 'required'], // 必须要加上这一句
            ['passwordRepeat', 'compare', 'compareAttribute' => 'password', 'operator' => '===']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'password' => '密码',
            'passwordRepeat' => '密码',
            'name' => '用户名',
            'gender' => 'Gender',
            'orgid' => '权限',
            'isdelete' => 'Isdelete',
        ];
    }
}
