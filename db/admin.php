<?php
//require_once "model.php";
require_once "general.php";

class Admin extends Model{
	public static $_table = 'admin';
	protected static $class = 'Admin';
	
	protected function getId(){
		return $this->_orm->id;
	}

	public function getUsername(){
		return $this->_orm->username;
	}

	protected function getProfile(){
		//self::configure();
		$profile = ORM::for_table('profiles')->where('user_id',$this->id)->find_one();
		if($profile){
			return new Profile($profile);
		}
		$profile = new Profile();
		$profile->user_id = $this->id;
		return $profile;
	}
	
	public function setPassword($value){
		$pass = md5($value);
		$this->_orm->password = $pass;
		
	}
	
	public function setUsername($value){
		$this->_orm->username = $value;
		
	}
	
	public function validate($password){
		if($this->_orm->password == md5($password)){
			return true;
		}
		return false;
	}
	
	public static function findByUsername($username){
		//self::configure();
		$user = ORM::for_table(static::$_table)->where('username', $username)->find_one();
		if($user){
			return new User($user);
		}
		return null;
		
	}
	
	public static function validateUserPass($username, $password){
		//self::configure();
		$user = ORM::for_table(static::$_table)->where('username',$username)->find_one();
		if ($user->password == md5($password)){
			return true;
		}
		return false;
	}
	
}

?>
