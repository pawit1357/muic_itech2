<?php
class DashboardController extends CController
{
	public $layout='login';
	private $_model;

	public function actionIndex()
	{
		// Authen Login
		if(!UserLoginUtil::isLogin()){
			$this->redirect(Yii::app()->createUrl('Dashboard/login'));
		}
		// Render
		$this->redirect(Yii::app()->createUrl('AppMenu/'));
	}
	
	/**
	 * Login Page
	 */
	public function actionLogin()
	{
		// if login redirect to index
		if(UserLoginUtil::isLogin()){
			$this->redirect(Yii::app()->createUrl(''));
		}
		// if post parameters username and password submitted
		if(isset($_POST['Users']['username']) && isset($_POST['Users']['password'])){
			$username = addslashes($_POST['Users']['username']);
			$password = addslashes($_POST['Users']['password']);
			// Authen
			echo '=================='.UserLoginUtil::authen($username, $password);
			if(UserLoginUtil::authen($username, $password)) {
				$this->redirect(Yii::app()->createUrl('AppMenu/'));
			} else {
				$this->redirect(Yii::app()->createUrl('Dashboard/login'));
			}
		}
		$this->render('login');
	}
	
	/**
	 * Logout
	 */
	public function actionLogout()
	{
		UserLoginUtil::logout();
		$this->redirect(Yii::app()->createUrl('Dashboard/login'));
	}
	
}