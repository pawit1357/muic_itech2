﻿<div class="full_w">
	<div class="h_title">Management-Status</div>
	<?php
$this->widget('zii.widgets.grid.CGridView', array(
		'id' => 'my-model-grid',
		'dataProvider' => $data->search(),
		'htmlOptions' => array('style' => 'width: 500px;'),
		'ajaxUpdate'=>true,
		'columns' => array(
				array(
						'header'=>'#',
						'value'=>'$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',       //  row is zero based
						'htmlOptions'=>array('width'=>'5%', 'align'=>'center'),
				),
				array(
						'name'=>'status_code',
						'htmlOptions'=>array('width'=>'5%', 'align'=>'center'),
				),
				array(
						'name'=>'status_group_id',
						'htmlOptions'=>array('width'=>'5%', 'align'=>'center'),
				),
				array(
						'name'=>'name',
						'htmlOptions'=>array('width'=>'15%', 'align'=>'center'),
				),
				array(
						'name'=>'active',
						'htmlOptions'=>array('width'=>'15%', 'align'=>'center'),
				),
				array(            // display a column with "view", "update" and "delete" buttons
						'class'=>'CButtonColumn',
						'template'=>'{update} {delete}',
						'htmlOptions'=>array('width'=>'10%', 'align'=>'center'),
						'buttons'=>array
						(
						),
				),
		),
));
?>
	<div class="entry">
		<div class="sep"></div>
		<?php echo CHtml::link('Add New',array('mstatus/create'), array('class'=>'button add'));?>
	</div>
</div>

<div class="clear"></div>