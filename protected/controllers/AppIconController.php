<?php

/**
 * Default controller to handle user requests.
 */
class AppIconController extends CController
{
	public $layout='main';
	private $_model;

	public function actionIndex()
	{
		$model = new AppIcon();
		$this->render('main', array(
				'data' => $model,
		));
	}

	public function actionCreate()
	{
		$now = new DateTime();
// 		$uploadFolder='upload/'.DateTimeUtil::getCurdateYYYYMMDD();// folder for uploaded files
		$model = new AppIcon();

		if(isset($_POST['AppIcon'])){

			$model->attributes = $_POST['AppIcon'];
			$model->create_date = new CDbExpression('NOW()');
			$model->app_id = UserLoginUtil::getUserAppId();
			
			
			if($_FILES['icon_path']['name'])
			{
				//if no errors...
				if(!$_FILES['icon_path']['error'])
				{
					$currentdir = getcwd ();
			
					$target = $currentdir . "/images/icon_app_menu/".$model->app_id."/";
					$target = $target . basename ( $_FILES ['icon_path'] ['name'] );
					$temploc = $_FILES ['uploadedfile'] ['tmp_name'];
			
					$download_name = "/images/icon_app_menu/".$model->app_id."/".basename ( $_FILES ['icon_path'] ['name'] );
					echo $download_name;
					
					// This is our size condition
					if ($uploaded_size > 350000) {
						echo "Your file is too large.<br>";
					}
					// This is our limit file type condition
					if ($uploaded_type == "text/php") {
						echo "No PHP files<br>";
					}
					else {
						if (move_uploaded_file ( $_FILES ['icon_path'] ['tmp_name'], $target )) // THIS IS LINE 43
						{
								
							$model->icon_path = $download_name;
							// 							echo "The file " . basename ( $_FILES ['document_path'] ['name'] ) . " has been uploaded";
						} else {
							echo "Sorry, there was a problem uploading your file.";
						}
					}
				}
			}
			
			if($model->save()){
				$this->redirect(Yii::app()->createUrl('AppIcon/'));
			}
		}else
		{
			$this->render('create');
		}	
		
	}
	public function actionUpdate()
	{
		$uploadFolder='upload/'.DateTimeUtil::getCurdateYYYYMMDD();// folder for uploaded files
		$model = $this->loadModel();
// 		$tmpModel = new AppIcon();
// 		$tmpModel = $model;
		if(isset($_POST['AppIcon'])){
		
			$model->attributes = $_POST['AppIcon'];
// 			$model->update_date = new CDbExpression('NOW()');
			//$model->app_id = UserLoginUtil::getUserAppId();
				
			//$model->icon_path = $tmpModel->icon_path;
			if($_FILES['icon_path']['name'])
			{
				//if no errors...
				if(!$_FILES['icon_path']['error'])
				{
					$currentdir = getcwd ();
						
					$target = $currentdir . "/images/icon_app_menu/".$model->app_id."/";
					$target = $target . basename ( $_FILES ['icon_path'] ['name'] );
					$temploc = $_FILES ['uploadedfile'] ['tmp_name'];
						
					$download_name = "/images/icon_app_menu/".$model->app_id."/".basename ( $_FILES ['icon_path'] ['name'] );
					echo $download_name;
						
					// This is our size condition
					if ($uploaded_size > 350000) {
						echo "Your file is too large.<br>";
					}
					// This is our limit file type condition
					if ($uploaded_type == "text/php") {
						echo "No PHP files<br>";
					}
					else {
						if (move_uploaded_file ( $_FILES ['icon_path'] ['tmp_name'], $target )) // THIS IS LINE 43
						{
		
							$model->icon_path = $download_name;
							// 							echo "The file " . basename ( $_FILES ['document_path'] ['name'] ) . " has been uploaded";
						} else {
							echo "Sorry, there was a problem uploading your file.";
						}
					}
				}
			}
				
			if($model->update()){
				$this->redirect(Yii::app()->createUrl('AppIcon/'));
			}
		}else
		{
			$this->render('update', array(
					'model' => $model,
			));		}
		
		
// 		if(isset($_POST['AppBanner'])){
// 			$model->attributes = $_POST['AppBanner'];
// 			$model->app_id =UserLoginUtil::getUserAppId();
// 			$model->isChange = 1;
	
// 			if(!CommonUtil::IsNullOrEmptyString($model->image_path1)){
// 				$destSrcPath = $uploadFolder.'/A_1_'.DateTimeUtil::getCurdateYYYYMMDDHHMMSS().'.'.pathinfo($model->image_path1,PATHINFO_EXTENSION);
// 				if(file_exists($uploadFolder.'/'.$model->image_path1) && !file_exists($destSrcPath)){
// 					rename($uploadFolder.'/'.$model->image_path1,$destSrcPath);
// 					$model->image_path1 = $destSrcPath;
// 				}
// 			}
// 			if(!CommonUtil::IsNullOrEmptyString($model->image_path2)){
// 				$destSrcPath = $uploadFolder.'/A_2_'.DateTimeUtil::getCurdateYYYYMMDDHHMMSS().'.'.pathinfo($model->image_path2,PATHINFO_EXTENSION);
// 				if(file_exists($uploadFolder.'/'.$model->image_path2) && !file_exists($destSrcPath)){
// 					rename($uploadFolder.'/'.$model->image_path2,$destSrcPath);
// 					$model->image_path2 = $destSrcPath;
// 				}
// 			}
	
// 			if($model->update()){
// 				$this->redirect(Yii::app()->createUrl('AppBanner/'));
// 			}
// 		}
// 		$this->render('update', array(
// 				'model' => $model,
// 		));
	
	
	}


	public function actionDelete()
	{
		$model = $this->loadModel();
		if($model->delete()){
			
			
			$this->redirect(Yii::app()->createUrl('AppIcon/'));
		}

		$this->render('main', array(
				'data' => $model,
		));
	}

	public function actionUpload()
	{

		Yii::import("ext.EAjaxUpload.qqFileUploader");

		$folder='/upload/'.DateTimeUtil::getCurdateYYYYMMDD().'/';// folder for uploaded files

		if (!is_dir($folder)) {
			mkdir($folder,0777,TRUE);
		}

		$allowedExtensions = array("jpg","png","xls");//array("jpg","jpeg","gif","exe","mov" and etc...
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
				$this->_model=AppIcon::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
}