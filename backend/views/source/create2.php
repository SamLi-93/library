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
<div class="center subject_name">
    <span>图文消息添加</span>
</div>
<div class="col-xs-12">

    <?php $form = ActiveForm::begin([
        'action' => ['create2'],
        'method' => 'post',
        'id' => 'my_form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>
    <table>
        <tr>
        <?foreach($list as $key=>$value){?>
            <td><input type="checkbox" name="id[]" value="<?=$value['id']?>"><?=$value['title'];?></td>
        <?}?>
    </table>
    <input type="hidden" name="type" value="1" id="type">
    <div class="form-group-btn">
        <?//= Html::submitButton('添加', ['class' => 'btn btn-primary source_create','onclick' => 'return set(0)']) ?>
        <?= Html::submitButton('发送', ['class' => 'btn btn-primary source_create','onclick' => 'return set(1)']) ?>
        <?= Html::a("返回", ['index'], ["class" => "btn btn-primary"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    function set(type){
        $('#type').val(type);
        var id = document.getElementsByName("id[]");
            check_val = [];
            for(k in id){
                if(id[k].checked)
                    check_val.push(id[k].value);
            }
            if(check_val.length==0){
                alert('请至少选择一条');
                return false;
            }else{
                if(confirm('您确定要提交吗？')){
                    return true;
                }else{
                    return false;
                }
            }
    }
</script>
