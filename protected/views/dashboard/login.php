

<div>
	<?php 
	// Start create form
	$form = $this->beginWidget('CActiveForm', array(
			'id' => 'users-form',
        'enableAjaxValidation' => false      )); ?>

	<b style="color: red"> <?php 
	if(isset($_SESSION['FAIL_MESSAGE'])){
				echo $_SESSION['FAIL_MESSAGE'];
				unset($_SESSION['FAIL_MESSAGE']);
			}

			?>
	</b> <label for="login">Username:</label> <input id="Users[username]"
		name="Users[username]" class="text" /> <label for="pass">Password:</label>
	<input id="Users[password]" name="Users[password]" type="password"
		class="text" />
	<div class="sep"></div>
	<button type="submit" class="ok">Login</button>
<!-- 	<a class="button" href="">Forgotten password?</a> -->
	<?php $this->endWidget(); ?>

</div>
