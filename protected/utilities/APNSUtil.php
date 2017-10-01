<?php 
class APNSUtil {


	public function sendPushnotification($app_id,$url,$message)
	{
		if(!CommonUtil::IsNullOrEmptyString($message))
		{

			mysql_connect(ConfigUtil::getHostName(), ConfigUtil::getUsername(), ConfigUtil::getPassword());
			mysql_select_db(ConfigUtil::getDbName());

			if(!CommonUtil::IsNullOrEmptyString($url)){
				
				$urlHttps = parse_url ( $url );
				
				if ($urlHttps['scheme'] == 'https') {
					// is https;
				} else {
					
					// Get the file
					$content1 = file_get_contents ($url);
					
					// Store in the filesystem.
					$save_path1 = $uploadFolder . "/" . CommonUtil::random_string ( 10 ) . '.' . CommonUtil::f_extension ( $url);
					
					file_put_contents ( $save_path1, $content1 );
					
					$useUrl = ConfigUtil::getSiteName () . "" . $save_path1;
					
					
					/* Save data to popup url */
					$sql1 = "insert into tb_popup_url(id,url,message,create_date) values(0,'".$useUrl."','".$message."',NOW())";
					$res = mysql_query($sql1);
					if($res) {
						
					}
					
					
				}
				
				

			}

			/* Get List of Tokenid for send pushnotification */
			$sql = "select id,token_id,phone_type from users where token_id <> '' and role_id=-1";

			$result = mysql_query($sql);
			$i = 0;

			$iosDeviceToken = '';
			$androidDeviceToken ='';
			$phoneType = '';
			while($item = mysql_fetch_assoc($result)){
				$deviceToken = 	$item['token_id'];
				$phoneType = $item['phone_type'];
				if($phoneType == '1'){
					HttpRequestUtil::request(ConfigUtil::getSiteName()."pushservice/service.php?app_id=".urlencode($app_id)."&token=".str_replace(",", "", $deviceToken)."&msg=".urlencode($message));
					$iosDeviceToken .= $deviceToken.',';
				}else {
// 					$androidDeviceToken = $deviceToken.',';
				}
			}
			/* IOS */
			if(!CommonUtil::IsNullOrEmptyString($iosDeviceToken)){
				if(!CommonUtil::IsNullOrEmptyString($url)){
					
					//return HttpRequestUtil::request(ConfigUtil::getSiteName()."pushservice/service.php?app_id=".urlencode($app_id)."&token=".urlencode($iosDeviceToken)."&msg=".urlencode("+".$message));
				}else{
					
					//echo "".ConfigUtil::getSiteName()."pushservice/service.php?app_id=".urlencode($app_id)."&token=".urlencode($iosDeviceToken)."&msg=".urlencode("+".$message);
					//return HttpRequestUtil::request(ConfigUtil::getSiteName()."pushservice/service.php?app_id=".urlencode($app_id)."&token=".str_replace(",", "", $iosDeviceToken)."&msg=".urlencode($message));
				}				
			}
			/* ANDRIOD */
			if(!CommonUtil::IsNullOrEmptyString($androidDeviceToken)){
				if(!CommonUtil::IsNullOrEmptyString($url)){
				}else{
				}
			}
		}
		return true;
	}
	
	function hex2bin($hexdata) {
		$bindata="";
		for ($i=0;$i<strlen($hexdata);$i+=2) {
			$bindata.=chr(hexdec(substr($hexdata,$i,2)));
		}
	
		return $bindata;
	}
}

?>