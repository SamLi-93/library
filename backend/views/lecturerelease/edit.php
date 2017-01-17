<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Project*/
/* @var $form yii\widgets\ActiveForm */
$this->title = '讲座修改';
$this->params['breadcrumbs'][] = ['label' => 'Project', 'url' =>  ['index']];
$this->params['breadcrumbs'][] = $this->title;
// $this->params['breadcrumbs'][] = ['label' => $model->projectname, 'url' => ['view', 'id' => $model->id]];
?>
<div class="center subject_name">
    <span>讲座修改</span>
</div>
<div class="col-xs-12">

    <?php $form = ActiveForm::begin([
        'action' => ['lecturerelease/edit/'.$model['id']],
        'method' => 'post',
        'id' => 'my_form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true,'placeholder' =>'标题']) ?>
    <?= $form->field($model, 'content')->textInput(['maxlength' => true,'placeholder' =>'描述']) ?>
    <?= $form->field($model, 'speaker')->textInput(['maxlength' => true,'placeholder' =>'讲座人']) ?>
    <?= $form->field($model, 'datetime')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => ''],
        'pluginOptions' => [
            'autoclose' => true,
            'todayHighlight' => true,
            'format' => 'yyyy-mm-dd hh:ii',
        ]
    ]); ?>
    <?= $form->field($model, 'address')->textInput(['maxlength' => true,'placeholder' =>'讲座地点']) ?>
    <?= $form->field($model, 'brand_name')->textInput(['maxlength' => true,'placeholder' =>'讲座名字']) ?>
    <?= $form->field($model, 'logo_url')->fileInput(['placeholder' =>'缩略图']) ?>
    <?= $form->field($model, 'notice')->textInput(['maxlength' => true,'placeholder' =>'卡券使用提醒']) ?>
    <?= $form->field($model, 'service_phone')->textInput(['maxlength' => true,'placeholder' =>'联系电话']) ?>
    <?= $form->field($model, 'description')->textInput(['maxlength' => true,'placeholder' =>'卡券使用说明']) ?>
    <?= $form->field($model, 'quantity')->textInput(['maxlength' => true,'placeholder' =>'卡券库存数量']) ?>
    <?= $form->field($model, 'custom_url_name')->textInput(['maxlength' => true,'placeholder' =>'自定义跳转外链的入口名字']) ?>
    <?= $form->field($model, 'custom_url')->textInput(['maxlength' => true,'placeholder' =>'自定义跳转URL']) ?>
    <?= $form->field($model, 'custom_url_sub_title')->textInput(['maxlength' => true,'placeholder' =>'显示在入口右侧的提示语']) ?>

    <div class="form-group-btn">
        <?= Html::submitButton('修改', ['class' => 'btn btn-primary', 'id'=> 'submit-btn']) ?>
        <?= Html::a("返回", ['index'], ["class" => "btn btn-primary back-btn"]) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<script>
    $(function(){
        $('#submit-btn').click(function(){
            if($.trim($('#lecture-title').val()) == ''){
                alert('请输入标题！');
                $('#lecture-title').focus();
                return false;
            }
            // if($.trim($('#lecture-content').val()) == ''){
            //     alert('请输入描述！');
            //     $('#lecture-content').focus();
            //     return false;
            // }
            if($.trim($('#lecture-speaker').val()) == ''){
                alert('请输入讲座人！');
                $('#lecture-speaker').focus();
                return false;
            }
            if($.trim($('#lecture-datetime').val()) == ''){
                alert('请输入时间！');
                $('#lecture-datetime').focus();
                return false;
            }
            if($.trim($('#lecture-address').val()) == ''){
                alert('请输入地址！');
                $('#lecture-address').focus();
                return false;
            }

            if(confirm('您确定要提交吗？')){
                return true;
            }else{
                return false;
            }
        });
    });

</script>