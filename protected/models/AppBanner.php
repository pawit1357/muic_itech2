<?php

class AppBanner extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tb_content_image';
	}

	public function relations()
	{
		return array(

		);
	}

	public function rules() {
		return array(
				array('id,menu_id, image_path1, image_size,image_path2, device,status,isChange', 'safe'),
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
						'pageSize' => 100//ConfigUtil::getDefaultPageSize()
				),
		));
	}
}