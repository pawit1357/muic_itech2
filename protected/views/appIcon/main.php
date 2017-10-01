<div class="full_w">
	<div class="h_title">Management-Icon</div>
	
	<table style="width: 96%; impotant!">
		<thead>
			<tr>
				<th>#</th>
				<th>icon</th>
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
				<td class="center">
				<img src="<?php echo Yii::app()->request->baseUrl."/".$data->icon_path?>" alt="" style="width:20px;height:20px;">
				</td>

				<td class="center"><a title="Edit" class="fa fa-edit"
					href="<?php echo Yii::app()->CreateUrl('AppIcon/Update/id/'.$data->id)?>">Edit</a>|
					<a title="Delete"
					onclick="return confirm('ต้องการลบข้อมูลใช่หรือไม่?')"
					class="fa fa-trash"
					href="<?php echo Yii::app()->CreateUrl('AppIcon/Delete/id/'.$data->id)?>">Delete</a>



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
		<?php echo CHtml::link('Add New',array('AppIcon/create'), array('class'=>'button add'));?>
	</div>
</div>

<div class="clear"></div>
