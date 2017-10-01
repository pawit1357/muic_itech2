<div class="full_w">
	<div class="h_title">Management-User Role</div>
	
		<table>
		<thead>
			<tr>
				<th>#</th>
				<th>name</th>
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
				<td class="center"><?php echo  $counter++;?></td>
				<td class="center"><?php echo $data->name?></td>
				<td class="center"><?php echo $data->status?></td>

				<td class="center"><a title="Edit" class="fa fa-edit"
					href="<?php echo Yii::app()->CreateUrl('UsersRole/Update/id/'.$data->id)?>">Edit</a>|
					<a title="Delete"
					onclick="return confirm('ต้องการลบข้อมูลใช่หรือไม่?')"
					class="fa fa-trash"
					href="<?php echo Yii::app()->CreateUrl('UsersRole/Delete/id/'.$data->id)?>">Delete</a>



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
		<?php echo CHtml::link('Add New',array('UsersRole/create'), array('class'=>'button add'));?>
	</div>
</div>

<div class="clear"></div>
