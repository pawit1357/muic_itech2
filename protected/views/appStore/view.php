<div class="full_w">
	<div class="h_title">View page - Detail AppStore</div>
	<table class="simple-form">
		<tr>
			<td class="column-left" width="15%">App Name</td>
			<td class="column-right"><?php echo $model->name ?></td>
		</tr>
		<tr>
			<td class="column-left">Version</td>
			<td class="column-right"><?php echo $model->bundle ?>
			</td>
		</tr>
		<tr>
			<td class="column-left">Platform</td>
			<td class="column-right"><?php echo $model->url ?>
			</td>
		</tr>
		<tr>
			<td class="column-left">Images</td>
			<td class="column-right"><?php echo $model->image ?>
			</td>
		</tr>
		<tr>
			<td class="column-left"></td>
			<td class="column-right"><?php 
			echo CHtml::link('Back',array('AppStore/')).' | ';
		echo CHtml::link('Edit',array('AppStore/update','id'=>$model->id)); ?>
			</td>
		</tr>
	</table>
</div>


