<?php 
include_once('simple_html_dom.php');
// require_once 'Excel/reader.php';

class FeedUtil {

	public static function lifeFeed1()
	{
		$folder='upload/'.DateTimeUtil::getCurdateYYYYMMDD().'/';// folder for uploaded files

		/* Content URL */
		$html = file_get_html('http://www.muic.mahidol.ac.th/eng/');
		foreach ($html->find('div[class=post_news] img') as $element) {
			$src[$j] =  $element->src ;
			$j++;
		}
		$tmpP = '';
		foreach ($html->find('div[class=post_news] a') as $element) {
			if( $tmpP != substr($element->href,0,41))
			{
				echo $element->href.','.$element->title.','.$element->src.','.$src[$i]  .'<br/>' ;
				$tmpP = substr($element->href,0,41);
				$i++;
			}
		}

		return false;
	}

	public static function lifeFeed()
	{
		$folder='upload/'.DateTimeUtil::getCurdateYYYYMMDD().'/';// folder for uploaded files

		$bResult = 'false';

		if (!is_dir($folder)) {
			mkdir($folder,0777,TRUE);
		}

		/* Save to DB */
		$link = mysql_connect(ConfigUtil::getHostName(), ConfigUtil::getUsername(), ConfigUtil::getPassword());
		mysql_select_db(ConfigUtil::getDbName());

		if (!$link) {
			die('Could not connect: ' . mysql_error());
			return 'Could not connect: ' .mysql_error();
		}
		// 		ConfigUtil::getLifeNewsFeedURL()
		// 		ConfigUtil::getLifeNewsFeedImageURL().$imgName;

		$html = file_get_html('http://www.muic.mahidol.ac.th/eng/');
		foreach ($html->find('div[class=post_news] img') as $element) {
			$src[$j] =  $element->src ;
			$j++;
		}
		$tmpP = '';
		foreach ($html->find('div[class=post_news] a') as $element) {
			if( $tmpP != substr($element->href,0,41))
			{
				// 				echo $element->href.','.$element->title.','.$element->src.','.$src[$i]  .'<br/>' ;
				$tmpP = substr($element->href,0,41);

				/* Content URL */
				$html = file_get_html($tmpP);

				$content = $html->find('div[id=portfolio]');
				$description = $content[0]->innertext;
				$content = $html->find('div[id=portfolio] a');
				$topic = $content[0]->innertext;

				/* Image URL */
				$imgPath = $src[$i];
				$content_img = file_get_contents($imgPath);
				$fp = fopen($folder.basename($imgPath), "w");
				fwrite($fp, $content_img);
				fclose($fp);

				/* Find News menu ID */
				$sql = "select id from tb_menu where app_id=1 and parent =-1 and menu_type=0";

				$result = mysql_query($sql);
				$menu_id = 0;
				while($item = mysql_fetch_assoc($result)){
					$menu_id = $item['id'];
				}
				$destSrcPath = $folder.'A_1_'.DateTimeUtil::getCurdateYYYYMMDDHHMMSS().'.'.pathinfo(basename($imgPath),PATHINFO_EXTENSION);
				/* Rename */
				if(!file_exists($destSrcPath) ){
					rename($folder.basename($imgPath),$destSrcPath);

					/* Check Dup */
					$sql = "select id from tb_content where app_id=1 and topic like '".$topic."'";

					$res = mysql_query($sql);
					$count = mysql_num_rows($res);
					if ($count == 0)
					{
						$sql = "insert into tb_content(id,app_id,menu_id,topic,description,image_src1,image_src2,status,isChange,create_date) values(0,1,".$menu_id.",'".$topic."','".$description."','".$destSrcPath."','".$destSrcPath."','A',1,NOW())";

						$result = mysql_query($sql);
						if($result) {
							/* phone_type{1=iPhone,2=iPad} */
							$bResult = 'true';
						} else {
							$bResult = 'false';
						}
					}else
					{
						$bResult = 'false';
					}
				}
				//====================================================================================

				$i++;
			}
		}

		mysql_close($link);
		echo 'Complete';
	}

	public static function sphPromotionFeed()
	{

		$folder='upload/'.DateTimeUtil::getCurdateYYYYMMDD().'/';// folder for uploaded files
		if (!is_dir($folder)) {
			mkdir($folder,0777,TRUE);
		}
		/* Topic URL */
		$html = file_get_html(ConfigUtil::getSphPromotionFeedURL());

		foreach ($html->find('a[class=contentpagetitle]') as $element) {
			$urls[$j] = $element->innertext;
			$j++;
		}


		/* Save to DB */
		$bResult = false;
		$link = mysql_connect(ConfigUtil::getHostName(), ConfigUtil::getUsername(), ConfigUtil::getPassword());
		mysql_select_db(ConfigUtil::getDbName());

		if (!$link) {
			die('Could not connect: ' . mysql_error());
			return 'Could not connect: ' .mysql_error();
		}

		/* Find News menu ID */
		$sql = "select id from tb_menu where app_id=2 and parent =-1 and menu_type=1";

		$result = mysql_query($sql) or die(mysql_error());
		$menu_id = 0;
		while($item = mysql_fetch_assoc($result)){
			$menu_id = $item['id'];
		}

		/* Image URL */
		foreach ($html->find('div[class=blogcontent] img') as $element) {

			$imgPath = ConfigUtil::getSphWebURL().$element->src;

			$content_img = file_get_contents(str_replace(' ' , '%20',$imgPath));
			$fp = fopen(str_replace('-','_',str_replace(' ','',$folder.basename($imgPath))), "w");
			fwrite($fp, $content_img);
			fclose($fp);

			$imgsrc = str_replace('-','_',str_replace(' ','',basename($imgPath)));
			$destSrcPath = $folder.$k.'A_2_'.DateTimeUtil::getCurdateYYYYMMDDHHMMSS().'.'.pathinfo($imgsrc,PATHINFO_EXTENSION);

			/* Rename */
			if(file_exists($folder.$imgsr) && !file_exists($destSrcPath) ){
				rename($folder.$imgsrc,$destSrcPath);
			}
			/* Check Dup */
			$sql = "select id from tb_content where app_id=2 and topic ='".$urls[$k]."'";

			$res = mysql_query($sql);
			$count = mysql_num_rows($res);
			if ($count == 0)
			{
				$desc = "<p><img alt=\"\" src=\"".$imgPath."\" style=\"height:840px; width:594px\" /></p>";
				$sql = "insert into tb_content(id,app_id,menu_id,topic,description,image_src1,image_src2,status,isChange,create_date) values(0,2,".$menu_id.",'".$urls[$k]."','".$desc."','".$destSrcPath."','".$destSrcPath."','A',1,NOW())";
				$result = mysql_query($sql) or die(mysql_error());

				if($result) {
					$bResult = true;
				} else {
					$bResult = false;
				}
			}else
			{
				$bResult = false;
			}

			$k++;
		}
		mysql_close($link);
		return $bResult;
	}

	public static function libMangazine($filePath)
	{
		$folder='upload/'.DateTimeUtil::getCurdateYYYYMMDD().'/';// folder for uploaded files
		if (!is_dir($folder)) {
			mkdir($folder,0777,TRUE);
		}

		$link = mysql_connect(ConfigUtil::getHostName(), ConfigUtil::getUsername(), ConfigUtil::getPassword());
		mysql_select_db(ConfigUtil::getDbName());

		if (!$link) {
			die('Could not connect: ' . mysql_error());
			return 'Could not connect: ' .mysql_error();
		}

		$data = new Spreadsheet_Excel_Reader();
		// Set output Encoding.
		$data->setOutputEncoding('CP1251');
		$data->setUTFEncoder('mb');


		$data->read($filePath);
		$items = array();

		for ($i = 0; $i <= $data->sheets[0]['numRows']-1; $i++) {
			for ($j = 0; $j <= $data->sheets[0]['numCols']-1; $j++) {
				$items[$j] = ''.$data->sheets[0]['cells'][$i][$j];
				// 				echo  $items[$j].'<br>';
			}
			if( $i >1){
				$imgPath = $items[2];

				if(!CommonUtil::IsNullOrEmptyString($imgPath)){
					$content_img = file_get_contents(str_replace(' ' , '%20',$imgPath));
					$fp = fopen(str_replace('-','_',str_replace(' ','',$folder.basename($imgPath))), "w");
					fwrite($fp, $content_img);
					fclose($fp);

					$imgsrc = str_replace('-','_',str_replace(' ','',basename($imgPath)));
					$destSrcPath = $folder.$i.'A_4_'.DateTimeUtil::getCurdateYYYYMMDDHHMMSS().'.'.pathinfo($imgsrc,PATHINFO_EXTENSION);
					/* Rename */
					if(!file_exists($destSrcPath) ){
						rename($folder.$imgsrc,$destSrcPath);
					}
				}else
				{
					$destSrcPath = $folder.'none.png';
				}
				/* Check Dup */
				$sql = "select id from tb_book where book_name ='".mysql_real_escape_string($items[3])."' and callNo='".mysql_real_escape_string($items[6])."'";

				$res = mysql_query($sql) or die(mysql_error());;
				$count = mysql_num_rows($res);
				//echo $sql.'<br>';
				if ($count == 0)
				{
					$sql = "insert into tb_book(id,book_name,book_cover1,book_cover2,book_title,book_author,callNo,division,program,type,status,flag,isChange,recommented,create_date) values(0,'".mysql_real_escape_string($items[3])."','".$destSrcPath."','".$destSrcPath."','".mysql_real_escape_string($items[5])."','".mysql_real_escape_string($items[4])."','".mysql_real_escape_string($items[6])."','".mysql_real_escape_string($items[9])."','".mysql_real_escape_string($items[8])."','".mysql_real_escape_string($items[7])."','A','".mysql_real_escape_string($items[10])."',1,'T',NOW())";
					$result = mysql_query($sql);
					if($result) {
						$bResult = true;
					} else {
						$bResult = false;
					}
				}else
				{
					$bResult = false;
				}
			}
		}
		mysql_close($link);
		return false;
	}
}
?>