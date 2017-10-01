<?php
class ServiceAppController extends CController
{
	public $layout='ajax';
	private $_model;

	/**
	 * Index action is the default action in a controller.
	 */
	public function actionIndex()
	{

	}

	public function actionGetBanner()
	{
		$udid = $_GET['udid'];
		$result = array();
		$menu = AppBanner::model()->findAll();
		if($menu != null) {
			foreach($menu as $m) {
				$datas = array();
				$datas['id'] = $m->id;
				$datas['app_id'] = $m->app_id;
				$datas['image_url'] = $m->image_path1;
				$datas['status'] = $m->status;
				$result[count($result)]=$datas;
			}
		}
		echo json_encode($result);
	}

	public function actionGetMenu()
	{
		$result = array();
		$menu = AppMenu::model()->findAll();
		if($menu != null) {
			foreach($menu as $m) {
				$datas = array();
				$datas['id'] = $m->id;
				$datas['app_id'] = $m->app_id;
				$datas['parent'] = $m->parent;
				$datas['name'] = $m->menu_item;
				$datas['icon'] = $m->menu_icon;
				$datas['type'] = $m->menu_type;
				$datas['order'] = $m->menu_order;
				$datas['status'] = $m->menu_status;
				$datas['description'] = $m->menu_item_src;
				$result[count($result)]=$datas;
			}
		}
		echo json_encode($result);
	}

	public function actionGetContent()
	{
		$udid = $_GET['udid'];
		$result = array();
		$menu = AppContent::model()->findAll();
		if($menu != null) {
			foreach($menu as $m) {
				$datas = array();
				$datas['id'] = $m->id;
				$datas['app_id'] = $m->app_id;
				$datas['menu_id'] = $m->menu_id;
				$datas['title'] = base64_encode($m->topic);
				$datas['sub_title'] =  base64_encode($m->short_description);
				$datas['description'] = base64_encode($m->description);
				$datas['image_url'] = $m->image_src1;
				$datas['status'] = $m->status;
				$datas['read'] = "0";
				$datas['create_date'] = $m->create_date;
				$result[count($result)]=$datas;
			}
		}
		echo json_encode($result);
	}
	
	public function actionGetContentNews()
	{
		$udid = $_GET['udid'];
		$result = array();
		$menu = AppContent::model()->findAll(array('condition'=>"username = '".$udid."'"));
		if($menu != null) {
			foreach($menu as $m) {
				$datas = array();
				$datas['id'] = $m->id;
				$datas['app_id'] = $m->app_id;
				$datas['menu_id'] = $m->menu_id;
				$datas['title'] = base64_encode($m->topic);
				$datas['sub_title'] =  base64_encode($m->short_description);
				$datas['description'] = base64_encode($m->description);
				$datas['image_url'] = $m->image_src1;
				$datas['status'] = $m->status;
				$datas['read'] = "0";
				$datas['create_date'] = $m->create_date;
				$result[count($result)]=$datas;
			}
		}
		echo json_encode($result);
	}
	
	public function actionGetBook()
	{
		$result = array();
		$menu = Book::model()->findAll();
		if($menu != null) {
			foreach($menu as $m) {
				$datas = array();
				$datas['id'] = $m->id;
				$datas['book_name'] = base64_encode($m->book_name);
				$datas['book_cover'] = $m->book_cover1;
				$datas['book_title'] = base64_encode($m->book_title);
				$datas['book_author'] = base64_encode($m->book_author);
				$datas['callNo'] = base64_encode($m->callNo);
				$datas['division'] =$m->division;
				$datas['program'] = $m->program;
				$datas['type'] =  $m->type;
				$datas['status'] =  $m->status;
				$datas['flag'] =  $m->flag;
				$datas['recommended'] = $m->recommented;
				$datas['create_date'] = $m->create_date;
				$result[count($result)]=$datas;
			}
		}
		echo json_encode($result);
	}

	public function actionGetQuestion()
	{
		$udid = $_GET['udid'];
		$result = array();
		$menu = Question::model()->findAll();

		if($menu != null) {
			foreach($menu as $m) {
				$datas = array();
				$question_answer = QuestionAnswer::model()->findAll(array('condition'=>"question_id = '".$m->id."'"));
				if($question_answer != null) {
					$answer ="";

					foreach ($question_answer as $detail) {
						$answer .= $detail->answer.'#';
					}
					$datas['id'] = $m->id;
					$datas['app_id'] = $m->app_id;
					$datas['device_udid'] = $m->device_udid;
					$datas['question'] = base64_encode($m->question);
					$datas['status'] = $m->status;
					$datas['create_date'] = $m->create_date;
					$datas['isRead'] = $m->isRead;
					$datas['answer']=base64_encode($answer);
					$result[count($result)]=$datas;
				}
				
			}
		}
		echo json_encode($result);
	}

	public function actionGetVersion()
	{

		/*
		 * 1 = ios
		* 2 = andriod
		* */

		$udid = $_GET['udid'];
		$phone_type = $_GET['phone_type'];
		$result = array();

		$app = AppStore::model()->findAll(array('condition'=>"id = 1"));
		if($app != null) {
			foreach($app as $m) {
				$datas = array();
				$datas['version'] = $m->version;
				$result[count($result)]=$datas;
			}
		}
		echo json_encode($result);
	}
	
	public function actionRegister()
	{
	
		/*
		 * 1 = ios
		* 2 = andriod
		* */
	
		$udid = $_GET['udid'];
		$phone_type = $_GET['phone_type'];
		$result = array();
		if(CommonUtil::IsNullOrEmptyString($udid)  ||CommonUtil::IsNullOrEmptyString($phone_type))
		{
			$datas['result'] = false;
			$datas['error_message'] = "Invalid parameter";
		}
		else{
	
			$user = Users::model()->findAll(array('condition'=>"username = '".$udid."'"));
			if($user == null) {
	
				$model = new Users();
				$model->username = $udid;
				$model->password = md5($model->username);
				$model->phone_type =$phone_type;
				$model->create_by = 'SYSTEM';
				$model->role_id=-1;
				$model->status='ACTIVE';
				$model->app_id= 1;
				$model->token_id=$udid;
				if($model->save()){
						
				}
			}
		}
		$app = AppStore::model()->findAll(array('condition'=>"id = 1"));
		if($app != null) {
			foreach($app as $m) {
				$datas = array();
				$datas['version'] = $m->version;
				$result[count($result)]=$datas;
			}
		}
		echo json_encode($result);
	}
	
	
	
}