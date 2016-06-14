<?php
//-----------------------------PAGE FOR FIRST LAYOUT---------------------------//
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\widgets\ActiveForm;
	$this->title = 'Add Text';
?>

<html>
	<head>
	</head>
	<body>
		<textarea style="overflow:scroll;resize:none;margin-left:20px;" rows="12" cols="40"></textarea>
		<!--ADD TEXT BUTTON-->
		 <?= Html::submitButton('ADD TEXT', ['class' => 'btn btn-warning btn-lg', 'id'=> 'add_text_button', 'name' => 'Submit', 'onclick' => "popUp('addtextpopup')"]) ?>
	</body>
</html>