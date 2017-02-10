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
use yii\helpers\Url;
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
            <?php if (!empty($query['Books'])) {
                $model->name = $query['Books']['name'];
                $model->status = $query['Books']['status'];
            }?>
            <?= $form->field($model, 'name')->textInput(['placeholder' =>'书名']) ?>
            <?= $form->field($model, 'status')->widget(Select2::classname(), ['data' => ['0' => '未通报', '1' => '通报成功'],'options' => ['placeholder' => '通报状态'],  ]); ?>
            <table style="width: 100%;">
                <tr>
                    <td>
                        <div class="form-group">
                            <?= Html::submitButton("查询", ["class" => "btn btn-primary btn-sm"]) ?>
                            <?= Html::a("重置", ['index'], ["class" => "btn btn-primary btn-sm"]) ?>
                            <?= Html::label('通报新书', '', ['class' => 'btn btn-sm btn-success','onclick'=>'return send()'])?>
                            <?= Html::a("获取新书", ['get'], ["class" => "btn btn-sm btn-success"]) ?>
                            <?echo !empty($query['status'])?$query['status']:"";?>
                        </div>
                    </td>
                </tr>
            </table>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
