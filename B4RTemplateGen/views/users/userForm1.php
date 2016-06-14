<?php
//-----------------------------PAGE FOR FIRST LAYOUT: FIELD LABEL---------------------------//
	
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\widgets\ActiveForm;
	$this->title = 'Field Label';
?>
<?php 
	
	

	if(Yii::$app->session->hasFlash('success')){
		echo "<div class = 'alert alert-success'>",Yii::$app->session->getFlash('success'),"</div>";
	}
?>
<html>
	<head>
		<script type = "text/javascript">
			function popUp(url) {
			window.open(url,'PHP Pop Up','width=500,height=500');
			}
		</script>
	</head>
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
					Year,Source,<br>
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
		 <?= Html::submitButton('CREATE NEWLAYOUT', ['class' => 'btn btn-primary btn-lg', 'id'=>'create_newlayout_button','name' => 'Submit']) ?>
		
	</ul>
	</form>
	</div>
	 <div id = "left_bar2">
			<!--ADD CSV BUTTON-->
			 <?= Html::submitButton('', ['class' => 'btn btn-primary btn-lg','id'=> 'csv_new_button', 'name' => 'Submit','onclick' => "popUp('viewcsv')", 'title'=>'Upload CSV File']) ?>
	</div>
	<div id = "main_edit">
	 <?php $form = ActiveForm::begin([
			'id' => 'select-form',
			'method' => 'get',
			'action' => Url::to(['users/user_input']),
			]); 
	?>
	<?= Html::img('@web/img/labels/FieldLabel2.png', ['id' => 'fieldlabel', 'alt'=>'some','width'=>300]);?> 
	 
	<input id = "first_text" name = "year" type = "text" placeholder = "Year">
	<input id = "second_text" name = "source" type = "text" placeholder = "Source">
	<input id = "third_text" name ="plot_number" type = "text" placeholder = "Plot Number">
	<input id = "fourth_text" name = "current_gen" type = "text" placeholder = "Current Generation">
	</div>
	
	<input type = "number" name = "num_cop" id = "generate1" placeholder = "Number Of Copies"/>
	<?= Html::submitButton('GENERATE', ['id'=>'generate','class' => 'btn btn-info btn-lg', 'name' => 'Submit', 'title' => 'generate a PDF copy']) ?>
	</form>
	
	
</div>
</html>
	
	