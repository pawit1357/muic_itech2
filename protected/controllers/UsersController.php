<?php

/**
 * SiteController is the default controller to handle user requests.
 */
class UsersController extends CController
{
	public $layout='main';
	private $_model;

	/**
	 * Index action is the default action in a controller.
	 */
	public function actionIndex()
	{
		$model = new Users();

		$this->render('main', array(
				'data' => $model,
		));
	}
	public function actionCreate()
	{

		if(isset($_POST['Users'])){
			$model = new Users();
			$model->attributes = $_POST['Users'];
			$model->password = md5($model->password);
			$model->create_by = 'SYSTEM';
			$model->app_id= $model->department_id;
			if($model->save()){
				$this->redirect(Yii::app()->createUrl('Users/'));
			}
		}
		$this->render('create');

	}
	public function actionDelete()
	{
		$model = $this->loadModel();
		if($model->delete()){
			$this->redirect(Yii::app()->createUrl('Users/'));
		}

		$this->render('main', array(
				'data' => $model,
		));
	}
	public function actionView()
	{
		$model = $this->loadModel();
		$this->render('view', array(
				'model' => $model,
		));
	}
	public function actionUpdate()
	{

		$model = $this->loadModel();
		if(isset($_POST['Users'])){
			$model->attributes = $_POST['Users'];
			$model->password = md5($model->password);
			$model->app_id= $model->department_id;
			if($model->update()){
				$this->redirect(Yii::app()->createUrl('Users/'));
			}
		}
		$this->render('update', array(
				'model' => $model,
		));
	}

	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=Users::model()->findbyPk(array('id' => $_GET['id'],'username'=>$_GET['username'],'app_id'=>$_GET['app_id']));
			if($this->_model===null)
				echo "XXX";
				//throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}


}