<?php
//-----------------------------PAGE FOR FIRST LAYOUT---------------------------//
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\widgets\ActiveForm;
	$this->title = 'Add BarCode';
?>

<html>
	<head>
		<script>
			alert("Bar Code has been stored!");
		</script>
	</head>
	<body>
		 <?php $form = ActiveForm::begin([
				'id' => 'select-form',
				'method' => 'get',
				'action' => Url::to(['users/addbarcode']),
				]); 
		?>
		<textarea name = "text_barcode"style="overflow:scroll;resize:none;margin-left:20px;" rows="12" cols="40"></textarea>
		<!--ADD QR CODE BUTTON-->
		 <?= Html::submitButton('GENERATE BAR CODE', ['class' => 'btn btn-default btn-lg', 'id'=> 'add_qrcode_button', 'name' => 'Submit']) ?>
		 </form>
	</body>
</html>