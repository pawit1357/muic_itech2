<script
	type="text/javascript"
	src="<?php echo Yii::app()->request->baseUrl;?>/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
$(function(){
	$('#users-form').submit(function(){
		return (validateForm() && confirm('Confirm ?'));
		});
});
function validateForm(){
	var isResult = true;
	var app_id = $('#app_id :selected').val();
	//var txtquestion = $('#question').val();
	var active = $('#active :selected').val();
	
	if(app_id==0){
				$('#txtapp_id').html('<b style="color:red">*App ID invalid</b>');
				isResult = false;
				return false;
	}else{
				$('#txtapp_id').html('');
	}
	/*
	if(txtquestion==""){
				$("#question").focus();
				$('#txtquestion').html('<b style="color:red">*Question invalid</b>');
				isResult = false;
				return false;
	}else{
				$('#txtquestion').html('');
	}
	*/
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
	<div class="h_title">Management-Create-Question</div>
	<?php 
	$form = $this->beginWidget('CActiveForm', array(
			'id' => 'users-form',
			'enableAjaxValidation' => true
	));
	?>
					
		<div class="element">
			<label for="name">Question <span class="red">(required)</span>
			</label> <?php echo $form->textArea(Question::model(), 'question', array('id'=>'question','size' => 20, 'maxlength' => 255,'class' => 'ckeditor')); ?>
			<div id="txtquestion"></div>
		</div>
		
		<div class="element">
			<label for="name">Status <span class="red">(required)</span>
			</label> <select id="active" name="Question[status]">
					<option value="">--Select--</option>
					<option value="A">ACTIVE</option>
					<option value="I">INACTIVE</option>
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
