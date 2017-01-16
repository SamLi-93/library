<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Project*/
/* @var $form yii\widgets\ActiveForm */
$this->title = '讲座预定管理';
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="center subject_name">
    <span>讲座预定管理</span>
</div>
<div class="col-xs-12">

    <?php $form = ActiveForm::begin([
        'action' => ['create'],
        'method' => 'post',
        'id' => 'my_form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'lecture_id')->textInput(['maxlength' => true,'placeholder' =>'讲座id']) ?>
    <?= $form->field($model, 'readercode')->textInput(['maxlength' => true,'placeholder' =>'预定人的读者证']) ?>
    <?= $form->field($model, 'datetime')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => ''],
        'pluginOptions' => [
            'autoclose' => true,
            'todayHighlight' => true,
            'format' => 'yyyy-mm-dd',
        ]
    ]); ?>

    <div class="form-group-btn">
        <?= Html::submitButton('添加', ['class' => 'btn btn-primary', 'id' => 'submit-btn']) ?>
        <?= Html::a("返回", ['index'], ["class" => "btn btn-primary back-btn"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    $(function(){
        $('#submit-btn').click(function(){
            if($.trim($('#project-projectname').val()) == ''){
                alert('请输入项目名称！');
                $('#projectname').focus();
                return false;
            }
            if($.trim($('#project-school').val()) == ''){
                alert('请输入学校！');
                $('#school').focus();
                return false;
            }
            var date = ($('#project-time').val());
            var enddate = ($('#project-endtime').val());
            if(enddate != ''){
                if (enddate < date) {
                    alert('结束时间不能小于开始日期!');
                    return false
                }
            }
            if(confirm('您确定要提交吗？')){
                return true;
            }else{
                return false;
            }
        });
    });

</script>
