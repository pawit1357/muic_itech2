<div class="full_w">
	<div class="h_title">Management-User</div>
	<table style="width: 96%; impotant!">
		<thead>
			<tr>
				<th>#</th>
				<th>username</th>
				<th>latest_login</th>
				<th>status</th>
				<th class="no-sort"></th>
			</tr>
		</thead>
		<tbody>
	<?php
	$counter = 1;
	$dataProvider = $data->search ();
	
	foreach ( $dataProvider->data as $data ) {
		?>
				<tr class="line-<?php echo $counter%2 == 0 ? '1' : '2'?>">
				<td class="center"><?php echo  $counter;?></td>
				<td class="center"><?php echo $data->username?></td>
				<td class="center"><?php echo $data->latest_login?></td>
				<td class="center"><?php echo $data->status?></td>

				<td><a title="Edit" class="fa fa-edit"
					href="<?php echo Yii::app()->CreateUrl('Users/Update/id/'.$data->id.'/username/'.$data->username.'/app_id/'.$data->app_id)?>">Edit</a>|
					<a title="Delete"
					onclick="return confirm('ต้องการลบข้อมูลใช่หรือไม่?')"
					class="fa fa-trash"
					href="<?php echo Yii::app()->CreateUrl('Users/Delete/id/'.$data->id.'/username/'.$data->username.'/app_id/'.$data->app_id)?>">Delete</a>



				</td>
			</tr>
			<?php
		$counter ++;
	}
	?>
						</tbody>
	</table>

	<div class="entry">
		<div class="sep"></div>
		<?php echo CHtml::link('Add New',array('Users/create'), array('class'=>'button add'));?>
	</div>
</div>

<div class="clear"></div>