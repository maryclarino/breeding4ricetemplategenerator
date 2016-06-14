<?php 
	//MODEL FOR SAVE TEMPLATE FUNCTION
	
	namespace app\models;
	use yii\base\Model;
	use yii\db\Query;
	use Yii;
	use yii\db\Command;
	use yii\db\Connection;
class savetemplate extends Model{
	public function add_data($session){	//function for updating or adding new custom template
		$connection = new \yii\db\Connection([
		 'dsn' => 'pgsql:host=localhost;port=5432;dbname=users',
		'username' => 'postgres',
		'password' => 'admin',
		]);
		$connection->open();
		
		$temp = array(
			'username' => $session['username'],
			
			'canvas_height'=>$session['height_canvas'],'canvas_width'=>$session['width_canvas'],
			
			'textfield_num'=>$session['textfield_num'], 
			'textfield_h'=>$session['textfield_height'],
			'textfield_w'=> $session['textfield_width'],
			'attribute_textfield'=>$session['attribute_textfield'],
			'textfield_x' => $session['tf_x'],
			'textfield_y' =>$session['tf_y'],
			
			'img_num'=>$session['upload_cnt_custom'],
			'img_h'=>$session['image_height'], 
			'img_w'=>$session['image_width'],
			'img_x' =>$session['img_x'] ,
			'img_y' =>$session['img_y'],
			'img_name'=>$session['upload_image_custom'],
			
			'qrcode_h'=>$session['height_qrcode'], 
			'qrcode_w'=>$session['width_qrcode'],
			'qrcode_x' =>$session['qr_x'],
			'qrcode_y' =>$session['qr_y'],			
			'qrcode_text'=>$session['text_qrcode'],
			'qrcode_attrib'=>$session['text_attrib_qrcode'],
		
			'barcode_text'=>$session['text_barcode'],
			'barcode_x' =>$session['bar_x'],
			'barcode_y' =>$session['bar_y'],
			'barcode_num'=>$session['custom_barcode_num'], 
			'barcode_attrib'=>$session['text_attrib_barcode'],
			'barcode_h'=>$session['height_barcode'],  
			'barcode_w'=>$session['width_barcode'],
			
			'font_size'=>$session['font_size'],  
			'font_family'=>$session['font_family'],
			
			
			
			
			
		);
		
		$username = $connection->createCommand('SELECT username FROM custom_template')->queryColumn();
		
		$bool = true;
		foreach($username as $user){
			if($user == $session['username']){
				$bool = false;					//old template
				break;
			}
		}
	if($bool == true){
		//IF NEW TEMPLATE
		$connection->createCommand()->insert('custom_template', $temp)->execute();
	}else{
		//UPDATE IF TEMPLATE IS IN DB
		$connection->createCommand()->update('custom_template', $temp, 'username=:username',array(':username'=>$session['username']))->execute();
	}
		
		return TRUE;
	}//end of function
	
	public function check_user($username,$session){					//function that checks duplicates
	
		$connection = new \yii\db\Connection([
		 'dsn' => 'pgsql:host=localhost;port=5432;dbname=users',
		'username' => 'postgres',
		'password' => 'admin',
		]);
		$connection->open();
		$command = $connection->createCommand();
		
		$username = $connection->createCommand('SELECT username FROM custom_template')->queryColumn();
		
		$bool = true;
		foreach($username as $user){
			if($user == $session['username']){
				
				$bool = false;												//old 
				break;	
					
			}
		}
		return $bool;
		
		
	}
	
	public function retrieve_data($username){								//function for loading the page
		
		$connection = new \yii\db\Connection([
		 'dsn' => 'pgsql:host=localhost;port=5432;dbname=users',
		'username' => 'postgres',
		'password' => 'admin',
		]);
		$connection->open();
		$command = $connection->createCommand();
		
		$command = $connection->createCommand('SELECT * FROM custom_template WHERE username=:username');
		$command->bindValue(':username', $username);
		$user_data = $command->queryAll();
		
		return $user_data[0];
		
	}
	
	public function del_data($username){
		$connection = new \yii\db\Connection([
		 'dsn' => 'pgsql:host=localhost;port=5432;dbname=users',
		'username' => 'postgres',
		'password' => 'admin',
		]);
		$connection->open();
		
		//find in custom_template
		$command = $connection->createCommand('SELECT * FROM custom_template WHERE username=:username'); 
		$command->bindValue(':username', $username);
		$user_data = $command->queryAll();
		
		//delete in custom_template 
		$connection->createCommand()->delete('custom_template', 'username=:username', array(':username'=>$username))->execute();
	}
}//end of class 