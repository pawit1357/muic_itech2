<?php

/**
 * Default controller to handle user requests.
 */
class AppContentController extends CController
{
	public $layout='main';
	private $_model;

	public function actionIndex()
	{
		$model = new AppContent();
		$this->render('main',array(
				'data' => $model
		));
	}

	public function actionCreate()
	{
		$uploadFolder='upload/'.DateTimeUtil::getCurdateYYYYMMDD();// folder for uploaded files
		if (! is_dir ( $uploadFolder)) {
			mkdir ( $uploadFolder, 0777, TRUE );
		}
		$menu_id = Yii::app()->getRequest()->getQuery('menu_id');
		if(isset($_POST['AppContent'])){
			$model = new AppContent();
			$model->attributes = $_POST['AppContent'];
			$model->app_id =UserLoginUtil::getUserAppId();
			$model->menu_id=$menu_id;
			$model->isChange = 1;
			$model->create_date = new CDbExpression('NOW()');

// 			if(!CommonUtil::IsNullOrEmptyString($model->image_src1)){
// 				$destSrcPath = $uploadFolder.'/A_1_'.DateTimeUtil::getCurdateYYYYMMDDHHMMSS().'.'.pathinfo($model->image_src1,PATHINFO_EXTENSION);
// 				if(file_exists($uploadFolder.'/'.$model->image_src1) && !file_exists($destSrcPath)){
// 					rename($uploadFolder.'/'.$model->image_src1,$destSrcPath);
// 					$model->image_src1 = $destSrcPath;
// 				}
// 			}
// 			if(!CommonUtil::IsNullOrEmptyString($model->image_src2)){
// 				$destSrcPath = $uploadFolder.'/A_2_'.DateTimeUtil::getCurdateYYYYMMDDHHMMSS().'.'.pathinfo($model->image_src2,PATHINFO_EXTENSION);
// 				if(file_exists($uploadFolder.'/'.$model->image_src2) && !file_exists($destSrcPath)){
// 					rename($uploadFolder.'/'.$model->image_src2,$destSrcPath);
// 					$model->image_src2 = $destSrcPath;
// 				}
// 			}
			//Get the file
			$contents= file_get_contents($model->image_src1);
			//Store in the filesystem.
			$save_path= $uploadFolder."/".CommonUtil::random_string(10).'.'.CommonUtil::f_extension($model->image_src1);
			file_put_contents($save_path,$contents);
			
		
			$model->image_src1= ConfigUtil::getSiteName()."". $save_path;
			
			if($model->save()){
				$this->redirect(Yii::app()->createUrl('AppMenu/'));
			}
		}

		$model->menu_id = $menu_id;

		$this->render('create', array(
				'model' => $model,
		));


	}

	public function actionUpdate()
	{
		$uploadFolder='upload/'.DateTimeUtil::getCurdateYYYYMMDD();// folder for uploaded files
		if (! is_dir ( $uploadFolder)) {
			mkdir ( $uploadFolder, 0777, TRUE );
		}
		$model = $this->loadModel();
		if(isset($_POST['AppContent'])){
			$model->attributes = $_POST['AppContent'];
			$model->app_id =UserLoginUtil::getUserAppId();
			$model->isChange = 1;
			$model->create_date = new CDbExpression('NOW()');

			$url = parse_url ( $model->image_src1);
			
			if ($url ['scheme'] == 'https') {
				// is https;
			} else {
			//Get the file
			$contents= file_get_contents($model->image_src1);
			//Store in the filesystem.
			$save_path= $uploadFolder."/".CommonUtil::random_string(10).'.'.CommonUtil::f_extension($model->image_src1);
			file_put_contents($save_path,$contents);
			
			
			$model->image_src1= ConfigUtil::getSiteName()."". $save_path;
			}
			if($model->update()){
				$this->redirect(Yii::app()->createUrl('AppMenu/'));
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
		$model = new AppContent();
		$model->isChange = 1;
		$model = $this->loadModel();
		$model->status='I';
		if($model->update()){
			$this->redirect(Yii::app()->createUrl('AppMenu/'));
		}

		$this->render('main', array(
				'data' => $model,
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

	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=AppContent::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}



}