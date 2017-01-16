<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Project*/
/* @var $form yii\widgets\ActiveForm */
$this->title = '课件管理';
$this->params['breadcrumbs'][] = ['label' => 'Project', 'url' =>  ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = ['label' => $model->projectname, 'url' => ['view', 'id' => $model->id]];
?>
<div class="center subject_name">
    <span>课程管理</span>
<!--    --><?// print_r($model);exit;?>
</div>
<div class="col-xs-12">

    <?php $form = ActiveForm::begin([
        'action' => ['videomaking/edit/'.$model['id']],
        'method' => 'post',
        'id' => 'my_form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'projectname')->widget(Select2::classname(), ['data' =>$pro_projectname ,
        'options' => ['placeholder' => '选择项目','onchange' => "changecheck(this.options[this.options.selectedIndex].value)" ],
    ]); ?>
    <?= $form->field($model, 'school')->widget(Select2::classname(), ['data' => $pro_school,
        'options' => ['placeholder' => '请选择学校','onchange' => "getteacher(this.options[this.options.selectedIndex].value)" ],
    ]); ?>

    <?= $form->field($model, 'courcename')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'teacher')->widget(Select2::classname(), ['data' =>$teacher_list , 'options' => ['placeholder' => '选择讲师'], ]); ?>
    <?= $form->field($model, 'subtitle')->widget(Select2::classname(), ['data' => ['0' => '否', '1' => '是'], 'options' => ['placeholder' => '选择有无字幕'], ]); ?>
    <?= $form->field($model, 'free')->widget(Select2::classname(), ['data' =>['0' => '否', '1' => '是'] , 'options' => ['placeholder' => '选择是否结算'], ]); ?>

    <?
        if (count($model['imageFiles'])>1) {
            foreach ($model['imageFiles'] as $k => $v) { ?>
            <div class="image_div" >
                <div class="fleft"><?= Html::a($v['path'], \yii\helpers\Url::to(['pic/makingsingle','path'=>$v['path']]), ['title' => '图片']);?></div>
                <div class="image_delete"><?= Html::a('删除', '', ['onclick'=> 'return check('.$v['id'].')', 'class' => 'btn-sm', 'id' => 'delete-iamge' ]);?></div>
            </div>
            <?}
        } elseif (count($model['imageFiles'])==1) { ?>
            <div class="image_div" >
                <div class="fleft"><?= Html::a($model['imageFiles'][0]['path'], \yii\helpers\Url::to(['pic/index','id'=>$model['id']]), ['title' => '图片']);?></div>
                <div class="image_delete"><?= Html::a('删除', '', ['onclick'=> 'return check('.$model['imageFiles'][0]['id'].')', 'class' => 'btn-sm', 'id' => 'delete-iamge' ]);?></div>
            </div>
        <?}
    ?>
    <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
    <?= $form->field($model, 'makingname', ['template' => "{label}\n<div class=\"col-lg-6\">{input}</div>",])->checkboxList($person_list,[
        'itemOptions' => ['checked' => '1']
    ]); ?>

    <div class="form-group-btn">
        <?= Html::submitButton('修改', ['class' => 'btn btn-primary', 'id'=> 'submit-btn']) ?>
        <?= Html::a("返回", ['index'], ["class" => "btn btn-primary back-btn"]) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<script>
    $(function(){
        $('#submit-btn').click(function(){
            if($.trim($('#videomaking-projectname').val()) == ''){
                alert('请选择项目名称！');
                return false;
            }
            if($.trim($('#videomaking-school').val()) == ''){
                alert('请选择学校名称！');
                return false;
            }
            if($.trim($('#videomaking-courcename').val()) == ''){
                alert('请输入课程名称！');
                $('#projectname').focus();
                return false;
            }
            if($.trim($('#videomaking-teacher').val()) == ''){
                alert('请选择讲师名称！');
                return false;
            }
            if($.trim($('#videomaking-subtitle').val()) == ''){
                alert('请选择字幕名称！');
                return false;
            }
            if($.trim($('#videomaking-free').val()) == ''){
                alert('请选择结算！');
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
<script>
    function check(id) {
        if(confirm('您确定要删除吗？')){
            $.ajax({
                type: "post",
                method: "post",
                dataType: "json",
                data: {"id": id},
                url: "<?= \yii\helpers\Url::to(['videomaking/picdelete']);?>",
                success: function(data){

                }
            });
        } else {
            return false;
        }
    }
    function changecheck(value) {
        $.ajax({
            type: "post",
            method: "post",
            dataType: "json",
            data: {"value": value},
            url: "<?= Url::to(['videomaking/changecheck']);?>",
            success: function(data){
                console.log(data);
                var name = data.coursename;
                var educational = data.educational;

                var school_list = "<select id=\"videomaking-school\" class=\"form-control select2-hidden-accessible\" name=\"VideoMaking[school]\" ><option value=\"\">选择课程名</option>";
                for(var i = 0; i < educational.length; i++){
                    school_list +="<option value=\"educational[i]\"> "+educational[i]+" </option>";
                }
                school_list +="</select>";
                $('#videomaking-school').html(school_list);
            }
        });
    }
//    function getteacher(value) {
//        $.ajax({
//            type: "post",
//            method: "post",
//            dataType: "json",
//            data: {"value": value},
//            url: "<?//= Url::to(['videomaking/getteacher']);?>//",
//            success: function(data){
//                console.log(data);
//                var teacher = data.teacher;
//
//                var teacher_list = "<select id=\"videomaking-teacher\" class=\"form-control select2-hidden-accessible\" name=\"VideoMaking[teacher]\" ><option value=\"\">选择讲师</option>";
//                for(key in teacher){
//                    teacher_list +="<option value="+teacher[key]+"> "+teacher[key]+" </option>";
//                }
//                teacher_list +="</select>";
//                $('#videomaking-teacher').html(teacher_list);
//            }
//        });
//    }



</script>