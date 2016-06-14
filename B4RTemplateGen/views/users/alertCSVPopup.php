<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
$this->title = 'Upload CSV File';
//REFERENCE: yiiframework.com
?>
	<html>
	<head>
		<script>
			alert("CSV File has been uploaded!");
		</script>
	</head>
	<body>
		<div style = "margin-left:100px;margin-top:50px;">
			<?php $form = ActiveForm::begin([
					'action' => Url::to(['users/uploadcsv']),
					'options' => 
						['enctype' => 'multipart/form-data']
					]) ?>

			<?= $form->field($model, 'csvFile')->fileInput() ?>

			<button class = "btn btn-primary btn-lg" style = "width:150px;height:40px;">UPLOAD</button>

			<?php ActiveForm::end() ?>
			
		</div>
	</body>
	<html>
