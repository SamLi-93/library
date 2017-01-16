<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "video_making".
 *
 * @property integer $id
 * @property string $makingname
 * @property integer $subtitle
 * @property string $projectname
 * @property string $school
 * @property string $courcename
 * @property integer $free
 * @property string $teacher
 * @property integer $pid
 */
class VideoMaking extends \yii\db\ActiveRecord
{
    public $imageFiles;
    private $pic_name;
    private $path;
    public $test;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'video_making';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['id'], 'required'],
            [['id', 'subtitle', 'free', 'status', 'pid'], 'integer'],
            [['makingname', 'projectname', 'teacher', 'school', 'courcename'], 'string', 'max' => 100],
            [['teacher'], 'string', 'max' => 50],
//            ['courcename', 'unique', ],
//            [['pic'], 'file','maxFiles' => 14],
            [['imageFiles'], 'file', 'maxFiles' => 14],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'makingname' => '上传人 *',
            'subtitle' => '字幕 *',
            'projectname' => '项目名 *',
            'school' => '学校 *',
            'courcename' => '课程名 *',
            'free' => '结算 *',
            'teacher' => '讲师 *',
            'status' => '审核',
            'pid' => 'Pid',
            'imageFiles' => '图片',
        ];
    }

    //保存图片到本地
    public function upload()
    {
//        var_dump('t1');
//        if ($this->validate()) {
//            var_dump('t');exit;
//            foreach ($this->imageFiles as $k => $v) {
//                $pic_name = $v->name;
//                $this->pic_name = $v->name;
//                $type = strpos($pic_name, '.jpg') === false ? '.png' : '.jpg';
//                $this->path = 'upload_files\pic\\' . date("Y-m-d-H-i-s")  . '_' . $k . $type ;
//                $v->saveAs(dirname(__DIR__) . '\\web\\' . $this->path);
//            }
//            return true;
//        } else {
//            return false;
//        }
    }

    // videomaking 表存入数据后 把图片存入pic表
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
        $cid = $this->id;

        if ($this->imageFiles) {
            foreach ($this->imageFiles as $k => $v) {
                $pic_model = new Pic();
                $pic_name = $v->name;
                $this->pic_name = $v->name;
                $type = strpos($pic_name, '.jpg') === false ? '.png' : '.jpg';
                $path = 'upload_files/pic/' . date("Y-m-d-H-i-s") . '_' . $k . $type ;
                $pic_model->setAttributes([
                    'type' => 0,
                    'name' => $pic_name,
                    'path' => $path,
                    'cid' => $cid,
                ]);
                $pic_model->save();
//                $v->saveAs('./backend/web/'.$path);
                $v->saveAs( $path );
            }
        }
    }


    public function getCourseList()
    {
        $list = self::findBySql('select DISTINCT courcename,id from video_making')->all();
        $course_list = [];
        foreach ($list as $k => $v) {
            $key = $v['courcename'];
            $course_list[$v['id']] = $v['courcename'];
        }
        return $course_list;
    }

}