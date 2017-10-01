<?php

/**
 * Default controller to handle user requests.
 */
class QuestionController extends CController
{
	public $layout='main';
	private $_model;

	public function actionIndex()
	{

		/* Update isRead Flag */
		CommonUtil::updateAlreadyRead();
		
		$model = new Question();
		$this->render('main', array(
				'data' => $model,
		));

	}

	public function actionCreate()
	{
		if(isset($_POST['Question'])){
			$model = new Question();
			$model->attributes = $_POST['Question'];
			$model->app_id = UserLoginUtil::getUserAppId();
			if($model->save()){
				$this->redirect(Yii::app()->createUrl('Question/'));
			}
		}
		$this->render('create');
	}


	public function actionUpdate()
	{
		$model = $this->loadModel();
		if(isset($_POST['Question'])){
			$model->attributes = $_POST['Question'];
			$model->app_id = UserLoginUtil::getUserAppId();
			if($model->update()){
				$this->redirect(Yii::app()->createUrl('Question/'));
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
		$model = new Question();

		$model = $this->loadModel();
		$model->status='I';
		if($model->update()){
			$this->redirect(Yii::app()->createUrl('Question/'));
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
				$this->_model=Question::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
}