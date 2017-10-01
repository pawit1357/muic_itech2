<?php

class AppGallery extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tb_gallery';
	}

	public function relations()
	{
		return array(

		);
	}

	public function rules() {
		return array(
				array('id, app_id, menu_id, thumnail_size, thumnail_src1, thumnail_src2,  image_size, image_src1, image_src2,status,isChange', 'safe'),
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
			$criteria->addCondition(" app_id=".UserLoginUtil::getUserAppId().' and menu_id='.$_SESSION['MenuID']);
		}		
		return new CActiveDataProvider(get_class($this), array(
				'criteria' => $criteria,
				'sort' => array(
						'defaultOrder' => 't.id',
				),
				'pagination' => array(
						'pageSize' => 500//ConfigUtil::getDefaultPageSize()
				),
		));
	}
}