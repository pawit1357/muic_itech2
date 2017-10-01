<?php

/**
 * Default controller to handle user requests.
 */
class QuestionAnswerController extends CController
{
	public $layout='main';
	private $_model;

	public function actionIndex()
	{
		$model = new QuestionAnswer();
		$this->render('main', array(
				'data' => $model,
		));
		
	}
	
	public function actionCreate()
	{
		if(isset($_POST['QuestionAnswer'])){
			$model = new QuestionAnswer();
			$model->attributes = $_POST['QuestionAnswer'];
			if($model->save()){
				$this->redirect(Yii::app()->createUrl('QuestionAnswer/'));
			}
		}
		$question_id = Yii::app()->getRequest()->getQuery('id');
		$model->question_id = $question_id;
		$this->render('create', array(
				'model' => $model,
		));
	}
	
	
	public function actionUpdate()
	{
		$model = $this->loadModel();
		if(isset($_POST['QuestionAnswer'])){
			$model->attributes = $_POST['QuestionAnswer'];
			if($model->update()){
				$this->redirect(Yii::app()->createUrl('QuestionAnswer/'));
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
		$model = new QuestionAnswer();
	
		$model = $this->loadModel();
		if($model->delete()){
			$this->redirect(Yii::app()->createUrl('QuestionAnswer/'));
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
				$this->_model=QuestionAnswer::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
}