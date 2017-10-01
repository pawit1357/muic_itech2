
<script type="text/javascript">
$(document).ready(function(){
	$("#browser").treeview();

});
</script>

<div class="full_w">
	<div class="h_title">
		<?php echo CHtml::image('../../images/i_archive.png', ''); ?>
		จัดการเมนู
	</div>
	<br>

	<?php 
	$this->widget('zii.widgets.grid.CGridView', array(
			'id' => 'my-model-grid',
			'dataProvider' => $data->search1(),
			'ajaxUpdate'=>true,
			'columns' => array(
					array(
							'header'=>'#',
							'value'=>'$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',       //  row is zero based
							'htmlOptions'=>array('width'=>'5%', 'align'=>'center'),
					),
					array(
							'name'=>'menu_order',
							'htmlOptions'=>array('width'=>'5%'),
					),				
					array(
							'name'=>'menu_icon',
							'type'=>'raw',
							'value'=>'CHtml::image(Yii::app()->request->baseUrl."/".$data->menu_icon,
							"",
							array(\'width\'=>16, \'height\'=>16))',
							'htmlOptions'=>array('width'=>'20%', 'align'=>'center'),
					),					
					array(
							'name'=>'menu_item',
							'htmlOptions'=>array('width'=>'5%'),
					),
					array(
							'name'=>'menu_status',
							'htmlOptions'=>array('width'=>'5%', 'align'=>'center'),
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
		<?php //echo CHtml::link('Create Menu',array('appMenu/create'), array('class'=>'button add'));?>
	</div>
</div>

<div class="clear"></div>
