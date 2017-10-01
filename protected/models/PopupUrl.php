<?php

class PopupUrl extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tb_popup_url';
	}

	public function relations()
	{
		return array(

		);
	}

	public function rules() {
		return array(
				array('id,url, message, create_date', 'safe'),
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
// 		if(UserLoginUtil::getUserAppId() == 0) {
// 		}else {
// 			$criteria->addCondition(" app_id=".UserLoginUtil::getUserAppId());
// 		}		
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