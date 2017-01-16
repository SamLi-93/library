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
            <?php if (!empty($query['ProjectSearch'])) {
//                $model->projectname = $query['ProjectSearch']['projectname'];
            }?>

<!--            --><?//= $form->field($model, 'teacher')->widget(Select2::classname(), ['data' => $pro_teacher,'options' => ['placeholder' => '请选择讲师'],  ]); ?>
<!--            --><?//= $form->field($model, 'is_neibu')->widget(Select2::classname(), ['data' => ['2' => '外部', '1' => '内部'],'options' => ['placeholder' => '请选择是否内部课程'],  ]); ?>

            <table style="width: 100%;">
                <tr>
                    <td>
                        <div class="form-group">
                            <?= Html::submitButton("查询", ["class" => "btn btn-primary btn-sm"]) ?>
                            <?= Html::a("重置", ['index'], ["class" => "btn btn-primary btn-sm"]) ?>
                            <?= Html::a('添加', ['create'], ['class' => 'btn btn-sm btn-success'])?>
                        </div>
                    </td>
                </tr>
            </table>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
