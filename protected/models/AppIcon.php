<?php

class AppIcon extends CActiveRecord
{
	public $menu_id;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tb_icon';
	}

	public function relations()
	{
		return array(

		);
	}

	public function rules() {
		return array(
				array('id, app_id,icon_path', 'safe'),
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
		return true;
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		if(UserLoginUtil::getUserAppId() == 0) {
				
		}else {
			$criteria->addCondition(" app_id=".UserLoginUtil::getUserAppId());
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