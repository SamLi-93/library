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
class Project extends \yii\db\ActiveRecord
{
    public $from_date;
    public $to_date;
    public $record_time;
    public $course_total;
    public $video_time;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['over', 'free','is_neibu'], 'integer'],
            [['projectname', 'school',], 'string', 'max' => 100],
            ['projectname', 'unique', ],
            [['time','endtime'], 'filter','filter' => function($value) {
                return ($value);
            }  ],
            [['teacher', 'uploadname'], 'string', 'max' => 50],
            [['original_path', 'making_path'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'projectname' => '项目名称 *',
            'school' => '学校 *',
            'over' => '是否结束',
            'free' => '费用结算',
            'teacher' => '项目联系人 *',
            'time' => '开始时间 *',
            'endtime' => '结束时间',
            'original_path' => '原始路径',
            'making_path' => '制作路径',
            'uploadname' => '上传人 *',
            'is_neibu' =>'课程类型 ',
            'record_time' => '录制时长',
            'course_total' => '课时总数',
            'video_time' => '视频总时长',
        ];
    }

//    public function getProjectName()
//    {
//        $list = self::findBySql('select DISTINCT projectname from project')->all();
//        $pro_list = [];
//        foreach ($list as $k => $v) {
////            array_push($pro_list, $v['projectname']);
//            $key = $v['projectname'];
//            $pro_list[$key] = $v['projectname'] ;
//        }
////        print_r($pro_list);exit;
//        return $pro_list;
//    }

    public function getProjectName()
    {
        $list = self::findBySql('select id, projectname from project ')->all();
        $pro_list = [];
        foreach ($list as $k => $v) {
//            array_push($pro_list, $v['projectname']);
            $key = $v['projectname'];
            $pro_list[$v['id']] = $v['projectname'] ;
        }
        return $pro_list;
    }

    public function getSchoolName()
    {
        $list = self::findBySql('select DISTINCT school from project')->all();
        $school_list = [];
        foreach ($list as $k => $v) {
//            array_push($school_list, $v['school']);
            $key = $v['school'];
            $school_list[$key] = $v['school'] ;
        }
        return $school_list;
    }

    public function getTeacherName()
    {
        $list = self::findBySql('select DISTINCT teacher from project')->all();
        $teacher_list = [];
        foreach ($list as $k => $v) {
//            array_push($teacher_list, $v['teacher']);
            $key = $v['teacher'];
            $teacher_list[$key] = $v['teacher'] ;
        }
        return $teacher_list;
    }

//    public function getOverList()
//    {
//        $list = self::findBySql('select DISTINCT over from project')->all();
////        $over_list = [0 => '请选择'];
//        $over_list = [];
//        foreach ($list as $k => $v) {
////            array_push($over_list, $v['over']);
//            $key = $v['over'];
//            $over_list[$key] = $v['over'] ;
//        }
//        return $over_list;
//    }
}
