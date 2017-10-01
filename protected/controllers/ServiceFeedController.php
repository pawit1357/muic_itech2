
<?php
/**
 *http://prdapp.net/itechservice/index.php/ServiceFeed/lifeFeed
 *http://prdapp.net/itechservice/index.php/ServiceFeed/SphPromotionFeed
 *http://prdapp.net/itechservice/index.php/ServiceFeed/LibMagazineFeed
 */
class ServiceFeedController extends CController
{
	public $layout='ajax';
	private $_model;

	/**
	 * Index action is the default action in a controller.
	 */
	public function actionIndex()
	{

	}

	/* http://localhost:88/itechservice/index.php/ServiceFeed/lifeFeed/p/{0}/y/{1}/m/{2}/img/{3}
	 * {0} = 8685
	* {1} = Year: 	format yyyy 	Sample: 2013
	* {2} = Month: format MM		Sample: 01
	* {3} = closed_dec_09.jpg
	* Sample: http://localhost:88/itechservice/index.php/ServiceFeed/lifeFeed/p/8664/y/2013/m/02/img/150_named_MU.jpg
	* */
	public function actionLifeFeed()
	{
		FeedUtil::lifeFeed();
	}

	/* http://prdapp.net/itechservice/index.php/ServiceFeed/SphPromotionFeed
	 * */
	public function actionSphPromotionFeed()
	{
		// 		echo ':::'. FeedUtil::sphPromotionFeed();

		header('Content-type: text/xml');
			


		$output = '<?xml version="1.0"?>';
		$output = '<item>';

		$data = FeedUtil::sphPromotionFeed();
		if($data){
			$output .= '<result>true</result>';
			$output .= '<message>'.$data.'</message>';
		}else{
			$output .= '<result>fale</result>';
			$output .= '<message>Duplicate promotion.</message>';
		}

		$output .= '</item>';
		echo ($output);


	}

	/* http://prdapp.net/itechservice/index.php/ServiceFeed/LibMagazineFeed
	 * */
	public function actionLibMagazineFeed()
	{


		echo 'Complete';

	}
}