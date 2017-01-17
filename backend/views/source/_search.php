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
            <?php if (!empty($query['SourceSearch'])) {
                $model->digest = $query['SourceSearch']['digest'];
                $model->show_cover_pic = $query['SourceSearch']['show_cover_pic'];
                $model->status = $query['SourceSearch']['status'];
                $model->title = $query['SourceSearch']['title'];
            }?>
            <?= $form->field($model, 'title')->textInput(['placeholder' =>'标题']) ?>
            <?= $form->field($model, 'digest')->widget(Select2::classname(), ['data' => ['0' => '否', '1' => '是'], 'options' => ['placeholder' => '显示消息描述'], ]); ?>
            <?= $form->field($model, 'show_cover_pic')->widget(Select2::classname(), ['data' => ['0' => '否', '1' => '是'],'options' => ['placeholder' => '内容展示封面'],  ]); ?>
            <?= $form->field($model, 'status')->widget(Select2::classname(), ['data' => ['0' => '否', '1' => '是'],'options' => ['placeholder' => '是否发送过'],  ]); ?>
            <table style="width: 100%;">
                <tr>
                    <td>
                        <div class="form-group">
                            <?= Html::submitButton("查询", ["class" => "btn btn-primary btn-sm"]) ?>
                            <?= Html::a("重置", ['index'], ["class" => "btn btn-primary btn-sm"]) ?>
                            <?= Html::a('添加消息', ['create'], ['class' => 'btn btn-sm btn-success'])?>
                            <?= Html::label('发送消息', '', ['class' => 'btn btn-sm btn-success','onclick'=>'send()'])?>
                        </div>
                    </td>
                </tr>
            </table>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
