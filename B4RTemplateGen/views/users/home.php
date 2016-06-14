<!--HOME PAGE: THIS IS THE INITIAL PAGE OF THE SYSTEM-->

<?php
	use yii\helpers\HTML;
	use yii\widgets\ActiveForm;
	use yii\helpers\Url;
	use yii\widgets\ActiveField;
?>
<?php 
	if(Yii::$app->session->getFlash('success')){
		echo "<div class = 'alert alert-success'>".Yii::$app->session->getFlash('success')."</div>";
	}
	
	if(Yii::$app->session->getFlash('error')){
		echo "<div class = 'alert alert-danger'>".Yii::$app->session->getFlash('error')."</div>";
	}
	
?>
<html>
	<head>
	
	</head>
	
	<body>
	<div id = "home">
		<!--image-->
		<?= Html::img('@web/img/template_gen2.png', ['alt'=>'some', 'id'=>'bg',]);?>
	</div>
	
		<!--form for sign-up-->
		<?php $form2 = ActiveForm::begin([
			'id' => 'select-form',
			'method' => 'get',
			'action' => Url::to(['users/signup']),
		]); ?>
	
			<!--sign-up button-->
			<button type="submit" class="btn btn-default btn-lg" title="SIGN UP" id = "signup"> <span class="glyphicon glyphicon-pencil"></span> SIGN UP</button>
		<?php ActiveForm::end() ?>
		
		<!--log-in button-->
		<button type="button" title="LOG IN" class="btn btn-default btn-lg" data-toggle="modal" data-target="#log_in" id = "login"> <span class="glyphicon glyphicon-log-in"></span> LOG IN</button>
	
		
	</div>
	
	

	  <!-- Modal FOR LOG-IN -->
	  <div class="modal fade" id="log_in" role="dialog"">
		<div class="modal-dialog">
		
		  <!-- Modal content-->
		  <div class="modal-content" style="width:500px;">
			<div class="modal-header"  style="height:50px;">
			  
			  <button type="button" class="btn btn-default" style="margin-left:420px;" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
			
			</div>
			
			<div class="modal-body" >
			
				<!--form for log-in-->
				<?php $form = ActiveForm::begin([
					'id' => 'select-form',
					'method' => 'get',
					'action' => Url::to(['users/processlogin']),
				]); ?>
	
				<label id = "labels"> Username</label>
				<input id = "username" class="form-control" name = "username" type = "text" placeholder = "username" required>
				<label id = "labels">Password</label>
				<input id = "password" class="form-control" name = "password" type = "password" placeholder = "password" required>
				
				<!--Submit button-->
			
			 <div class="modal-footer" style="height:40px;margin-top:15px;">
				
				<?= Html::submitButton('Submit', ['class' => 'btn btn-success', 'title'=>'Submit', 'id' => 'submit']) ?>
				
			<?php ActiveForm::end() ?>
				
			</div>
			
		  </div>
		  
		</div>
	  </div>
	<!-- END Modal FOR LOG-IN -->
	

	
	
	
	
	</body>
</html>