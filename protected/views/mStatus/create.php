
<div class="full_w">
	<div class="h_title">Management-Create-Status</div>
	<?php 
	$form = $this->beginWidget('CActiveForm', array(
			'id' => 'users-form',
			'enableAjaxValidation' => true
	));
	?>

		<div class="element">
			<label for="name">Status Code <span class="red">(required)</span>
			</label> <?php echo $form->textField(MStatus::model(), 'status_code', array('size' => 50, 'maxlength' => 255)); ?>
		</div>
		

		<div class="element">
			<label for="name">Status Group ID <span class="red">(required)</span>
			</label> <?php 
				$mStatusGroup = MStatusGroup::model()->findAll();
				?>
				<select name="MStatus[status_group_id]">
					<option value="">-Select-</option>
					<?php foreach($mStatusGroup as $mStatusGroup) {?>
						<option value="<?php echo $mStatusGroup->id?>"><?php echo $mStatusGroup->id?></option>
					<?php }?>
				</select>
		</div>
		<div class="element">
			<label for="name">Name <span class="red">(required)</span>
			</label> <?php echo $form->textField(MStatus::model(), 'name', array('size' => 50, 'maxlength' => 255)); ?>
		</div>
		<div class="element">
			<label for="name">Description
			</label> <?php echo $form->textArea(MStatus::model(), 'description', array()); ?>
		</div>
		<div class="element">
			<label for="name">Status Code <span class="red">(required)</span>
			</label> <select name="MStatus[active]">
					<option value="">--Select--</option>
					<option value="Y">ACTIVE</option>
					<option value="N">INACTIVE</option>
			</select>
		</div>
	
	
		<div class="entry">
			<!-- 			<button type="submit">Preview</button> -->
			<button type="submit" class="add">Save</button>
			<button type = "reset" class="cancel" onClick="javascript:history.back();">Cancel</button>
		</div>
	<?php $this->endWidget(); ?>
</div>
