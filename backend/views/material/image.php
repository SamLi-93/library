<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

$this->title = '图文消息管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'post',
        'id' => 'my_form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>
  	<div>
  		<tr>
  			<td>类型:</td>
  			<td>
  				<select id="type" name="type">
			  		<?foreach($type_arr as $key=>$value){?>
			  			<option value="<?=$key?>" <?if($key==$type) echo "selected";?>><?=$value?></option>
			  		<?}?>
			  	</select>
			</td>
			<td> <?= Html::submitButton('确定', ['class' => 'btn btn-primary', 'id' => 'submit-btn']) ?></td>
			<td><a href="<?=Url::to(['material/create'])?>" class="btn btn-primary">增加素材</a></td>
  		</tr>
  	</div>
<?php ActiveForm::end(); ?>
<table style="width:500px;">
	<tr><th>多媒体id</th><th>多媒体</th><th>上传时间</th></tr>
	<?foreach($data as $key=>$value){?>
		<tr>
			<td style="width:33%"><?=$value['media_id']?></td>
			<td style="width:33%"><img src="<?=$value['url']?>"></td>
			<td style="width:33%"><?=date('Y-m-d H:i:s',$value['update_time'])?></td>
		</tr>
	<?}?>
	<tr><td><?=$error?></td></tr>
</table>