<div class="full_w">
	<div class="h_title">แจ้งข่าวสาร</div>
	<h2>แจ้งข่าวสาร(Pushnotification)</h2>
	<div class="entry">
		<div class="sep"></div>
	</div>
	<?php 
	$form = $this->beginWidget('CActiveForm', array(
			'id' => 'users-form',
			'enableAjaxValidation' => true
	));
	?>
	<?php if( UserLoginUtil::getUserAppId() == 1){?>
	<div class="element">
		<label for="name">Popup URL </label> <input name="url" id="url"
			style="width: 400px"></input>

		<div id="txtNameValidate"></div>
	</div>
	<?php }?>
	<div class="element">
		<label for="content">ข้อความ </label>
		<textarea name="content" class="textarea" rows="10"></textarea>
	</div>
	<div class="entry">
		<button type="submit" class="add">ส่ง</button>
		<button class="cancel">ยกเลิก</button>
	</div>
	<?php $this->endWidget(); ?>
</div>
