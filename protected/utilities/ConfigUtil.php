<?php
class ConfigUtil {
	//-- update tb_menu set menu_icon = REPLACE(menu_icon, 'http://www.prdapp.net/itechservice', 'http://localhost:81/itech2');
// 	private static $siteName = 'https://ed.muic.mahidol.ac.th/itech2/';
	private static $siteName = 'http://localhost:81/itech2/';
	
	private static $URLLifeNewsFeed = 'http://www.muic.mahidol.ac.th/eng/?p=';
	private static $URLLifeNewsFeedImage = 'http://www.muic.mahidol.ac.th/eng/wp-content/uploads/';
	private static $URLSphPromotionFeed = 'http://www.salayapavilion.com/websph/index.php?option=com_content&view=category&layout=blog&id=118&Itemid=290';
	private static $URLSphWeb = 'http://www.salayapavilion.com';
	private static $URLLibMagazineURL = 'http://lib.muic.mahidol.ac.th/index.php?option=com_content&view=article&id=70&Itemid=175';
	private static $defaultPageSize = 15;

	public static function getDbName() {
		$str = Yii::app()->db->connectionString;
		list($host, $db) = explode(';', $str);
		list($xx, $dbName) = explode('=', $db);
		return $dbName;
	}
	public static function getHostName() {
		$str = Yii::app()->db->connectionString;
		list($host, $db) = explode(';', $str);
		list($xx, $hostName) = explode('=', $host);
		return $hostName;
	}
	public static function getUsername() {
		return Yii::app()->db->username;
	}
	public static function getPassword() {
		return Yii::app()->db->password;
	}
	public static function getSiteName() {
		return self::$siteName;
	}
// 	public static function getPushServiceURL() {
// 		return self::$URLPushService;
// 	}	
	public static function getLifeNewsFeedURL() {
		return self::$URLLifeNewsFeed;
	}
	public static function getLifeNewsFeedImageURL() {
		return self::$URLLifeNewsFeedImage;
	}
	public static function getSphPromotionFeedURL() {
		return self::$URLSphPromotionFeed;
	}
	public static function getSphWebURL() {
		return self::$URLSphWeb;
	}
	public static function getLibMagazineURL() {
		return self::$URLLibMagazineURL;
	}
	
	
	public static function getDefaultPageSize() {
		return self::$defaultPageSize;
	}
}
?>