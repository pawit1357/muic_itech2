
<div class="full_w">
	<div class="h_title">Management-Create-Status</div>
	<?php 
	$form = $this->beginWidget('CActiveForm', array(
			'id' => 'users-form',
			'enableAjaxValidation' => true
	));
	?>


		<div class="element">
			<label for="name">Name <span class="red">(required)</span>
			</label> <?php echo $form->textField(Catagories::model(), 'name', array('size' => 50, 'maxlength' => 255)); ?>
		</div>
		<div class="element">
			<label for="name">Status Code <span class="red">(required)</span>
			</label> <select name="Catagories[status]">
					<option value="">--Select--</option>
					<option value="A">ACTIVE</option>
					<option value="I">INACTIVE</option>
			</select>
		</div>
	
		<div class="entry">
			<!-- 			<button type="submit">Preview</button> -->
			<button type="submit" class="add">Save</button>
			<button type = "reset" class="cancel" onClick="javascript:history.back();">Cancel</button>
		</div>
	<?php $this->endWidget(); ?>
</div>
