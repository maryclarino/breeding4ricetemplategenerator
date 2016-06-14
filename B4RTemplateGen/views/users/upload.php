
<?php
//MODEL FOR UPLOAD IN EDITOR
use yii\widgets\ActiveForm;
use yii\helpers\Url;
$this->title = 'Upload Image';
//REFERENCE: yiiframework.com
?>
	<html>
	<head>
		
	</head>
	<body>
		<div style = "margin-left:100px;margin-top:50px;">
			<?php $form = ActiveForm::begin([
					'action' => Url::to(['users/upload']),
					'options' => 
						['enctype' => 'multipart/form-data']
					]) ?>

			<?= $form->field($model, 'imageFile')->fileInput() ?>

			<button class = "btn btn-warning btn-lg" style = "width:150px;height:40px;">UPLOAD</button>

			<?php ActiveForm::end() ?>
			
		</div>
	</body>
	<html>
