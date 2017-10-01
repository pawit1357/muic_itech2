<?php

class AppArticle extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tb_article';
	}

	public function relations()
	{
		return array(

		);
	}

	public function rules() {
		return array(
				array('id,app_id, image, image_src, topic, description_short, descripton', 'safe'),
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
		return new CActiveDataProvider(get_class($this), array(
				'criteria' => $criteria,
				'sort' => array(
						'defaultOrder' => 't.id',
				),
				'pagination' => array(
						'pageSize' => 100//ConfigUtil::getDefaultPageSize()
				),
		));
	}
}