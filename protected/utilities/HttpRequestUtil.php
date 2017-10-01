<?php
class HttpRequestUtil {
	public static function request($url) {
		$ch = curl_init($url);
		curl_exec($ch);
		return true;
	}
}
?>