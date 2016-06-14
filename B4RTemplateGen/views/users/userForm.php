<?php
//-----------------------------PAGE FOR DEFINED LAYOUT---------------------------//
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\widgets\ActiveForm;
	use yii\jui\Draggable;
	use yii\jui\Resizable;
	$this->title = 'Template Generator';
?>
<?php 
	
	if(Yii::$app->session->hasFlash('success')){
		echo "<div class = 'alert alert-success'>",Yii::$app->session->getFlash('success'),"</div>";
	}
?>


<html>
<head>

	<script>
		$(document).ready(function(){
		
			$('#upload').appendTo("body"); 
			
	</script>
</head>
<body>
<div id = "all">
<!------------------SIDE BAR--------------->
	<div id ="side_bar">
	<br>
	<ul class= "img-list">
		<li>
		 <?php $form = ActiveForm::begin([
					'id' => 'select-form',
					//'method' => 'get',
					'action' => Url::to(['users/select1']),
					]); 
		?>
		
		<?= Html::img('@web/img/labels/FieldLabel.png', ['alt'=>'some', 'class'=>'choice', 'width'=>300]);?> 
		<!--FOR HOVER-->
		<span class = "choice">
				<span>
					<b><font size = '5px'>FIELD LABEL<br></font></b>
					Year,Source<br>
					Plot Number,Current Generation<br>
					<i>Size: 2.766 X 1.35 (in)</i>
				</span>
		</span>
		<br>
		 <?= Html::submitButton('SELECT', ['class' => 'btn btn-success', 'name' => 'select1']) ?>
		<br>
		<br>
		<br>
		</li>
		
	</form>
	
	 <?php $form = ActiveForm::begin([
			'id' => 'select-form',
			//'method' => 'get',
			'action' => Url::to(['users/select2']),
			]); 
	?>
		<li>
		<?= Html::img('@web/img/labels/harvestlabels.png', ['alt'=>'some', 'class'=>'choice', 'width'=>300]);?> 
		<!--FOR HOVER-->
		<span class = "choice2">
				<span>
					<b><font size = '5px'>HARVEST LABEL<br></font></b>
					Designation<br>
					Current Generation<br>
					Source<br>
					Tray Number<br>
					<i>Size: 2.075 X 1.35 (in)</i>
				</span>
		</span>
		 <?= Html::submitButton('SELECT', ['class' => 'btn btn-success', 'name' => 'select2']) ?>
		<br>
		<br>
		<br>
		</li>
	</form>
	
	 <?php $form = ActiveForm::begin([
			'id' => 'select-form',
			//'method' => 'get',
			'action' => Url::to(['users/select3']),
			]); 
	?>
		<li>
		<?= Html::img('@web/img/labels/shelflabels.png', ['alt'=>'some', 'class'=>'choice','width'=>300]);?> 
		<!--FOR HOVER-->
		<span class = "choice3">
				<span>
					<b><font size = '5px'>SHELF LABEL<br></font></b>
					Designation/Current Generation<br>
					Source/Tray Number/Plot Number<br>
					<i>Size: 4.0 X 5.0 (in)</i>
				</span>
		</span>
		 <?= Html::submitButton('SELECT', ['class' => 'btn btn-success', 'name' => 'select3']) ?>
		
		<br>
		<br>
		<br>
		</li>
	</form>

	 <?php $form = ActiveForm::begin([
			'id' => 'select-form',
			//'method' => 'get',
			'action' => Url::to(['users/select4']),
			]); 
	?>
		<li>
		<?= Html::img('@web/img/labels/traylabels5.png', ['alt'=>'some', 'class'=>'choice','width'=>300]);?> 
		<!--FOR HOVER-->
		<span class = "choice4">
				<span>
					<b><font size = '5px'>TRAY LABEL<br></font></b>
					Designation/Current Generation<br>
					Source/Tray Number/Plot Number<br>
						<i>Size: 2.766 X 1.35 (in)</i>
				</span>
		</span>
		<?= Html::submitButton('SELECT', ['class' => 'btn btn-success', 'name' => 'select4']) ?>
		</li>
	<br>
	<br>
	<br>
	</form>
		
		 <?php $form = ActiveForm::begin([
				'id' => 'select-form',
				//'method' => 'get',
				'action' => Url::to(['users/viewcustompage2']),
				]); 
		?>
		 <?= Html::submitButton('CREATE NEWLAYOUT', ['class' => 'btn btn-primary btn-lg', 'id'=>'create_newlayout_button', 'name' => 'Submit']) ?>
		
	</ul>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

	<script>
		function set_tf(cnt) {
			document.getElementById("choice").value = cnt;
		}
</script>
	
	</form>
	<!---ACCESSING NEW DEFINED TEMPLATES-->
		
		<?php 
			$cnt=0;
		$form = ActiveForm::begin([
					'id' => 'select-form',
					'method' => 'get',
					'action' => Url::to(['users/getchoice']),
		]);
			while($cnt!=$count){
				$cnt++;
				echo '<button class = "btn btn-primary btn-lg" onclick="set_tf('.$cnt.')">'.$cnt.'</button>';
			}
			echo '<input type="hidden" id="choice" name="choice" value=""></input>';
		ActiveForm::end();
		?>
	
	</div>
	
	<div id = "left_bar2">
	
		 <button type="submit" title="Upload CSV File" class="btn btn-default" data-toggle="modal" data-target="#upload" id = "custom_buttons_add"> <span id ="custom_icon" class="glyphicon glyphicon-open"></span> </button>
		 
		 <?php $form = ActiveForm::begin([
				'id' => 'select-form',
				//'method' => 'get',
				'action' => Url::to(['users/resetcsv']),
				]); 
			?>
		 <button type="submit" title="Manual Input" class="btn btn-default" data-toggle="modal" data-target="#reset" id = "custom_buttons_add"> <span id ="custom_icon" class="glyphicon glyphicon-pencil"></span> </button>
		
		 <?php ActiveForm::end() ?>
		 
		 
			
	</div>
	
	<div id = "main_edit" draggable = "true">

	 <?php $form = ActiveForm::begin([
			'id' => 'select-form',
			'method' => 'get',
			'action' => Url::to(['users/generate']),
			]); 
	?>
		<!--CANVAS-->
		
		<?php
			echo'<div id = "canvas">';
			echo Html::img('@web/img/canvas.png', ['alt'=>'some', 'class'=>'choice','width'=>$width_canvas, 'height'=>$height_canvas, 'style'=>'position:absolute;', 'id'=>'canvas_img']);
			echo'</div>';
		?>
		
		
	
		<!--TEXTFIELD-->
		<?php
	
		if($textfield_num>=1){
			$cnt = 0;
			$textfield_height_array = explode(',', $height_textfield);		//SPLIT TEXT
			$textfield_width_array = explode(',', $width_textfield);		//SPLIT TEXT
			$textfield_attrib_array = explode(',', $attribute_textfield);		//SPLIT TEXT
			$textfield_x_array = explode(',', $tf_x);		//SPLIT TEXT
			$textfield_y_array = explode(',', $tf_y);		//SPLIT TEXT
			$textfield_fs_array = explode(',', $font_size);		//SPLIT TEXT
			$textfield_ff_array = explode(',', $font_family);		//SPLIT TEXT
		
			while($cnt!=$textfield_num){
					
					$textfield_width_array[$cnt] = ($textfield_width_array[$cnt]).'px';
					$textfield_height_array[$cnt] = ($textfield_height_array[$cnt]).'px';
					
					echo '<div id = "tf_drag_'.$cnt.'"><input name = "tf_'.$cnt.'" id = "tf_'.$cnt.'" type="text" style="font-family:'.$textfield_ff_array[$cnt].';font-size:'.$textfield_fs_array[$cnt].'px;position:relative;margin-left:'.$textfield_x_array[$cnt].'px;margin-top:'.$textfield_y_array[$cnt].'px;width:'.$textfield_width_array[$cnt].';height:'.$textfield_height_array[$cnt].';" placeholder='.$textfield_attrib_array[$cnt].'></input></div>';
					
					$cnt++;
			}//end of while loop
		}
		?>
		
		<!--IMAGE-->
		<?php
			if($upload_cnt_custom >= 1){
				$cnt = 0;
				$image_array_custom = explode(',', $upload_image_custom); 
				$image_array_height = explode(',', $image_height); 
				$image_array_width = explode(',', $image_width);
				$image_array_x = explode(',', $img_x); 
				$image_array_y = explode(',', $img_y);
					
				//SPLIT TEXT
				while($cnt!=$upload_cnt_custom){
					
					Draggable::begin([
					'clientOptions' => ['grid' => [0, 0]],
					]);
					echo '<div>';
					$image_array_height[$cnt] = $image_array_height[$cnt];
					$image_array_width[$cnt] = $image_array_width[$cnt];
					
					echo Html::img('@web/uploads/'.$image_array_custom[$cnt].'', ['alt'=>'some','title'=> $image_array_custom[$cnt], 'width'=>$image_array_width[$cnt], 'height'=>$image_array_height[$cnt], 'id'=>'img_'.$cnt.'','style'=>'postion:relative;margin-left:'.$image_array_x[$cnt].'px;margin-top:'.$image_array_y[$cnt].'px;']);
				
					Draggable::end();
					echo '</div>';
					$cnt++;
				}//end of while loop
			}
		?>
		
	<!--QRCODE-->
	
	<?php 
		if($custom_qrcode_num >= 1){
			
		echo '<div id = "qrcode">';
			echo '<img id = "qrcode_resize" src = "http://chart.apis.google.com/chart?cht=qr&chs=200x200&chl='.$text_qrcode.'" title="QR Code of '.$text_qrcode.'" height = '.$height_qrcode.' width = '.$width_qrcode.' style="position:relative;margin-left:'.$qrcode_x.'px;margin-top:'.$qrcode_y.'px;"';
		
			
			echo '</div>';
		}
	?>
	
	<!--BARCODE-->
	<?php 
	
		if($custom_barcode_num >= 1){
			echo '<div id = "barcode">';
			echo '<img id = "barcode_resize" src = "http://www.barcodesinc.com/generator/image.php?code='.$text_barcode.'&style=197&type=C128B&width=170&height=73&xres=1&font=5" title="Barcode of '.$text_barcode.'" height = '.$height_barcode.' width = '.$width_barcode.' style="position:relative;margin-left:'.$barcode_x.'px;margin-top:'.$barcode_y.'px;"/>';
			echo '</div>';
		}
	?>
	<input type = "number"  name = "num_cop" id = "num_cop" placeholder = "Number Of Copies"/>
	<?= Html::submitButton('GENERATE', ['id'=>'generate_button','class' => 'btn btn-info btn-lg', 'name' => 'Submit', 'title' => 'generate a PDF copy']) ?>
	<?php ActiveForm::end(); ?>

	</div>
	
</div>

	
<!-- Modal FOR UPLOAD -->
	  <div class="modal fade" id="upload" role="dialog"">
		<div class="modal-dialog">
		
		  <!-- Modal content-->
		  <div class="modal-content" style="width:300px;">
			<div class="modal-header"  style="height:50px;">
			  
			  <button type="button" class="btn btn-default" style="margin-left:220px;" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
			
			</div>
			
			<div class="modal-body" >
				<?php $form = ActiveForm::begin([
					'action' => Url::to(['users/uploadcsvcustom']),
					'options' => 
						['enctype' => 'multipart/form-data']
					]) ?>

			<?= $form->field($model, 'csvFile')->fileInput() ?>

			<button class = "btn btn-success" style = "margin-left:90px;margin-top:10px;"><span style="font-size:1.5em;" class="glyphicon glyphicon-open"></span>UPLOAD</button>

			<?php ActiveForm::end() ?>
				
				
			</div>
			
		  </div>
		  
		</div>
	<!-- END Modal FOR UPLOAD-->
	
	<!-- Modal FOR RESET -->
	  <div class="modal fade" id="reset" role="dialog"">
		<div class="modal-dialog">
		
		  <!-- Modal content-->
		  <div class="modal-content" style="width:300px;">
			<div class="modal-header"  style="height:50px;">
			  
			  <?php $form = ActiveForm::begin([
					'action' => Url::to(['users/resetcsv']),
					'options' => 
						['enctype' => 'multipart/form-data']
					]) ?>
			  <button type="button" class="btn btn-default" style="margin-left:220px;" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
			<? ActiveForm::end(); ?>
			</div>
			
			<div class="modal-body" >
			</div>
			
		  </div>
		  
		</div>
	<!-- END Modal FOR RESET-->
	
	
	


		
</body>
</html>
	
	