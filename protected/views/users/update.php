<script type="text/javascript">
$(function(){
	$('#users-form').submit(function(){
		return (validateForm() && confirm('Confirm ?'));
		});
});
function validateForm(){
	var isResult = true;
	var role_id = $('#role_id :selected').val();
	var txtusername = $('#username').val();
	var txtpassword = $('#password').val();
	var status = $('#status :selected').val();
	var txtcreate_by = $('#create_by').val();
	var department_id = $('#department_id :selected').val();
	var txtemail = $('#email').val();
	
	
	if(role_id==0){
				$('#txtrole_id').html('<b style="color:red">*Role ID invalid</b>');
				isResult = false;
				return false;
	}else{
				$('#txtrole_id').html('');
	}
	if(txtusername==""){
				$("#username").focus();
				$('#txtusername').html('<b style="color:red">*Username invalid</b>');
				isResult = false;
				return false;
	}else{
				$('#txtusername').html('');
	}
	if(txtpassword==""){
				$("#password").focus();
				$('#txtpassword').html('<b style="color:red">*Password invalid</b>');
				isResult = false;
				return false;
	}else{
				$('#txtpassword').html('');
	}
	if(status==0){
				$('#txtstatus').html('<b style="color:red">*Status invalid</b>');
				isResult = false;
				return false;
	}else{
				$('#txtstatus').html('');
	}
	if(txtcreate_by==""){
				$("#create_by").focus();
				$('#txtcreate_by').html('<b style="color:red">*Create By invalid</b>');
				isResult = false;
				return false;
	}else{
				$('#txtcreate_by').html('');
	}
	if(department_id==0){
				$('#txtdepartment_id').html('<b style="color:red">*Department ID invalid</b>');
				isResult = false;
				return false;
	}else{
				$('#txtdepartment_id').html('');
	}
	if(txtemail==""){
				$("#email").focus();
				$('#txtemail').html('<b style="color:red">*Email invalid</b>');
				isResult = false;
				return false;
	}else{
				$('#txtemail').html('');
	}
	if(isResult == false){
				alert("Please correct data.");
			
			}
		return isResult;
}
</script>

<div class="full_w">
	<div class="h_title">Management-Edit-User</div>
	<?php 
	$form = $this->beginWidget('CActiveForm', array(
			'id' => 'users-form',
			'enableAjaxValidation' => true
	));
	?>



	<div class="element">
		<label for="name">Username <span class="red">(required)</span>
		</label>
		<?php echo $form->textField(Users::model(), 'username', array('id'=>'username', 'size' => 50, 'maxlength' => 255,'value'=>$model->username)); ?>
		<div id="txtusername"></div>
	</div>

	<div class="element">
		<label for="name">Password <span class="red">(required)</span>
		</label>
		<?php echo $form->passwordField(Users::model(), 'password', array('id'=>'password', 'size' => 50, 'maxlength' => 255)); ?>
		<div id="txtpassword"></div>
	</div>
	<div class="element">
		<label for="name">Status Group ID <span class="red">(required)</span>
		</label>
		<?php 
		$mRole = UsersRole::model()->findAll();
		?>
		<select id="role_id" name="Users[role_id]">
			<option value="">-Select-</option>
			<?php foreach($mRole as $mRole) {?>
			<option value="<?php echo $mRole->id?>"
			<?php echo $mRole->id == $model->role_id ? 'selected="selected"' : ''?>><?php echo $mRole->name?></option>
			<?php }?>
		</select>
		<div id="txtrole_id"></div>
	</div>


	<div class="element">
		<label for="name">Application <span class="red">(required)</span>
		</label>
		<?php 
		$department = MDepartment::model()->findAll();
		?>
		<select id="department_id" name="Users[department_id]">
			<option value="">-Select-</option>
			<?php foreach($department as $department) {?>
			<option value="<?php echo $department->id?>"
			<?php echo $department->id == $model->department_id ? 'selected="selected"' : ''?>><?php echo $department->name?></option>
			<?php }?>
		</select>
		<div id="txtdepartment_id"></div>
	</div>

	<div class="element">
		<label for="name">Email <span class="red">(required)</span>
		</label>
		<?php echo $form->textField(Users::model(), 'email', array('id'=>'email', 'size' => 50, 'maxlength' => 255,'value'=>$model->email)); ?>
		<div id="txtemail"></div>
	</div>

	<div class="element">
		<label for="name">Status <span class="red">(required)</span>
		</label> <select id="status" name="Users[status]">
			<option value="">--Select--</option>
			<option value="ACTIVE"
			<?php echo $model->status == 'ACTIVE' ? 'selected="selected"' : ''?>>ACTIVE</option>
			<option value="INACTIVE"
			<?php echo $model->status == 'INACTIVE' ? 'selected="selected"' : ''?>>INACTIVE</option>
		</select>
		<div id="txtstatus"></div>
	</div>

	<?php echo $form->hiddenField(Users::model(), 'user_type', array('size' => 50, 'maxlength' => 255,'value'=>'1')); ?>



	<div class="entry">
		<!-- 			<button type="submit">Preview</button> -->
		<button type="submit" class="add">Save</button>
		<button type="reset" class="cancel"
			onClick="javascript:history.back();">Cancel</button>
	</div>
	<?php $this->endWidget(); ?>
</div>
