<?php

/**
 * Default controller to handle user requests.
 */
class BookController extends CController {
	public $layout = 'main';
	private $_model;
	public function actionIndex() {
// 		$model = new Book ();
		
		$criteria=new CDbCriteria();
		$count=Book::model()->count($criteria);
		$pages=new CPagination($count);
		
		// results per page
		$pages->pageSize=10;
		$pages->applyLimit($criteria);
		$models=Book::model()->findAll($criteria);
		
		$this->render('main', array(
				'models' => $models,
				'pages' => $pages
		));
		
		
		
		
		
		
// 		$this->render ( 'main', array (
// 				'data' => $model 
// 		) );
	}
	public function actionCreate() {
		$now = new DateTime ();
		$uploadFolder = 'upload/' . DateTimeUtil::getCurdateYYYYMMDD (); // folder for uploaded files
		if (! is_dir ( $uploadFolder)) {
			mkdir ( $uploadFolder, 0777, TRUE );
		}
		if (isset ( $_POST ['Book'] )) {
			$model = new Book ();
			$model->attributes = $_POST ['Book'];
			$model->create_date = new CDbExpression ( 'NOW()' );
			$model->isChange = 1;
			
			//Get the file
			$contents= file_get_contents($model->book_cover1);
			//Store in the filesystem.
			$save_path= $uploadFolder."/".CommonUtil::random_string(10).'.'.CommonUtil::f_extension($model->book_cover1);
			file_put_contents($save_path,$contents);
			
			$model->book_cover1 = ConfigUtil::getSiteName()."". $save_path;
			
			
			if ($model->save ()) {
				$this->redirect ( Yii::app ()->createUrl ( 'Book/' ) );
			}
		}
		$this->render ( 'create' );
	}
	public function actionUpdate() {
		$uploadFolder = 'upload/';// . DateTimeUtil::getCurdateYYYYMMDD (); // folder for uploaded files
		if (! is_dir ( $uploadFolder)) {
			mkdir ( $uploadFolder, 0777, TRUE );
		}
		$model = $this->loadModel ();
		if (isset ( $_POST ['Book'] )) {
			$model->attributes = $_POST ['Book'];
			$model->create_date = new CDbExpression ( 'NOW()' );
			$model->isChange = 1;

			$url = parse_url($model->book_cover1);
			
			if($url['scheme'] == 'https'){
				// is https;
				
			}else{
				//Get the file
				$contents= file_get_contents($model->book_cover1);
				//Store in the filesystem.
				$save_path= $uploadFolder."/".CommonUtil::random_string(10).'.'.CommonUtil::f_extension($model->book_cover1);
				
				file_put_contents($save_path,$contents);
				$model->book_cover1 = ConfigUtil::getSiteName()."". $save_path;
				
			}
			
	
			
			
			
			
			
// 			echo $contents;
			
			if ($model->update ()) {
				$this->redirect ( Yii::app ()->createUrl ( 'Book/' ) );
			}
		}
		$this->render ( 'update', array (
				'model' => $model 
		) );
	}
	public function actionView() {
		$model = $this->loadModel ();
		$this->render ( 'view', array (
				'model' => $model 
		) );
	}
	public function actionimportBook() {
		$uploadFolder = 'upload/' . DateTimeUtil::getCurdateYYYYMMDD (); // folder for uploaded files
		
		if (isset ( $_POST ['Book'] )) {
			$model = new Book ();
			$model->attributes = $_POST ['Book'];
			
			if ($_FILES ['fileupload1'] ['name']) {
				// if no errors...
				if (! $_FILES ['fileupload1'] ['error']) {
					$currentdir = getcwd ();
					
					$target = $currentdir . "/upload/";
					$target = $target . basename ( $_FILES ['fileupload1'] ['name'] );
					
					if (move_uploaded_file ( $_FILES ['fileupload1'] ['tmp_name'], $target )) {
						// try {
						
						$inputFileType = PHPExcel_IOFactory::identify ( $target );
						$objReader = PHPExcel_IOFactory::createReader ( $inputFileType );
						$objPHPExcel = $objReader->load ( $target );
						$sheet = $objPHPExcel->getSheet ( 0 );
						$highestRow = $sheet->getHighestRow ();
						$highestColumn = $sheet->getHighestColumn ();
						
						for($row = 1; $row <= $highestRow; $row ++) {
							if ($row > 1) {
								$Cover = $sheet->getCell ( "C" . $row )->getValue ();
								
								$Title = $sheet->getCell ( "D" . $row )->getValue ();
								// $Author = $sheet->getCell ( "C" . $row )->getValue ();
								$CallNo = $sheet->getCell ( "E" . $row )->getValue ();
								// $ISBN = $sheet->getCell ( "E" . $row )->getValue ();
								if (! CommonUtil::IsNullOrEmptyString ( $CallNo ) && $CallNo != 'Call No.') {
									$model = new Book ();
									$model->book_name = $Title;
// 									save_image('http://lib.muic.mahidol.ac.th/images/Newbook/2016/nov/do/1.jpg','image.jpg');
									$model->book_cover1 = 'http://lib.muic.mahidol.ac.th/'.$Cover;
									$model->book_cover2 = '';
									$model->book_title = $Title;
									$model->book_author = '';
									$model->callNo = $CallNo;
									$model->division = '';
									$model->program = '';
									$model->type = 6;
									$model->status = 'A';
									$model->flag = 'T';
									$model->recommented = 'T';
									$model->isChange = 1;
									$model->create_date = date ( "Y-m-d H:i:s" );
									$model->save ();
								}
							}
						}
						// } catch ( Exception $e ) {
						// die ( 'Error loading file "' . pathinfo ( $target, PATHINFO_BASENAME ) . '": ' . $e->getMessage () );
						// }
					} else {
						echo "Sorry, there was a problem uploading your file.";
					}
				}
			}
			
			// if(!file_exists($model->book_cover1)){
			// $destSrcPath = $uploadFolder.'/4_'.DateTimeUtil::getCurdateYYYYMMDDHHMMSS().'.'.pathinfo($model->book_cover1,PATHINFO_EXTENSION);
			// /* Rename */
			// rename($uploadFolder.'/'.$model->book_cover1,$destSrcPath);
			
			// if(FeedUtil::libMangazine($destSrcPath)){
			
			// $this->redirect(Yii::app()->createUrl('Book/'));
			// }
			// }
		}
		$this->render ( 'importBook', array (
				'model' => $model 
		) );
	}
	public function actionDelete() {
		$model = new Book ();
		$model->isChange = 1;
		$model = $this->loadModel ();
		if ($model->delete ()) {
			$this->redirect ( Yii::app ()->createUrl ( 'Book/' ) );
		}
		
		$this->render ( 'main', array (
				'data' => $model 
		) );
	}
	public function actionUpload() {
		Yii::import ( "ext.EAjaxUpload.qqFileUploader" );
		
		$folder = 'upload/' . DateTimeUtil::getCurdateYYYYMMDD () . '/'; // folder for uploaded files
		
		if (! is_dir ( $folder )) {
			mkdir ( $folder, 0777, TRUE );
		}
		
		$allowedExtensions = array (
				"jpg",
				"png",
				"xls" 
		); // array("jpg","jpeg","gif","exe","mov" and etc...
		$sizeLimit = 5 * 1024 * 1024; // maximum file size in bytes
		$uploader = new qqFileUploader ( $allowedExtensions, $sizeLimit );
		$result = $uploader->handleUpload ( $folder );
		$return = htmlspecialchars ( json_encode ( $result ), ENT_NOQUOTES );
		
		$fileSize = filesize ( $folder . $result ['filename'] ); // GETTING FILE SIZE
		$fileName = $result ['filename']; // GETTING FILE NAME
		
		echo $return; // it's array
	}
	public function loadModel() {
		if ($this->_model === null) {
			if (isset ( $_GET ['id'] ))
				$this->_model = Book::model ()->findbyPk ( $_GET ['id'] );
			if ($this->_model === null)
				throw new CHttpException ( 404, 'The requested page does not exist.' );
		}
		return $this->_model;
	}
	function save_image($inPath, $outPath) { // Download images from remote server
		$in = fopen ( $inPath, "rb" );
		$out = fopen ( $outPath, "wb" );
		while ( $chunk = fread ( $in, 8192 ) ) {
			fwrite ( $out, $chunk, 8192 );
		}
		fclose ( $in );
		fclose ( $out );
	}
	
	
}