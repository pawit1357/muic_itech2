<?php
header('content-type: text/html; charset=utf-8');
class ServiceLibController extends CController
{
	public $layout='ajax';
	private $_model;

	/**
	 * Index action is the default action in a controller.
	 */
	public function actionIndex()
	{

	}

	/*
	 * Register TokenID and check username/password for alert to smartphone
	* */
	public function actionSendQuestion()
	{
		$question = $_GET['question'];
		$udid = $_GET['udid'];
		$app_id =0;// $_GET['app_id'];

		$datas = array();
		mysql_connect(ConfigUtil::getHostName(), ConfigUtil::getUsername(), ConfigUtil::getPassword());
		mysql_select_db(ConfigUtil::getDbName());
		mysql_query("SET NAMES UTF8");
		$sql = "insert into tb_question(app_id,device_udid,question,status,create_date,isRead) values(".$app_id.",'".$udid."','". urldecode($question) ."','A',NOW(),'1')";

		$result = mysql_query($sql);

		if($result) {
			$datas['result'] = true;
			$datas['message'] = "";
		} else {
			$datas['false'] = true;
			$datas['message'] = "";
		}

		echo json_encode($datas);
	}



}