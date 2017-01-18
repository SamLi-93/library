<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Teacher */
/* @var $form yii\widgets\ActiveForm */
$this->title = '人员管理';
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="center subject_name">
    <span>人员管理</span>
</div>
<div class="col-xs-12">

    <?php $form = ActiveForm::begin([
        'action' => ['account/edit/'. $model['id']],
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
    <? if (Yii::$app->user->identity->orgid==2) {
        echo $form->field($model, 'orgid')->widget(Select2::classname(), ['data' => ['0' => '用户', '1' => '审核人', '2' => '管理员'], ] );
    } ?>
<!--    --><?//= $form->field($model, 'orgid')->widget(Select2::classname(), ['data' => ['0' => '用户', '1' => '审核人', '2' => '管理员'], ] ); ?>

    <div class="form-group-btn">
        <?= Html::submitButton('修改', ['class' => 'btn btn-primary', 'id' => 'submit-btn']) ?>
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
            if (confirm('您确定要提交吗？')) {
                return true;
            } else {
                return false;
            }
        });
    });
</script>
