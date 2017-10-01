<div class="full_w">
	<div class="h_title">Management-Gallery</div>
	<h2>MUIC AppGallery</h2>
	<p>MUIC AppGallery</p>

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
// 				array(
// 						'name'=>'app_id',
// 						'htmlOptions'=>array('width'=>'5%', 'align'=>'center'),
// 				),
				array(
						'name'=>'menu_id',
						'htmlOptions'=>array('width'=>'5%', 'align'=>'center'),
				),
				array(
						'name'=>'iPhone image',
						'type'=>'raw',
						'value'=>'CHtml::image(Yii::app()->request->baseUrl."/".$data->image_src1,
							"",
							array(\'width\'=>100, \'height\'=>62))',
						'htmlOptions'=>array('width'=>'20%', 'align'=>'center'),
				),
				array(
						'name'=>'iPad,image',
						'type'=>'raw',
						'value'=>'CHtml::image(Yii::app()->request->baseUrl."/".$data->image_src2,
							"",
							array(\'width\'=>100, \'height\'=>62))',
						'htmlOptions'=>array('width'=>'20%', 'align'=>'center'),
				),
				array(
						'name'=>'status',
						'htmlOptions'=>array('width'=>'15%'),
				),
				/* array(
						'name'=>'thumnail_src',
						'htmlOptions'=>array('width'=>'15%', 'align'=>'center'),
				), */
				array(            // display a column with "view", "update" and "delete" buttons
						'class'=>'CButtonColumn',
						'template'=>' {update} {delete}',
						'htmlOptions'=>array('width'=>'10%', 'align'=>'center'),
						'buttons'=>array
						(
// 								'view' => array
// 								(
// 										'visible'=>'UserLoginUtil::hasPermission(array("FULL_ADMIN", "VIEW_USER"))',
// 								),
// 								'update' => array
// 								(
// 										'visible'=>'UserLoginUtil::hasPermission(array("FULL_ADMIN", "UPDATE_USER"))',
// 								),
// 								'delete' => array
// 								(
// 										'visible'=>'UserLoginUtil::hasPermission(array("FULL_ADMIN", "DELETE_USER"))',
// 								),
						),
				),
		),
));
?>
	<div class="entry">
<!-- 		<div class="pagination"> -->
<!-- 			<span>« First</span> <span class="active">1</span> <a href="">2</a> <a -->
<!-- 				href="">3</a> <a href="">4</a> <span>...</span> <a href="">23</a> <a -->
<!-- 				href="">24</a> <a href="">Last »</a> -->
<!-- 		</div> -->
		<div class="sep"></div>
		<?php echo CHtml::link('Add New',array('appGallery/create'), array('class'=>'button add'));?>
	</div>
</div>

<div class="clear"></div>
