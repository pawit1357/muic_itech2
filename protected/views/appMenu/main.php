
<script type="text/javascript">
$(document).ready(function(){
	$("#browser").treeview();

});
</script>

<div class="full_w">
	<div class="h_title">
		<?php echo CHtml::image('../images/i_archive.png', ''); ?>
		จัดการเมนู
	</div>
	<br>

	<div id="content" class="general-style1">
		<?php 
		$app_id = UserLoginUtil::getUserAppId();
		if(isset($app_id)){
			MenuUtil::getMenu($app_id);
		}

		?>
	</div>
		<!-- 
	<div class="entry">
		<div class="sep"></div>
		<?//php echo CHtml::link('Create Menu',array('appMenu/create'), array('class'=>'button add'));?>
	</div>
	-->
</div>

<div class="clear"></div>
