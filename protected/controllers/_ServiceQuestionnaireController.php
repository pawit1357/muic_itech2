<?php
class ServiceQuestionnaireController extends CController
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
	 * URL: http://localhost:88/itechservice/index.php/ServiceQuestionnaire/GetQuestion/app_id/1/token_id/03d1ce399fe2f6185c76880f2748026e50d151d6f4c50bbfd18ffce5f97b1124
	* */
	public function actionGetQuestion()
	{
		header('Content-type: text/xml');

		//CONSTRUCT RSS FEED HEADERS
		$output = '<?xml version="1.0"?>';
		$output = '<item>';

		$app_id = $_GET['app_id'];

		if(CommonUtil::IsNullOrEmptyString($app_id) )
		{
			$output .= '<url></url>';
		}
		else{
			mysql_connect(ConfigUtil::getHostName(), ConfigUtil::getUsername(), ConfigUtil::getPassword());
			mysql_select_db(ConfigUtil::getDbName());



			$sql = "select questionnaire_url from tb_app where id='".$app_id."';" ;

			$result = mysql_query($sql);
			$questionnaire_url = 0;
			while($item = mysql_fetch_assoc($result)){
				$questionnaire_url = $item['questionnaire_url'];
			}
			$output .= '<url>'.$questionnaire_url.'</url>';
		}
		$output .= '</item>';
		echo($output);
	}

	/*
	 * URL: http://localhost:88/itechservice/index.php/ServiceQuestionnaire/UpdateFlag/token_id/03d1ce399fe2f6185c76880f2748026e50d151d6f4c50bbfd18ffce5f97b1124
	* */
	public function actionUpdateFlag()
	{
		$datas = array();

		//CONSTRUCT RSS FEED HEADERS
		$token_id = $_GET['token_id'];

		if(CommonUtil::IsNullOrEmptyString($token_id))
		{
			$datas['result'] = false;
		}
		else{
			mysql_connect(ConfigUtil::getHostName(), ConfigUtil::getUsername(), ConfigUtil::getPassword());
			mysql_select_db(ConfigUtil::getDbName());

			$sql = "update users set flag1='1' where username='".$token_id."'";

			$result = mysql_query($sql);
			if($result) {
				$datas['result'] = true;
			} else {
				$datas['result'] = false;

			}
		}
		echo json_encode($datas);
	}
}