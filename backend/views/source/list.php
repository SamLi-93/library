<table>
	<?foreach($list as $key=>$value){$data = $value[0];print_r($data);exit;?>
		<tr>
		<td><?=$data['media_id']?></td>
		<td><?=date('Y-m-d',$data['update_time'])?></td>>
		<tr>
	<?}?>
</table>