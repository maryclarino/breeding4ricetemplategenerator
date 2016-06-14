<?php 
//MODEL FOR SIGNUP

namespace app\models;
use yii\base\Model;
use yii\db\Query; 

class UserSignup extends Model{
	public $username,$password,$repassword,$fname,$mname,$lname,$email,$num;
	
	public function rules(){
		return [
				[['username','password','repassword','fname','mname','lname','email','num'],'required'],
				['email','email'],
				];
	}//end of rules function
	
	public function find_user($uname,$pass){
		$all = Signup::find()->all();
		foreach($all as $indiv){
			if($indiv['username'] == $uname && $indiv['password'] == $pass){
				return TRUE;
			}
		}
		return FALSE;
	}//end of add user function
	
}//end of class'