<?php

class Catagories extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tb_catagories';
	}

	public function relations()
	{
		return array(

		);
	}

	public function rules() {
		return array(
				array('id,name, status', 'safe'),
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

		return new CActiveDataProvider(get_class($this), array(
				'sort' => array(
						'defaultOrder' => 't.id',
				),
				'pagination' => array(
						'pageSize' => 150//ConfigUtil::getDefaultPageSize()
				),
		));
	}
}