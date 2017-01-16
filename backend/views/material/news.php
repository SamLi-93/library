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
	<tr><th>序号</th><th>标题</th><th>作者</th><th>是否摘要(仅单图文有效)</th><th>是否显示封面</th><th>上传时间</th><th>操作</th></tr>
	<?foreach($data as $key=>$value){
		$num = count($value['content']['news_item']);
		foreach ($value['content']['news_item'] as $k => $v) {
			if($k == 0){?>
				<tr>
					<td rowspan="<?=$num?>"><?=$key?></td>
					<td><?=$v['title']?></td>
					<td><?=$v['author']?></td>
					<td><?=$v['digest']==0?'否':'是'?></td>
					<td><?=$v['show_cover_pic']==0?'否':'是'?></td>
					<td rowspan="<?=$num?>"><?=date('Y-m-d H:i:s',$value['content']['update_time'])?></td>
					<td rowspan="<?=$num?>"><a href="<?=Url::to(['material/delete', 'id' => $value['media_id']])?>">删除</a></td>
				</tr>
			<?}
			if($k>0){?>
				<tr>
					<td><?=$v['title']?></td>
					<td><?=$v['author']?></td>
					<td><?=$v['digest']==0?'否':'是'?></td>
					<td><?=$v['show_cover_pic']==0?'否':'是'?></td>
				</tr>
			<?}?>

		<?}?>

	<?}?>
	<tr><td><?=$error?></td></tr>
</table>