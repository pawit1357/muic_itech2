<?php
class VersionController extends CController
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
	public function actionVerify()
	{
		/*  
		 * 1=Iphone
		 * 2=Ipad
		 * */
		header('Content-type: text/xml');
		
		//CONSTRUCT RSS FEED HEADERS
		$output = '<?xml version="1.0"?>';
		$output = '<item>';

		$app_id = $_GET['id'];
		$mobile_type = $_GET['mobile_type'];

		
		if(CommonUtil::IsNullOrEmptyString($app_id))
		{
			$output .= '<result>false</result>';
			$output .= '<path></path>';
			$output .= '<version/>';
			$output .= '<message>Invalid parameter</message>';
			
		}
		else{
			mysql_connect(ConfigUtil::getHostName(), ConfigUtil::getUsername(), ConfigUtil::getPassword());
			mysql_select_db(ConfigUtil::getDbName());

			$sql = "select version from tb_app where id='".$app_id."'" ;

			$result = mysql_query($sql);
			$version = 0;
			while($item = mysql_fetch_assoc($result)){
				$version = $item['version'];
			}

			$output .= '<result>true</result>';
			$output .= '<path>'.ConfigUtil::getSiteName().'download/'.$app_id.'_'.$mobile_type.'_V'.$version.'.zip'.'</path>';
			$output .= '<version>'.$version.'</version>';
			$output .= '<message>'.$mobile_type.'</message>';
			
		}
		$output .= '</item>';
		//SEND COMPLETE RSS FEED TO BROWSER
		echo($output);
	}
	
	

}