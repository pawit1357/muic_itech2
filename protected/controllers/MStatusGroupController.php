<?php

/**
 * SiteController is the default controller to handle user requests.
 */
class MStatusGroupController extends CController
{
	public $layout='main';
	private $_model;

	/**
	 * Index action is the default action in a controller.
	 */
	public function actionIndex()
	{
		$model = new MStatusGroup();
		$this->render('main', array(
				'data' => $model,
		));
		
	}
	public function actionCreate()
	{
		if(isset($_POST['MStatusGroup'])){
			$model = new MStatusGroup();
			$model->attributes = $_POST['MStatusGroup'];
			if($model->save()){
				$this->redirect(Yii::app()->createUrl('MStatusGroup/'));
			}
		}
		$this->render('create');

	}
	public function actionDelete()
	{
		$model = $this->loadModel();
		if($model->delete()){
			$this->redirect(Yii::app()->createUrl('MStatusGroup/'));
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
		if(isset($_POST['MStatusGroup'])){
			$model->attributes = $_POST['MStatusGroup'];
			if($model->update()){
				$this->redirect(Yii::app()->createUrl('MStatusGroup/'));
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
				$this->_model=MStatusGroup::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}


}