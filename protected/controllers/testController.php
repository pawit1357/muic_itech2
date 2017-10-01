<?php

/**
 * Default controller to handle user requests.
 */
class TestController extends CController
{
	public $layout='main';
	private $_model;

	public function actionIndex()
	{

	}

	public function actionCreate()
	{

		if(isset($_POST['Test'])){
			$model = new Test();
			$model->attributes = $_POST['Test'];
			if($model->save()){
				$this->redirect(Yii::app()->createUrl('Test/'));
			}
		}
		$this->render('create');

	}


	public function actionUpdate()
	{
		$model = $this->loadModel();
		if(isset($_POST['Test'])){
			$model->attributes = $_POST['Test'];
			if($model->update()){
				$this->redirect(Yii::app()->createUrl('Test/'));
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
				$this->_model=Test::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}


	public function actionDelete()
	{
		$model = $this->loadModel();
		$model->delete();

		$model = new Test();


		$this->render('main', array(
				'data' => $model,
		));
	}

}