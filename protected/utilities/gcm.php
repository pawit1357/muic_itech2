<?php 
define("GOOGLE_API_KEY", "AIzaSyAyo-pTRU50IQse72GkLxCSWW3x466n9cM");
define("GOOGLE_GCM_URL", "https://android.googleapis.com/gcm/send");
/**
 *
 * @package c2dm
 * @version $Id$
 * @copyright (c) 2011 lytsing.org & 2012 thebub.net
 * Description: C2DM implementation PHP code
 * refer to: http://stackoverflow.com/questions/4121508/c2dm-implementation-php-code
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */

class gcm {

	private static $instance = null;

	private function __construct() {
	}

	public static function getInstance() {
		if (!gcm::$instance) {
			gcm::$instance = new gcm();
		}

		return gcm::$instance;
	}

	private $authString = "";

	/**
	 * Sending Push Notification
	 */
	function send_notification($registatoin_ids, $message) {

		// Set POST variables
		$url = 'https://android.googleapis.com/gcm/send';

		$fields = array(
				'registration_ids' => $registatoin_ids,
				'data' => $message,
		);

		$headers = array(
				'Authorization: key=' . GOOGLE_API_KEY,
				'Content-Type: application/json'
		);
		// Open connection
		$ch = curl_init();

		// Set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);

		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// Disabling SSL Certificate support temporarly
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

		// Execute post
		$result = curl_exec($ch);
		if ($result === FALSE) {
			die('Curl failed: ' . curl_error($ch));
		}

		// Close connection
		curl_close($ch);
		echo $result;
	}
}