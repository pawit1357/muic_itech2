<?php
class ServiceAccountController extends CController
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
	public function actionRegister()
	{
		$datas = array();
		$app_id = 0;//$_GET['app_id'];
		$username = $_GET['user'];
		//$token_id = $_GET['token_id'];
		$phone_type = $_GET['phone_type'];

		if(CommonUtil::IsNullOrEmptyString($username)  ||CommonUtil::IsNullOrEmptyString($phone_type))
		{
			$datas['result'] = false;
			$datas['error_message'] = "Invalid parameter";
		}
		else{
			mysql_connect(ConfigUtil::getHostName(), ConfigUtil::getUsername(), ConfigUtil::getPassword());
			mysql_select_db(ConfigUtil::getDbName());

			$sql = "select id from users where username='".$username."' and app_id=".$app_id ;

			$result = mysql_query($sql);
			$userId = 0;
			$inTokenId = "";
			while($item = mysql_fetch_assoc($result)){
				$userId = $item['id'];
			}

			if( $userId == 0 )
			{
				$sql = "insert into users(username,token_id,phone_type,user_type,role_id,status,create_date,app_id) values('".$username."','".$username."','".$phone_type."','1',-1,'ACTIVE',NOW(),'".$app_id."')";
				//echo $sql;
				$result = mysql_query($sql);
				if($result) {
					$datas['result'] = true;
					//$datas['error_message'] = "success";
				} else {

					$datas['result'] = false;
					//$datas['error_message'] = "Duplicate username.";
				}
			}else {
				$datas['result'] = false;
			}
		}
		echo json_encode($datas);
	}
	
	

}