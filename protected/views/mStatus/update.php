
<div class="full_w">
	<div class="h_title">Management-Edit-Status</div>
	<?php 
	$form = $this->beginWidget('CActiveForm', array(
			'id' => 'users-form',
			'enableAjaxValidation' => true
	));
	?>

		<div class="element">
			<label for="name">Status Code <span class="red">(required)</span>
			</label> <?php echo $form->textField(MStatus::model(), 'status_code', array('size' => 50, 'maxlength' => 255,'value'=>$model->status_code)); ?>
		</div>
		<div class="element">
			<label for="name">Status Group ID <span class="red">(required)</span>
			</label> <?php 
				$mStatusGroup = MStatusGroup::model()->findAll();
				?>
				<select name="MStatus[status_group_id]">
					<option value="">-Select-</option>
					<?php foreach($mStatusGroup as $mStatusGroup) {?>
						<option value="<?php echo $mStatusGroup->id?>" <?php echo $mStatusGroup->id == $model->status_group_id ? 'selected="selected"' : ''?>><?php echo $mStatusGroup->name?></option>
					<?php }?>
				</select>
		</div>
		<div class="element">
			<label for="name">Name <span class="red">(required)</span>
			</label> <?php echo $form->textField(MStatus::model(), 'name', array('size' => 50, 'maxlength' => 255,'value'=>$model->name)); ?>
		</div>
		<div class="element">
			<label for="name">Description
			</label> <?php echo $form->textArea(MStatus::model(), 'description', array('value'=>$model->description)); ?>
		</div>
		
		<div class="element">
			<label for="name">Status Code <span class="red">(required)</span>
			</label> <select name="MStatus[active]">
					<option value="">--Select--</option>
					<option value="Y" <?php echo 'Y' == $model->active ? 'selected="selected"' : ''?>>ACTIVE</option>
					<option value="N" <?php echo 'N' == $model->active ? 'selected="selected"' : ''?>>INACTIVE</option>
			</select>
		</div>
	
		<div class="entry">
			<!-- 			<button type="submit">Preview</button> -->
			<button type="submit" class="add">Save</button>
			<button type = "reset" class="cancel" onClick="javascript:history.back();">Cancel</button>
		</div>
	<?php $this->endWidget(); ?>
</div>
