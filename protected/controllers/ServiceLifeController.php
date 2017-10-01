<?php
class ServiceLifeController extends CController
{
	public $layout='ajax';
	private $_model;

	/**
	 * Index action is the default action in a controller.
	 */
	public function actionIndex()
	{

	}

	public function actionPushNews()
	{

		$udid = $_GET['udid'];
		$result = array();
		$criteria=new CDbCriteria();
		$criteria->order=' create_date DESC';
		$criteria->limit=1;
		$menu = PopupUrl::model()->findAll($criteria);
		if($menu != null) {
			foreach($menu as $m) {
				$datas = array();
				$datas['id'] = $m->id;
				$datas['url'] = $m->url;
				$datas['message'] = $m->message;
				$result[count($result)]=$datas;
			}
		}
		echo json_encode($result);
	}
}