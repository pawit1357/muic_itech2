<?php

class AppMenu extends CActiveRecord
{
	public $menu_id;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tb_menu';
	}

	public function relations()
	{
		return array(

		);
	}

	public function rules() {
		return array(
				array('id, app_id, parent, menu_icon, menu_type, menu_item, menu_item_src, menu_order, menu_version, menu_status,isChange', 'safe'),
		);
	}

	public function attributeLabels()
	{
		return array(
				
		);
	}

	public function getUrl($post=null)
	{
		if($post===null)
			$post=$this->post;
		return $post->url.'#c'.$this->id;
	}

	protected function beforeSave()
	{
		/*
		 if(parent::beforeSave())
		 {
		if($this->isNewRecord)
			$this->create_time=time();
		return true;
		}
		else
			return false;
		*/
		return true;
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		if(UserLoginUtil::getUserAppId() == 0) {
				
		}else {
		}	
			
		return new CActiveDataProvider(get_class($this), array(
				'criteria' => $criteria,
				'sort' => array(
						'defaultOrder' => 't.id',
				),
				'pagination' => array(
						'pageSize' => 15//ConfigUtil::getDefaultPageSize()
				),
		));
	}
	public function search1()
	{
		$criteria = new CDbCriteria;
	
		if(UserLoginUtil::getUserAppId() == 0) {
	
		}else {
			$criteria->addCondition(" app_id=".UserLoginUtil::getUserAppId()." and parent=-1");
		}
			
		return new CActiveDataProvider(get_class($this), array(
				'criteria' => $criteria,
				'sort' => array(
						'defaultOrder' => 't.id',
				),
				'pagination' => array(
						'pageSize' => 150//ConfigUtil::getDefaultPageSize()
				),
		));
	}	
}