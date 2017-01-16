<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Project*/
/* @var $form yii\widgets\ActiveForm */
$this->title = '修改';
$this->params['breadcrumbs'][] = ['label' => 'Project', 'url' =>  ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = ['label' => $model->projectname, 'url' => ['view', 'id' => $model->id]];
?>
<div class="center subject_name">
    <span>项目管理</span>
</div>
<div class="col-xs-12">

    <?php $form = ActiveForm::begin([
        'action' => ['project/edit/'.$model['id']],
        'method' => 'post',
        'id' => 'my_form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'projectname')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'school')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'is_neibu')->widget(Select2::classname(), ['data' => ['0' => '外部', '1' => '内部'], ]); ?>
    <?= $form->field($model, 'over')->widget(Select2::classname(), ['data' => ['0' => '否', '1' => '是'], ]); ?>
    <?= $form->field($model, 'free')->widget(Select2::classname(), ['data' => ['0' => '否', '1' => '是'], ]); ?>

    <?= $form->field($model, 'teacher')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'time')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => ''],
        'pluginOptions' => [
            'autoclose' => true,
            'todayHighlight' => true,
            'format' => 'yyyy-mm-dd',
        ]
    ]); ?>
    <?= $form->field($model, 'endtime')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => ''],
        'pluginOptions' => [
            'autoclose' => true,
            'todayHighlight' => true,
            'format' => 'yyyy-mm-dd',
        ]
    ]); ?>

    <?= $form->field($model, 'original_path')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'making_path')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'uploadname')->widget(Select2::classname(), ['data' => $person_list ]); ?>

    <div class="form-group-btn">
        <?= Html::submitButton('修改', ['class' => 'btn btn-primary', 'id'=> 'submit-btn']) ?>
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