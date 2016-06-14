<?php
//-----------------------------PAGE FOR FIRST LAYOUT---------------------------//
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\widgets\ActiveForm;
	$this->title = 'Select layout';
?>

<html>
	<head>
		
	</head>
	<body>
		<div id ="side_bar">
	<br>
	<ul class= "img-list">
		<li>
		 <?php $form = ActiveForm::begin([
					'id' => 'select-form',
					//'method' => 'get',
					'action' => Url::to(['users/layoutchoice1']),
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
			'action' => Url::to(['users/layoutchoice2']),
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
			'action' => Url::to(['users/layoutchoice3']),
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
			'action' => Url::to(['users/layoutchoice4']),
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
	</body>
</html>