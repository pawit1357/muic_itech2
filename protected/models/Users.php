<?php

class Users extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'users';
	}

	public function relations()
	{
		return array(

				'users_role' => array(self::BELONGS_TO, 'role_id', 'ROLE_ID'),
		);
	}

	public function rules() {
		return array(
				array('id, role_id, username, password, status, create_by, latest_login, department_id, email, token_id, phone_type, user_type', 'safe'),
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

		$criteria->condition="role_id<>-1";



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
}