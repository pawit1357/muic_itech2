<?php

class Book extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tb_book';
	}

	public function relations()
	{
		return array(

		);
	}

	public function rules() {
		return array(
				array('id, book_name, book_cover1,book_cover2,  book_title, book_author, callNo, division, program, type,status,flag,recommented', 'safe'),
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
						'defaultOrder' => 't.create_date desc',
				),
				'pagination' => array(
						'pageSize' => 1000//ConfigUtil::getDefaultPageSize()
				),
		));
	}
}