﻿
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
	var menu_id = $('#menu_id :selected').val();
	var txtname = $('#name').val();
	var active = $('#active :selected').val();
	
	
	if(app_id==0){
				$('#txtapp_id').html('<b style="color:red">*App ID invalid</b>');
				isResult = false;
				return false;
	}else{
				$('#txtapp_id').html('');
	}	
	if(menu_id==0){
				$('#txtmenu_id').html('<b style="color:red">*Menu ID invalid</b>');
				isResult = false;
				return false;
	}else{
				$('#txtmenu_id').html('');
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
	<div class="h_title">Management-Create-Content</div>
	<?php 
	$form = $this->beginWidget('CActiveForm', array(
			'id' => 'users-form',
			'enableAjaxValidation' => true,
			'htmlOptions'=>array('enctype' => 'multipart/form-data')
	));
	?>


	<div class="element">
		<label for="name">Menu ID <span class="red">(required)</span>
		</label>
		<?php 
		$appMenu = AppMenu::model()->findAll(array('condition'=>" app_id=".UserLoginUtil::getUserAppId() ));
		?>
		<select id="menu_id" name="AppContent[menu_id]" disabled="disabled">
			<option value="">-Select-</option>
			<?php foreach($appMenu as $appMenu) {?>
			<option value="<?php echo $appMenu->id?>"
			<?php echo $appMenu->id == $model->menu_id ? 'selected="selected"' : ''?>><?php echo $appMenu->menu_item?></option>
			<?php }?>
		</select>
		<div id="txtmenu_id"></div>
	</div>

	<div class="element">
		<label for="name">Topic </label>
		<?php echo $form->textArea(AppContent::model(), 'topic', array('size' => 50, 'maxlength' => 255)); ?>
	</div>

	<div class="element">
		<label for="name">Description <span class="red">(required)</span>
		</label>
		<?php echo $form->textArea(AppContent::model(), 'description', array('id'=>'description' ,'size' => 50, 'maxlength' => 255,'class' => 'ckeditor')); ?>
		<div id="txtdescription"></div>
	</div>

	<?php //echo		'---=xx>'.$_SESSION['MenuType'] ?>
	
	<div class="element">
		<label for="name">Image url. <b style="color: red">*</b>
		</label>
		<?php echo $form->textField(AppContent::model(), 'image_src1', array('size' => 100, 'maxlength' => 255)); ?>
	</div>
	
	<?php if($_SESSION['MenuType'] != 2){?>
	<!-- 
	<div class="element">
		<label for="name">IPhone Image (Size 1536*2048) <b style="color: red">*Allow
				Only *.jpg,*.png</b>
		</label>
		<?//php echo $form->hiddenField(AppContent::model(), 'image_src1', array('size' => 50, 'maxlength' => 255)); ?>
		<?/* $this->widget('ext.EAjaxUpload.EAjaxUpload',
				array(
			        'id'=>'image_src1',
			        'config'=>array(
			               'action'=>Yii::app()->createUrl('AppContent/upload'),
			               'allowedExtensions'=>array("jpg","png"),//array("jpg","jpeg","gif","exe","mov" and etc...
			               'sizeLimit'=>5*1024*1024,// maximum file size in bytes
			              // 'minSizeLimit'=>10*1024*1024,// minimum file size in bytes
			              'onComplete'=>"js:function(id, fileName, responseJSON){ $('#AppContent_image_src1').val(fileName); }",
			               //'messages'=>array(
			               //                  'typeError'=>"{file} has invalid extension. Only {extensions} are allowed.",
			               //                  'sizeError'=>"{file} is too large, maximum file size is {sizeLimit}.",
			               //                  'minSizeError'=>"{file} is too small, minimum file size is {minSizeLimit}.",
			               //                  'emptyError'=>"{file} is empty, please select files again without it.",
			               //                  'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
			               //                 ),
			               //'showMessage'=>"js:function(message){ alert(message); }"
			              )
					)); */?>
	</div>
	<div class="element">
		<label for="name">IPad Image (Size 1536*2048) <b style="color: red">*Allow
				Only *.jpg,*.png</b>
		</label>
		<?//php echo $form->hiddenField(AppContent::model(), 'image_src2', array('size' => 50, 'maxlength' => 255)); ?>
		<?/* $this->widget('ext.EAjaxUpload.EAjaxUpload',
				array(
			        'id'=>'image_src2',
			        'config'=>array(
			               'action'=>Yii::app()->createUrl('AppContent/upload'),
			               'allowedExtensions'=>array("jpg","png"),//array("jpg","jpeg","gif","exe","mov" and etc...
			               'sizeLimit'=>5*1024*1024,// maximum file size in bytes
			              // 'minSizeLimit'=>10*1024*1024,// minimum file size in bytes
			              'onComplete'=>"js:function(id, fileName, responseJSON){ $('#AppContent_image_src2').val(fileName); }",
			               //'messages'=>array(
			               //                  'typeError'=>"{file} has invalid extension. Only {extensions} are allowed.",
			               //                  'sizeError'=>"{file} is too large, maximum file size is {sizeLimit}.",
			               //                  'minSizeError'=>"{file} is too small, minimum file size is {minSizeLimit}.",
			               //                  'emptyError'=>"{file} is empty, please select files again without it.",
			               //                  'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
			               //                 ),
			               //'showMessage'=>"js:function(message){ alert(message); }"
			              )
					)); */?>
	</div>
	-->
	<?php }?>

	<div class="element">
		<label for="name">Status<span class="red">(required)</span>
		</label> <select id="active" name="AppContent[status]">
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