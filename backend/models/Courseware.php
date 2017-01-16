<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "courseware".
 *
 * @property integer $id
 * @property string $title
 * @property string $teacher
 * @property integer $time
 * @property string $makingname
 * @property string $uploadname
 * @property integer $state
 * @property string $projectname
 * @property string $school
 * @property string $coursename
 * @property integer $date
 * @property integer $enddate
 * @property integer $totalday
 * @property string $status
 * @property string $auditor1
 * @property string $auditor2
 * @property string $remark
 * @property integer $cid
 */
class Courseware extends \yii\db\ActiveRecord
{
    public $time0;
    public $time1;
    public $time2;
    public $excelFile;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'courseware';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time0','time1','time2','time', 'state', 'totalday', 'cid','pid'], 'integer'],
            [['cid','date','enddate',], 'required'],
            [['excelFile'], 'file', 'extensions' => 'xls'],
            [['title', 'teacher', 'makingname', 'uploadname', 'projectname', 'school', 'coursename', 'status', 'auditor1', 'auditor2', 'remark'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '	视频标题 *',
            'teacher' => '讲师 *',
            'time' => '制作时长 *',
            'makingname' => '制作人 *',
            'uploadname' => '上传人 *',
            'state' => '状态',
            'projectname' => '项目名称 *',
            'school' => '学校 *',
            'coursename' => '课程名称 *',
            'date' => '开始日期 *',
            'enddate' => '结束日期',
            'totalday' => '制作天数 *',
            'status' => '审核',
            'auditor1' => 'Auditor1',
            'auditor2' => 'Auditor2',
            'remark' => '备注',
            'cid' => 'Cid',
            'time1' => '分 *',
            'time2' => '秒 *',
            'time0' => '时 *',
            'excelFile' =>'excel文件' ,

        ];
    }
}
