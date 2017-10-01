a<script type="text/javascript">
$(function(){
	$('#users-form').submit(function(){
		return (validateForm() && confirm('Confirm ?'));
		});
});
function validateForm(){
	var isResult = true;
	var txtname = $('#name').val();
	var status = $('#status :selected').val();
		
	if(txtname==""){
				$("#name").focus();
				$('#txtname').html('<b style="color:red">*Name invalid</b>');
				isResult = false;
				return false;
	}else{
				$('#txtname').html('');
	}
	if(status==0){
				$('#txtstatus').html('<b style="color:red">*Status invalid</b>');
				isResult = false;
				return false;
	}else{
				$('#txtstatus').html('');
	}
	if(isResult == false){
				alert("Please correct data.");
			
			}			
		return isResult;
}
</script>

<div class="full_w">
	<div class="h_title">Management-Edit-User Role</div>
	<?php 
	$form = $this->beginWidget('CActiveForm', array(
			'id' => 'users-form',
			'enableAjaxValidation' => true
	));
	?>

	<div class="element">
		<label for="name">Name <span class="red">(required)</span>
		</label>
		<?php echo $form->textField(UsersRole::model(), 'name', array('id'=>'name','size' => 20, 'maxlength' => 255, 'value'=>$model->name)); ?>
		<div id="txtname"></div>
	</div>
	<div class="element">
		<label for="name">Status <span class="red">(required)</span>
		</label> <select id="status" name="UsersRole[status]">
			<option value="">--Select--</option>
			<option value="ACTIVE"
			<?php echo $model->status == 'ACTIVE' ? 'selected="selected"' : ''?>>ACTIVE</option>
			<option value="INACTIVE"
			<?php echo $model->status == 'INACTIVE' ? 'selected="selected"' : ''?>>INACTIVE</option>
			<option value="HIDDEN"
			<?php echo $model->status == 'HIDDEN' ? 'selected="selected"' : ''?>>HIDDEN</option>
		</select>
		<div id="txtstatus"></div>
	</div>
	<div class="element">
		<label for="name">Description </label>
		<?php echo $form->textArea(UsersRole::model(), 'description', array('value'=>$model->description)); ?>
	</div>

	<div class="entry">
		<!-- 			<button type="submit">Preview</button> -->
		<button type="submit" class="add">Save</button>
		<button type="reset" class="cancel"
			onClick="javascript:history.back();">Cancel</button>
	</div>
	<?php $this->endWidget(); ?>
</div>





