<?php

/**
 * Default controller to handle user requests.
 */
class AppBannerController extends CController {
	public $layout = 'main';
	private $_model;
	public function actionIndex() {
		$model = new AppBanner ();
		$this->render ( 'main', array (
				'data' => $model 
		) );
	}
	public function actionCreate() {
		$uploadFolder = 'upload/' . DateTimeUtil::getCurdateYYYYMMDD (); // folder for uploaded files
		
		if (! is_dir ( $uploadFolder )) {
			mkdir ( $uploadFolder, 0777, TRUE );
		}
		
		if (isset ( $_POST ['AppBanner'] )) {
			$model = new AppBanner ();
			$model->app_id = UserLoginUtil::getUserAppId ();
			$model->attributes = $_POST ['AppBanner'];
			$model->isChange = 1;
			
			// if(!CommonUtil::IsNullOrEmptyString($model->image_path1)){
			// $destSrcPath = $uploadFolder.'/A_1_'.DateTimeUtil::getCurdateYYYYMMDDHHMMSS().'.'.pathinfo($model->image_path1,PATHINFO_EXTENSION);
			// if(file_exists($uploadFolder.'/'.$model->image_path1) && !file_exists($destSrcPath)){
			// rename($uploadFolder.'/'.$model->image_path1,$destSrcPath);
			// $model->image_path1 = $destSrcPath;
			// }
			// }
			// if(!CommonUtil::IsNullOrEmptyString($model->image_path2)){
			// $destSrcPath = $uploadFolder.'/A_2_'.DateTimeUtil::getCurdateYYYYMMDDHHMMSS().'.'.pathinfo($model->image_path2,PATHINFO_EXTENSION);
			// if(file_exists($uploadFolder.'/'.$model->image_path2) && !file_exists($destSrcPath)){
			// rename($uploadFolder.'/'.$model->image_path2,$destSrcPath);
			// $model->image_path2 = $destSrcPath;
			// }
			// }
			// Get the file
			$content1 = file_get_contents ( $model->image_path1 );
			// $content2= file_get_contents($model->image_path2);
			
			// Store in the filesystem.
			// $save_path1= $uploadFolder."/".basename($model->image_path1);
			$save_path1 = $uploadFolder . "/" . CommonUtil::random_string ( 10 ) . '.' . CommonUtil::f_extension ( $model->image_path1 );
			
			// $save_path2= $uploadFolder."/".basename($model->image_path2);
			
			file_put_contents ( $save_path1, $content1 );
			// file_put_contents($save_path2,$content2);
			
			$model->image_path1 = ConfigUtil::getSiteName () . "" . $save_path1;
			// $model->image_path2= ConfigUtil::getSiteName()."". $save_path2;
			
			if ($model->save ()) {
				$this->redirect ( Yii::app ()->createUrl ( 'AppBanner/' ) );
			}
		}
		$this->render ( 'create' );
	}
	public function actionUpdate() {
		$uploadFolder = 'upload/' . DateTimeUtil::getCurdateYYYYMMDD (); // folder for uploaded files
		if (! is_dir ( $uploadFolder )) {
			mkdir ( $uploadFolder, 0777, TRUE );
		}
		$model = $this->loadModel ();
		if (isset ( $_POST ['AppBanner'] )) {
			$model->attributes = $_POST ['AppBanner'];
			$model->app_id = UserLoginUtil::getUserAppId ();
			$model->isChange = 1;
			
			$url = parse_url ( $model->image_path1 );
			
			if ($url ['scheme'] == 'https') {
				// is https;
			} else {
				
				// Get the file
				$content1 = file_get_contents ( $model->image_path1 );
				
				// Store in the filesystem.
				$save_path1 = $uploadFolder . "/" . CommonUtil::random_string ( 10 ) . '.' . CommonUtil::f_extension ( $model->image_path1 );
				
				file_put_contents ( $save_path1, $content1 );
				
				$model->image_path1 = ConfigUtil::getSiteName () . "" . $save_path1;
			}
			if ($model->update ()) {
				$this->redirect ( Yii::app ()->createUrl ( 'AppBanner/' ) );
			}
		}
		$this->render ( 'update', array (
				'model' => $model 
		) );
	}
	public function actionView() {
		$model = $this->loadModel ();
		$this->render ( 'view', array (
				'model' => $model 
		) );
	}
	public function actionDelete() {
		$model = new AppBanner ();
		$model->isChange = 1;
		$model = $this->loadModel ();
		if ($model->delete ()) {
			$this->redirect ( Yii::app ()->createUrl ( 'AppBanner/' ) );
		}
		$this->render ( 'main', array (
				'data' => $model 
		) );
	}
	public function actionUpload() {
		Yii::import ( "ext.EAjaxUpload.qqFileUploader" );
		
		$folder = 'upload/' . DateTimeUtil::getCurdateYYYYMMDD () . '/'; // folder for uploaded files
		
		if (! is_dir ( $folder )) {
			mkdir ( $folder, 0777, TRUE );
		}
		
		$allowedExtensions = array (
				"jpg",
				"png" 
		); // array("jpg","jpeg","gif","exe","mov" and etc...
		$sizeLimit = 1 * 1024 * 1024; // maximum file size in bytes
		                              // $minSizeLimit = 1*1024*1024;// minimum file size in bytes
		$uploader = new qqFileUploader ( $allowedExtensions, $sizeLimit );
		$result = $uploader->handleUpload ( $folder );
		$return = htmlspecialchars ( json_encode ( $result ), ENT_NOQUOTES );
		
		$fileSize = filesize ( $folder . $result ['filename'] ); // GETTING FILE SIZE
		$fileName = $result ['filename']; // GETTING FILE NAME
		
		echo $return; // it's array
	}
	public function loadModel() {
		if ($this->_model === null) {
			if (isset ( $_GET ['id'] ))
				$this->_model = AppBanner::model ()->findbyPk ( $_GET ['id'] );
			if ($this->_model === null)
				throw new CHttpException ( 404, 'The requested page does not exist.' );
		}
		return $this->_model;
	}
}