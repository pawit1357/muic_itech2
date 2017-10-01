<?php
class ServiceMediaController extends CController
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
	 * URL: http://localhost:88/mleaning/index.php/ServiceMedia/GetMedia/ID/9
	* */
	public function actionGetMedia()
	{

		$path = '';

		if (! preg_match('/^[-a-z.-@,\'\s]*$/i',$_GET['ID']))
		{
			die('Invalid name proved, the name may only contain a-z, A-Z, 0-9, "-", "_" and spaces.');
		}else {

			mysql_connect(ConfigUtil::getHostName(), ConfigUtil::getUsername(), ConfigUtil::getPassword());
			mysql_select_db(ConfigUtil::getDbName());

			$sql = "select media_realurl from tb_media where id='".$_GET['ID']."';" ;

			$result = mysql_query($sql);
			while($item = mysql_fetch_assoc($result)){
				$path = $item['media_realurl'];
			}
			mysql_close();
		}
		//echo filesize($path);
		$fd = fopen($fileName, "rb");

		while(!feof($fd))
		{
			echo fread($fd, 1024 * 5);
			//flush_buffers();
		}

		fclose ($fd);


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