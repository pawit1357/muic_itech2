<?php

/**
 * Default controller to handle user requests.
 */
class AppStoreController extends CController
{
	public $layout='main';
	private $_model;

	public function actionIndex()
	{
		
		$model = new AppStore();	

		$this->render('main', array(
				'data' => $model,
		));
		
	}
	
	public function actionCreate()
	{
		if(isset($_POST['AppStore'])){
			$model = new AppStore();
			$model->attributes = $_POST['AppStore'];
			if($model->save()){
				$this->redirect(Yii::app()->createUrl('AppStore/'));
			}
		}
		$this->render('create');
	}
	
	
	public function actionUpdate()
	{
		$model = $this->loadModel();
		if(isset($_POST['AppStore'])){
			$model->attributes = $_POST['AppStore'];
			if($model->update()){
				$this->redirect(Yii::app()->createUrl('AppStore/'));
			}
		}
		$this->render('update', array(
				'model' => $model,
		));
	}
	
	public function actionView()
	{
		$model = $this->loadModel();
		$this->render('view', array(
				'model' => $model,
		));
	}
	
	
	public function actionDelete()
	{
		$model = new AppStore();
	
		$model = $this->loadModel();
		if($model->delete()){
			$this->redirect(Yii::app()->createUrl('AppStore/'));
		}

		$this->render('main', array(
				'data' => $model,
		));
	}
	

	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=AppStore::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
}