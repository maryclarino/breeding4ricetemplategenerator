<?php
//CONTROLLER FOR ALL OF THE PAGES

namespace app\controllers;																//additional libraries.start()
use Yii;
use yii\filters\AccessControl;	
use yii\web\Controller;
use yii\web\Session;
use mPDF;
use QRcode;
use PDFBarcode;	
use yii\web\UploadedFile;
use yii\helpers\FileHelper ;
use yii\base\InvalidConfigException;
																		
use app\models\User_Login;																//model libraries.
use app\models\UploadForm;
use app\models\UploadFormCSV;
use app\models\LoginForm;
use app\models\UserSignup;
use app\models\Users;
use app\models\Signup;
use app\models\savetemplate;
use app\models\transfertemplate;

use yii\jui\Draggable;
use yii\helpers\Html;
class UsersController extends Controller{
	public function actionIndex(){														//INDEX goes to home page
		//Yii::$app->session->username = 'MARY';
		$model = new UserSignup();
		return $this->render('home', ['model'=>$model]);
	}//end of actionIndex 
	
	public function actionProcesslogin(){												//process login data
		$session = Yii::$app->session;
		$uname = $_GET['username'];															//get input
		$pass = $_GET['password'];
		$model = new UserSignup();
		$users = $model->find_user($uname,MD5($pass));
		
		if($users == TRUE){																	//successful logging in
			$session['username'] = $uname;
			return $this->redirect('defined');
		}
		else{																				//log-in error: return to home
			return $this->render('home', []);
		}
			
	}//end of actionProcesslogin
	

	public function actionSignup(){															//SIGN UP function
		$model = new UserSignup();
		$post = Yii::$app->request->post();
		
		if($model->load($post) && $model->validate() && ($post['UserSignup']['password'] == $post['UserSignup']['repassword']) ){
			Yii::$app->session->setFlash('success', 'You have entered the data correctly');
			$info = new signup();
			$info->username = $post['UserSignup']['username'];
			$info->password = MD5($post['UserSignup']['password']);
			$info->fname = $post['UserSignup']['fname'];
			$info->mname = $post['UserSignup']['mname'];
			$info->lname = $post['UserSignup']['lname'];
			$info->eadd = $post['UserSignup']['email'];
			$info->contact_num = $post['UserSignup']['num'];
			$info->save();
		
			return $this->render('userSignUp', ['model'=>$model]);
		}
		else if($model->load($post) && ($post['UserSignup']['password'] != $post['UserSignup']['repassword'])){
			Yii::$app->session->setFlash('error', 'Password and Re-enter password are not the same.');
			return $this->render('userSignUp', ['model'=>$model]);
		}	
		else if($model->load($post) && (strlen($post['UserSignup']['password']) <6)){
			Yii::$app->session->setFlash('error', 'Password must be greater than or equal to 6.');
			return $this->render('userSignUp', ['model'=>$model]);
		}	
			
		else{
			return $this->render('userSignUp', ['model'=>$model]);
		}
	}//end of user sign up
	
	public function actionViewupload(){
		$model = new UploadForm();
		return $this->render('upload', ['model'=>$model]);
	}
	
																										//UPLOAD IMAGE//
	public function actionUpload()
    {
		$session = Yii::$app->session;
        $model = new UploadForm();
	
        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
			$model->imageFile->saveAs('uploads/' . $model->imageFile->baseName . '.' . $model->imageFile->extension);
			$model->save();
			// file is uploaded successfully
            if ($model->upload()) {
				$file_name = $model->imageFile->baseName;
				if($session['upload_cnt'] == 0){				//first image
					$session['upload_image'] = $file_name.'.'.$model->imageFile->extension;
				}
				else{ //concat previous filenames and the new filename + extension
				$session['upload_image']=$session['upload_image'].','.$file_name.'.'.$model->imageFile->extension; 
				}
				$session['upload_cnt'] = $session['upload_cnt']+1;
				
				return $this->render('alertUpload', ['model'=>$model,'data'=>$session['upload_image']]);
			}
        }
	}//end of function
	
																									//UPLOAD CSV FILE FOR DEFINED LABELS//
	public function actionUploadcsv()
    	{
		$session = Yii::$app->session;
        $model = new UploadFormCSV();
	
        if (Yii::$app->request->isPost) {
            $model->csvFile = UploadedFile::getInstance($model, 'csvFile');
			$model->csvFile->saveAs('uploadscsv/' . $model->csvFile->baseName . '.' . $model->csvFile->extension);
			$model->save();
			// file is uploaded successfully
            if ($model->upload()) {
				$session['csv_num']=1;
				$session['csv']=$model->csvFile->baseName . '.' . $model->csvFile->extension;
				
				return $this->render('CsvInput', ['model'=>$model]);
			}
        }
	}//end of function
	
																									//UPLOAD CSV FILE FOR DEFINED TEMPLATE//
	public function actionUploadcsvcustom()
    	{
		$session = Yii::$app->session;
        	$model = new UploadFormCSV();
	
        if (Yii::$app->request->isPost) {
            $model->csvFile = UploadedFile::getInstance($model, 'csvFile');
			$model->csvFile->saveAs('uploadscsv/' . $model->csvFile->baseName . '.' . $model->csvFile->extension);
			$model->save();
			// file is uploaded successfully
            if ($model->upload()) {
				$session['csv_num']=1;
				$session['csv']=$model->csvFile->baseName . '.' . $model->csvFile->extension;
				
				return $this->redirect('uploadsuccess');
			}
        }
	}//end of function
	
																									//UPLOADED CSV WILL BE GENERATED AS PDF
	public function actionUploadsuccess(){
		$session = Yii::$app->session;
		$model = new transfertemplate();
		$count = $model->getCount('def_template');								//get current count of defined templates
		$temp_id = $model->getRow($session['choice']);							//get template id
		$res = $model->getData($temp_id);
		
        $file = fopen('uploadscsv/'.$session['csv'],"r"); 						//open and read file
		
		$temp = '';
		$head = fgetcsv($file);
		$array_num = count($head);
		$row = $array_num;
		$temp = 1;
		$user_data2 = array();
		$attrib_array = explode(',',$res['attribute_textfield']);
		if($res['textfield_num'] == $array_num){
			$cnt = 0;
			while($cnt!= $array_num){											//checks the headers of the csv and textfields of the label
				if($attrib_array[$cnt]== $head[$cnt]){							//NOT EQUAL: headers of csv and the textfields
					$file = fopen('uploadscsv/'.$session['csv'],"r");
					$temp = '';
					while(!feof($file)){
						$array = fgetcsv($file);
						$temp = $temp.",".$array[$cnt];
						$user_data2[$attrib_array[$cnt]] = $temp;
						
					}
					
				}
				$cnt++;
			}
			$session['csv_array_num'] = $array_num;
			$session['csv_user_data'] = $user_data2;
		}
		return $this->redirect('loadtransfer');
	}
	
																								//Resets the $session['csv_num'] to be able to use the Manual input
	public function actionResetcsv(){
		$session = Yii::$app->session;
		$session['csv_num']=0;
		return $this->redirect('loadtransfer');
	}
																								//Access Defined Templates Page
	public function actionDefined(){
		$model = new transfertemplate();
	
		$count = $model->getCount('def_template');
		$model2 = new UploadFormCSV();
												//RESET VALUES IN SESSION
		$session['def_layout_num'] = 0;
		$session['barcode_num'] =0;				//number of csv
		$session['text_barcode'] = '';			//number of 
		$session['csv_num'] =0;					//number of csv
		$session['text_num'] =0;				//number of texts
		$session['qrcode_num']=0;				//number of qrcodes
		$session['upload_cnt']=0;				//number or images
		$session['upload_image'] =''; 			//filename of image
		$session['csv'] ='';					//filename of csv
		$session['text_qrcode'] ='';			//text of qrcode 
		$session['text_data'] ='';
		
		return $this->render('userForm',['model'=>$model2,
		'count'=>$count[0]['count'], 
		'height_canvas'=>0,'width_canvas'=>0,
		
		'height_textfield'=>0,'textfield_num'=>0, 'width_textfield'=> 0,'attribute_textfield'=>'',
		
		'upload_cnt_custom'=>0,'upload_image_custom'=>0,'image_width'=>0,'image_height'=>0, 
		
		'text_qrcode'=>0,'height_qrcode'=>0, 'width_qrcode'=>0, 'custom_qrcode_num'=>0,'text_attrib_qrcode'=>'',
		
		'text_barcode'=>'','height_barcode'=>0, 'width_barcode'=>0, 'custom_barcode_num'=>0, 'text_attrib_barcode'=>'',
		
		'qrcode_x' => 0,
		'qrcode_y' => 0,
		'barcode_x' =>  0,
		'barcode_y' =>  0,
		'tf_x' =>  0,
		'tf_y' => 0,
		'img_x' => 0,
		'img_y' =>  0,
		]);
	}
	
	public function actionUser(){
		return $this->render('userForm',[]);
	}//end of function
	
																					//FIRST LAYOUT: Access Field Label 
	public function actionSelect1(){
		 $session = Yii::$app->session;
		 $session['label'] = 1;
		 $session['csv_num'] = 0;
		 return $this->render('userForm1',[]);
	}
	
																					//SECOND LAYOUT: Access Harvest Label
	public function actionSelect2(){
		 $session = Yii::$app->session;
		 $session['label'] = 2;
		 $session['csv_num'] = 0;
		 return $this->render('userForm2',[]);
	}
	
																					//THIRD LAYOUT: : Access Shelf Label
	public function actionSelect3(){
		 $session = Yii::$app->session;
		 $session['label'] = 3;
		 $session['csv_num'] = 0;
		 return $this->render('userForm3',[]);
	}
	
																					//FOURTH LAYOUT: Access Tray Label
	public function actionSelect4(){
		 $session = Yii::$app->session;
		 $session['label'] = 4;
		 $session['csv_num'] = 0;
		 return $this->render('userForm4',[]);
	}
	
																					//get user_input: FIELD LABEL
	public function actionUser_input(){
																							//formatting
		$data = 
		'<html>
			<head>
				<style>
					#all{
						height: 100px;
						width: 280px;
						margin-top:5px;
						background: url("img\labels\FieldLabel4.png");
						background-repeat: no-repeat;
						float:left;
					}
					
					
					#user_data{
						margin-top: 100px;
						margin-left: 10px;
						display:inline-block;
						height: 100px;
						width: 100px;
						float:left;
						font-size: 10px;
					}
					#qrcode{
						position: absolute;
						height: 100px;
						width: 50px;
						margin-left: 80px;
						margin-top: 100px;
						position: center;
						float: left;
						
					}

				</style>
			</head>
			
			<body>';
		$session = Yii::$app->session;
		if($session['csv_num']==1){
				$data2 = '';
				$file = fopen('uploadscsv/'.$session['csv'],"r"); 							//open and read file for csv file
				
					while(! feof($file))
					{	
						
						$user_data = '';
						$array = fgetcsv($file);
						$array_num = count($array);
						for($cnt=0; $cnt<$array_num; $cnt++){
							$user_data = $user_data."<br>".$array[$cnt];
							$qrcode_text = $user_data.', ';
						}//end of for loop
						
						$qrcode = '<br><barcode code="'.$qrcode_text.'" type="QR" class="barcode" size="0.5" error="M" style = "margin-top:-5px;" />';
						$data2 = $data2.
							'<div id = "all">
								<div id = "qrcode">'.$qrcode.'
								</div>
								<div id = "user_data"><b>'.$user_data.'</b>
								</div>
							</div>';
						
					}//end of while loop (end of file)
					fclose($file);
			}
		else{
																							//TEXT or manual input
		$user_data = "<br><b>".$_GET['year']."<br>".$_GET['source']."<br>".$_GET['plot_number']."<br>".$_GET['current_gen']."</textarea></b>";
		$qrcode_text = 'Year:'.$_GET['year'].' Source:'.$_GET['source'].' Plot number:'.$_GET['plot_number'].' Current Generation:'.$_GET['current_gen'];
		//QR CODE
		$qrcode = '<br><barcode code="'.$qrcode_text.'" type="QR" class="barcode" size="0.5" error="M" />';
		//formatting
			$data2='';
			$cnt=0;
			$num_cop = $_GET['num_cop'];
			if($num_cop == ''){
				$num_cop = 1;
			}
			while($cnt!=$num_cop){
			
				$data2 = $data2.'<div id = "all">
						<div id = "qrcode">
							'.$qrcode.'
						</div>
						<div id = "user_data">
							'.$user_data.'
						</div>
					</div>';
					$cnt++;
			}
		}
			$data2 = $data2.'				
			</body>
		</html>';
	
		//generate pdf
		$mpdf = new mPDF();
		$mpdf->WriteHTML($data.$data2);
		$mpdf->Output('fieldlabel.pdf', 'D');
	}
	
	//get user_input: HARVEST LABEL
	public function actionUser_secondinput(){
		
		//formatting
		$data = 
		'<html>
			<head>
				<style>
					#all{
						height: 150px;
						width: 280px;
						background: url("img\labels\harvestlabels4.png");
						background-repeat: no-repeat;
						margin-left:-20px;
						float:left;
					}
					
					#user_data{
						margin-top: 20px;
						white-space: pre;
						margin-left: 20px;
						display:inline-block;
						height: 80px;
						width: 100px;
						float:left;
						font-size: 10px;
						
					}
					#qrcode{
						position: absolute;
						height: 100px;
						width: 50px;
						margin-left: 10px;
						margin-top: 200px;
						position: center;
						float: left;
						font-size: 10px;
					
					}

				</style>
			</head>
			
			<body>';
			$trayno;
			$session = Yii::$app->session;
			if($session['csv_num']==1){
				$data2 = '';
				$file = fopen('uploadscsv/'.$session['csv'],"r"); //open and read file
				
					while(! feof($file))
					{	
						
						$user_data = '';
						$array = fgetcsv($file);
						$array_num = count($array);
						for($cnt=0; $cnt<$array_num; $cnt++){
							if($cnt == $array_num-1){
								$trayno = $array[$cnt];
							}
							else{
							$user_data = $user_data."<br>".$array[$cnt];
							$qrcode_text = $user_data.', ';
							}
							
						}//end of for loop
						$qrcode_text = $qrcode_text.$trayno;
						$qrcode = '<barcode code="'.$qrcode_text.'" type="QR" class="barcode" size="0.6" error="M" style = "margin-top:-5px;" />';
						$data2 = $data2.
							'<div id = "all">
								<div id = "qrcode"><br><br><br>'.$qrcode.'
								<b>'.$trayno.'<b>
								</div>
								<div id = "user_data"><br><br><b>'.$user_data.'</b>
								</div>
							</div>';
						
					}//end of while loop (end of file)
					fclose($file);
			}
			else{
					$user_data = "<br><br><br><b>".$_GET['designation']."<br>".$_GET['current_gen']."<br>".$_GET['source']."<br></b>";
					$trayno = "<b>".$_GET['tray_number']."</b>";
					$qrcode_text = 'Designation:'.$_GET['designation'].' Current Generation:'.$_GET['current_gen'].' Source:'.$_GET['source'].' Tray Number:'.$trayno;
					
					//generate qr code
					$qrcode = '<br><br><br><barcode code="'.$qrcode_text.'" type="QR" class="barcode" size="0.6" error="M" />';
					$data2='';
					$cnt = 0;
					$num_cop = $_GET['num_cop'];
					if($num_cop == ''){
						$num_cop = 1;
					}
					while($cnt!=$num_cop){
						$data2=$data2.'
								<div id = "all">
										<div id = "qrcode">
											'.$qrcode.'
											'.$trayno.'
											
										</div>
										<div id = "user_data">
											'.$user_data.'
										</div>
								</div>';
						$cnt++;
					}
			}
			$data2 = $data2.
			'</body>
		</html>';
		
		$mpdf = new mPDF();
		$mpdf->WriteHTML($data.$data2);
		$mpdf->Output('harvestlabel.pdf', 'D');
	}
	
	//get user_input: SHELF LABEL
	public function actionUser_thirdinput()
	{
		$data = 
		'<html>
			<head>
				<style>
					#all{
						margin-top: -100px;
						height: 580px;
						width: 380px;
						background: url("img\labels\shelflabels4.png");
						background-repeat: no-repeat;
					}
					
					#user_data{
						margin-left:70px;
						white-space: pre;
						display:inline-block;
						height: 200px;
						width: 384px;
						float:left;
						font-size: 60px;
						
					}
					#qrcode{
						
						height: 10px;
						width: 50px;
						float:left;
						margin-left:150px;
					}

				</style>
			</head>
			
			<body>';
			$session = Yii::$app->session;
			if($session['csv_num']==1){
				$data2 = '';
				$file = fopen('uploadscsv/'.$session['csv'],"r"); //open and read file
					while(! feof($file))
					{	$user_data = '';
					
						$array = fgetcsv($file);
						$array_num = count($array);
						for($cnt=0; $cnt<$array_num; $cnt++){
							$user_data = $user_data.$array[$cnt];
						}//end of for loop
						
						$qrcode = '<br><barcode code="'.$user_data.'" type="QR" class="barcode" size="0.8" error="M" style = "margin-top:-5px;" />';
						$data2 = $data2.
							'<div id = "all">
								<div id = "user_data"><br><b>'.$user_data.'</b>
								</div>
								<div id = "qrcode"><br><br><br>'.$qrcode.'
								</div>
							</div>';
					}//end of while loop (end of file)
					fclose($file);
			}else
			{
				$user_data = "<br><b>".$_GET['input']."</b>";
				$qrcode_text = $_GET['input'];
				//generate qr code
				$qrcode = '<barcode code="'.$qrcode_text.'" type="QR" class="barcode" size="0.8" error="M" style="margin-top:70px;"/>';
				//formatting
						
				$data2 = '';
				$cnt = 0;
				$num_cop = $_GET['num_cop'];
					if( $num_cop == ''){
						$num_cop =1;
					}
				while($cnt!=$num_cop){
					$data2 = $data2.'
						<div id = "all">
								<div id = "user_data">
									'.$user_data.'
								</div>
								<div id = "qrcode">
									'.$qrcode.'
								</div>
							
						</div>';
						$cnt++;
				}
		}
		$data2=$data2.			
			'</body>
		</html>';
		
		$mpdf = new mPDF();
		$mpdf->WriteHTML($data.$data2);
		$mpdf->Output('shelflabel.pdf', 'D');
	}
	
	//get user_input: TRAY LABEL
	public function actionUser_fourthinput()
	{
		$session = Yii::$app->session;
		
		//formatting
		$data = 
		'<html>
			<head>
				<style>
					#over_all{
						width: 100%;
						height: 100%;
					}
					#all{
						height: 100px;
						width: 280px;
						margin-top:5px;
						background: url("img\labels\traylabels4.png");
						background-repeat: no-repeat;
						float: left;
						border:-10px solid transparent;
					}
					
					
					#user_data{
						width: 120px;
						height: 30px;
						margin-left: 40px;
						margin-top:0px;
						position: center;
						float: left;
						font-size: 30px;
						overflow:hidden;
					}
					#qrcode{
						width: 150px;
						height: 40px;
						overflow:hidden;
						width: 80px;
						margin-left:40px;
						position: center;
						float: left;
					}
				</style>
			</head>
			<body>
				<div id = "over_all">';
		
		if($session['csv_num'] == 1){
				$data2 = '';
				$file = fopen('uploadscsv/'.$session['csv'],"r"); //open and read file
					while(! feof($file))
					{	$user_data = '';
					
						$array = fgetcsv($file);
						$array_num = count($array);
						for($cnt=0; $cnt<$array_num; $cnt++){
							$user_data = $user_data.$array[$cnt];
						}//end of for loop
						
						$qrcode = '<br><barcode code="'.$user_data.'" type="QR" class="barcode" size="0.6" error="M" style = "margin-top:-5px;" />';
						$data2 = $data2.
							'<div id = "all">
								<div id = "user_data"><b>'.$user_data.'</b>
								</div>
								<div id = "qrcode">'.$qrcode.'
								</div>
							</div>';
					}//end of while loop (end of file)
					fclose($file);
		}else{
		//user-input
		$user_data = "<b>".$_GET['input']."</b>";
		$qrcode_text = $_GET['input'];
		//generate qr code
		$qrcode = '<br><barcode code="'.$qrcode_text.'" type="QR" class="barcode" size="0.6" error="M" style = "margin-top:-5px;" />';
		
		
			$data2 = '';
			$cnt=0;
			$num_cop = $_GET['num_cop'];
			if( $num_cop == ''){
				$num_cop =1;
			}
			while($cnt!=$num_cop){
				$data2 = $data2.
							'<div id = "all">
							<div id = "user_data">'.$user_data.'
							</div>
							<div id = "qrcode">'.$qrcode.'
							</div>
							</div>';
				$cnt++;
			}	

		}
		$data2 =$data2.'
			</body>
		</html>';
		
		$mpdf = new mPDF();
		$mpdf->WriteHTML($data.$data2);
		$mpdf->Output('traylabel.pdf', 'D');
		
	}//end of function

	//EDITOR: VIEW BAR CODE POP-UP
	public function actionViewbarcodepopup(){
		return $this->render('AddBarCodePopUp', []);
	}//end of function
	
	
	//FETCH TEXT FROM ADD TEXT POP-UP
	public function actionAddtext(){
		$session = Yii::$app->session;
		if($session['text_num'] == 0){								//first text
			$session['text_data']  = $_GET['addtext'];
		}
		else{
			$session['text_data']  = $session['text_data'].','.$_GET['addtext']; 	//concat the texts with space as delimiter
		
		}
		$session['text_num'] = $session['text_num']+1;							//count the number of texts
		return $this->redirect('viewcustom');
	}//end of function
	
	
	public function actionAddqrcode()
	{
		$session = Yii::$app->session;
		if($session['qrcode_num'] == 0){
			$session['text_qrcode']  = $_GET['text_qrcode']; 	//text for qrcode;
		}
		else{
			$session['text_qrcode']  = $session['text_qrcode'].','.$_GET['text_qrcode'];
		}
		$session['qrcode_num'] = $session['qrcode_num']+1; 						//marker
		return $this->redirect('viewcustom');			//alert window
	}//end of function
	
	public function actionAddbarcode(){
		$session = Yii::$app->session;
		if($session['barcode_num'] == 0){
			$session['text_barcode']  = $_GET['text_barcode']; 	//text for qrcode;
		}
		else{
			$session['text_barcode']  = $session['text_barcode'].','.$_GET['text_barcode'];
		}
		$session['barcode_num'] = $session['barcode_num']+1; 						//marker
		return $this->render('alertBarCode', []);			//alert window
		
	}
																		//ACCESS EDITOR PAGE
	public function actionViewcustom()
	{
			$session = Yii::$app->session;
			$def_layout='';
			if($session['def_layout_num']==1){
				//field label
				if($session['def_layout']==1){
					$def_layout = 'FieldLabel5.png';
				}
				//harvest label
				else if($session['def_layout']==2){
					$def_layout = 'harvestlabels5.png';
				}
				//shelf label
				else if($session['def_layout']==3){
					$def_layout = 'shelflabels4.png';
				}
				//tray label
				else if($session['def_layout']==4){
					$def_layout = 'traylabels4.png';
				}
			}
			else{
				$def_layout = '';
			}
			
			$model = new UploadForm();					//model for upload
			
			return $this->render('userFormCustom', 
			[
			'model' =>$model,
			'def_layout_num'=> $session['def_layout_num'],
			'def_layout' => $def_layout,
			'barcode_num'=>$session['barcode_num'],						//number of csv
			'text_barcode'=>$session['text_barcode'], 					//number of 
			'csv_num'=>$session['csv_num'],						//number of csv
			'text_num'=>$session['text_num'], 					//number of texts
			'qrcode_num'=>$session['qrcode_num'], 				//number of qrcodes
			'upload_num'=>$session['upload_cnt'], 				//number or images
			'upload_image'=>$session['upload_image'], 			//filename of image
			'csv'=>$session['csv'],								//filename of csv
			'text_qrcode'=>$session['text_qrcode'],				//text of qrcode 
			'text' => $session['text_data'],					//texts
			]);
			
	}
	
	public function actionViewcsv(){											//CSV POP-UP WINDOW
		$model = new UploadFormCSV();
		return $this->render('CSVPopup', ['model'=>$model]);
	} 
	
	public function actionLayoutchoice1(){										//sets the choice for editor page
		$session = Yii::$app->session;
		$session['layout'] = 1;
	}
	public function actionLayoutchoice2(){
		$session = Yii::$app->session;
		$session['layout'] = 2;
	}
	public function actionLayoutchoice3(){
		$session = Yii::$app->session;
		$session['layout'] = 3;
	}
	public function actionLayoutchoice4(){
		$session = Yii::$app->session;
		$session['layout'] = 4;
	}
	
	public function actionDeflayoutchoice1(){
		$session = Yii::$app->session;
		$session['def_layout'] = 1;
		$session['def_layout_num'] = 1;
		return $this->redirect('viewcustom');
		
	}
	public function actionDeflayoutchoice2(){
		$session = Yii::$app->session;
		$session['def_layout'] = 2;
		$session['def_layout_num'] = 1;
		return $this->redirect('viewcustom');
	}
	public function actionDeflayoutchoice3(){
		$session = Yii::$app->session;
		$session['def_layout'] = 3;
		$session['def_layout_num'] = 1;
		return $this->redirect('viewcustom');
	}
	public function actionDeflayoutchoice4(){
		$session = Yii::$app->session;
		$session['def_layout'] = 4;
		$session['def_layout_num'] = 1;
		return $this->redirect('viewcustom');
	}
//CUSTOM PAGE INITIAL
	public function actionReset(){
			$session = Yii::$app->session;								//load session
			$model = new savetemplate();
			$model->del_data($session['username']);
			
			$session['width_canvas'] = 300;								//canvas
			$session['height_canvas'] = 300;
			
			$session['textfield_num'] = 0;								//textfield
			$session['textfield_height'] = '';
			$session['textfield_width'] = '';
			$session['attribute_textfield'] = '';
			$session['tf_x'] = '0,';
			$session['tf_y'] = '0,';
			
			$session['upload_image_custom'] = '';						//image
			$session['upload_cnt_custom'] = 0;
			$session['image_height'] = '';
			$session['image_width'] = '';
			$session['img_x'] = 0;
			$session['img_y'] = 0;
			
			$session['text_qrcode'] = '';								//qrcode
			$session['text_attrib_qrcode'] = '';
			$session['height_qrcode'] = '';
			$session['width_qrcode'] = '';
			$session['custom_qrcode_num']= 0;
			$session['qr_x'] = 0;
			$session['qr_y'] = 0;
			
			$session['text_barcode'] = '';								//barcode
			$session['text_attrib_barcode'] = '';
			$session['height_barcode'] = '';
			$session['width_barcode'] = '';
			$session['custom_barcode_num']= 0;
			$session['bar_x'] = 0;
			$session['bar_y'] = 0;

			$session['font_size'] = '';
			$session['font_family'] = '';

			return $this->redirect('viewcustompage2');
		
	}



	public function actionCustom(){
		
		$session = Yii::$app->session;									//load session
		$model = new savetemplate();									//load model
		$result = $model->check_user($session['username'],$session);
		//return $this->render('try', ['user_data'=>$result]);
		
		if($result == true){											//new template:RESET ALL ELEMENTS	
			return $this->redirect('reset');
		}
		else{															//previous template
			//retrieve data from database
			$user_data = $model->retrieve_data($session['username']);
			$session = Yii::$app->session;
		
			
			$session['height_canvas'] = $user_data['canvas_height'];
			$session['width_canvas'] = $user_data['canvas_width'];
		
			$session['textfield_height'] =  $user_data['textfield_h'];
			$session['textfield_num'] =  $user_data['textfield_num'];
			$session['textfield_width'] =  $user_data['textfield_w'];
			$session['attribute_textfield'] =  $user_data['attribute_textfield'];
		
			$session['upload_cnt_custom'] =  $user_data['img_num'];
			$session['upload_image_custom'] =  $user_data['img_name'];
			$session['image_width'] =  $user_data['img_w'];
			$session['image_height'] = $user_data['img_h'];
		
			$session['text_qrcode'] =  $user_data['qrcode_text'];
			$session['height_qrcode'] =  $user_data['qrcode_h'];
			$session['width_qrcode'] =  $user_data['qrcode_w'];
			if($session['width_qrcode']!=''){
				$session['custom_qrcode_num'] = 1;
			}else{
				$session['custom_qrcode_num'] = 0;
			
			}			
			$session['text_attrib_qrcode'] =  $user_data['qrcode_attrib'];
		
			$session['text_barcode'] =  $user_data['barcode_text'];
			$session['height_barcode']=  $user_data['barcode_h'];
			$session['width_barcode'] =  $user_data['barcode_w'];
			$session['custom_barcode_num']=  $user_data['barcode_num'];
			$session['text_attrib_barcode']= $user_data['barcode_text'];
			
			$session['qr_x'] =  $user_data['qrcode_x'];
			$session['qr_y'] =  $user_data['qrcode_y'];
			$session['bar_x'] = $user_data['barcode_x'];
			$session['bar_y'] =  $user_data['barcode_y'];
			
			$session['tf_x'] = $user_data['textfield_x'];
			$session['tf_y'] =  $user_data['textfield_y'];
			
			$session['img_x'] = $user_data['img_x'];
			$session['img_y'] =  $user_data['img_y'];
		}
		return $this->redirect('viewcustompage2');
			
	}//end of actionCustom

//CUSTOM PAGE TEXTFIELD
	public function actionTextfielddetails(){
		$session = Yii::$app->session;
		$session['textfield_num'] = $session['textfield_num']+1;
		$mul=1;
		if($_GET['dim']=="in"){
			$mul = 72;
		}else if($_GET['dim']=="cm"){
			$mul= 28;
		}
		
		if($session['textfield_num']>1){
			$session['textfield_height'] = $session['textfield_height'].$_GET['height_textfield']*$mul.',';
			$session['textfield_width'] = $session['textfield_width'].$_GET['width_textfield']*$mul.',';
			$session['attribute_textfield'] = $session['attribute_textfield'].$_GET['attribute_textfield'].',';
			$session['font_size'] = $session['font_size'].$_GET['font_size'].',';
			$session['font_family'] = $session['font_family'].$_GET['font_family'].',';
		}
		else if($session['textfield_num']==1){
			$session['textfield_height'] = $_GET['height_textfield']*$mul.',';
			$session['textfield_width'] = $_GET['width_textfield']*$mul.',';
			$session['attribute_textfield']=$_GET['attribute_textfield'].',';
			$session['font_size'] = $_GET['font_size'].',';
			$session['font_family'] = $_GET['font_family'].',';
		}
		
		return $this->redirect('viewcustompage2');
	}

//CUSTOM PAGE UPLOAD IMAGE

	public function actionCustomuploadimage(){
		$session = Yii::$app->session;
        $model = new UploadForm();
		
		if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
			$model->imageFile->saveAs('uploads/' . $model->imageFile->baseName . '.' . $model->imageFile->extension);
			$model->save();
			// file is uploaded successfully
            if ($model->upload()) {
				$session['temp_height'] =  50;
				$session['temp_width'] = 50;
				$file_name = $model->imageFile->baseName;
				if($session['upload_cnt_custom'] == 0){				//first image
					$session['upload_image_custom'] = $file_name.'.'.$model->imageFile->extension;
				}
				else{ //concat previous filenames and the new filename + extension
				$session['upload_image_custom']=$session['upload_image_custom'].','.$file_name.'.'.$model->imageFile->extension; 
				}
				$session['upload_cnt_custom'] = $session['upload_cnt_custom']+1;
				
				if($session['upload_cnt_custom']>1){
					$session['image_height'] = $session['image_height'].','.$session['temp_height'];
					$session['image_width'] = $session['image_width'].','.$session['temp_width'];
				}
				else if($session['upload_cnt_custom']==1){
					$session['image_height'] = $session['temp_height'];
					$session['image_width'] = $session['temp_width'];
				}
				
			}
		}
		
		return $this->redirect('viewcustompage2');
     }
	
	
//ADD QRCODE
	 public function actionCustomaddqrcode(){
		$session = Yii::$app->session;
		$session['height_qrcode'] = 40;
		$session['width_qrcode'] = 40;
		$session['custom_qrcode_num'] = 1;
		$session['text_attrib_qrcode'] = '';
		
		if($session['textfield_num']>=1){
			$session['text_attrib_qrcode'] = $_GET['attrib_qrcode'];
			 $text_attrib='';
			foreach($session['text_attrib_qrcode'] as $a){
				$text_attrib=$a.','.$text_attrib;
			}
			$session['text_attrib_qrcode'] = $text_attrib;
		}
		
		$session['text_qrcode'] = $_GET['text_qrcode'];
			
		
		return $this->redirect('viewcustompage2');
	 }
//CUSTOM PAGE BARCODE	 

	public function actionCustomaddbarcode(){
		$session = Yii::$app->session;
		$session['height_barcode'] = 20;
		$session['width_barcode'] = 40;
		$session['custom_barcode_num'] = 1;
		$session['text_barcode'] = $_GET['text_barcode'];
		return $this->redirect('viewcustompage2');
		//return $this->render('try', ['model'=>$text_attrib]);
	}
	   
	 //WORKING AREA PAGE
	 public function actionViewcustompage2(){								
		$session = Yii::$app->session;
		$model = new UploadForm();
		
		return $this->render('custompage2',['model'=>$model,
		'height_canvas'=>$session['height_canvas'],'width_canvas'=>$session['width_canvas'],
		
		'height_textfield'=>$session['textfield_height'],'textfield_num'=>$session['textfield_num'], 'width_textfield'=> $session['textfield_width'],'attribute_textfield'=>$session['attribute_textfield'],
		
		'upload_cnt_custom'=>$session['upload_cnt_custom'],'upload_image_custom'=>$session['upload_image_custom'],'image_width'=>$session['image_width'],'image_height'=>$session['image_height'], 
		
		'text_qrcode'=>$session['text_qrcode'],'height_qrcode'=>$session['height_qrcode'], 'width_qrcode'=>$session['width_qrcode'], 'custom_qrcode_num'=>$session['custom_qrcode_num'],'text_attrib_qrcode'=>$session['text_attrib_qrcode'],
		
		'text_barcode'=>$session['text_barcode'],'height_barcode'=>$session['height_barcode'], 'width_barcode'=>$session['width_barcode'], 'custom_barcode_num'=>$session['custom_barcode_num'], 'text_attrib_barcode'=>$session['text_attrib_barcode'],
		
		'qrcode_x' => $session['qr_x'],
		'qrcode_y' => $session['qr_y'],
		'barcode_x' =>  $session['bar_x'],
		'barcode_y' =>  $session['bar_y'],
		'tf_x' =>  $session['tf_x'],
		'tf_y' =>  $session['tf_y'],
		'img_x' =>  $session['img_x'],
		'img_y' =>  $session['img_y'],
		
		'font_size' => $session['font_size'],
		'font_family'=>  $session['font_family'],
		]);

	 }
	 
	 //SAVING THE TEMPLATE OF THE USER
	 public function actionSavetemplate(){
		$session = Yii::$app->session;
		
		$session['height_canvas'] = $_GET['can_h'];							//get canvas data
		$session['width_canvas'] = $_GET['can_w'];
		
		$session['height_qrcode'] = $_GET['qr_h'];							//get qrcode data
		$session['width_qrcode'] = $_GET['qr_w'];
		$session['qr_x'] = $_GET['qr_x'];
		$session['qr_y'] = $_GET['qr_y'];
		
		$session['height_barcode'] = $_GET['bar_h'];						//get barcode data
		$session['width_barcode'] = $_GET['bar_w'];
		$session['bar_x'] = $_GET['bar_x'];
		$session['bar_y'] = $_GET['bar_y'];
		
		$x='';
		$y='';
		$h = '';
		$w ='';
		$cnt=0;
		
		while($cnt!=$session['textfield_num']){
			$x = $x.$_GET['tf_'.$cnt.'_x'].',';
			$y = $y.$_GET['tf_'.$cnt.'_y'].',';
			$h = $h.$_GET['tf_h_'.$cnt.''].',';
			$w = $w.$_GET['tf_w_'.$cnt.''].',';
			
			$cnt++;
		}
		$session['tf_x'] = $x;											//get textfield data
		$session['tf_y'] = $y;
		$session['textfield_width'] = $w;
		$session['textfield_height'] = $h;
		
		$x='';
		$y='';
		$h = '';
		$w ='';
		$cnt=0;
		
		while($cnt!=$session['upload_cnt_custom']){
			$x = $x.$_GET['img_x_'.$cnt.''].',';
			$y = $y.$_GET['img_y_'.$cnt.''].',';
			$h = $h.$_GET['img_h_'.$cnt.''].',';
			$w = $w.$_GET['img_w_'.$cnt.''].',';
			
			$cnt++;
		}
		
		
		$session['img_x'] = $x;
		$session['img_y'] = $y;
		$session['image_height'] = $h;
		$session['image_width'] = $w;
	
		$model = new savetemplate();
		$model->add_data($session);
		
		return $this->redirect('viewcustompage2');
	 }
	 
	 public function actionTransfer(){
		$session = Yii::$app->session;
		$model = new transfertemplate();
		$user = $model->transfer($session['username']);
		$count = $model->getCount('def_template');
		$model2 = new UploadFormCSV();
		return $this->render('userForm',['model'=>$model2,
		'count'=>$count[0]['count'], 
		'height_canvas'=>0,'width_canvas'=>0,
		
		'height_textfield'=>0,'textfield_num'=>0, 'width_textfield'=> 0,'attribute_textfield'=>'',
		
		'upload_cnt_custom'=>0,'upload_image_custom'=>0,'image_width'=>0,'image_height'=>0, 
		
		'text_qrcode'=>0,'height_qrcode'=>0, 'width_qrcode'=>0, 'custom_qrcode_num'=>0,'text_attrib_qrcode'=>'',
		
		'text_barcode'=>'','height_barcode'=>0, 'width_barcode'=>0, 'custom_barcode_num'=>0, 'text_attrib_barcode'=>'',
		
		'qrcode_x' => 0,
		'qrcode_y' => 0,
		'barcode_x' =>  0,
		'barcode_y' =>  0,
		'tf_x' =>  0,
		'tf_y' => 0,
		'img_x' => 0,
		'img_y' =>  0,
		]);
	}
	 public function actionGetchoice(){
		$choice = $_GET['choice'];
		$session = Yii::$app->session;
		$session['choice'] = $choice;
		return $this->redirect('loadtransfer');
	 }
	 public function actionLoadtransfer(){
		
		$session = Yii::$app->session;
		
		$model = new transfertemplate();
		$count = $model->getCount('def_template');								//get current count of defined templates
		$temp_id = $model->getRow($session['choice']);											//get template id
		$res = $model->getData($temp_id);
		//return $this->render('try',['res'=>$res]);
		//return $this->render('userForm',['count'=>$count[0]['count']]);
		$qrcode_num= 0;
		if($res['qrcode_w']!=''){
				$qrcode_num = 1;
		}		
			
		$model2 = new UploadFormCSV();
		return $this->render('userForm',['model'=>$model2,
		'count'=>$count[0]['count'], 
		'height_canvas'=>$res['canvas_height'],'width_canvas'=>$res['canvas_width'],
		
		'height_textfield'=>$res['textfield_h'],'textfield_num'=>$res['textfield_num'], 'width_textfield'=> $res['textfield_w'],'attribute_textfield'=>$res['attribute_textfield'],
		
		'upload_cnt_custom'=>$res['img_num'],'upload_image_custom'=>$res['img_name'],'image_width'=>$res['img_w'],'image_height'=>$res['img_h'], 
		
		'text_qrcode'=>$res['qrcode_text'],'height_qrcode'=>$res['qrcode_h'], 'width_qrcode'=>$res['qrcode_w'], 'custom_qrcode_num'=>$qrcode_num,'text_attrib_qrcode'=>$res['qrcode_attrib'],
		
		'text_barcode'=>$res['barcode_text'],'height_barcode'=>$res['barcode_h'], 'width_barcode'=>$res['barcode_w'], 'custom_barcode_num'=>$res['barcode_num'], 'text_attrib_barcode'=>$res['barcode_text'],
		
		'qrcode_x' => $res['qrcode_x'],
		'qrcode_y' => $res['qrcode_y'],
		'barcode_x' =>  $res['barcode_x'],
		'barcode_y' =>  $res['barcode_y'],
		'tf_x' =>  $res['textfield_x'],
		'tf_y' =>  $res['textfield_y'],
		'img_x' =>  $res['img_x'],
		'img_y' =>  $res['img_y'],
		
		'font_size'=>$res['font_size'],
		'font_family'=>$res['font_family'],
		]);
	
	 }
	 
	 public function actionGenerate(){
		$session = Yii::$app->session;
		$model = new transfertemplate();
		$count = $model->getCount('def_template');								//get current count of defined templates
		$temp_id = $model->getRow($session['choice']);											//get template id
		$res = $model->getData($temp_id);
		//return $this->render('try',['res'=>$res]);
		//return $this->render('userForm',['count'=>$count[0]['count']]);
		$qrcode_num= 0;
		if($res['qrcode_w']!=''){
				$qrcode_num = 1;
		}		
		
	//$canvas='<img src="img\canvas.png" style="height:'.$res['canvas_height'].'px;width:'.$res['canvas_width'].'px;"/>';
	
	$image = '';
	$qrcode = '';
	$barcode = '';
	$data2='';
	$textfield='';
if($session['csv_num'] == 0){											//MANUAL INPUT
	if($res['textfield_num']>=1){
			$cnt = 0;
			
			$textfield_x_array = explode(',', $res['textfield_x']);		//SPLIT TEXT
			$textfield_y_array = explode(',', $res['textfield_y']);	
			$textfield_fs_array = explode(',', $res['font_size']);		//SPLIT TEXT
			$textfield_ff_array = explode(',', $res['font_family']);	
		
			while($cnt!=$res['textfield_num']){
					
					$textfield = $textfield.'<br><p style="font-family:'.$textfield_ff_array[$cnt].';font-size:'.$textfield_fs_array[$cnt].'px;margin-top:'.$textfield_y_array[$cnt].'px;margin-left:'.$textfield_x_array[$cnt].'px">'.$_GET['tf_'.$cnt.''].'</p>';
					
					$cnt++;
			}//end of while loop

	}
	
	
	if($res['img_num'] >= 1){
				$cnt = 0;
				$image_array_custom = explode(',', $res['img_name']); 
				$image_array_height = explode(',', $res['img_h']); 
				$image_array_width = explode(',', $res['img_w']);
				$image_array_x = explode(',', $res['img_x']); 
				$image_array_y = explode(',', $res['img_y']);
				$image = '';	
			
				//SPLIT TEXT
				while($cnt!=$res['img_num']){
					
					Draggable::begin([
					'clientOptions' => ['grid' => [0, 0]],
					]);
			
					 $temp = Html::img('@web/uploads/'.$image_array_custom[$cnt].'', ['alt'=>'some','title'=> $image_array_custom[$cnt], 'width'=>$image_array_width[$cnt], 'height'=>$image_array_height[$cnt], 'id'=>'img_'.$cnt.'','style'=>'postion:relative;margin-left:'.$image_array_x[$cnt].'px;margin-top:'.$image_array_y[$cnt].'px;']);
					 $image = $image.'<br>'.$temp;
					 //$image = $image.$temp;
					 $cnt++;
				}//end of while loop
			
	}
	
	if($qrcode_num >= 1){
		$attrib_qrcode = explode(',', $res['qrcode_attrib']);		//SPLIT TEXT
		$textfield_array = explode(',', $res['attribute_textfield']);
		$cnt=0;$cnt2=0;
		$qrcode_text = $res['qrcode_text'];
		
			while($cnt!=$res['textfield_num']){
				$cnt2=0;
				while($cnt2!=$res['textfield_num']){
					if($cnt2 == $attrib_qrcode[$cnt]){
						$qrcode_text = $qrcode_text."\n".$textfield_array[$cnt2].': '.$_GET['tf_'.$cnt2.'']; 
					}
					$cnt2++;
				}
				$cnt++;
			}//end of while loop
		
		$qrcode= '<br><img id = "qrcode_resize" src = "http://chart.apis.google.com/chart?cht=qr&chs=200x200&chl='.$qrcode_text.'" title="QR Code of '.$res['qrcode_text'].'" height = "'.$res['qrcode_h'].'px" width = "'.$res['qrcode_w'].'px" style="margin-left:'.$res['qrcode_x'].'px;margin-top:'.$res['qrcode_y'].'px;">';
		
	}
	if($res['barcode_num']>=1){
		$barcode= '<br><img id = "barcode_resize" src = "http://www.barcodesinc.com/generator/image.php?code='.$res['barcode_text'].'&style=197&type=C128B&width=170&height=73&xres=1&font=5" title="Barcode of '.$res['barcode_text'].'" height = "'.$res['barcode_h'].'px" width = "'.$res['barcode_w'].'px" style="position:relative;margin-left:'.$res['barcode_x'].'px;margin-top:'.$res['barcode_y'].'px;"/>'; 
		
	}
	
	$res['canvas_height'] =$res['canvas_height']*2.8;
	$res['canvas_width'] =$res['canvas_width']*2.8;
	
		$data = 
		'<html>
			<head>
				<style>
					#all{
						height:100%;
						width:100%;
					}
					#bg{
						display:inline-block;
						width: '.$res['canvas_width'].'px;
						height: '.$res['canvas_height'].'px;
						position: relative;
						background: url("img\canvas.png");
						background-size: '.$res['canvas_width'].'px '.$res['canvas_height'].'px;
						background-repeat: no-repeat; 
					}
					
					#top {
						 position: absolute;
						 top: 0;
						 left: 0;
						 z-index: 10;
					}
		
				</style>
			</head>
			<body><div id ="all">';
			
			$num_cop = $_GET['num_cop'];										//number of copies
			$cnt=0;
			if($num_cop == ''){
				$num_cop = 1;
			}
		
			while($cnt!=$num_cop){
				$data2=$data2.'
					<div id = "bg">
						<div id = "top">
							'.$textfield.'
							'.$image.'
							'.$qrcode.'
							'.$barcode.'
							
						</div>
					</div>';
				$cnt++;
			}	
			
				
			
			$data3=	'</div></body></html>';
}
else{																									//UPLOADED CSV
	
	$tf_array = explode(',',$res['attribute_textfield']);												//get the attributes of the current template
	$cnt = 0;
	while($cnt!=count($tf_array)-1){
		$num =0;
		$user_data_array[$cnt] = explode(',',$session['csv_user_data'][$tf_array[$cnt]]);				//parse the data by column
		$cnt++;
	}
	$res['canvas_height'] =$res['canvas_height']*2.8;
	$res['canvas_width'] =$res['canvas_width']*2.8;
	
	$image = '';
	
	$barcode = '';
	$data2='';
	
	//FOR TEXTFIELD RENDERING
	if($res['textfield_num']>=1){
			$cnt = 0;
			
			$textfield_x_array = explode(',', $res['textfield_x']);		//SPLIT TEXT
			$textfield_y_array = explode(',', $res['textfield_y']);	
			$textfield_fs_array = explode(',', $res['font_size']);		//SPLIT TEXT
			$textfield_ff_array = explode(',', $res['font_family']);	
		$cnt2= 2;
		while($cnt2!=count($user_data_array[0])-1){
			$textfield[$cnt2] ='';
			$cnt2++;
		}
		$cnt2=2;
		while($cnt2!=count($user_data_array[0])-1){																	//PARSE DATA FROM CSV
			$cnt=0;
			while($cnt!=$res['textfield_num']){
				
				$textfield[$cnt2] = $textfield[$cnt2].'<br><p style="font-family:'.$textfield_ff_array[$cnt].';font-size:'.$textfield_fs_array[$cnt].'px;margin-top:'.$textfield_y_array[$cnt].'px;margin-left:'.$textfield_x_array[$cnt].'px">'.$user_data_array[$cnt][$cnt2].'</p>';
					
					$cnt++;
			}//end of while loop
			$cnt2++;
		}

	}
	//FOR IMAGE RENDERING
	if($res['img_num'] >= 1){
				$cnt = 0;
				$image_array_custom = explode(',', $res['img_name']); 
				$image_array_height = explode(',', $res['img_h']); 
				$image_array_width = explode(',', $res['img_w']);
				$image_array_x = explode(',', $res['img_x']); 
				$image_array_y = explode(',', $res['img_y']);
				$image = '';	
			
				//SPLIT TEXT
				while($cnt!=$res['img_num']){
					$image_array_height[$cnt] = $image_array_height[$cnt];
					$image_array_width[$cnt] = $image_array_width[$cnt];
					
					Draggable::begin([
					'clientOptions' => ['grid' => [0, 0]],
					]);
			
					 $temp = Html::img('@web/uploads/'.$image_array_custom[$cnt].'', ['alt'=>'some','title'=> $image_array_custom[$cnt], 'width'=>$image_array_width[$cnt], 'height'=>$image_array_height[$cnt], 'id'=>'img_'.$cnt.'','style'=>'postion:relative;margin-left:'.$image_array_x[$cnt].'px;margin-top:'.$image_array_y[$cnt].'px;']);
					 $image = $image.'<br>'.$temp;
					 //$image = $image.$temp;
					 $cnt++;
				}//end of while loop
			
	}
	//FOR QRCODE RENDERING
	if($qrcode_num >= 1){
		$attrib_qrcode = explode(',', $res['qrcode_attrib']);																//SPLIT TEXT
		$textfield_array = explode(',', $res['attribute_textfield']);
		
		$cnt2= 2;
		while($cnt2!=count($user_data_array[0])-1){
			$qrcode[$cnt2] = '';
			$qrcode_text[$cnt2] =$res['qrcode_text'];
			$cnt2++;
		}															
		$cnt2=2;																										//SET QRCODE BASED ON CSV FILE
		while($cnt2!=count($user_data_array[0])-1){																		//PARSE DATA FROM CSV
			$cnt=0;
			while($cnt!=$res['textfield_num']){
				$qrcode_text[$cnt2] = $qrcode_text[$cnt2]."\n".$textfield_array[$cnt].': '.$user_data_array[$cnt][$cnt2];
				$cnt++;
			}
			$qrcode[$cnt2]= '<br><img id = "qrcode_resize" src = "http://chart.apis.google.com/chart?cht=qr&chs=200x200&chl='.$qrcode_text[$cnt2].'" title="QR Code of '.$res['qrcode_text'].'" height = "'.$res['qrcode_h'].'px" width = "'.$res['qrcode_w'].'px" style="margin-left:'.$res['qrcode_x'].'px;margin-top:'.$res['qrcode_y'].'px;">';
			$cnt2++;
		}
																													
		
		
		
	}
	if($res['barcode_num']>=1){
		$barcode= '<br><img id = "barcode_resize" src = "http://www.barcodesinc.com/generator/image.php?code='.$res['barcode_text'].'&style=197&type=C128B&width=170&height=73&xres=1&font=5" title="Barcode of '.$res['barcode_text'].'" height = "'.$res['barcode_h'].'px" width = "'.$res['barcode_w'].'px" style="position:relative;margin-left:'.$res['barcode_x'].'px;margin-top:'.$res['barcode_y'].'px;"/>'; 
		
	}
	
	//FORMATTING
		$data = 
		'<html>
			<head>
				<style>
					#all{
						height:100%;
						width:100%;
					}
					#bg{
						display:inline-block;
						width: '.$res['canvas_width'].'px;
						height: '.$res['canvas_height'].'px;
						position: relative;
						background: url("img\canvas.png");
						background-size: '.$res['canvas_width'].'px '.$res['canvas_height'].'px;
						background-repeat: no-repeat; 
					}
					
					#top {
						 position: absolute;
						 top: 0;
						 left: 0;
						 z-index: 10;
					}
		
				</style>
			</head>
			<body><div id ="all">';
			
			$num_cop = '';										//number of copies
			$cnt=2;
			if($num_cop == ''){
				$num_cop = 1;
			}
			
			while($cnt!=count($textfield)+2){
					$data2=$data2.'
					<div id = "bg">
						<div id = "top">
							
							'.$textfield[$cnt].'
							'.$image.'
							'.$qrcode[$cnt].'
							'.$barcode.'
							
							
						</div>
					</div>';
				$cnt++;
			}
						
					
				
			
			$data3=	'</div></body></html>';
	
}

		//generate pdf
		$mpdf = new mPDF();
		$mpdf->WriteHTML($data.$data2.$data3);
		$mpdf->Output('defined_template.pdf', 'D');
		
}//end of function
	
	
	
	
}