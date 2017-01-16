<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2016/9/29
 * Time: 9:22
 */

namespace backend\controllers;


use app\models\Courseware;
use app\models\Project;
use app\models\Tedeng;
use app\models\VideoMaking;
use yii\data\SqlDataProvider;
use yii\web\Controller;
use PHPExcel_IOFactory;
use Yii;

class TestController extends Controller
{

    public function actionSql()
    {
        for ($id = 6086; $id < 6133; $id++) {
            $course_list = Courseware::findBySql("select * from courseware where id = :id", ['id' => $id])->all();
            $times = $course_list[0]['remark'];
            for ($i=0;$i<$times;$i++) {
                $model = new Courseware();
                $model->setAttributes([
                    'projectname' => $course_list[0]['projectname'],
                    'school' => $course_list[0]['school'],
                    'coursename' => $course_list[0]['coursename'],
                    'title' => strval($course_list[0]['title']),
                    'teacher' => $course_list[0]['teacher'],
                    'time' => intval($course_list[0]['time']),
                    'makingname' => $course_list[0]['makingname'],
                    'uploadname' => $course_list[0]['uploadname'],
                    'date' => intval($course_list[0]['date']),
                    'enddate' => 0,                                   // u can delete this attribute of the table!!
                    'totalday' => intval($course_list[0]['totalday']),
                    'remark' => strval($course_list[0]['remark']),
                    'cid' => $course_list[0]['cid'],
                ]);
                var_dump($model->save());
            }

        }
    }

    public function actionCourse()
    {
        $dir = dirname(__FILE__);
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load($dir . '/55.xls');
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        var_dump($highestRow);exit;
        $c_list = [];
        $school = [];

//        $time = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(9, 1378)->getValue();
//        var_dump(intval($time));exit;

        for ($j = 2; $j <= $highestRow; $j++) {
            $a = $objPHPExcel->getActiveSheet()->getCell("D" . $j)->getValue();//获取B列的值
            $c_list[$j - 2] = $a;
        }

        $teacher = [];
        $time = [];
        $prolist = [];
        $makingname = [];
        $couselist = [];
        $title = [];
        $totalday = [];
        $m = [];
        $s = [];
        $remark = [];
//        $title = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3,  3)->getValue();
//        var_dump($title);exit;
        for ($i = 0; $i <= $highestRow-2; $i++) {
//            $prolist[$i] = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $i + 2)->getValue();
//            $school[$i] = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $i + 2)->getValue();
//            $courselist[$i] = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $i + 2)->getValue();
            $title[$i] = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $i + 2)->getValue();
            $makingname[$i] = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $i + 2)->getValue();
            $teacher[$i] = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $i + 2)->getValue();
            $time[$i] = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $i + 2)->getValue();
            $totalday[$i] = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $i + 2)->getValue();
            $m[$i] = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, $i + 2)->getValue();
            $s[$i] = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $i + 2)->getValue();
            $remark[$i] = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(9, $i + 2)->getValue();

            var_dump($title);
//            $cid = VideoMaking::findBySql("select id from video_making where
//              projectname = :projectname and school =:school and courcename = :coucename ",
//                [':projectname' => $prolist[$i], 'school' => $school[$i], ':coucename' => $courselist[$i]])->one();

            $time_long = $m[$i] * 60 + $s[$i];

            $model = new Courseware();
            $model->setAttributes([
                'projectname' => '$prolist[$i]',
                'school' => '$school[$i]',
                'coursename' => '$courselist[$i]',
                'title' => strval($title[$i]),
                'teacher' => $teacher[$i],
                'time' => intval($time_long),
                'makingname' => $makingname[$i],
                'uploadname' => $makingname[$i],
                'date' => intval(strtotime($time[$i])),
                'enddate' => 0,                                   // u can delete this attribute of the table!!
                'totalday' => intval($totalday[$i]),
                'remark' => strval($remark[$i]),
                'cid' => 0,
            ]);
//            var_dump($model);
//            var_dump($i);
//            var_dump($title[$i]);
//            var_dump($cid['id']);
//            var_dump($model->save());
        }


    }

    public function actionVideomaking()
    {
        $dir = dirname(__FILE__);
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load($dir . '/3333.xls');
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumn = $sheet->getHighestColumn(); // 取得总列数
        $c_list = [];
        $school = [];

        for ($j = 2; $j <= $highestRow; $j++) {
            $a = $objPHPExcel->getActiveSheet()->getCell("D" . $j)->getValue();//获取A列的值
            $c_list[$j - 2] = $a;
        }
        $pro = array_unique($c_list);
        $teacher = [];
        $time = [];
        $prolist = [];
        $makingname = [];
        foreach ($pro as $key => $value) {
            $prolist[$key] = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $key + 2)->getValue();
            $school[$key] = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $key + 2)->getValue();
            $teacher[$key] = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $key + 2)->getValue();
            $courselist[$key] = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $key + 2)->getValue();
            $time[$key] = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $key + 2)->getValue();
            $makingname[$key] = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, $key + 2)->getValue();
            $pid = Project::findBySql("select id from project where projectname = :projectname", [':projectname' => $prolist[$key]])->one();
//            print_r($pid['id']);

            $model = new VideoMaking();
            $model->setAttributes([
                'status' => 4,
                'projectname' => $prolist[$key],
                'school' => $school[$key],
                'courcename' => strval($courselist[$key]),
                'teacher' => $teacher[$key],
                'subtitle' => 0,
                'free' => 0,
                'makingname' => $makingname[$key],
                'pid' => $pid['id'],
            ]);
            var_dump($key);
            var_dump($courselist[$key]);
            var_dump($model->save());
        }


    }

    public function actionIndex()
    {
        $k = '1';
        $type = '.jpg';
        $path = 'upload_files\pic\\' . date("Y-m-d-H-i-s") . '_' . $k . $type;
//        echo ('..\backend'. '\\web\\' . $path);
//        echo dirname(__DIR__);
        echo dirname(__DIR__) . ('\\web\\' . $path);
    }

    public function actionExport()
    {
        echo phpinfo();
        exit;
    }

    public function actionInput()
    {

        $conn = Yii::$app->db;
        $dir = dirname(__FILE__);
//        var_dump($dir);exit;
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load($dir . '/1111.xls');
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumn = $sheet->getHighestColumn(); // 取得总列数
        $k = 0;
        $pro_list = [];
        $school = [];

        for ($j = 2; $j <= $highestRow; $j++) {
            $a = $objPHPExcel->getActiveSheet()->getCell("B" . $j)->getValue();//获取A列的值
            $pro_list[$j - 2] = $a;
        }
        $pro = array_unique($pro_list);
        $teacher = [];
        $time = [];
        foreach ($pro as $key => $value) {
            $school[$key] = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $key + 2)->getValue();
            $teacher[$key] = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $key + 2)->getValue();
            $time[$key] = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $key + 2)->getValue();
            $model = new Project();
            $model->setAttributes([
                'projectname' => $value,
                'school' => $school[$key],
                'over' => 0,
                'free' => 0,
                'teacher' => $teacher[$key],
                'time' => strtotime($time[$key]),
                'endtime' => 0,
            ]);
            $model->save();
        }
    }
}