<!-- Start css and js Select box Show picture -->
<link
	rel="stylesheet"
	href="<?php echo Yii::app()->request->baseUrl;?>/css/style.css">
<link
	rel="stylesheet"
	href="<?php echo Yii::app()->request->baseUrl;?>/css/wSelect.css">


<script
	type="text/javascript"
	src="<?php echo Yii::app()->request->baseUrl;?>/js/jquery-1.9.1.min.js"></script>

<!-- End css Select box Show picture -->

<script type="text/javascript">

$(function(){
	$('#users-form').submit(function(){
		return (validateForm() && confirm('Confirm ?'));
		});
});
function validateForm(){
	var isResult = true;
	var txtName = $('#name').val();
	var txtBundle = $('#bundle').val();
	var txtUrl = $('#url').val();	
	var image = $('#image :selected').val();
	
	
	if(txtName==""){
				$("#name").focus();
				$('#txtNameValidate').html('<b style="color:red">*Name invalid</b>');
				isResult = false;
				return false;
	}else{
				$('#txtNameValidate').html('');
	}
	
	if(txtBundle==""){
				$("#bundle").focus();
				$('#txtBundleValidate').html('<b style="color:red">*Bundle invalid</b>');
				isResult = false;
				return false;
	}else{
				$('#txtBundle').html('');
	}

	if(image==0){
			$('#txtimage').html('<b style="color:red">*Image invalid</b>');
			isResult = false;
	}else{
			$('#txtimage').html('');
	}
	if(isResult == false){
				alert("Please correct data.");
			
			}
		return isResult;	
}

</script>

<div
	class="full_w">
	<div class="h_title">Management-Edit-Store</div>
	<?php 
	$form = $this->beginWidget('CActiveForm', array(
			'id' => 'users-form',
			'enableAjaxValidation' => true
	));
	?>
	<div class="element">
		<label for="name">App Name <span class="red">(required)</span>
		</label>
		<?php echo $form->textField(AppStore::model(), 'name', array('id'=>'name', 'size' => 50, 'maxlength' => 255,'value'=>$model->name)); ?>
		<div id="txtNameValidate"></div>
	</div>

	<div class="element">
		<label for="name">Bundle <span class="red">(required)</span>
		</label>
		<?php echo $form->textField(AppStore::model(), 'bundle', array('id'=>'bundle', 'size' => 50, 'maxlength' => 255,'value'=>$model->bundle)); ?>
		<div id="txtBundleValidate"></div>
	</div>
	<div class="element">
		<label for="name">URL <span class="red">(required)</span>
		</label>
		<?php echo $form->textField(AppStore::model(), 'url', array('id'=>'url', 'size' => 50, 'maxlength' => 255,'value'=>$model->url)); ?>
		<div id="txtUrlValidate"></div>
	</div>
	
		<div class="element">
		<label for="name">Questionnaire Url <span class="red">(required)</span>
		</label>
		<?php echo $form->textField(AppStore::model(), 'questionnaire_url', array('id'=>'questionnaire_url', 'size' => 50, 'maxlength' => 255,'value'=>$model->questionnaire_url)); ?>
		<div id="txtQuestionnaire_url"></div>
	</div>
		
	<div class="element">
		<label for="name">Platform </label> <select id="AppStore[platform]"
			name="AppStore[platform]" style="">
			<option value="0" <?php if($model->platform = 0){?> selected
			<?php }?>>--Select Platform--</option>
			<option value="1" <?php if($model->platform = 1){?> selected
			<?php }?>>IOS</option>
			<option value="2" <?php if($model->platform = 2){?> selected
			<?php }?>>Andriod</option>
		</select>

	</div>


	<!--------- Start select box show picture -------->
	<div class="element">
		<label for="name">Image <span class="red">(required)</span>
		</label>
		<?php 
		//$appStore = AppStore::model()->findAll();
		$path = "images/icon";
		$d = dir($path);
		$tmpSelectedIndex = 0;
		$pathsave = str_replace('images','',$path); //substring
		$test = array();
		$i= 0;
		$tmpImg = basename($model->image);
		while (false !== ($entry = $d->read())) {
						if($entry != '.' && $entry != '..' && $entry != '.svn'){
							$test[$i++] = $entry;
						}
					}
					?>

		<select id="image" name="AppStore[image]">
			<option value="">-Select-</option>
			<?php 

			foreach($test as $appS)
					 {?>
			<option value="<?php  echo $pathsave.'/'.$appS?>"
			<?php if($appS == $tmpImg){?> selected="selected" <?php }?>
				data-icon='/itech2/images/icon/<?php echo $appS;?>'><?php echo $appS; ?></option>
			<?php }

			?>
		</select>
		<div id="txtimage"></div>
	</div>
	<script type="text/javascript"
		src="<?php echo Yii::app()->request->baseUrl;?>/js/wSelect.js"></script>
	<script type="text/javascript">
		$('select').wSelect();
		</script>
	<!--------- end select box show picture -------->



	<div class="entry">
		<!-- 			<button type="submit">Preview</button> -->
		<button type="submit" class="add">Save</button>
		<button type="reset" class="cancel"
			onClick="javascript:history.back();">Cancel</button>
	</div>
	<?php $this->endWidget(); ?>
</div>
