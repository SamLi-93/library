<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2016/9/30
 * Time: 14:34
 */


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectSearch*/
/* @var $form yii\widgets\ActiveForm */
?>

<div class="widget-box widget_tableDiv">
    <div id="filter_show" class="widget-body">
        <div class="widget-main">
            <?php $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
                'fieldConfig' => [
                    'template' => "<div class='form-group' style='float: left;width:150px;'>{input}</div>",
                    'labelOptions' => ['style' => 'width:60px;'],
                ],
            ]);
            ?>

            <?php if (!empty($query['VideoMaking'])) {
                $model->projectname = $query['VideoMaking']['projectname'];
                $model->courcename = $query['VideoMaking']['courcename'];
                $model->school = $query['VideoMaking']['school'];
                $model->makingname = $query['VideoMaking']['makingname'];
                $model->free = $query['VideoMaking']['free'];
                $model->status = $query['VideoMaking']['status'];
                $model->subtitle = $query['VideoMaking']['subtitle'];
            }?>

            <?= $form->field($model, 'projectname')->widget(Select2::classname(), ['data' =>$pro_projectname , 'options' => ['placeholder' => '请选择项目'], ]); ?>
            <?= $form->field($model, 'school')->widget(Select2::classname(), ['data' => $pro_school, 'options' => ['placeholder' => '请选择学校'], ]); ?>
            <?= $form->field($model, 'courcename')->widget(Select2::classname(), ['data' => $course_list, 'options' => ['placeholder' => '请选择课程'], ]); ?>
            <?= $form->field($model, 'makingname')->widget(Select2::classname(), ['data' => $person_list, 'options' => ['placeholder' => '请选择上传人'], ]); ?>
            <?= $form->field($model, 'free')->widget(Select2::classname(), ['data' => ['2' => '否', '1' => '是'], 'options' => ['placeholder' => '请选择费用结算'], ]); ?>
            <?= $form->field($model, 'subtitle')->widget(Select2::classname(), ['data' => ['2' => '无', '1' => '有'], 'options' => ['placeholder' => '请选择有无字幕'], ]); ?>
            <?= $form->field($model, 'status')->widget(Select2::classname(), ['data' => ['9' => '未审核', '1' => '一级审核中','2' => '一级通过',
                '3' => '一级驳回','4' => '二级通过','5' => '二级驳回','6' => '二级审核中'],
                'options' => ['placeholder' => '请选择状态'], ]); ?>

            <table style="width: 100%;">
                <tr>
                    <td>
                        <div class="form-group">
                            <?= Html::submitButton("查询", ["class" => "btn btn-primary btn-sm"]) ?>
                            <?= Html::a("重置", ['index'], ["class" => "btn btn-primary btn-sm"]) ?>
                            <?= Html::a('添加', ['create'], ['class' => 'btn btn-sm btn-success'])?>
                            <?= Html::a('批量审核', "", ['class' => 'btn btn-primary btn-sm gridviewverified']) ?>
                        </div>
                    </td>
                </tr>
            </table>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
