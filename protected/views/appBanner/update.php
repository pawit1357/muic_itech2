<script type="text/javascript">
$(function(){
	$('#users-form').submit(function(){
		return (validateForm() && confirm('Confirm ?'));
		});
});
function validateForm(){

	var active = $('#active :selected').val();
	if(active==0){
		$('#txtactive').html('<b style="color:red">*Status invalid</b>');
		isResult = false;
		return false;
	}else{
			$('#txtactive').html('');
	}
}
</script>

<div class="full_w">
	<div class="h_title">Management-Update-Banner</div>
	<?php 
	$form = $this->beginWidget('CActiveForm', array(
			'id' => 'users-form',
			'enableAjaxValidation' => true,
			'htmlOptions'=>array('enctype' => 'multipart/form-data')
	));
	?>

	<div class="element">
		<label for="name">Image url. <b style="color: red">*</b>
		</label>
		<?php echo $form->textField(AppBanner::model(), 'image_path1', array('id'=>'image_path1', 'size' => 100, 'maxlength' => 255, 'value'=>$model->image_path1)); ?>
				

	<div class="element">
		<label for="name">Status<span class="red">(required)</span>
		</label> <select id="active" name="AppBanner[status]">
			<option value="">--Select--</option>
			<option value="A"
			<?php echo $model->status == 'A' ? 'selected="selected"' : ''?>>ACTIVE</option>
			<option value="I"
			<?php echo $model->status == 'I' ? 'selected="selected"' : ''?>>INACTIVE</option>
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
</div>