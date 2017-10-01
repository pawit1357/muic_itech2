
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
	<div class="h_title">Management-Create-Icon</div>
	<?php 
	$form = $this->beginWidget('CActiveForm', array(
			'id' => 'users-form',
			'enableAjaxValidation' => true,
			'htmlOptions'=>array('enctype' => 'multipart/form-data')
	));
	?>


	<div class="element">
		<label for="name">Icon (Size 40*40) <b style="color: red">*Allow
				Only *.jpg,*.png</b>
		</label>
		<?php echo $form->hiddenField(AppIcon::model(), 'icon_path', array('size' => 50, 'maxlength' => 255)); ?>
    <input type="file" name="icon_path" id="icon_path">


	</div>


	<div class="entry">
		<!-- 			<button type="submit">Preview</button> -->
		<button type="submit" class="add">Save</button>
		<button type="reset" class="cancel"
			onClick="javascript:history.back();">Cancel</button>
	</div>
	<?php $this->endWidget(); ?>
</div>
