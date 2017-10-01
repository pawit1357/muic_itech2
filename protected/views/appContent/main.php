<div class="full_w">
	<div class="h_title">Management-Content</div>
	<?php
	$this->widget('zii.widgets.grid.CGridView', array(
			'id' => 'my-model-grid',
			'dataProvider' => $data->search(),
			'ajaxUpdate'=>true,
			'columns' => array(
					array(
							'header'=>'#',
							'value'=>'$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',       //  row is zero based
							'htmlOptions'=>array('width'=>'5%', 'align'=>'center'),
					),
					array(
							'name'=>'menu_id',
							'htmlOptions'=>array('width'=>'5%', 'align'=>'center'),
					),
					array(
							'name'=>'iPhone image',
							'type'=>'raw',
							'visible'=>(($_SESSION['MenuType'] != 2)?true:false),
							'value'=>'CHtml::image(Yii::app()->request->baseUrl."/".$data->image_src1,
							"",
							array(\'width\'=>100, \'height\'=>62))',
							'htmlOptions'=>array('width'=>'20%', 'align'=>'center'),
					),		
					array(
							'name'=>'iPad image',
							'type'=>'raw',
							'visible'=>(($_SESSION['MenuType'] != 2)?true:false),
							'value'=>'CHtml::image(Yii::app()->request->baseUrl."/".$data->image_src2,
							"",
							array(\'width\'=>100, \'height\'=>62))',
							'htmlOptions'=>array('width'=>'20%', 'align'=>'center'),
					),
					array(
							'name'=>'topic',
							'htmlOptions'=>array('width'=>'15%'),
					),
					array(
							'name'=>'status',
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
		<?php echo CHtml::link('Add New',array('appContent/create'), array('class'=>'button add'));?>
	</div>
</div>

<div class="clear"></div>
