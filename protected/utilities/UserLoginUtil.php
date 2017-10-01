<?php
class UserLoginUtil {
	private static $userPermissions = array();

	public static function hasPermission($permissionCodes) {
		$UsersId = self::getUsersId();
		if($UsersId == null) {
			return false;
		}

		$currentTime = time();
		// Cache timeout in 5 minites
		$cacheTimeout = (5 * 60 * 1000);

		if(self::$userPermissions['latestUpdateTime'] < ($currentTime - $cacheTimeout)){
			$Users = Users::model()->with('role')->findByPk($UsersId);
			$permissions = array();
			if(isset($Users->role)) {
				$criteria = new CDbCriteria;
				$criteria->condition="role_id = '".$Users->role->id."'";
				$rolePermissions = RolePermission::model()->with('permission')->findAll($criteria);
				foreach ($rolePermissions as $rolePermission){
					if(!in_array($rolePermission->permission_code, $permissions)){
						$permissions[count($permissions)] = $rolePermission->permission_code;
					}
				}
			}
			self::$userPermissions['permissions'] = $permissions;
			self::$userPermissions['latestUpdateTime'] = $currentTime;
		}
		$permissions = self::$userPermissions['permissions'];
		foreach ($permissionCodes as $permissionCode){
			if(in_array($permissionCode, $permissions)) {
				return true;
				break;
			}
		}
		return false;
	}

	public static function isLogin() {
		return isset($_SESSION['USER_LOGIN_ID']);
	}

	public static function logout() {
		unset($_SESSION['USER_LOGIN_ID']);
		unset($_SESSION['USER_APP_ID']);
		unset($_SESSION['USER_INFO']);
		unset($_SESSION['USER_ROLE']);
	}

	public static function authen($username, $password) {
		$criteria = new CDbCriteria;
		$criteria->condition="username = '".$username."' and password='".md5($password)."' and status='ACTIVE'";
		$Users = Users::model()->findAll($criteria);
		if(isset($Users[0])) {
			$Users[0]->latest_login = date("Y-m-d H:i:s");
			$Users[0]->update();
			$_SESSION['USER_LOGIN_ID'] = $Users[0]->id;
			$_SESSION['USER_APP_ID'] = $Users[0]->app_id;
			$_SESSION['USER_ROLE'] = $Users[0]->role_id;
			$_SESSION['USER_INFO'] = $Users[0]->username.' Application('.$Users[0]->app_id.')';
			
			return true;
		} else {
			$_SESSION['FAIL_MESSAGE'] = 'Incorrect Username or Password!';
			return false;
		}
	}

	public static function getUserAppId(){
		if(isset($_SESSION['USER_APP_ID'])){
			return $_SESSION['USER_APP_ID'];
		} else {
			return -1;
		}
	}
	public static function getUserRole(){
		if(isset($_SESSION['USER_ROLE'])){
			return $_SESSION['USER_ROLE'];
		} else {
			return -1;
		}
	}
	public static function getUsersId(){
		if(isset($_SESSION['USER_LOGIN_ID'])){
			return $_SESSION['USER_LOGIN_ID'];
		} else {
			return -1;
		}
	}
	
	public static function getUserInfo(){
		if(isset($_SESSION['USER_INFO'])){
			return $_SESSION['USER_INFO'];
		} else {
			return null;
		}
	}
	
	public static function getUsers(){
		if(self::isLogin()){
			$Users = Users::model()->findByPk(self::getUsersId());
			return $Users;
		} else {
			return null;
		}
	}

// 	public static function getUserRole(){
// 		if(self::isLogin()){
// 			$Users = Users::model()->findByPk(self::getUsersId());
// 			return $Users->users_role->id;
// 		} else {
// 			return null;
// 		}
// 	}

}
?>