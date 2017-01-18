<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Teacher */
/* @var $form yii\widgets\ActiveForm */
$this->title = '添加人员';
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="center subject_name">
    <span>添加人员</span>
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

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'passwordRepeat')->passwordInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'orgid')->widget(Select2::classname(), ['data' => ['0' => '用户', '2' => '管理员'], ] ); ?>

    <div class="form-group-btn">
        <?= Html::submitButton('添加', ['class' => 'btn btn-primary', 'id' => 'submit-btn']) ?>
        <?= Html::a("返回", ['index'], ["class" => "btn btn-primary back-btn"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    $(function () {
        $('#submit-btn').click(function () {
            if ($.trim($('#smsadminnoauth-username').val()) == '') {
                alert('请输入用户名！');
                $('#smsadminnoauth-username').focus();
                return false;
            }
            if ($.trim($('#smsadminnoauth-password').val()) == '') {
                alert('请输入密码！');
                $('#smsadminnoauth-password').focus();
                return false;
            }
            if ($.trim($('#smsadminnoauth-orgid').val()) == '') {
                alert('请选择用户角色！');
                return false;
            }
            if (confirm('您确定要提交吗？')) {
                return true;
            } else {
                return false;
            }
        });
    });

</script>
