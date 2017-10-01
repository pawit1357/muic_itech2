
<script type="text/javascript"
	src="<?php echo Yii::app()->request->baseUrl;?>/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
$(function(){
	$('#users-form').submit(function(){
		return (validateForm() && confirm('Confirm ?'));
		});
});
function validateForm(){
	var isResult = true;
	var question_id = $('#question_id :selected').val();
	//var txtanswer = $('#answer').val();
	var active = $('#active :selected').val();
	
	if(question_id==0){
				$('#txtquestion_id').html('<b style="color:red">*Question ID invalid</b>');
				isResult = false;
				return false;
	}else{
				$('#txtquestion_id').html('');
	}
	/*
	if(txtanswer==""){
				$("#answer").focus();
				$('#txtanswer').html('<b style="color:red">*Answer invalid</b>');
				isResult = false;
				return false;
	}else{
				$('#txtanswer').html('');
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
	<div class="h_title">Management-Create-Question Answer</div>
	<?php 
	$form = $this->beginWidget('CActiveForm', array(
			'id' => 'users-form',
			'enableAjaxValidation' => true
	));
	?>
		<div class="element">
			<label for="name">Question ID <span class="red">(required)</span>
			</label> <?php 
				$question = Question::model()->findAll();
				?>
				<select id="question_id" name="QuestionAnswer[question_id]">
					<option value="">-Select-</option>
					<?php foreach($question as $question) {?>
					
						<option value="<?php echo $question->id?>" <?php echo $question->id == $model->question_id  ? 'selected="selected"' : ''?>><?php echo $question->question?></option>
					<?php }?>
				</select>
			<div id="txtquestion_id"></div>
		</div>
		
		

		
		
		<div class="element">
			<label for="name">Answer <span class="red">(required)</span>
			</label> <?php echo $form->textArea(QuestionAnswer::model(), 'answer', array('id'=>'answer','size' => 20, 'maxlength' => 255,'class' => 'ckeditor')); ?>
			<div id="txtanswer"></div>
		</div>
		
		<div class="element">
			<label for="name">Status <span class="red">(required)</span>
			</label> <select id="active" name="QuestionAnswer[status]">
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
