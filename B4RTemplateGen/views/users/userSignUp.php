<!--USER SIGN UP USER INTERFACE-->
<?php 

use yii\helpers\Html;
use yii\widgets\ActiveForm;
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
<?php $form = ActiveForm::begin();?>
<?= $form->field($model,'username');?>
<?= $form->field($model,'password');?>
<label>Re-enter password:</label><?= $form->field($model,'repassword')->label(false);?>
<label>First Name:</label><?= $form->field($model,'fname')->label(false);?>
<label>Middle Name:</label><?= $form->field($model,'mname')->label(false);?>
<label>Last Name:</label> <?= $form->field($model,'lname')->label(false) ?>
<label>Email Address:</label><?= $form->field($model,'email')->label(false);?>
<label>Contact Number:</label><?= $form->field($model,'num')->label(false);?>




<?= Html::submitButton('Submit',['class'=>'btn btn-success']);?>

