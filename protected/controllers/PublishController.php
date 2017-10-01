<?php
error_reporting ( E_ALL );
/**
 * Default controller to handle user requests.
 */
class PublishController extends CController {
	public $layout = 'main';
	private $_model;
	public function actionIndex() {
		$model = AppStore::model ()->findbyPk ( 1 );
		$this->render ( 'main', array (
				'data' => $model 
		) );
	}
	public function actionGeneratePackage() {
		$app = AppStore::model ()->findbyPk ( 1 );
		
		if ($app != null) {
			$app->version = $app->version + 1;
			// echo '--->'.$app->version = $app->version + 1;
			$app->update ();
		}
		
		// XMLUtil::updatePackageVersion();
		
		// {
		// APNSUtil::sendPushnotification($app_id,'','MUIC already update content! ');
		// }
		
		$this->render ( 'result' );
	}
	public function loadModel() {
		if ($this->_model === null) {
			if (isset ( $_GET ['id'] ))
				$this->_model = AppStore::model ()->findbyPk ( 1 );
			if ($this->_model === null)
				throw new CHttpException ( 404, 'The requested page does not exist.' );
		}
		return $this->_model;
	}
}