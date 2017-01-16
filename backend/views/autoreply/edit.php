<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Project*/
/* @var $form yii\widgets\ActiveForm */
$this->title = '自动回复';
$this->params['breadcrumbs'][] = ['label' => 'Project', 'url' =>  ['index']];
$this->params['breadcrumbs'][] = $this->title;
//$this->params['breadcrumbs'][] = ['label' => $model->projectname, 'url' => ['view', 'id' => $model->id]];
?>
<div class="center subject_name">
    <span>自动回复</span>
</div>
<div class="col-xs-12">

    <?php $form = ActiveForm::begin([
        'action' => ['autoreply/edit/'.$model['id']],
        'method' => 'post',
        'id' => 'my_form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

<!--    --><?//= var_dump($model['imageFiles']);exit;?>

    <?= $form->field($model, 'keyword')->textInput(['maxlength' => true,'placeholder' =>'关键字']) ?>
    <?= $form->field($model, 'reply_type')->widget(Select2::classname(), ['data' => ['1' => '文本', '2' => '图片','3' => '图文'], ]); ?>
    <?= $form->field($model, 'content')->textInput(['maxlength' => true,'placeholder' =>'回复内容']) ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true,'placeholder' =>'标题']) ?>
    <?= $form->field($model, 'summary')->textInput(['maxlength' => true,'placeholder' =>'简介']) ?>

    <div class="image_div" >
        <div class="fleft"><?= Html::a($model['imageFiles'], '#', ['title' => '图片']);?></div>
        <div class="image_delete"><?= Html::a('删除', '#', ['onclick'=> 'return check('.$model['imageFiles'].')', 'class' => 'btn-sm', 'id' => 'delete-iamge' ]);?></div>
    </div>

    <?= $form->field($model, 'imageFiles')->fileInput(['multiple' => false, 'accept' => 'image/*']) ?>
    <?= $form->field($model, 'url')->textInput(['maxlength' => true,'placeholder' =>'链接地址']) ?>

    <div class="form-group-btn">
        <?= Html::submitButton('修改', ['class' => 'btn btn-primary', 'id'=> 'submit-btn']) ?>
        <?= Html::a("返回", ['index'], ["class" => "btn btn-primary back-btn"]) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<script>
    $(function(){
        $('#submit-btn').click(function(){
            if($.trim($('#indexkeywords-keyword').val()) == ''){
                alert('请输入关键字！');
                $('#indexkeywords-keyword').focus();
                return false;
            }
            if($.trim($('#indexkeywords-reply_type').val()) == ''){
                alert('请选择类型！');
                $('#indexkeywords-reply_type').focus();
                return false;
            }
            if($.trim($('#indexkeywords-content').val()) == ''){
                alert('请输入回复内容！');
                $('#indexkeywords-content').focus();
                return false;
            }

            if(confirm('您确定要提交吗？')){
                return true;
            }else{
                return false;
            }
        });
    });
    $(function () {
//        $(".field-indexkeywords-imagefiles").css("visibility", "hidden");
        $(".field-indexkeywords-url").css("visibility", "hidden");
        $(".field-indexkeywords-title").css("visibility", "hidden");
        var tt = $("#indexkeywords-reply_type").val();
        if(tt == 1) {
            $(".field-indexkeywords-imagefiles").css("visibility", "hidden");
            $(".field-indexkeywords-url").css("visibility", "hidden");
            $(".field-indexkeywords-title").css("visibility", "hidden");
            $(".field-indexkeywords-summary").css("visibility", "hidden");
            $(".image_div").css("visibility", "hidden");
        } else if(tt == 2 ) {
            $(".field-indexkeywords-imagefiles").css("visibility", "visible");
            $(".field-indexkeywords-url").css("visibility", "hidden");
            $(".image_div").css("visibility", "visible");
            $(".field-indexkeywords-title").css("visibility", "hidden");
            $(".field-indexkeywords-summary").css("visibility", "hidden");
        } else if(tt == 3 ) {
            $(".field-indexkeywords-imagefiles").css("visibility", "visible");
            $(".field-indexkeywords-url").css("visibility", "visible");
            $(".image_div").css("visibility", "visible");
            $(".field-indexkeywords-title").css("visibility", "visible");
            $(".field-indexkeywords-summary").css("visibility", "visible");
        }
        $("#indexkeywords-reply_type").change(function () {
            var ss = $(this).children('option:selected').val();
            if(ss== 1) {
                $(".field-indexkeywords-imagefiles").css("visibility", "hidden");
                $(".field-indexkeywords-url").css("visibility", "hidden");
                $(".image_div").css("visibility", "hidden");

            } else if(ss == 2) {
                $(".field-indexkeywords-imagefiles").css("visibility", "visible");
                $(".field-indexkeywords-url").css("visibility", "hidden");
                $(".field-indexkeywords-title").css("visibility", "hidden");
            } else if (ss == 3) {
                $(".field-indexkeywords-title").css("visibility", "visible");
                $(".field-indexkeywords-imagefiles").css("visibility", "visible");
                $(".field-indexkeywords-url").css("visibility", "visible");
            }
        })
    })

</script>