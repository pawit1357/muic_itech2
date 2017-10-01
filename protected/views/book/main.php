<div class="full_w">
	<div class="h_title">Management-Book</div>

	<table style="width: 96%;">
		<thead>
			<tr>
				<th>#</th>
				<th>Cover</th>
				<th>book_name</th>
				<th>callNo</th>
				<th>program</th>
				<th>status</th>
				<th class="no-sort"></th>
			</tr>
		</thead>
		<tbody>
	<?php
	$counter = 1;
	$index = 1;
	//$dataProvider = $data->search ();
	foreach($models as $data){
// 	foreach ( $dataProvider->data as $data ) {
		?>
				<tr class="line-<?php echo $counter%2 == 0 ? '1' : '2'?>">
				<td class="center"><?php echo  $index;?></td>
				<td class="center"><?php echo CHtml::image($data->book_cover1,"",array('width'=>62, 'height'=>62))?></td>
				<td class="center"><?php echo $data->book_name?></td>
				<td class="center"><?php echo $data->callNo?></td>
				<td class="center"><?php echo $data->program?></td>
				<td class="center"><?php echo $data->status?></td>

				<td class="center"><a title="Edit" class="fa fa-edit"
					href="<?php echo Yii::app()->CreateUrl('book/Update/id/'.$data->id)?>">Edit</a>|
					<a title="Delete"
					onclick="return confirm('ต้องการลบข้อมูลใช่หรือไม่?')"
					class="fa fa-trash"
					href="<?php echo Yii::app()->CreateUrl('book/Delete/id/'.$data->id)?>">Delete</a>

				</td>
			</tr>
			<?php
		$counter ++;
		$index ++;
	}
	?>
						</tbody>
	</table>

	<div class="paging">
	<?php $this->widget('CLinkPager', array('pages' => $pages)) ?>
		<?php //GridUtil::RenderPageButton($this, $dataProvider); ?>
	</div>

	<div class="entry">
		<div class="sep"></div>
		<?php echo CHtml::link('Add New',array('book/create'), array('class'=>'button add'));?>
		|
		<?php echo CHtml::link('Import',array('book/importBook'), array('class'=>'button add'));?>
	</div>
</div>

<div class="clear"></div>
