<?php

/**
 * Default controller to handle user requests.
 */
class MediaController extends CController
{
	public $layout='main';
	private $_model;

	public function actionIndex()
	{
		$model = new Media();
		
		$this->render('main', array(
				'data' => $model,
		));
	}

	public function actionCreate()
	{
		$uploadFolder='upload/'.UserLoginUtil::getUsersId().'/'.DateTimeUtil::getCurdateYYYYMMDD();// folder for uploaded files
		
		if(isset($_POST['Media'])){
			$model = new Media();
			$model->attributes = $_POST['Media'];


			if(!CommonUtil::IsNullOrEmptyString($model->media_realurl)){

				$destSrcPath = $uploadFolder.'/'.DateTimeUtil::getCurdateYYYYMMDDHHMMSS().'.'.pathinfo($model->media_realurl,PATHINFO_EXTENSION);
				if(file_exists($uploadFolder.'/'.$model->media_realurl) && !file_exists($destSrcPath)){
					rename($uploadFolder.'/'.$model->media_realurl,$destSrcPath);
					$model->media_realurl = $destSrcPath;
					$model->user_id =UserLoginUtil::getUsersId();
					$model->media_key = CommonUtil::randomKey(25);
				}
			}

			if($model->save()){
				$this->redirect(Yii::app()->createUrl('Media/'));
			}
		}
		$this->render('create');
	}


	public function actionUpdate()
	{
		$uploadFolder='upload/'.UserLoginUtil::getUsersId().'/'.DateTimeUtil::getCurdateYYYYMMDD();// folder for uploaded files
		$model = $this->loadModel();
		if(isset($_POST['Media'])){
			$model->attributes = $_POST['Media'];
			if(!CommonUtil::IsNullOrEmptyString($model->media_realurl)){
				$destSrcPath = $uploadFolder.'/'.DateTimeUtil::getCurdateYYYYMMDDHHMMSS().'.'.pathinfo($model->media_realurl,PATHINFO_EXTENSION);
				if(file_exists($uploadFolder.'/'.$model->media_realurl) && !file_exists($destSrcPath)){
					rename($uploadFolder.'/'.$model->media_realurl,$destSrcPath);
					$model->media_realurl = $destSrcPath;
					//$model->media_key = CommonUtil::randomKey();
				}
			}

			if($model->update()){
				$this->redirect(Yii::app()->createUrl('Media/'));
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
		$model = new Media();
		$model = $this->loadModel();
		if($model->delete())
		{
			$this->redirect(Yii::app()->createUrl('Media/'));
		}
		$this->render('main', array(
				'data' => $model,
		));
	}

	public function actionUpload()
	{

		Yii::import("ext.EAjaxUpload.qqFileUploader");

		$folder='upload/'.UserLoginUtil::getUsersId().'/'.DateTimeUtil::getCurdateYYYYMMDD().'/';// folder for uploaded files

		if (!is_dir($folder)) {
			mkdir($folder,0777,TRUE);
		}

		$allowedExtensions = array("wmv","mov","mp3","mp4");//array("jpg","jpeg","gif","exe","mov" and etc...
		$sizeLimit =50 * 1024 * 1024;// maximum file size in bytes
		// 		$minSizeLimit = 1*1024*1024;// minimum file size in bytes
		$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
		$result = $uploader->handleUpload($folder);
		$return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);

		$fileSize=filesize($folder.$result['filename']);//GETTING FILE SIZE
		$fileName=$result['filename'];//GETTING FILE NAME

		echo $return;// it's array
	}

	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=Media::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
}