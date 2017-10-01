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
	var parent1 = $('#parent1 :selected').val();
	var menu_icon = $('#menu_icon :selected').val();
	var txtmenu_type = $('#menu_type :selected').val();
	var txtmenu_item = $('#menu_item').val();
	var active = $('#menu_status :selected').val();
	if(menu_icon==0){
				$('#txtmenu_icon').html('<b style="color:red">*Menu Icon invalid</b>');
				isResult = false;
				return false;
	}else{
				$('#txtmenu_icon').html('');
	}
	if(txtmenu_type==-1){

				$('#txtmenu_type').html('<b style="color:red">*Menu Type invalid</b>');
				isResult = false;
				return false;
	}else{
				$('#txtmenu_type').html('');
	}
	if(txtmenu_item==""){
				$("#menu_item").focus();
				$('#txtmenu_item').html('<b style="color:red">*Menu Item invalid</b>');
				isResult = false;
				return false;
	}else{
				$('#txtmenu_item').html('');
	}

	if(active==0){
			$('#txtactive').html('<b style="color:red">*Status invalid</b>');
			isResult = false;
	}else{
			$('#txtactive').html('');
	}
	
	if(isResult == false){
				alert("Please correct data.");
			
			}
		return isResult;
}

</script>
<div
	class="full_w">
	<div class="h_title">Management-Edit-Menu</div>
	<?php 
	$form = $this->beginWidget('CActiveForm', array(
			'id' => 'users-form',
			'enableAjaxValidation' => true
	));
	?>
	<div class="element">
		<label for="name">Menu Parent <span class="red">(required)</span>
		</label>
		<?php 
		$appMenus = AppMenu::model()->findAll(array('condition'=>" app_id=".UserLoginUtil::getUserAppId()));

		?>
		<select id="parent1" name="AppMenu[parent]"
			onchange="document.getElementById('parent').value = document.getElementById('parent1').value">
			<option value="">-Select-</option>
			<?php foreach($appMenus as $am) {?>

			<option value="<?php echo $am->id?>"
			<?php if($am->id == $model->parent){?> selected="selected" <?php }?>><?php echo $am->menu_item?></option>
			<?php }?>
		</select>
		<div id="txtparent1"></div>
		<?php echo $form->hiddenField(AppMenu::model(), 'parent', array('id'=>'parent','size' => 50, 'maxlength' => 255,'value'=>$model->parent)); ?>

	</div>

	<!--------- Start select box show picture -------->
	<div class="element">
		<label for="name">Menu Icon <span class="red">(required)</span>
		</label>
		<?php 
		//$appStore = AppStore::model()->findAll();
		$path = realpath(Yii::app()->basePath . '/../images/')."/icon_app_menu/".UserLoginUtil::getUserAppId();
		$d = dir($path);
		//$pathsave = str_replace('images','',$path); //substring
		$test = array();
		$i= 0;
		$tmpImg = basename($model->menu_icon);
		while (false !== ($entry = $d->read())) {
						if($entry != '.' && $entry != '..' && $entry != '1' && $entry != '2' && $entry != '3' && $entry != '4'&& $entry != '.svn') {
						$test[$i++] = $entry;

						}
					}

					?>
		<select id="menu_icon" name="AppMenu[menu_icon]">
			<option value="">-Select-</option>
			<?php foreach($test as $appS) {?>

			<option value="<?php  echo $path.'/'.$appS?>"
			<?php if($appS == $tmpImg){?> selected="selected" <?php }?>
				data-icon='/itech2/images/icon_app_menu/<?php echo UserLoginUtil::getUserAppId().'/'.
				$appS;?>'><?php echo $appS; ?></option>
			<?php }?>
		</select>
		<div id="txtmenu_icon"></div>
	</div>

	<!--------- end select box show picture -------->

	<div class="element">
		<label for="name">Menu Order<span class="red">(required)</span>
		</label>
		<?php echo $form->textField(AppMenu::model(), 'menu_order', array('id'=>'menu_order', 'size' => 50, 'maxlength' => 255, 'value'=>$model->menu_order)); ?>
		<div id="txtmenu_order"></div>
	</div>
	<div class="element">
		<label for="name">Menu Name<span class="red">(required)</span>
		</label>
		<?php echo $form->textField(AppMenu::model(), 'menu_item', array('id'=>'menu_item', 'size' => 50, 'maxlength' => 255, 'value'=>$model->menu_item)); ?>
		<div id="txtmenu_item"></div>
	</div>
	<div class="element">
		<label for="name">Menu Description<span class="red">(required)</span>
		</label>
		<?php echo $form->textField(AppMenu::model(), 'menu_item_src', array('id'=>'menu_item_src', 'size' => 50, 'maxlength' => 255, 'value'=>$model->menu_item_src)); ?>
		<div id="txtmenu_item"></div>
	</div>

	<div class="element">
		<label for="name">Display Format <span class="red">(required)</span>
		</label> 
		<select id="menu_type" name="AppMenu[menu_type]">
			<option value="-1">--Select--</option>
			<option value="0" <?php if($model->menu_type == 0){?> selected=selected <?php }?>>Menu</option>
			<option value="1" <?php if($model->menu_type == 1){?> selected=selected <?php }?>>News&amp;Event</option>
			<option value="11" <?php if($model->menu_type == 1){?> selected=selected <?php }?>>News&amp;Event-content</option>
			<option value="2" <?php if($model->menu_type == 2){?> selected=selected <?php }?>>Announce</option>
			<option value="21" <?php if($model->menu_type == 2){?> selected=selected <?php }?>>Announce-content</option>
			<option value="3" <?php if($model->menu_type == 3){?> selected=selected <?php }?>>Gallery</option>
			<option value="31" <?php if($model->menu_type == 3){?> selected=selected <?php }?>>Gallery-content</option>
			<?php if(UserLoginUtil::getUserAppId() == 2 ){?>
			<option value="4" <?php if($model->menu_type == 4){?> selected=selected <?php }?>>Promotion</option>
			<option value="41" <?php if($model->menu_type == 4){?> selected=selected <?php }?>>Promotoin-content</option>
			<?php }?>
			<option value="5" <?php if($model->menu_type == 5){?> selected=selected <?php }?>>Content</option>
			<?php if(UserLoginUtil::getUserAppId() == 4 ){?>
			<option value="6" <?php if($model->menu_type == 6){?> selected=selected <?php }?>>Book</option>
			<option value="7" <?php if($model->menu_type == 7){?> selected=selected <?php }?>>Thesis</option>
			<option value="8" <?php if($model->menu_type == 8){?> selected=selected <?php }?>>Faq</option>
			<?php }?>
		</select>
		
		
		

		<div id="txtmenu_type"></div>
	</div>


	<div class="element">
		<label for="name">Menu Status <span class="red">(required)</span>
		</label> <select id="active" name="AppMenu[menu_status]">
			<option value="">--Select--</option>
			<option value="A"
			<?php echo $model->menu_status == 'A' ? 'selected="selected"' : ''?>>ACTIVE</option>
			<option value="I"
			<?php echo $model->menu_status == 'I' ? 'selected="selected"' : ''?>>INACTIVE</option>
		</select>
		<div id="txtactive"></div>
	</div>

	<script type="text/javascript"
		src="<?php echo Yii::app()->request->baseUrl;?>/js/wSelect.js"></script>
	<script type="text/javascript">
		$('select').wSelect();
	</script>

	<div class="entry">
		<!-- 			<button type="submit">Preview</button> -->
		<button type="submit" class="add">Save</button>
		<button type="reset" class="cancel"
			onClick="javascript:history.back();">Cancel</button>
	</div>
	<?php $this->endWidget(); ?>
</div>
