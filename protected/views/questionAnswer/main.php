<div class="full_w">
	<div class="h_title">Management-Question Answer</div>
	
	<table style="width: 96%; impotant!">
		<thead>
			<tr>
				<th>#</th>
				<th>question_id</th>
				<th>answer</th>
				<th>status</th>
				<th class="no-sort"></th>
			</tr>
		</thead>
		<tbody>
	<?php
	$counter = 1;
	$order = 1;
	$dataProvider = $data->search ();
	
	foreach ( $dataProvider->data as $data ) {
		?>
				<tr class="line-<?php echo $counter%2 == 0 ? '1' : '2'?>">
				<td class="center"><?php echo  $order;?></td>
				<td class="center"><?php echo $data->question->question?></td>
								<td class="center"><?php echo $data->answer?></td>
				
				<td class="center"><?php echo $data->status?></td>

				<td class="center">
				<a title="Edit" class="fa fa-edit"
					href="<?php echo Yii::app()->CreateUrl('QuestionAnswer/Update/id/'.$data->id)?>">Edit</a>|
					<a title="Delete"
					onclick="return confirm('ต้องการลบข้อมูลใช่หรือไม่?')"
					class="fa fa-trash"
					href="<?php echo Yii::app()->CreateUrl('QuestionAnswer/Delete/id/'.$data->id)?>">Delete</a>




				</td>
			</tr>
			<?php
		$counter ++;
		$order++;
	}
	?>
						</tbody>
	</table>
	
	<div class="entry">
		<div class="sep"></div>
		<?php echo CHtml::link('Add New',array('questionAnswer/create'), array('class'=>'button add'));?>
	</div>
</div>

<div class="clear"></div>
