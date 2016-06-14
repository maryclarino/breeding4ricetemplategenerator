<!--NOT NEEDED--!>

<?php
//-----------------------------PAGE FOR FIRST LAYOUT---------------------------//
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\widgets\ActiveForm;
	use yii\jui\Draggable;
	use yii\jui\Resizable;
	use yii\jui\Dialog;
	
	use yii\helpers\BaseHtml;
	$this->title = 'Custom Layouts';
?>
<html>

<head>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script>
	
		$(document).ready(function(){
			$("#div_textfield").hide();
			$("#custom_buttons_addtextfield").click(function(){
				 $( "#div_textfield" ).animate({
					left: "+=1000",
					right: "+=1000",
					height: "toggle"
				  }, 1000, function() {
					// Animation complete.
				  });
			});
		})
	</script>
</head>

<body>
<div id = "all">
<!------------------SIDE BAR--------------->
	<div id ="custom_side_bar">
	<br>
	<ul class= "img-list">
		<!--------ADD TEXT FIELD BUTTON---------->
		<li>
		<?php $form = ActiveForm::begin([
					'id' => 'select-form',
					//'method' => 'get',
					'action' => Url::to(['users/viewaddtextfield']),
					]); 
		?> 
		<?= Html::submitButton('', ['class' => 'btn btn-info', 'title' => 'Add Textfield', 'id' => 'custom_buttons_addtextfield']) ?>
		<?php ActiveForm::end() ?>
		</li>
		<!--------UPLOAD IMAGE BUTTON---------->
		
		<li>
			  <?php $form = ActiveForm::begin([
					'id' => 'select-form',
					//'method' => 'get',
					'action' => Url::to(['users/viewcustompageaddimagedimensions']),
					]); 
			 ?>
			 <?= Html::submitButton('', ['class' => 'btn btn-warning', 'title' => 'Upload Image', 'id' => 'custom_buttons_uploadimage']) ?>
			<?php ActiveForm::end() ?>
		</li>
		
		<!--------ADD QRCODE BUTTON---------->
		
		<li>
		  <?php $form = ActiveForm::begin([
				'id' => 'select-form',
				//'method' => 'get',
				'action' => Url::to(['users/viewcustomaddqrcode']),
				]); 
		 ?>
		 <?= Html::submitButton('', ['class' => 'btn btn-default', 'title' => 'Add QRCODE', 'id' => 'custom_buttons_addqrcode']) ?>
		 
		<?php ActiveForm::end() ?>
		</li>
		
		<!--------ADD BARCODE BUTTON---------->
		<li>
		  <?php $form = ActiveForm::begin([
				'id' => 'select-form',
				//'method' => 'get',
				'action' => Url::to(['users/viewcustombarcode']),
				]); 
		 ?>
		 <?= Html::submitButton('', ['class' => 'btn btn-default', 'title' => 'Add Barcode', 'id' => 'custom_buttons_addbarcode']) ?>
		 
		<?php ActiveForm::end() ?>
		</li>
		
		<!--------SAVE DRAFT BUTTON---------->
		<li>
		  <?php $form = ActiveForm::begin([
				'id' => 'select-form',
				//'method' => 'get',
				'action' => Url::to(['users/select2']),
				]); 
		 ?>
		 <?= Html::submitButton('', ['class' => 'btn btn-primary', 'title' => 'Save as Draft', 'id' => 'custom_buttons_savedraft']) ?>
		 
		<?php ActiveForm::end() ?>
		</li>
		
		<!--------TRANSFER TO DEFINED Template---------->
		<li>
		  <?php $form = ActiveForm::begin([
				'id' => 'select-form',
				//'method' => 'get',
				'action' => Url::to(['users/select2']),
				]); 
		 ?>
		 <?= Html::submitButton('', ['class' => 'btn btn-danger', 'title' => 'Transfer to Defined Layouts', 'id' => 'custom_buttons_transfer']) ?>
		 
		<?php ActiveForm::end() ?>
		</li>
	</ul>
	</form>
	</div>
	<!------------------END OF SIDE BAR--------------->	
	<!-------------------GET CANVAS SIZE--------------->
	<?php
	Dialog::begin([
			'clientOptions' => [
				'modal' => true,
				'height'=>150,
					],
		]);
	
		$form2 = ActiveForm::begin([
			'id' => 'select-form',
			'method' => 'get',
			'action' => Url::to(['users/canvasdetails']),
		]); 
		

		echo 'Enter canvas size (px):'."<input type = 'text' placeholder ='height' style = 'width:50px;' name = 'height_canvas'></input><input type = 'text' placeholder ='width' style = 'width:50px;margin-left:3px;' name = 'width_canvas'></input>";
		
		echo Html::submitButton('OK',['class'=>'btn btn-warning', 'style'=>'margin-left:120px;margin-top:10px;']);
		
		
		ActiveForm::end();
	Dialog::end();
	?>
	

	
	</div>
</div>
</body>
</html>
	
	