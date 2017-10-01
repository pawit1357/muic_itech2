<script type="text/javascript">
$(function(){
	$('#users-form').submit(function(){
		return (validateForm() && confirm('Confirm ?'));
		});
});
function validateForm(){
	var isResult = true;
	var txtdepartment_code = $('#department_code').val();
	var app_id = $('#app_id :selected').val();
	var txtname = $('#name').val();
	
	
	
	if(txtdepartment_code==""){
				$("#department_code").focus();
				$('#txtdepartment_code').html('<b style="color:red">*Code invalid</b>');
				isResult = false;
				return false;
	}else{
				$('#txtdepartment_code').html('');
	}
	if(app_id==0){
				$('#txtapp_id').html('<b style="color:red">*App ID invalid</b>');
				isResult = false;
				return false;
	}else{
				$('#txtapp_id').html('');
	}
	if(txtname==""){
				$("#name").focus();
				$('#txtname').html('<b style="color:red">*Name invalid</b>');
				isResult = false;
				return false;
	}else{
				$('#txtname').html('');
	}
	if(isResult == false){
				alert("Please correct data.");			
			}				
		return isResult;	
}

</script>
<div class="full_w">
	<div class="h_title">Management-Create-Department</div>
	<?php 
	$form = $this->beginWidget('CActiveForm', array(
			'id' => 'users-form',
			'enableAjaxValidation' => true
	));
	?>

	<div class="element">
		<label for="name">Code <span class="red">(required)</span>
		</label>
		<?php echo $form->textField(MDepartment::model(), 'department_code', array('id'=>'department_code','size' => 20, 'maxlength' => 255)); ?>
		<div id="txtdepartment_code"></div>
	</div>
	<div class="element">
		<label for="name">App ID <span class="red">(required)</span>
		</label>
		<?php 
		$appStore = AppStore::model()->findAll();
		?>
		<select id="app_id" name="MDepartment[app_id]">
			<option value="">-Select-</option>
			<?php foreach($appStore as $appStore) {?>
			<option value="<?php echo $appStore->id?>"><?php echo $appStore->name?></option>
			<?php }?>
		</select>
		<div id="txtapp_id"></div>
	</div>
	<div class="element">
		<label for="name">Name <span class="red">(required)</span>
		</label>
		<?php echo $form->textField(MDepartment::model(), 'name', array('id'=>'name','size' => 20, 'maxlength' => 255)); ?>
		<div id="txtname"></div>
	</div>
	<div class="element">
		<label for="name">Description </label>
		<?php echo $form->textArea(MDepartment::model(), 'description', array()); ?>
	</div>

	<div class="entry">
		<!-- 			<button type="submit">Preview</button> -->
		<button type="submit" class="add">Save</button>
		<button type="reset" class="cancel"
			onClick="javascript:history.back();">Cancel</button>
	</div>
	<?php $this->endWidget(); ?>
</div>
