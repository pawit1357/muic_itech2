<?php

/**
 * Default controller to handle user requests.
 */
class AppMenuController extends CController
{
	public $layout='main';
	private $_model;

	public function actionIndex()
	{
		$model = new AppMenu();

		$this->render('main',array(
				'data' => $model,
		));
	}

	public function actionListView()
	{
		$model = new AppMenu();

		$this->render('listView',array(
				'data' => $model,
		));
	}

	public function actionCreateSubmenu()
	{
		$rootPath  = ConfigUtil::getSiteName();// Yii::app()->request->baseUrl.'/';
		$id = Yii::app()->getRequest()->getQuery('id');
		
		if(isset($_POST['AppMenu'])){

			$model = new AppMenu();
			$model->attributes = $_POST['AppMenu'];
			$model->parent = $id;
			$model->menu_version = 1;
			$model->app_id = UserLoginUtil::getUserAppId();
			$model->menu_item_src = preg_replace('/[^A-Za-z0-9\-]/', '',str_replace('-', '',str_replace(' ', '-',$model->menu_item)));
			if(isset($model->menu_icon)){
				$model->menu_icon = $rootPath.'images/icon_app_menu/'.$model->app_id.'/'.basename($model->menu_icon);
			}
			$model->isChange = 1;
			$appMenus = AppMenu::model()->findAll(array('condition'=>" app_id=".UserLoginUtil::getUserAppId()." and parent=".$id));
			$model->menu_order = count($appMenus)+1;
			
			if($model->save()){
				$this->redirect(Yii::app()->createUrl('AppMenu/'));
			}
		}
		
		
		$model = new AppMenu();
		$model->parent = $id;

		
		$this->render('createSubmenu', array(
				'model' => $model,
		));
	}

	public function actionCreate()
	{
		$rootPath  = ConfigUtil::getSiteName();// Yii::app()->request->baseUrl.'/';
		if(isset($_POST['AppMenu'])){
			$model = new AppMenu();
			$model->attributes = $_POST['AppMenu'];

			if((!isset($model->parent) || trim($model->parent)===''))
			{
				$model->parent = -1;
			}
			$model->menu_version = 1;
			$model->app_id = UserLoginUtil::getUserAppId();
			$model->menu_item_src = preg_replace('/[^A-Za-z0-9\-]/', '',str_replace('-', '',str_replace(' ', '-',$model->menu_item)));
			$model->menu_icon = $rootPath.'images/icon_app_menu/'.$model->app_id.'/'.basename($model->menu_icon);
			$model->isChange = 1;
			//Order
			$appMenus = AppMenu::model()->findAll(array('condition'=>" app_id=".UserLoginUtil::getUserAppId()." and parent=".$model->parent));
			$model->menu_order = count($appMenus)+1;

			if($model->save()){
				$this->redirect(Yii::app()->createUrl('AppMenu/'));
			}
		}
		$this->render('create');
	}

	public function actionUpdate()
	{
		
		$rootPath  = ConfigUtil::getSiteName();// Yii::app()->request->baseUrl.'/';
		
		$model = $this->loadModel();
		if(isset($_POST['AppMenu'])){
			$model->attributes = $_POST['AppMenu'];
			if((!isset($model->parent) || trim($model->parent)===''))
			{
				$model->parent = -1;
			}
			
			$model->menu_item_src = $model->menu_item_src;//preg_replace('/[^A-Za-z0-9\-]/', '',str_replace('-', '',str_replace(' ', '-',$model->menu_item)));
			$model->menu_icon = $rootPath.'images/icon_app_menu/'.$model->app_id.'/'.basename($model->menu_icon);
			$model->isChange = 1;
			if($model->update()){
				$this->redirect(Yii::app()->createUrl('AppMenu/'));
			}
		}
		$this->render('update', array(
				'model' => $model,
		));
	}

	public function actionView()
	{
		$model = $this->loadModel();
		$this->render('view', array(
				'model' => $model,
		));
	}

	public function actionDelete()
	{
		$model = new AppMenu();

		$model = $this->loadModel();
		$model->menu_status='I';
		if($model->update()){
			$this->redirect(Yii::app()->createUrl('AppMenu/'));
		}
		$this->render('main', array(
				'data' => $model,
		));
	}

	public function actionDeleteMenu()
	{

		//Check if have child not allow to delete

		$criteria = new CDbCriteria;
		$criteria->addCondition(" app_id=".UserLoginUtil::getUserAppId()." and parent=".$_GET['id']);
		$tmpMenu = AppMenu::model()->findAll($criteria);

		if(count($tmpMenu) > 0 )
		{
			//echo 'Not allow to delete';
			$this->redirect(Yii::app()->createUrl('AppMenu/'));
		}else{
			
			$model = $this->loadModel();
			$model->menu_status='I';
			if($model->update()){
				/* Delete menu & Content */
				$content = new AppContent();
				$content = AppContent::model()->findAll(array('condition'=>" menu_id=".$_GET['id']));
				foreach($content as $c){
					$c->status='I';
					$c->update();	
				}
				$this->redirect(Yii::app()->createUrl('AppMenu/'));
			}
		}

		$this->render('main', array(
				'data' => $model,
		));
	}

	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=AppMenu::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

	
	/*
	public function actionOrderUp($app_id,$menu_id){
		
		$appMenus = AppMenu::model()->findAll(array('condition'=>" app_id=".UserLoginUtil::getUserAppId()." and parent=".$id));
		foreach($appMenus as $menu) {
			
		}
		
		$menus = new AppMenu();
		$menus = AppMenu::model()->findAll(array('condition'=>" id=".$menu_id));
	}
	public function actoinOrderDown($menu_id){
		
	}
	*/

}