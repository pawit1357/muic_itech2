
<?php
header('content-type: text/html; charset=utf-8');
ini_set('max_execution_time', 0);

class XMLUtil {


	public function  copyFile($sourceFile,$outputFile)
	{

		if( !file_exists ( $sourceFile))
		{
			$sourceFile = realpath(Yii::app()->basePath . '/../upload/').'/none.png';
		}
		if( !file_exists ( $outputFile))
		{
			$d = XMLUtil::compress($sourceFile, $sourceFile, 10);

			return copy ( $sourceFile , $outputFile);
		}
		return false;
	}

	public function createXmlfile($app_id,$outputFile,$menu_id,$content_type,$phone_type)
	{

		// 		echo $outputFile.','.$content_id.','.$content_type.'<br>';
		$folder_content = "content";
		$folder_views = "views";
		$folder_images = "images";
		$folder_images_icon = "icon_app_menu";
		$folder_upload ="upload";
		$tmpPath  = realpath(Yii::app()->basePath . '/../tmp/').'/'.$app_id.'_'.$phone_type;
		$sourcePath  = realpath(Yii::app()->basePath . '/../images/');
		$rootPath  = realpath(Yii::app()->basePath . '/../');

		mysql_connect(ConfigUtil::getHostName(), ConfigUtil::getUsername(), ConfigUtil::getPassword());
		mysql_select_db(ConfigUtil::getDbName());
		// 		if (!$link) {
		// 			die('Could not connect: ' . mysql_error());
		// 			return 'Could not connect: ' .mysql_error();
		// 		}
		mysql_query("SET NAMES UTF8");
		switch ($content_type) {
			case 0:
				/* Home */

				/* Banner */
				$xml = new DOMDocument();
				$root = $xml->createElement('home');
				$sql = "select id,isChange,image_path".$phone_type." as image_path,image_size from tb_content_image where app_id=".$app_id." and menu_id=". $menu_id." and status='A'";
				// 				echo $sql."<br>";
				$res = mysql_query($sql);
				$messages = array();
				if (mysql_num_rows($res))
				{
					while ($result = mysql_fetch_assoc($res))
					{
						$messages["$result[id]"] = $result;
					}
					mysql_free_result($res);
					if (count($messages))
					{


						$xml->formatOutput = true;
						$xml->preserveWhitespace = false;

						$banners   = $xml->createElement('banners');
						foreach ($messages AS $id => $data)
						{
							//echo $data['id'].','.$data['isChange'].','.$data['image_path'].'<br>';
							$image   = $xml->createElement('image');
							$imageAttribute = $xml->createAttribute('id');
							$imageAttribute->value = $data['id'];
							$image->appendChild($imageAttribute);

							$src   = $xml->createElement("src");

							if(basename($data['image_path']) <> ''){
								if($data['isChange'] == "1"){
									// 									echo $rootPath.'/'.$data['image_path'];
									XMLUtil::copyFile($rootPath.'/'.$data['image_path'] ,$tmpPath.'/'.$folder_content.'/'.$folder_images.'/'.basename($data['image_path']));
								}
								$srcText = $xml->createTextNode(preg_replace('/[^(\x20-\x7F)]*/','',$folder_content.'/'.$folder_images.'/'.basename($data['image_path'])));
								$srcAttribute = $xml->createAttribute('size');
								$srcAttribute->value = $data['image_size'];
								$src->appendChild($srcAttribute);
								$src->appendChild($srcText);
							}



							$image->appendChild($src);
							$banners->appendChild($image);
						}
						$root->appendChild($banners);

					}
				}
				/* New & Update */
				$sql1 = "select id,isChange,topic,image_src".$phone_type." as image_src,image_size,description from tb_content where app_id=".$app_id." and  menu_id=". $menu_id." and status='A' order by create_date desc";
				$res1 = mysql_query($sql1);
				$messages1 = array();
				if (mysql_num_rows($res1))
				{
					while ($result = mysql_fetch_assoc($res1))
					{
						$messages1["$result[id]"] = $result;
					}
					mysql_free_result($res1);
					if (count($messages1))
					{
						$new_event   = $xml->createElement('new_event');
						foreach ($messages1 AS $id => $data)
						{

							$item   = $xml->createElement('news');
							$itemAttribute = $xml->createAttribute('id');
							$itemAttribute->value = $data['id'];
							$item->appendChild($itemAttribute);

							$topic   = $xml->createElement("topic");
							$topicText = $xml->createCDATASection(Encoding::toUTF8($data['topic']));
							$topic->appendChild($topicText);

							$picture   = $xml->createElement("picture");
							if(basename($data['image_src']) <> ''){

								// 								echo $data['id'].'['.($data['isChange'] == "1" ? "true" : "false").'],'.$data['isChange'].'<br>';

								if($data['isChange'] == "1"){
									XMLUtil::copyFile($rootPath.'/'.$data['image_src'] ,$tmpPath.'/'.$folder_content.'/'.$folder_images.'/'.basename($data['image_src']));
								}
								$pictureText = $xml->createTextNode(preg_replace('/[^(\x20-\x7F)]*/','', $folder_content.'/'.$folder_images.'/'.basename($data['image_src'])));
								$pictureAttribute = $xml->createAttribute('size');
								$pictureAttribute->value = $data['image_size'];
								$picture->appendChild($pictureAttribute);
								$picture->appendChild($pictureText);
							}


							$description   = $xml->createElement("description");
							$descriptionText = $xml->createCDATASection(Encoding::toUTF8($data['description']));
							$description->appendChild($descriptionText);

							$item->appendChild( $topic );
							$item->appendChild( $picture );
							$item->appendChild( $description );

							$new_event->appendChild( $item );
						}

						$root->appendChild($new_event);
					}
				}

				$xml->appendChild( $root );
				$xml->save($outputFile);

				break;
			case 1:
				/* List */
				$sql = "select id,topic,isChange,image_src".$phone_type." as image_src,image_size,description,short_description from tb_content where app_id=".$app_id." and  menu_id=". $menu_id." and status='A'";
				$res = mysql_query($sql);
				$messages = array();
				if (mysql_num_rows($res))
				{
					while ($result = mysql_fetch_assoc($res))
					{
						$messages["$result[id]"] = $result;
					}
					mysql_free_result($res);
					if (count($messages))
					{
						$xml = new DOMDocument();
						$root = $xml->createElement('articles');
						$xml->formatOutput = true;
						$xml->preserveWhitespace = false;
						foreach ($messages AS $id => $data)
						{

							$item   = $xml->createElement('article');
							$itemAttribute = $xml->createAttribute('id');
							$itemAttribute->value = $data['id'];
							$item->appendChild($itemAttribute);

							$topic   = $xml->createElement("topic");
							$topicText = $xml->createCDATASection($data['topic']);
							$topic->appendChild($topicText);

							$picture   = $xml->createElement("picture");
							if(basename($data['image_src']) <> ''){
								if($data['isChange'] == "1"){
									XMLUtil::copyFile($rootPath.'/'.$data['image_src'] ,$tmpPath.'/'.$folder_content.'/'.$folder_images.'/'.basename($data['image_src']));
								}
								$pictureText = $xml->createTextNode(preg_replace('/[^(\x20-\x7F)]*/','', $folder_content.'/'.$folder_images.'/'.basename($data['image_src'])));
								$pictureAttribute = $xml->createAttribute('size');
								$pictureAttribute->value = $data['image_size'];
								$picture->appendChild($pictureAttribute);
								$picture->appendChild($pictureText);
							}

							$description   = $xml->createElement("description");
							$descriptionText = $xml->createCDATASection(Encoding::toUTF8($data['description']));
							$description->appendChild($descriptionText);

							$item->appendChild( $topic );
							$item->appendChild( $picture );
							$item->appendChild( $description );

							$root->appendChild( $item );
						}


						$xml->appendChild( $root );
						$xml->save($outputFile);
					}
				}


				break;
			case 2:
				/* Webview */
				$sql = "select id,app_id,isChange,topic,description,image_size,image_src".$phone_type." as image_src from tb_content where app_id=".$app_id." and  menu_id=". $menu_id." and status='A'";
				$res = mysql_query($sql);
				$messages = array();
				if (mysql_num_rows($res))
				{
					while ($result = mysql_fetch_assoc($res))
					{
						$messages["$result[id]"] = $result;
					}
					mysql_free_result($res);
					if (count($messages))
					{
						$xml = new DOMDocument();
						$root = $xml->createElement('abouts');
						$xml->formatOutput = true;
						$xml->preserveWhitespace = false;
						foreach ($messages AS $id => $data)
						{

							$item   = $xml->createElement('about');
							$itemAttribute = $xml->createAttribute('id');
							$itemAttribute->value = $data['id'];
							$item->appendChild($itemAttribute);

							$topic   = $xml->createElement("topic");
							$topicText = $xml->createCDATASection($data['topic']);
							$topic->appendChild($topicText);


							$picture   = $xml->createElement("picture");
							if(basename($data['image_src']) <> ''){
								if($data['isChange'] == "1"){
									XMLUtil::copyFile($rootPath.'/'.basename($data['image_src']) ,$tmpPath.'/'.$folder_content.'/'.$folder_images.'/'.basename($data['image_src']));
								}
								$pictureText = $xml->createTextNode(preg_replace('/[^(\x20-\x7F)]*/','', $folder_content.'/'.$folder_images.'/'.basename($data['image_src'])));
								$pictureAttribute = $xml->createAttribute('size');
								$pictureAttribute->value = $data['image_size'];
								$picture->appendChild($pictureAttribute);
								$picture->appendChild($pictureText);
							}

							$description   = $xml->createElement("description");
							$descriptionText = $xml->createCDATASection(self::getHtmlTemplete(Encoding::toUTF8($data['description']),$phone_type));
							$description->appendChild($descriptionText);

							$item->appendChild( $topic );
							$item->appendChild( $picture );
							$item->appendChild( $description );
						}
							
						$root->appendChild( $item );
							
						$xml->appendChild( $root );
						$xml->save($outputFile);
					}
				}
				break;
			case 3:
				/* Gallery */
				$sql = "select id,isChange,thumnail_src".$phone_type." as thumnail_src,thumnail_size,image_src".$phone_type." as image_src,image_size from tb_gallery where app_id=".$app_id." and  menu_id=". $menu_id." and status='A'";
				$res = mysql_query($sql);
				$messages = array();
				if (mysql_num_rows($res))
				{
					while ($result = mysql_fetch_assoc($res))
					{
						$messages["$result[id]"] = $result;
					}
					mysql_free_result($res);
					if (count($messages))
					{
						$xml = new DOMDocument();
						$xml->formatOutput = true;
						$xml->preserveWhitespace = false;

						$new_event   = $xml->createElement('gallerys');
						foreach ($messages AS $id => $data)
						{

							$item   = $xml->createElement('gallery');
							$itemAttribute = $xml->createAttribute('id');
							$itemAttribute->value = $data['id'];
							$item->appendChild($itemAttribute);

							if(basename($data['thumnail_src']) <> ''){
								if($data['isChange'] == "1"){
									XMLUtil::copyFile($rootPath.'/'.$data['thumnail_src'] ,$tmpPath.'/'.$folder_content.'/'.$folder_images.'/'.basename($data['thumnail_src']));
								}
							}
							$thumnail   = $xml->createElement("thumnail");
							$thumnaiText = $xml->createTextNode(preg_replace('/[^(\x20-\x7F)]*/','', $folder_content.'/'.$folder_images.'/'.basename($data['thumnail_src'])));
							$thumnailAttribute = $xml->createAttribute('size');
							$thumnailAttribute->value = $data['thumnail_size'];
							$thumnail->appendChild($thumnailAttribute);
							$thumnail->appendChild($thumnaiText);

							$picture   = $xml->createElement("picture");
							if(basename($data['image_src']) <> ''){
								if($data['isChange'] == "1"){
									XMLUtil::copyFile($rootPath.'/'.$data['image_src'] ,$tmpPath.'/'.$folder_content.'/'.$folder_images.'/'.basename($data['image_src']));
								}
								$pictureText = $xml->createTextNode(preg_replace('/[^(\x20-\x7F)]*/','', $folder_content.'/'.$folder_images.'/'.basename($data['image_src'])));
								$pictureAttribute = $xml->createAttribute('size');
								$pictureAttribute->value = $data['image_size'];
								$picture->appendChild($pictureAttribute);
								$picture->appendChild($pictureText);
							}

							$item->appendChild( $thumnail );
							$item->appendChild( $picture );


							$new_event->appendChild( $item );
						}


						$xml->appendChild( $new_event );
						$xml->save($outputFile);
					}
				}


				break;
			case 41:/* New Arrival */
				/*  1=Thesis, 2=Thematic,
				 *  3=Magazine,
				 *  4=Book    */

				$sql = "SELECT id,isChange,book_name,book_cover".$phone_type." as book_cover,book_title,book_author,callNo,division,program,type,flag FROM tb_book where flag='T' and status='A'";
				$res = mysql_query($sql);
				$messages = array();
				if (mysql_num_rows($res))
				{
					while ($result = mysql_fetch_assoc($res))
					{
						$messages["$result[id]"] = $result;
					}
					mysql_free_result($res);
					if (count($messages))
					{
						$xml = new DOMDocument();
						$xml->formatOutput = true;
						$xml->preserveWhitespace = false;
						$root = $xml->createElement('muics');

						$rowSeq = 1;
						foreach ($messages AS $id => $data)
						{

							$item   = $xml->createElement('muic');
							$itemAttribute = $xml->createAttribute('id');
							$itemAttribute->value = $data['id'];
							$item->appendChild($itemAttribute);

							$no   = $xml->createElement("no");
							$noText = $xml->createTextNode($rowSeq);
							$no->appendChild($noText);

							$cover   = $xml->createElement("cover");
							if(basename($data['book_cover']) <> ''){
								if($data['isChange'] == "1"){
									XMLUtil::copyFile($rootPath.'/'.$data['book_cover'] ,$tmpPath.'/'.$folder_content.'/'.$folder_images.'/'.basename($data['book_cover']));
								}

								$coverText = $xml->createTextNode(preg_replace('/[^(\x20-\x7F)]*/','', $folder_content.'/'.$folder_images.'/'.basename($data['book_cover'])));
								$cover->appendChild($coverText);
							}
							$title   = $xml->createElement("title");
							$titleText = $xml->createCDATASection($data['book_name']);
							$title->appendChild($titleText);

							$author   = $xml->createElement("author");
							$authorText = $xml->createCDATASection($data['book_author']);
							$author->appendChild($authorText);

							$callno   = $xml->createElement("callno");
							$callnoText = $xml->createCDATASection($data['callNo']);
							$callno->appendChild($callnoText);

							$program   = $xml->createElement("program");
							$programText = $xml->createCDATASection($data['program']);
							$program->appendChild($programText);

							$type   = $xml->createElement("type");
							$typeText = $xml->createTextNode($data['type']);
							$type->appendChild($typeText);

							$divison   = $xml->createElement("divison");
							$divisonText = $xml->createTextNode($data['divison']);
							$divison->appendChild($divisonText);

							$flag   = $xml->createElement("flag");
							$flagText = $xml->createTextNode($data['flag']);
							$flag->appendChild($flagText);


							$description   = $xml->createElement("description");
							$descriptionText = $xml->createCDATASection(Encoding::toUTF8(preg_replace('/[^(\x20-\x7F)]*/','',$data['book_title'])));
							$description->appendChild($descriptionText);

							$item->appendChild( $no );
							$item->appendChild( $cover );
							$item->appendChild( $title );
							$item->appendChild( $author );
							$item->appendChild( $callno );
							$item->appendChild( $program );
							$item->appendChild( $type );
							$item->appendChild( $divison );
							$item->appendChild( $flag );
							$item->appendChild( $description );

							$root->appendChild( $item );

							$rowSeq++;
						}


						$xml->appendChild( $root );
						$xml->save($outputFile);
					}
				}
				break;
			case 42:/* Recommend */
				/*  1=Thesis, 2=Thematic,
				 *  3=Magazine,
				 *  4=Book    */

				$sql = "SELECT id,isChange,book_name,book_cover".$phone_type." as book_cover,book_title,book_author,callNo,division,program,type,flag FROM tb_book where recommented ='T' and status='A'";
				$res = mysql_query($sql);
				$messages = array();
				if (mysql_num_rows($res))
				{
					while ($result = mysql_fetch_assoc($res))
					{
						$messages["$result[id]"] = $result;
					}
					mysql_free_result($res);
					if (count($messages))
					{
						$xml = new DOMDocument();
						$xml->formatOutput = true;
						$xml->preserveWhitespace = false;
						$root = $xml->createElement('muics');

						$rowSeq = 1;
						foreach ($messages AS $id => $data)
						{

							$item   = $xml->createElement('muic');
							$itemAttribute = $xml->createAttribute('id');
							$itemAttribute->value = $data['id'];
							$item->appendChild($itemAttribute);

							$no   = $xml->createElement("no");
							$noText = $xml->createTextNode($rowSeq);
							$no->appendChild($noText);

							$cover   = $xml->createElement("cover");
							if(basename($data['book_cover']) <> ''){
								if($data['isChange'] == "1"){
									XMLUtil::copyFile($rootPath.'/'.$data['book_cover'] ,$tmpPath.'/'.$folder_content.'/'.$folder_images.'/'.basename($data['book_cover']));
								}else {
									// 									echo 'XXXXXXXXXXXXXXXXXXXXXXXXXXxx';
								}

								$coverText = $xml->createTextNode(preg_replace('/[^(\x20-\x7F)]*/','', $folder_content.'/'.$folder_images.'/'.basename($data['book_cover'])));
								$cover->appendChild($coverText);
							}
							$title   = $xml->createElement("title");
							$titleText = $xml->createCDATASection($data['book_name']);
							$title->appendChild($titleText);

							$author   = $xml->createElement("author");
							$authorText = $xml->createCDATASection($data['book_author']);
							$author->appendChild($authorText);

							$callno   = $xml->createElement("callno");
							$callnoText = $xml->createCDATASection($data['callNo']);
							$callno->appendChild($callnoText);

							$program   = $xml->createElement("program");
							$programText = $xml->createCDATASection($data['program']);
							$program->appendChild($programText);

							$type   = $xml->createElement("type");
							$typeText = $xml->createTextNode($data['type']);
							$type->appendChild($typeText);

							$divison   = $xml->createElement("divison");
							$divisonText = $xml->createTextNode($data['divison']);
							$divison->appendChild($divisonText);

							$flag   = $xml->createElement("flag");
							$flagText = $xml->createTextNode($data['flag']);
							$flag->appendChild($flagText);


							$description   = $xml->createElement("description");
							$descriptionText = $xml->createCDATASection(Encoding::toUTF8(preg_replace('/[^(\x20-\x7F)]*/','',$data['book_title'])));
							$description->appendChild($descriptionText);

							$item->appendChild( $no );
							$item->appendChild( $cover );
							$item->appendChild( $title );
							$item->appendChild( $author );
							$item->appendChild( $callno );
							$item->appendChild( $program );
							$item->appendChild( $type );
							$item->appendChild( $divison );
							$item->appendChild( $flag );
							$item->appendChild( $description );

							$root->appendChild( $item );

							$rowSeq++;
						}


						$xml->appendChild( $root );
						$xml->save($outputFile);
					}
				}
				break;
			case 43:/* Thesis */
				/*  1=Thesis, 2=Thematic,
				 *  3=Magazine,
				 *  4=Book    */
					
				$sql = "SELECT id,isChange,book_name,book_cover".$phone_type." as book_cover,book_title,book_author,callNo,division,program,type,flag FROM tb_book where type in(1,2) and status='A'";
				$res = mysql_query($sql);
				$messages = array();
				if (mysql_num_rows($res))
				{
					while ($result = mysql_fetch_assoc($res))
					{
						$messages["$result[id]"] = $result;
					}
					mysql_free_result($res);
					if (count($messages))
					{
						$xml = new DOMDocument();
						$xml->formatOutput = true;
						$xml->preserveWhitespace = false;
						$root = $xml->createElement('muics');
							
						$rowSeq = 1;
						foreach ($messages AS $id => $data)
						{

							$item   = $xml->createElement('muic');
							$itemAttribute = $xml->createAttribute('id');
							$itemAttribute->value = $data['id'];
							$item->appendChild($itemAttribute);

							$no   = $xml->createElement("no");
							$noText = $xml->createTextNode($rowSeq);
							$no->appendChild($noText);

							$cover   = $xml->createElement("cover");
							if(basename($data['book_cover']) <> ''){
								if($data['isChange'] == "1"){
									XMLUtil::copyFile($rootPath.'/'.$data['book_cover'] ,$tmpPath.'/'.$folder_content.'/'.$folder_images.'/'.basename($data['book_cover']));
								}
									
								$coverText = $xml->createTextNode(preg_replace('/[^(\x20-\x7F)]*/','', $folder_content.'/'.$folder_images.'/'.basename($data['book_cover'])));
								$cover->appendChild($coverText);
							}
							$title   = $xml->createElement("title");
							$titleText = $xml->createCDATASection($data['book_name']);
							$title->appendChild($titleText);

							$author   = $xml->createElement("author");
							$authorText = $xml->createCDATASection('<b style="color:red">Author:</b>'.$data['book_author']);//
							$author->appendChild($authorText);

							$callno   = $xml->createElement("callno");
							$callnoText = $xml->createCDATASection('<b style="color:red">Call No:</b>'.$data['callNo']);//
							$callno->appendChild($callnoText);

							$program   = $xml->createElement("program");
							$programText = $xml->createCDATASection($data['program']);
							$program->appendChild($programText);

							$type   = $xml->createElement("type");
							$typeText = $xml->createTextNode($data['type']);
							$type->appendChild($typeText);

							$divison   = $xml->createElement("divison");
							$divisonText = $xml->createTextNode($data['divison']);
							$divison->appendChild($divisonText);

							$flag   = $xml->createElement("flag");
							$flagText = $xml->createTextNode($data['flag']);
							$flag->appendChild($flagText);


							$description   = $xml->createElement("description");
							$descriptionText = $xml->createCDATASection(Encoding::toUTF8(preg_replace('/[^(\x20-\x7F)]*/','',$data['book_title'])));
							$description->appendChild($descriptionText);

							$item->appendChild( $no );
							$item->appendChild( $cover );
							$item->appendChild( $title );
							$item->appendChild( $author );
							$item->appendChild( $callno );
							$item->appendChild( $program );
							$item->appendChild( $type );
							$item->appendChild( $divison );
							$item->appendChild( $flag );
							$item->appendChild( $description );

							$root->appendChild( $item );

							$rowSeq++;
						}
							
							
						$xml->appendChild( $root );
						$xml->save($outputFile);
					}
				}
				break;
			case 5:
				/* Faq (Custom for Lib) */

				$sql = "select t1.id,t1.question,t2.answer from tb_question t1,tb_question_answer t2 where t1.id = t2.question_id and t1.app_id=". $app_id." and t1.status='A'";
				$res = mysql_query($sql);
				$messages = array();
				if (mysql_num_rows($res))
				{
					while ($result = mysql_fetch_assoc($res))
					{
						$messages["$result[id]"] = $result;
					}
					mysql_free_result($res);
					if (count($messages))
					{
						$xml = new DOMDocument();
						$xml->formatOutput = true;
						$xml->preserveWhitespace = false;
						$root = $xml->createElement('muics');

						foreach ($messages AS $id => $data)
						{
							$item   = $xml->createElement('muic');
							$itemAttribute = $xml->createAttribute('id');
							$itemAttribute->value = $data['id'];
							$item->appendChild($itemAttribute);

							$question   = $xml->createElement("question");
							$questionText = $xml->createCDATASection(Encoding::toUTF8($data['question']));
							$question->appendChild($questionText);

							$answer   = $xml->createElement("answer");
							$answerText = $xml->createCDATASection(Encoding::toUTF8($data['answer']));
							$answer->appendChild($answerText);

							$item->appendChild( $question );
							$item->appendChild( $answer );

							$root->appendChild( $item );
						}

						$xml->appendChild( $root );
						$xml->save($outputFile);
					}
				}
				break;
		}


	}

	public function createPackage($app_id,$phone_type)
	{
		/*
		 * ------ package structure ------
		* app
		* +content
		* 	+images
		* 		+gallery
		* 			-
		* 			-
		* 		-
		* 		-
		* 		-
		* +view
		*   -
		*   -
		*   -
		* menu.xml
		*
		* ------ end package structure ------
		*   */



		// 		$xml->save($tmpPath."/menu.xml") or die("Error");
		return true;
	}

	public function createZip($app_id,$phone_type)
	{
		$rootPath  ='tmp/'.$app_id.'_'.$phone_type;
		$contentPath = $rootPath.'/content';
		$menuFilePath = $rootPath.'/menu.xml';

		mysql_connect(ConfigUtil::getHostName(), ConfigUtil::getUsername(), ConfigUtil::getPassword());
		mysql_select_db(ConfigUtil::getDbName());
		// 		if (!$link) {
		// 			die('Could not connect: ' . mysql_error());
		// 			return 'Could not connect: ' .mysql_error();
		// 		}

		$sql = "select version from tb_app where id='".$app_id."' and status='A'" ;

		$result = mysql_query($sql);
		$version = 0;
		while($item = mysql_fetch_assoc($result)){
			$version = $item['version'];
		}
			
		$destFilePath = 'download/'.$app_id.'_'.$phone_type.'_V'.($version+1).'.zip';
		if (file_exists($destFilePath)) {
			unlink ($destFilePath);
		}
		// 		mysql_close($link);
		XMLUtil::zipFile($contentPath,$destFilePath,$menuFilePath, true);
		return true;
	}

	public static function updatePackageVersion()
	{

		$link = mysql_connect(ConfigUtil::getHostName(), ConfigUtil::getUsername(), ConfigUtil::getPassword());
		mysql_select_db(ConfigUtil::getDbName());

		$sql = "select version from tb_app where id = 1 and status='A'" ;

		$result = mysql_query($sql);
		$version = 0;
		while($item = mysql_fetch_assoc($result)){
			$version = $item['version'];
		}

// 		$sTbApp = "update tb_app set version=".($version+1)." where id=1";

// 		$sTbBook = "update tb_book set isChange=0 where id=".$app_id;
// 		$sTbContent = "update tb_content set isChange=0 where app_id=".$app_id;
// 		$sTbContentImage = "update tb_content_image set isChange=0 where app_id=".$app_id;
// 		$sTbMenu = "update tb_menu set isChange=0 where app_id=".$app_id;

// 		/* update content after generate package */
// 		$result = mysql_query($sTbApp);
// 		$result = mysql_query($sTbBook);
// 		$result = mysql_query($sTbContent);
// 		$result = mysql_query($sTbContentImage);
// 		$result = mysql_query($sTbMenu);
		if($result) {
			return true;
		} else {
			return false;
		}

	}

	private function zipFile($source, $destination,$menuFilePath, $flag = '')
	{
		if (!extension_loaded('zip') || !file_exists($source)) {
			return false;
		}

		$zip = new ZipArchive();
		if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
			return false;
		}

		$source = str_replace('\\', '/', realpath($source));
		if($flag)
		{
			$flag = basename($source) . '/';
			//$zip->addEmptyDir(basename($source) . '/');
		}

		if (is_dir($source) === true)
		{
			$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);
			foreach ($files as $file)
			{
				$file = str_replace('\\', '/', realpath($file));

				if (is_dir($file) === true)
				{
					$zip->addEmptyDir(str_replace($source . '/', '', $flag.$file . '/'));
				}
				else if (is_file($file) === true)
				{
					$zip->addFromString(str_replace($source . '/', '', $flag.$file), file_get_contents($file));
				}
			}
		}
		else if (is_file($source) === true)
		{
			$zip->addFromString($flag.basename($source), file_get_contents($source));
		}
		$zip->addFromString(basename($menuFilePath), file_get_contents($menuFilePath));

		return $zip->close();
	}

	public function  getChild($messages,$app_id,$parent_id)
	{
		$link = mysql_connect(ConfigUtil::getHostName(), ConfigUtil::getUsername(), ConfigUtil::getPassword());
		mysql_select_db(ConfigUtil::getDbName());
		// 		if (!$link) {
		// 			die('Could not connect: ' . mysql_error());
		// 			return 'Could not connect: ' .mysql_error();
		// 		}

		mysql_query("SET NAMES UTF8");
		$sql = "select id,isChange,menu_icon,menu_item,menu_item_src,menu_type from tb_menu where app_id=".$app_id." and parent=".$parent_id." and menu_status ='A'  order by menu_order asc";
		//echo $sql.'<br>';
		$res = mysql_query($sql) or die(mysql_error());
		$messages = array();

		if (mysql_num_rows($res))
		{
			while ($result = mysql_fetch_assoc($res))
			{
				$messages["$result[id]"] = $result;
			}
		}

		mysql_free_result($res);
		// 		mysql_close($link);
		return $messages;
	}

	public function  checkHaveContent($id,$app_id)
	{
			
		$link = mysql_connect(ConfigUtil::getHostName(), ConfigUtil::getUsername(), ConfigUtil::getPassword());
		mysql_select_db(ConfigUtil::getDbName());
		// 		if (!$link) {
		// 			die('Could not connect: ' . mysql_error());
		// 			return 'Could not connect: ' .mysql_error();
		// 		}

		mysql_query("SET NAMES UTF8");
		$sql = "select count(id) from tb_content where menu_id = ".$id." and app_id=".$app_id."";

		$res = mysql_query($sql) or die(mysql_error());
		$row = mysql_fetch_array($res);

		$total = $row[0];
		// 		mysql_close($link);
		if($total > 0)
		{
			return true;
		}else
		{
			return false;
		}
	}



	public function getHtmlTemplete($body,$phone_type)
	{
		$html =
		"<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">".
		"<html xmlns=\"http://www.w3.org/1999/xhtml\">".
		"<head>".
		"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />".
		"<title></title>".
		"<meta http-equiv=\"Content-Language\" content=\"th\">".
		"<meta http-equiv=\"content-Type\" content=\"text/html; charset=window-874\">".
		"<meta http-equiv=\"content-Type\" content=\"text/html; charset=tis-620\">".
		"<style>".
		"body {".
		"	 -webkit-text-size-adjust:none;".
		"	 padding:5px;".
		"    font-family: Arial, Helvetica, sans-serif;".
		"    font-size: 11px; padding:5px;".
		"}".
		"p {".
		"    font-family: Arial, Helvetica, sans-serif;".
		"    font-size: 13px;".
		"}".
		"".
		"td {".
		"    font-family: Arial, Helvetica, sans-serif;".
		"    font-size: 13px;".
		"}".
		"".
		"th {".
		"    font-family: Arial, Helvetica, sans-serif;".
		"    font-size: 13px;".
		"}".
		"".
		".medium {".
		"    font-family: Arial, Helvetica, sans-serif;".
		"    font-size: 16px; font-weight: bold;".
		"}".
		"".
		".mediumwhite{".
		"    font-family: Arial, Helvetica, sans-serif;".
		"    font-size: 16px;".
		"    font-weight: bold;".
		"  color: #FFF;".
		"}".
		"".
		".big {".
		"    font-family: Arial, Helvetica, sans-serif;".
		"    font-size: 20px; font-weight: bold;".
		"}".
		"".
		".xbig {".
		"    font-family: Arial, Helvetica, sans-serif;".
		"    font-size: 24px;".
		"    font-weight: bold;".
		"}".
		"</style>".
		"</head>".
		"<body><div  style=\"width:".($phone_type == "1"? "300":"620")."px\">".$body."</div></body></html>";
		return $html;
	}

	public function deleteTmp($app_id,$phone_type)
	{

		$folder_content = "content";
		$folder_views = "views";
		$folder_images = "images";
		$folder_images_icon = "icon_app_menu";
		$tmpPath  = realpath(Yii::app()->basePath . '/../tmp/').'/'.$app_id.'_'.$phone_type;



		//5.Delete images folder
		$path = $tmpPath.'/'.$folder_content.'/'.$folder_views.'/';
		if (is_dir($path)) {

			$files = glob($path. '/*', GLOB_MARK); // get all file names
			if(is_array($files))
			{
				foreach($files as $file){ // iterate files
					if(is_file($file))
						unlink($file); // delete file
				}
			}
			rmdir($path);
		}
		//4.Delete icon folder
		$path = $tmpPath.'/'.$folder_content.'/'.$folder_images.'/'.$folder_images_icon.'/';
		if (is_dir($path)) {
			$files = glob($path. '/*', GLOB_MARK); // get all file names

			if(is_array($files))
			{
				foreach($files as $file){ // iterate files
					if(is_file($file))
						unlink($file); // delete file
				}
			}
			rmdir($path);
		}
		//3.Delete images folder
		$path = $tmpPath.'/'.$folder_content.'/'.$folder_images.'/';
		if (is_dir($path)) {
			$files = glob($path. '/*', GLOB_MARK); // get all file names
			if(is_array($files))
			{
				foreach($files as $file){ // iterate files
					if(is_file($file))
						unlink($file); // delete file
				}
			}
			rmdir($path);
		}
		//2.Delete content folder
		$path = $tmpPath.'/'.$folder_content.'/';
		if (is_dir($path)) {
			$files = glob($path. '/*', GLOB_MARK); // get all file names
			if(is_array($files))
			{
				foreach($files as $file){ // iterate files
					if(is_file($file))
						unlink($file); // delete file
				}
			}
			rmdir($path);
		}
			

		$path = $tmpPath.'/';
		if (is_dir($path)) {
			$files = glob($path. '/*', GLOB_MARK); // get all file names
			if(is_array($files))
			{
				foreach($files as $file){ // iterate files
					if(is_file($file))
						unlink($file); // delete file
				}
			}
			rmdir($path);
		}

		return true;
	}



	function compress($source, $destination, $quality) {
		$info = getimagesize($source);
		if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source);
		elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source);
		elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source);
		imagejpeg($image, $destination, $quality);
		return $destination;
	}
	//$source_img = 'source.jpg'; $destination_img = 'destination .jpg'; $d = compress($source_img, $destination_img, 90);
	// 	- See more at: http://www.apptha.com/blog/how-to-reduce-image-file-size-while-uploading-using-php-code/#sthash.cgagCtRk.dpuf
}
?>