<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Project*/
/* @var $form yii\widgets\ActiveForm */
$this->title = '自动回复';
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<<<<<<< .mine
<script type="text/javascript" src="<?php echo Yii::$app ->request -> baseUrl?>/ckeditor/ckeditor.js">

</script>
<style type="text/css">
    #cke_indexkeywords-content{
        width: 600px;
    }
</style>
||||||| .r144
=======
<script type="text/javascript" src="<?php echo Yii::$app ->request -> baseUrl?>/ckeditor/ckeditor.js"></script>
<style type="text/css">
    #cke_indexkeywords-content{
        width: 600px;
    }
</style>
>>>>>>> .r145
<div class="center subject_name">
    <span>自动回复</span>
</div>
<div class="col-xs-12" style="padding-top: 10px;">
    <?php $form = ActiveForm::begin([
        'action' => ['create'],
        'method' => 'post',
        'id' => 'my_form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-3\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>
    <?= $form->field($model, 'keyword')->textInput(['maxlength' => true,'placeholder' =>'关键字']) ?>
    <?= $form->field($model, 'reply_type')->widget(Select2::classname(), ['data' => ['1' => '文本', '2' => '图片','3' => '图文'], ]); ?>
    <?= $form->field($model, 'content')->textInput(['maxlength' => true,'placeholder' =>'回复内容']) ?>
    <?= $form->field($model, 'summary')->textInput(['maxlength' => true,'placeholder' =>'简介']) ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true,'placeholder' =>'标题']) ?>
    <?= $form->field($model, 'imageFiles')->fileInput(['multiple' => false, 'accept' => 'image/*']) ?>
    <?= $form->field($model, 'url')->textInput(['maxlength' => true,'placeholder' =>'链接地址']) ?>


    <div class="form-group-btn">
        <?= Html::submitButton('添加', ['class' => 'btn btn-primary', 'id' => 'submit-btn']) ?>
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
var editor;
    $(function () {
<<<<<<< .mine
        $(".field-indexkeywords-imagefiles").css("visibility", "hidden");
        $(".field-indexkeywords-url").css("visibility", "hidden");
        $(".field-indexkeywords-title").css("visibility", "hidden");
//        $(".field-indexkeywords-summary").css("visibility", "hidden");
||||||| .r144
        $(".field-indexkeywords-imagefiles").css("visibility", "hidden");
        $(".field-indexkeywords-url").css("visibility", "hidden");
        $(".field-indexkeywords-title").css("visibility", "hidden");
        $(".field-indexkeywords-summary").css("visibility", "hidden");
=======
        $(".field-indexkeywords-imagefiles").css("display", "none");
        $(".field-indexkeywords-url").css("display", "none");
        $(".field-indexkeywords-title").css("display", "none");
        $(".field-indexkeywords-summary").css("display", "none");
>>>>>>> .r145
        $("#indexkeywords-reply_type").change(function () {
            var ss = $(this).children('option:selected').val();
            if(ss== 1) {
                if(editor)
                editor.destroy( true );
                editor = "";
                $(".field-indexkeywords-imagefiles").css("display", "none");
                $(".field-indexkeywords-url").css("display", "none");
            } else if(ss == 2) {
<<<<<<< .mine
                $(".field-indexkeywords-imagefiles").css("visibility", "visible");
                $(".field-indexkeywords-url").css("visibility", "hidden");
                $(".field-indexkeywords-title").css("visibility", "hidden");
//                $(".field-indexkeywords-summary").css("visibility", "hidden");
||||||| .r144
                $(".field-indexkeywords-imagefiles").css("visibility", "visible");
                $(".field-indexkeywords-url").css("visibility", "hidden");
                $(".field-indexkeywords-title").css("visibility", "hidden");
                $(".field-indexkeywords-summary").css("visibility", "hidden");
=======
                if(editor)
                editor.destroy( true );
                editor = "";
                $(".field-indexkeywords-imagefiles").css("display", "block");
                $(".field-indexkeywords-url").css("display", "none");
                $(".field-indexkeywords-title").css("display", "none");
                $(".field-indexkeywords-summary").css("display", "none");
>>>>>>> .r145
            } else if (ss == 3) {
<<<<<<< .mine
                $(".field-indexkeywords-title").css("visibility", "visible");
                $(".field-indexkeywords-imagefiles").css("visibility", "visible");
                $(".field-indexkeywords-url").css("visibility", "visible");
//                $(".field-indexkeywords-summary").css("visibility", "visible");
||||||| .r144
                $(".field-indexkeywords-title").css("visibility", "visible");
                $(".field-indexkeywords-imagefiles").css("visibility", "visible");
                $(".field-indexkeywords-url").css("visibility", "visible");
                $(".field-indexkeywords-summary").css("visibility", "visible");
=======
                editor = CKEDITOR.replace( 'indexkeywords-content', {extraPlugins : 'autogrow',removePlugins : 'resize'});
                $(".field-indexkeywords-title").css("display", "block");
                $(".field-indexkeywords-imagefiles").css("display", "block");
                $(".field-indexkeywords-url").css("display", "block");
                $(".field-indexkeywords-summary").css("display", "block");
>>>>>>> .r145
            }
        })
    })
    CKEDITOR.replace( 'indexkeywords-content',
        {

            // Define font sizes in percent values.
            fontSize_sizes : "30/30%;50/50%;100/100%;120/120%;150/150%;200/200%;300/300%",
            toolbar :
                [
                    ['Source', '-', 'Save','NewPage','-','Undo','Redo'],
                    ['Find','Replace','-','SelectAll','RemoveFormat'],
                    ['Link', 'Unlink', 'Image', 'Smiley','SpecialChar'],
                    '/',
                    ['Bold', 'Italic','Underline'],
                    ['FontSize'],
                    ['TextColor'],
                    ['NumberedList','BulletedList','-','Blockquote'],
                    ['Maximize']
                ],
            // Strip CKEditor smileys to those commonly used in BBCode.
            smiley_images :
                [
                    'regular_smile.gif','sad_smile.gif','wink_smile.gif','teeth_smile.gif','tounge_smile.gif',
                    'embaressed_smile.gif','omg_smile.gif','whatchutalkingabout_smile.gif','angel_smile.gif','shades_smile.gif',
                    'cry_smile.gif','kiss.gif'
                ],
            smiley_descriptions :
                [
                    'smiley', 'sad', 'wink', 'laugh', 'cheeky', 'blush', 'surprise',
                    'indecision', 'angel', 'cool', 'crying', 'kiss'
                ]
        } );

</script>
