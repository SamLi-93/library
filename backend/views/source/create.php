<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Project*/
/* @var $form yii\widgets\ActiveForm */
$this->title = '添加项目';
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<script type="text/javascript" src="<?php echo Yii::$app ->request -> baseUrl?>/ckeditor/ckeditor.js">

</script>
<style type="text/css">
    #cke_source-content{
        width: 600px;
    }
</style>
<div class="center subject_name">
    <span>消息添加</span>
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
    <?= $form->field($model, 'title')->textInput(['maxlength' => true,'placeholder' =>'']) ?>
    <?= $form->field($model, 'author')->textInput(['maxlength' => true,'placeholder' =>'']) ?>
    <?//= $form->field($model, 'thumb_media_id')->widget(Select2::classname(), ['data' => $list, ]); ?>
    <?= $form->field($model, 'file')->fileInput(['placeholder' =>'缩略图']) ?>
    <?= $form->field($model, 'digest')->widget(Select2::classname(), ['data' => ['0' => '否', '1' => '是'], ]); ?>
    <?= $form->field($model, 'show_cover_pic')->widget(Select2::classname(), ['data' => ['0' => '否', '1' => '是'], ]); ?>
    <?= $form->field($model, 'content')->textarea(['maxlength' => true,'placeholder' =>'','class'=>'content']) ?>
    <?= $form->field($model, 'content_source_url')->textInput(['maxlength' => true,'placeholder' =>'']) ?>
    <div class="form-group-btn">
        <?= Html::submitButton('添加', ['class' => 'btn btn-primary', 'id' => 'submit-btn']) ?>
        <?= Html::a("返回", ['index'], ["class" => "btn btn-primary back-btn"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    $(function(){
        $('#submit-btn').click(function(){
            /*if($.trim($('#project-projectname').val()) == ''){
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
            }*/
            if(confirm('您确定要提交吗？')){
                return true;
            }else{
                return false;
            }
        });
    });

CKEDITOR.replace( 'source-content',
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
