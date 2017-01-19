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
/* @var $model app\models\Lecture*/
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
            <?php if (!empty($query['Lecture'])) {
                $model->title = $query['Lecture']['title'];
            }?>
            <?= $form->field($model, 'title')->widget(Select2::classname(), ['data' => $lecturelist, 'options' => ['placeholder' => '请选择讲座'], ]); ?>
            <table style="width: 100%;">
                <tr>
                    <td>
                        <div class="form-group">
                            <?= Html::submitButton("查询", ["class" => "btn btn-primary btn-sm"]) ?>
                        </div>
                    </td>
                </tr>
            </table>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
