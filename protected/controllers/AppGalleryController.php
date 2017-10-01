<?php

/**
 * Default controller to handle user requests.
 */
class AppGalleryController extends CController
{
	public $layout='main';
	private $_model;

	public function actionIndex()
	{
		$model = new AppGallery();
			
		$this->render('main', array(
				'data' => $model,
		));

	}

	public function actionCreate()
	{
		$uploadFolder='upload/'.DateTimeUtil::getCurdateYYYYMMDD();// folder for uploaded files
		if(isset($_POST['AppGallery'])){
			$model = new AppGallery();
			$model->attributes = $_POST['AppGallery'];
			$model->app_id = UserLoginUtil::getUserAppId();
			$model->menu_id=$_SESSION['MenuID'];
			$model->isChange = 1;
			if(!CommonUtil::IsNullOrEmptyString($model->image_src1)){
				$destSrcPath = $uploadFolder.'/A_1_'.DateTimeUtil::getCurdateYYYYMMDDHHMMSS().'.'.pathinfo($model->image_src1,PATHINFO_EXTENSION);
				if(file_exists($uploadFolder.'/'.$model->image_src1) && !file_exists($destSrcPath)){
					rename($uploadFolder.'/'.$model->image_src1,$destSrcPath);
					$model->image_src1 = $destSrcPath;
					$model->thumnail_src1 = $destSrcPath;
				}
			}
			if(!CommonUtil::IsNullOrEmptyString($model->image_src2)){
				$destSrcPath = $uploadFolder.'/A_2_'.DateTimeUtil::getCurdateYYYYMMDDHHMMSS().'.'.pathinfo($model->image_src2,PATHINFO_EXTENSION);
				if(file_exists($uploadFolder.'/'.$model->image_src2) && !file_exists($destSrcPath)){
					rename($uploadFolder.'/'.$model->image_src2,$destSrcPath);
					$model->image_src2 = $destSrcPath;
					$model->thumnail_src1 = $destSrcPath;
				}
			}
			if($model->save()){

				$this->redirect(Yii::app()->createUrl('AppGallery/'));
			}
		}
		$menu_id = $_SESSION['MenuID'];
		$model->menu_id = $menu_id;

		$this->render('create', array(
				'model' => $model,
		));
	}

	public function actionUpdate()
	{
		$uploadFolder='upload/'.DateTimeUtil::getCurdateYYYYMMDD();// folder for uploaded files
		$model = $this->loadModel();
		if(isset($_POST['AppGallery'])){
			$model->attributes = $_POST['AppGallery'];
			$model->app_id = UserLoginUtil::getUserAppId();
			$model->isChange = 1;

			if(!CommonUtil::IsNullOrEmptyString($model->image_src1)){
				$destSrcPath = $uploadFolder.'/A_1_'.DateTimeUtil::getCurdateYYYYMMDDHHMMSS().'.'.pathinfo($model->image_src1,PATHINFO_EXTENSION);
				if(file_exists($uploadFolder.'/'.$model->image_src1) && !file_exists($destSrcPath)){
					rename($uploadFolder.'/'.$model->image_src1,$destSrcPath);
					$model->image_src1 = $destSrcPath;
					$model->thumnail_src1 = $destSrcPath;
				}
			}
			if(!CommonUtil::IsNullOrEmptyString($model->image_src2)){
				$destSrcPath = $uploadFolder.'/A_2_'.DateTimeUtil::getCurdateYYYYMMDDHHMMSS().'.'.pathinfo($model->image_src2,PATHINFO_EXTENSION);
				if(file_exists($uploadFolder.'/'.$model->image_src2) && !file_exists($destSrcPath)){
					rename($uploadFolder.'/'.$model->image_src2,$destSrcPath);
					$model->image_src2 = $destSrcPath;
					$model->thumnail_src1 = $destSrcPath;
				}
			}
			if($model->update()){
				$this->redirect(Yii::app()->createUrl('AppGallery/'));
			}
		}
		$this->render('update', array(
				'model' => $model,
		));
	}

	public function actionUpload()
	{

		Yii::import("ext.EAjaxUpload.qqFileUploader");

		$folder='upload/'.DateTimeUtil::getCurdateYYYYMMDD().'/';// folder for uploaded files

		if (!is_dir($folder)) {
			mkdir($folder,0777,TRUE);
		}

		$allowedExtensions = array("jpg","png");//array("jpg","jpeg","gif","exe","mov" and etc...
		$sizeLimit = 5 * 1024 * 1024;// maximum file size in bytes
		$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
		$result = $uploader->handleUpload($folder);
		$return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);

		$fileSize=filesize($folder.$result['filename']);//GETTING FILE SIZE
		$fileName=$result['filename'];//GETTING FILE NAME

		echo $return;// it's array
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
		$model = new AppGallery();
		$model->isChange = 1;
		$model = $this->loadModel();
		if($model->delete()){
			$this->redirect(Yii::app()->createUrl('AppGallery/'));

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
				$this->_model=AppGallery::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
}