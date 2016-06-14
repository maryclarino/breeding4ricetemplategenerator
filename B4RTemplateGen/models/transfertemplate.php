<?php 
	namespace app\models;
	use yii\base\Model;
	use yii\db\Query;
	use Yii;
	use yii\db\Command;
	use yii\db\Connection;
class transfertemplate extends Model{
	public function transfer($username){																//function for transferring from custom to defined
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
		
		//copy in def_template
		$connection->createCommand()->insert('def_template', $user_data[0])->execute();
		
		//delete in custom_template 
		$connection->createCommand()->delete('custom_template', 'username=:username', array(':username'=>$username))->execute();
	}//end of function
	
	public function getCount($tablename){															//function to get the current number of defined layouts
		$connection = new \yii\db\Connection([
		 'dsn' => 'pgsql:host=localhost;port=5432;dbname=users',
		'username' => 'postgres',
		'password' => 'admin',
		]);
		$connection->open();
		
		//find in custom_template
		return($connection->createCommand('SELECT COUNT(*) FROM '.$tablename.'')->queryAll());
		
	}//end of function
	
	public function getRow($row_num){																//function for getting the row of the defined layout
		$connection = new \yii\db\Connection([
		 'dsn' => 'pgsql:host=localhost;port=5432;dbname=users',
		'username' => 'postgres',
		'password' => 'admin',
		]);
		$connection->open();
		
	
		$command =$connection->createCommand(' SELECT * FROM (
		  SELECT
			ROW_NUMBER() OVER () AS rownumber,template_id
			FROM def_template
			) AS foo
			WHERE rownumber ='.$row_num.'')->queryAll();
			
		return($command[0]['template_id']);
		
	}
	
	public function getData($template_id){
		$connection = new \yii\db\Connection([
		 'dsn' => 'pgsql:host=localhost;port=5432;dbname=users',
		'username' => 'postgres',
		'password' => 'admin',
		]);
		$connection->open();
		
		return($connection->createCommand('SELECT * FROM def_template WHERE template_id ='.$template_id.'')->queryAll()[0]);
	
	}
}