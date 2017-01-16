<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "video_shoot".
 *
 * @property integer $id
 * @property string $recordname
 * @property string $time
 * @property string $time1
 * @property double $capture_time
 * @property string $uploadname
 * @property integer $seat
 * @property string $projectname
 * @property string $school
 * @property string $courcename
 * @property string $teacher
 * @property string $status
 * @property string $auditor1
 * @property string $auditor2
 * @property integer $cid
 */
class VideoShootOld extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'video_shoot';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['id'], 'required'],
            [['id', 'seat','cid' ], 'integer'],
            [['capture_time'], 'number'],
            [['recordname', 'time', 'time1', 'uploadname', 'projectname', 'school', 'courcename', 'teacher', 'status', 'auditor1', 'auditor2'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'recordname' => '录制人',
            'time' => '拍摄时间',
            'time1' => '拍摄时间1',
            'capture_time' => '时长',
            'uploadname' => '上传人',
            'seat' => '机位个数',
            'projectname' => '项目名称',
            'school' => '学校',
            'courcename' => '课程名称',
            'teacher' => '主讲人',
            'status' => '审核',
            'auditor1' => 'Auditor1',
            'auditor2' => 'Auditor2',
            'cid' => 'Cid',
        ];
    }

//    public function getProjectName()
//    {
//        $list = Project::findBySql('select pid, projectname from project GROUP BY projectname')->all();
//        $pro_list = [];
//        foreach ($list as $k => $v) {
////            array_push($pro_list, $v['projectname']);
//            $key = $v['projectname'];
//            $pro_list[$v['pid']] = $v['projectname'] ;
//        }
//        return $pro_list;
//    }

//    public function getPersonList()
//    {
//        $list = SmsAdmin::findBySql('select DISTINCT name from sms_admin')->all();
//        $person_list = [];
//        foreach ($list as $k => $v) {
//            $key = $v['name'];
//            $person_list[$key] = $v['name'] ;
//        }
//        return $person_list;
//    }

//    public function getCourseList()
//    {
//        $list = self::findBySql('select DISTINCT courcename from video_shoot')->all();
//        $course_list = [];
//        foreach ($list as $k => $v) {
//            $key = $v['courcename'];
//            $course_list[$key] = $v['courcename'] ;
//        }
//        return $course_list;
//    }

//    public function getTeacherList()
//    {
//        $list = Teacher::findBySql('select DISTINCT teacher from teacher')->all();
//        $teacher_list = [];
//        foreach ($list as $k => $v) {
//            $key = $v['teacher'];
//            $teacher_list[$key] = $v['teacher'] ;
//        }
//        return $teacher_list;
//    }

}
