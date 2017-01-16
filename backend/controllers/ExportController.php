<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2016/11/2
 * Time: 11:44
 */

namespace backend\controllers;

use yii\data\SqlDataProvider;
use yii\web\Controller;
use PHPExcel_IOFactory;

class ExportController extends Controller
{
    public function actionIndex() {
        echo 'test';
    }

    public function actionVideoshoot()
    {
        $sql_parms = 'where a.cid = b.id and b.pid = c.id';
        $query_parms = \Yii::$app->request->queryParams;


        if (!empty($query_parms['projectname'])) {
            $sql_parms .= " and b.pid = '" . $query_parms['projectname'] . "'";
        }

        if (!empty($query_parms['school'])) {
            $sql_parms .= " and c.school = '" . $query_parms['school'] . "'";
        }

        if (!empty($query_parms['courcename'])) {
            $sql_parms .= " and b.id = '" . $query_parms['courcename'] . "'";
        }

        if (!empty($query_parms['status'])) {
            $sql_parms .= " and a.status = '" . $query_parms['status'] . "'";
        }

        if (!empty($query_parms['recordname'])) {
            $sql_parms .= " and a.recordname like  '" . '%' . $query_parms['recordname'] . '%' . "'";
        }

        if (!empty($query_parms['uploadname'])) {
            $sql_parms .= " and a.uploadname like '" . '%' . $query_parms['uploadname'] . '%' . "'";
//            $sql_parms .= " and a.uploadname = '" . $query_parms['uploadname'] . "'";
        }

        if (!empty($query_parms['time'])) {
            if (!empty($query_parms['test'])) { //年份月份全有
                $year = $query_parms['time'];
                $month = $query_parms['test'];
                $time1 = $query_parms['time'] . '/' . $query_parms['test'];
                if ($month > 9) {
                    $time2 = $year . '-' . $month;
                } else {
                    $time2 = $year . '-0' . $month;
                }

                $sql_parms .= " and a.time like '" . $time1 . '%' . "'" . " or a.time like '" . $time2 . '%' . "'";
            } else {
                $sql_parms .= " and a.time like '" . $query_parms['time'] . '%' . "'";
            }
        }

        $sql = "SELECT a.id, a.recordname, a.time, a.capture_time, a.uploadname, a.seat, a.teacher, a.status, a.remark, 
c.projectname,c.school,b.courcename,b.pid, a.cid  FROM `video_shoot` as a, `video_making` as b, `project` as c " . $sql_parms . " order by a.id desc ";

        $command = \Yii::$app->db->createCommand('SELECT COUNT(a.id) as num,a.id, a.recordname, a.time,a.capture_time, a.uploadname, a.seat, a.teacher, a.status, 
c.projectname,c.school,b.courcename,b.pid, a.cid  FROM `video_shoot` as a, `video_making` as b, `project` as c  ' . $sql_parms);
        $count = $command->queryScalar();
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'totalCount' => $count,
            'pagination' => false,
            'sort' => [
                'attributes' => [
                    'id',
                ],
            ],
        ]);
        $models = $dataProvider->getModels();


        $objectPHPExcel = new \PHPExcel();
        $objectPHPExcel->setActiveSheetIndex(0);
        $n = 0;
        foreach ($models as $product) {

            //报表头的输出
            $objectPHPExcel->getActiveSheet()->mergeCells('B1:G1');
            $objectPHPExcel->getActiveSheet()->setCellValue('B1', '视频拍摄');

            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', '产品信息表');
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', '产品信息表');
            $objectPHPExcel->setActiveSheetIndex(0)->getStyle('B1')->getFont()->setSize(24);
            $objectPHPExcel->setActiveSheetIndex(0)->getStyle('B1')
                ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', '日期：' . date("Y年m月j日"));
            $objectPHPExcel->setActiveSheetIndex(0)->getStyle('G2')
                ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            //表格头的输出
            $objectPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', 'id');
            $objectPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(7);
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', '项目名称');
            $objectPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', '学校');
            $objectPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', '课程名');
            $objectPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', '录制人员');
            $objectPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', '主讲人');
            $objectPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', '拍摄时间');
            $objectPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(40);
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', '拍摄时长');
            $objectPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', '机位');
            $objectPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('K3', '上传人');
            $objectPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('L3', '备注');
            $objectPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);


            //设置居中
            $objectPHPExcel->getActiveSheet()->getStyle('B3:G3')
                ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            //设置边框
            $objectPHPExcel->getActiveSheet()->getStyle('B3:G3')
                ->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $objectPHPExcel->getActiveSheet()->getStyle('B3:G3')
                ->getBorders()->getLeft()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $objectPHPExcel->getActiveSheet()->getStyle('B3:G3')
                ->getBorders()->getRight()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $objectPHPExcel->getActiveSheet()->getStyle('B3:G3')
                ->getBorders()->getBottom()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $objectPHPExcel->getActiveSheet()->getStyle('B3:G3')
                ->getBorders()->getVertical()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);

            //设置颜色
            $objectPHPExcel->getActiveSheet()->getStyle('B3:L3')->getFill()
                ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF66CCCC');

            //明细的输出
            $objectPHPExcel->getActiveSheet()->setCellValue('B' . ($n + 4), $product['id']);
            $objectPHPExcel->getActiveSheet()->setCellValue('C' . ($n + 4), $product['projectname']);
            $objectPHPExcel->getActiveSheet()->setCellValue('D' . ($n + 4), $product['school']);
            $objectPHPExcel->getActiveSheet()->setCellValue('E' . ($n + 4), $product['courcename']);
            $objectPHPExcel->getActiveSheet()->setCellValue('F' . ($n + 4), $product['recordname']);
            $objectPHPExcel->getActiveSheet()->setCellValue('G' . ($n + 4), $product['teacher']);
            $objectPHPExcel->getActiveSheet()->setCellValue('H' . ($n + 4), $product['time']);
            $objectPHPExcel->getActiveSheet()->setCellValue('I' . ($n + 4), $product['capture_time']);
            $objectPHPExcel->getActiveSheet()->setCellValue('J' . ($n + 4), $product['seat']);
            $objectPHPExcel->getActiveSheet()->setCellValue('K' . ($n + 4), $product['uploadname']);
            $objectPHPExcel->getActiveSheet()->setCellValue('L' . ($n + 4), $product['remark']);

            //设置边框
            $currentRowNum = $n + 4;
            $objectPHPExcel->getActiveSheet()->getStyle('B' . ($n + 4) . ':G' . $currentRowNum)
                ->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $objectPHPExcel->getActiveSheet()->getStyle('B' . ($n + 4) . ':G' . $currentRowNum)
                ->getBorders()->getLeft()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $objectPHPExcel->getActiveSheet()->getStyle('B' . ($n + 4) . ':G' . $currentRowNum)
                ->getBorders()->getRight()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $objectPHPExcel->getActiveSheet()->getStyle('B' . ($n + 4) . ':G' . $currentRowNum)
                ->getBorders()->getBottom()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $objectPHPExcel->getActiveSheet()->getStyle('B' . ($n + 4) . ':G' . $currentRowNum)
                ->getBorders()->getVertical()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $n = $n + 1;
        }

        ob_end_clean();
        ob_start();

        header('Content-Type : application/vnd.ms-excel');
        header('Content-Disposition:attachment;filename="' . '视频拍摄-' . date("Y年m月j日") . '.xls"');
        $objWriter = PHPExcel_IOFactory::createWriter($objectPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    public function actionCouseware()
    {
        error_reporting(E_ALL);
        date_default_timezone_set('Europe/London');

        $query_parms = \Yii::$app->request->queryParams;
        $sql_parms = 'where a.cid = b.id and b.pid = c.id ';

        if (!empty($query_parms['projectname'])) {
            $sql_parms .= " and b.pid = '" . $query_parms['projectname'] . "'";
        }

        if (!empty($query_parms['school'])) {
            $sql_parms .= " and c.school = '" . $query_parms['school'] . "'";
        }

        if (!empty($query_parms['coursename'])) {
            $sql_parms .= " and b.id = '" . $query_parms['coursename'] . "'";
        }

        if (!empty($query_parms['teacher'])) {
            $sql_parms .= " and a.teacher = '" . $query_parms['teacher'] . "'";
        }

        if (!empty($query_parms['recordname'])) {
            $sql_parms .= " and a.recordname like  '" . '%' . $query_parms['recordname'] . '%' . "'";
        }

        if (!empty($query_parms['uploadname'])) {
            $sql_parms .= " and a.uploadname like '" . '%' . $query_parms['uploadname'] . '%' . "'";
        }

        if (!empty($query_parms['time'])) {
            if (!empty($query_parms['enddate'])) { //年份月份全有
                $year = $query_parms['time'];
                $month = $query_parms['enddate'];
                $min_year = $year . '-'.$month . '-01';
                $minyear = strtotime($min_year);
                $max_year = $year .'-'. $month . '-31';
                $maxyear = strtotime($max_year);
                $sql_parms .= " and a.date >= '" . $minyear . "' and a.date <= '" .$maxyear. "'" ;
            }
            else {
                $year = $query_parms['time'];
                $ages = $year . '-01-01';
                $minyear = strtotime($ages);
                $maxyear = $minyear+31449600;
                $sql_parms .= " and a.date >= '" . $minyear . "' and a.date <= '" .$maxyear. "'" ;
            }
        }

        $sql = "SELECT a.id, a.title, a.teacher, a.time, a.makingname, a.uploadname, a.date, a.enddate, a.totalday,a.remark, a.cid,
b.courcename,b.pid,c.projectname,c.school  FROM `courseware` as a , `video_making` as b, `project` as c " . $sql_parms . " order by a.id desc ";

        $command = \Yii::$app->db->createCommand('SELECT count(a.id) as num, a.id, a.title, a.teacher, a.time, a.makingname, a.uploadname, 
a.date, a.enddate, a.totalday,a.remark, a.cid,b.courcename,b.pid,c.projectname,c.school 
FROM `courseware` as a , `video_making` as b, `project` as c ' . $sql_parms );
        $count = $command->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'totalCount' => $count,
            'pagination' => false,
            'sort' => [
                'attributes' => [
                    'id',
                ],
            ],
        ]);
        $models = $dataProvider->getModels();


        $objectPHPExcel = new \PHPExcel();
        $objectPHPExcel->setActiveSheetIndex(0);
        $n = 0;
        foreach ($models as $product) {

            //报表头的输出
            $objectPHPExcel->getActiveSheet()->mergeCells('B1:G1');
            $objectPHPExcel->getActiveSheet()->setCellValue('B1', '课件制作');

            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', '产品信息表');
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', '产品信息表');
            $objectPHPExcel->setActiveSheetIndex(0)->getStyle('B1')->getFont()->setSize(24);
            $objectPHPExcel->setActiveSheetIndex(0)->getStyle('B1')
                ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', '日期：' . date("Y年m月j日"));
            $objectPHPExcel->setActiveSheetIndex(0)->getStyle('G2')
                ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            //表格头的输出
            $objectPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', 'id');
            $objectPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(17);
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', '项目名称');
            $objectPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(17);
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', '学校');
            $objectPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(22);
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', '课程名');
            $objectPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', '视频标题');
            $objectPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', '讲师');
            $objectPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', '时长');
            $objectPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', '制作人');
            $objectPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', '开始日期');
            $objectPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('K3', '制做天数');
            $objectPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(13);
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('L3', '备注');
            $objectPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);



            //设置居中
            $objectPHPExcel->getActiveSheet()->getStyle('B3:L3')
                ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            //设置边框
            $objectPHPExcel->getActiveSheet()->getStyle('B3:L3')
                ->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $objectPHPExcel->getActiveSheet()->getStyle('B3:L3')
                ->getBorders()->getLeft()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $objectPHPExcel->getActiveSheet()->getStyle('B3:L3')
                ->getBorders()->getRight()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $objectPHPExcel->getActiveSheet()->getStyle('B3:L3')
                ->getBorders()->getBottom()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $objectPHPExcel->getActiveSheet()->getStyle('B3:L3')
                ->getBorders()->getVertical()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);

            //设置颜色
            $objectPHPExcel->getActiveSheet()->getStyle('B3:L3')->getFill()
                ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF66CCCC');

            $h = floor($product['time'] / 3600);
            $m = floor(($product['time'] - $h * 3600) / 60);
            $s = ($product['time'] - $h * 3600) % 60;
            $test = $h."时".$m."分".$s."秒";

            //明细的输出
            $objectPHPExcel->getActiveSheet()->setCellValue('B' . ($n + 4), $product['id']);
            $objectPHPExcel->getActiveSheet()->setCellValue('C' . ($n + 4), $product['projectname']);
            $objectPHPExcel->getActiveSheet()->setCellValue('D' . ($n + 4), $product['school']);
            $objectPHPExcel->getActiveSheet()->setCellValue('E' . ($n + 4), $product['courcename']);
            $objectPHPExcel->getActiveSheet()->setCellValue('F' . ($n + 4), $product['title']);
            $objectPHPExcel->getActiveSheet()->setCellValue('G' . ($n + 4), $product['teacher']);
            $objectPHPExcel->getActiveSheet()->setCellValue('H' . ($n + 4), $test);
            $objectPHPExcel->getActiveSheet()->setCellValue('I' . ($n + 4), $product['makingname']);

            $objectPHPExcel->getActiveSheet()->setCellValue('J' . ($n + 4), date("Y-m-d" ,$product['date']));
            $objectPHPExcel->getActiveSheet()->setCellValue('K' . ($n + 4), $product['totalday']);
            $objectPHPExcel->getActiveSheet()->setCellValue('L' . ($n + 4), $product['remark']);

            //设置边框
            $currentRowNum = $n + 4;
            $objectPHPExcel->getActiveSheet()->getStyle('B' . ($n + 4) . ':L' . $currentRowNum)
                ->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $objectPHPExcel->getActiveSheet()->getStyle('B' . ($n + 4) . ':L' . $currentRowNum)
                ->getBorders()->getLeft()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $objectPHPExcel->getActiveSheet()->getStyle('B' . ($n + 4) . ':L' . $currentRowNum)
                ->getBorders()->getRight()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $objectPHPExcel->getActiveSheet()->getStyle('B' . ($n + 4) . ':L' . $currentRowNum)
                ->getBorders()->getBottom()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $objectPHPExcel->getActiveSheet()->getStyle('B' . ($n + 4) . ':L' . $currentRowNum)
                ->getBorders()->getVertical()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $n = $n + 1;
        }

        ob_end_clean();
        ob_start();

        header('Content-Type : application/vnd.ms-excel');
        header('Content-Disposition:attachment;filename="' . '课件管理-' . date("Y年m月j日") . '.xls"');
        $objWriter = PHPExcel_IOFactory::createWriter($objectPHPExcel, 'Excel5');
        $objWriter->save('php://output');

//        header('Content-Type: application/vnd.ms-excel');
//        header('Content-Disposition: attachment;filename="sss.xls"');
//        header('Cache-Control: max-age=0');
//        $objWriter = \PHPExcel_IOFactory::createWriter($objectPHPExcel, 'Excel5');
//        $objWriter->save('php://output');
//        exit;


    }


}