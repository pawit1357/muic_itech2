<?php

/**
 * Default controller to handle user requests.
 */
class ServicePushnotificationController extends CController
{
	public $layout='main';
	private $_model;

	public function actionIndex()
	{



		if (!isset($_POST['content'])){

		}else{
			$app_id = UserLoginUtil::getUserAppId();
			$message = $_POST['content'];
			if (!isset($_POST['url'])){
				APNSUtil::sendPushnotification($app_id,'',$message);
			}else
			{
				$url = $_POST['url'];
				APNSUtil::sendPushnotification($app_id,$url,$message);
			}
		}

		$this->render('main');
	}


}