<script type="text/javascript">
$(function(){
	$('#users-form').submit(function(){
		return (validateForm() && confirm('Confirm ?'));
		});
});
function validateForm(){
	var isResult = true;
	var txtid = $('#id').val();
	var txtname = $('#name').val();
	var active = $('#active :selected').val();
		
	if(txtid==""){
				$("#id").focus();
				$('#txtid').html('<b style="color:red">*ID invalid</b>');
				isResult = false;
				return false;
	}else{
				$('#txtid').html('');
	}
	if(txtname==""){
				$("#name").focus();
				$('#txtname').html('<b style="color:red">*Name invalid</b>');
				isResult = false;
				return false;
	}else{
				$('#txtname').html('');
	}
	if(active==0){
				$('#txtactive').html('<b style="color:red">*Status invalid</b>');
				isResult = false;
				return false;
	}else{
				$('#txtactive').html('');
	}
	if(isResult == false){
				alert("Please correct data.");
			
			}
		return isResult;	
}
</script>

<div class="full_w">
	<div class="h_title">Management-Create-Status Group</div>
	<?php 
	$form = $this->beginWidget('CActiveForm', array(
			'id' => 'users-form',
			'enableAjaxValidation' => true
	));
	?>

		<div class="element">
			<label for="name">ID <span class="red">(required)</span>
			</label> <?php echo $form->textField(MStatusGroup::model(), 'id', array('id'=>'id','size' => 50, 'maxlength' => 255)); ?>
			<div id="txtid"></div>
		</div>
		<div class="element">
			<label for="name">Name <span class="red">(required)</span>
			</label> <?php echo $form->textField(MStatusGroup::model(), 'name', array('id'=>'name','size' => 50, 'maxlength' => 255)); ?>
			<div id="txtname"></div>
		</div>
		<div class="element">
			<label for="name">Description
			</label> <?php echo $form->textArea(MStatusGroup::model(), 'description', array()); ?>
		</div>
		
		<div class="element">
			<label for="name">Status<span class="red">(required)</span>
			</label> <select id="active" name="MStatusGroup[active]">
					<option value="">--Select--</option>
					<option value="Y">ACTIVE</option>
					<option value="N">INACTIVE</option>
			</select>
			<div id="txtactive"></div>
		</div>
	
		<div class="entry">
			<!-- 			<button type="submit">Preview</button> -->
			<button type="submit" class="add">Save</button>
			<button type = "reset" class="cancel" onClick="javascript:history.back();">Cancel</button>
		</div>
	<?php $this->endWidget(); ?>
</div>
