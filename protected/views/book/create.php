
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
	var txtbook_name = $('#book_name').val();

	var txtRecommented  =$('#txtRecommented').val();
	var active = $('#active :selected').val();
	var type = $('#type :selected').val();
	var flag = $('#flag :selected').val(););
	if(txtbook_name==""){
				$("#book_name").focus();
				$('#txtbook_name').html('<b style="color:red">*Book Name invalid</b>');
				isResult = false;
				return false;
	}else{
				$('#txtbook_name').html('');
	}
	if(txtRecommented==""){
		$("#txtRecommented").focus();
		$('#txtRecommented').html('<b style="color:red">*Recommented invalid</b>');
		isResult = false;
		return false;
		}else{
				$('#txtRecommented').html('');
		}	
	if(flag==0){
		$('#txtflag').html('<b style="color:red">*New Arrival invalid</b>');
		isResult = false;
		return false;
	}else{
			$('#txtflag').html('');
	}
	if(type==0){
		$('#type').html('<b style="color:red">*type invalid</b>');
		isResult = false;
		return false;
	}else{
			$('#txttype').html('');
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
	<div class="h_title">Management-Create-Book</div>
	<?php 
	$form = $this->beginWidget('CActiveForm', array(
			'id' => 'users-form',
			'enableAjaxValidation' => true,
			'htmlOptions'=>array('enctype' => 'multipart/form-data')
	));
	?>
	<div class="element">
		<label for="name">Book Name <span class="red">(required)</span>
		</label>
		<?php echo $form->textField(Book::model(), 'book_name', array('id'=>'book_name' ,'size' => 50, 'maxlength' => 255)); ?>
		<div id="txtbook_name"></div>
	</div>

	<div class="element">
		<label for="name">Image url. <b style="color: red">*</b>
		</label>
				<?php echo $form->textArea(Book::model(), 'book_cover1', array('size' => 100, 'maxlength' => 255)); ?>

	</div>



	<div class="element">
		<label for="name">Book Title <span class="red">(required)</span>
		</label>
		<?php echo $form->textArea(Book::model(), 'book_title', array('id'=>'book_title' ,'size' => 50, 'maxlength' => 255,'class' => 'ckeditor')); ?>
		<div id="txtbook_title"></div>
	</div>

	<div class="element">
		<label for="name">Book Author </label>
		<?php echo $form->textField(Book::model(), 'book_author', array('size' => 50, 'maxlength' => 255)); ?>
	</div>

	<div class="element">
		<label for="name">Call No. </label>
		<?php echo $form->textField(Book::model(), 'callNo', array('size' => 50, 'maxlength' => 255)); ?>
	</div>

	<div class="element">
		<label for="name">Division </label>
		<?php echo $form->textField(Book::model(), 'division', array('size' => 50, 'maxlength' => 255)); ?>
	</div>

	<div class="element">
		<label for="name">Program </label>
		<?php echo $form->textField(Book::model(), 'program', array('size' => 50, 'maxlength' => 255)); ?>
	</div>

	<div class="element">
		<label for="name">Type </label> <select id="type"
			name="Book[type]">
			<option value="">--Select--</option>
			<option value="6">Book</option>
			<option value="7">Thesis</option>
			<!-- 
			<option value="2">Thematic Paper</option>
			<option value="3">Magazine</option>
			<option value="5">Book</option>
			 -->
		</select>
		<div id="txttype"></div>
	</div>

	<div class="element">
		<label for="name">New Arrival<span class="red">(required)</span>
		</label> <select id="flag" name="Book[flag]">
			<option value="">--Select--</option>
			<option value="T">Yes</option>
			<option value="F">No</option>
		</select>
		<div id="txtflag"></div>
	</div>
	<div class="element">
		<label for="name">Recommented<span class="red">(required)</span>
		</label> <select id="recommented" name="Book[recommented]">
			<option value="">--Select--</option>
			<option value="T">Yes</option>
			<option value="F">No</option>
		</select>
		<div id="txtRecommented"></div>
	</div>	

	
	<div class="element">
		<label for="name">Status<span class="red">(required)</span>
		</label> <select id="active" name="Book[status]">
			<option value="">--Select--</option>
			<option value="A">ACTIVE</option>
			<option value="I">INACTIVE</option>
		</select>
		<div id="txtactive"></div>
	</div>


	<div class="entry">
		<!-- 			<button type="submit">Preview</button> -->
		<button type="submit" class="add">Save</button>
		<button type="reset" class="cancel"
			onClick="javascript:history.back();">Cancel</button>
	</div>
	<?php $this->endWidget(); ?>
</div>
