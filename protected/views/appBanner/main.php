<div class="full_w">
	<div class="h_title">Management-Banner</div>
	
	<table style="width: 96%; impotant!">
		<thead>
			<tr>
				<th>#</th>
				<th>iPhone image</th>
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
				<td class="center">
				<img src="<?php echo $data->image_path1?>" alt="" style="width:350px;height:62px;">
				</td>
<td><?php $data->status?></td>
				<td class="center"><a title="Edit" class="fa fa-edit"
					href="<?php echo Yii::app()->CreateUrl('appBanner/Update/id/'.$data->id)?>">Edit</a>|
					<a title="Delete"
					onclick="return confirm('ต้องการลบข้อมูลใช่หรือไม่?')"
					class="fa fa-trash"
					href="<?php echo Yii::app()->CreateUrl('appBanner/Delete/id/'.$data->id)?>">Delete</a>



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
		<?php echo CHtml::link('Add',array('appBanner/create'), array('class'=>'button add'));?>
	</div>
</div>

<div class="clear"></div>
