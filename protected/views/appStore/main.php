<div class="full_w">
	<div class="h_title">Management-Store</div>
	
	<table style="width: 96%; impotant!">
		<thead>
			<tr>
				<th>#</th>
				<th>name</th>
				<th>bundle</th>
				<th>platform</th>
				<th>version</th>
<!-- 				<th>questionnaire_url</th> -->
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
				<td class="center"><?php echo $data->name?></td>
				<td class="center"><?php echo $data->bundle?></td>
				<td class="center"><?php echo $data->platform?></td>
				<td class="center"><?php echo $data->version?></td>

				<td class="center"><a title="Edit" class="fa fa-edit"
					href="<?php echo Yii::app()->CreateUrl('appStore/Update/id/'.$data->id)?>">Edit</a>|
					<a title="Delete"
					onclick="return confirm('ต้องการลบข้อมูลใช่หรือไม่?')"
					class="fa fa-trash"
					href="<?php echo Yii::app()->CreateUrl('appStore/Delete/id/'.$data->id)?>">Delete</a>



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
		<?php echo CHtml::link('Add New',array('appStore/create'), array('class'=>'button add'));?>
	</div>
</div>

<div class="clear"></div>
