<?php
class AppStore extends CActiveRecord {
	public $adminView = false;
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'tb_app';
	}
	public function relations() {
		return array ()

		;
	}
	public function rules() {
		return array (
				array (
						'id,name, platform,bundle,url, version, image,questionnaire_url',
						'safe' 
				) 
		);
	}
	public function attributeLabels() {
		return array ()

		;
	}
	public function getUrl($post = null) {
		if ($post === null)
			$post = $this->post;
		return $post->url . '#c' . $this->id;
	}
	protected function beforeSave() {
		return true;
	}
	public function search() {
		$criteria = new CDbCriteria ();
// 		if (UserLoginUtil::getUserAppId () == 0) {
// 		} else {
// 			if (UserLoginUtil::getUserRole () != 1) {
// 				$criteria->addCondition ( " id=" . UserLoginUtil::getUserAppId () );
// 			}
// 		}
		$criteria->addCondition ( " id=1");
		
		
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria,
				'sort' => array (
						'defaultOrder' => 't.id' 
				),
				'pagination' => array (
						'pageSize' => 150 
				) // ConfigUtil::getDefaultPageSize()
 
		) );
	}
}