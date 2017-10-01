<script type="text/javascript">
$(function(){
	$('#users-form').submit(function(){
		return (validateForm() && confirm('Confirm ?'));
		});
});
function validateForm(){
	var isResult = true;

		return isResult;	
}
</script>

<div class="full_w">
	<div class="h_title">Management-Import-Book</div>
	<?php
	$form = $this->beginWidget ( 'CActiveForm', array (
			'id' => 'users-form',
			'enableAjaxValidation' => true,
			'htmlOptions' => array (
					'enctype' => 'multipart/form-data' 
			) 
	) );
	?>



	<div class="element">
		<label for="name">Import File <b style="color: red">* Allow only *.xls</b>
		</label>
		<?php echo $form->hiddenField(Book::model(), 'book_cover1', array('size' => 50, 'maxlength' => 255)); ?>
		<input type="file" name="fileupload1" id="fileupload1" size="25">
	</div>

	<div class="entry">
		<!-- 			<button type="submit">Preview</button> -->
		<button type="submit" class="add">Save</button>
		<button type="reset" class="cancel"
			onClick="javascript:history.back();">Cancel</button>
	</div>
	<?php $this->endWidget(); ?>
</div>
