<?php
//-----------------------------PAGE FOR ---------------------------//
	use yii\helpers\Html;
	use yii\helpers\BaseHtml;
	use yii\helpers\Url;
	use yii\widgets\ActiveForm;
	use yii\jui\Draggable;
	use yii\jui\Resizable;
	use yii\jui\Selectable;
	use yii\jui\Slider;
	
	use jsPDF as jsPDF;
	$this->title = 'New Layout';
?>
<?php 
	if(Yii::$app->session->hasFlash('success')){
		echo "<div class = 'alert alert-success'>",Yii::$app->session->getFlash('success'),"</div>";
	}
?>
	
	
<html>

<head>
	
	<script type="text/javascript">
	$(document).ready(function(){
	});
		function popUp(url) {
			window.open(url,'PHP Pop Up','width=500,height=500');
		}
		function popUp2(url) {
			window.open(url,'PHP Pop Up','width=500,height=700');
		}
		
		
		function printDiv(divName) {
			 var printContents = document.getElementById(divName).innerHTML;
			 var originalContents = document.body.innerHTML;

			 document.body.innerHTML = printContents;
			
			 window.print();

			 document.body.innerHTML = originalContents;
		}
		
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
					'method' => 'post',
					'action' => Url::to(['users/deflayoutchoice1']),
					]); 
		?>
		
		<?= Html::img('@web/img/labels/FieldLabel5.png', ['alt'=>'some', 'class'=>'choice', 'width'=>300]);?> 
		<!--FOR HOVER-->
		<span class = "choice">
				<span>
				<b><font size = '5px'>FIELD LABEL<br></font></b>
					
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
			'action' => Url::to(['users/deflayoutchoice2']),
			]); 
	?>
		<li>
		<?= Html::img('@web/img/labels/harvestlabels5.png', ['alt'=>'some', 'class'=>'choice', 'width'=>300]);?> 
		<!--FOR HOVER-->
		<span class = "choice2">
				<span>
				<b><font size = '5px'>HARVEST LABEL<br></font></b>
				
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
			'action' => Url::to(['users/deflayoutchoice3']),
			]); 
	?>
		<li>
		<?= Html::img('@web/img/labels/shelflabels4.png', ['alt'=>'some', 'class'=>'choice','width'=>300]);?> 
		<!--FOR HOVER-->
		<span class = "choice3">
				<span>
				<b><font size = '5px'>SHELF LABEL<br></font></b>
					
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
			'action' => Url::to(['users/deflayoutchoice4']),
			]); 
	?>
		<li>
		<?= Html::img('@web/img/labels/traylabels4.png', ['alt'=>'some', 'class'=>'choice','width'=>300]);?> 
		<!--FOR HOVER-->
		<span class = "choice4">
				<span>
				<b><font size = '5px'>TRAY LABEL<br></font></b>
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
	</form>
	</div>
	
	<div id = "main_edit">
		<div id = "left_bar">
			<!--ADD TEXT BUTTON-->
			<button type="submit" title="Add Text" class="btn btn-default" data-toggle="modal" data-target="#text" id = "text_new_button"> </button>
			 
			
			 <?= Html::submitButton('', ['class' => 'btn btn-default','id'=> 'image_new_button', 'name' => 'Submit','onclick' => "popUp('viewupload')", 'title'=>'Upload Image']) ?>
			
			 
			<!--ADD QRCODE BUTTON-->
			<button type="submit" title="Add Qrcode" class="btn btn-default" data-toggle="modal" data-target="#qrcode" id = "qrcode_new_button"> </button>
			
			<!--ADD BAR CODE BUTTON-->
			<?= Html::submitButton('', ['class' => 'btn btn-default btn-lg','id'=> 'barcode_new_button', 'name' => 'Submit', 'onclick' => "popUp('viewbarcodepopup')", 'title'=>'Generate BarCode']) ?>
			
			
		</div>
		
		<div id = "custom_canvas">
			
			
			<br>
			<!-------------Draggable FUNCTIONS-------------->
			<!--------------DEF LAYOUT---------------------->
			<?php
			if($def_layout_num == 1){
					echo '<span style = "cursor:move">';
					Draggable::begin([
					'clientOptions' => ['grid' => [5, 5]],
					]);
					echo Html::img('@web/img/labels/'.$def_layout.'', ['alt'=>'some', 'class'=>'choice', 'width'=>'300']); 
					Draggable::end();
					echo '</span style>';
			
			}
			?>
			<!-------------UPLOADED IMAGE--------->
			<?php
			
			if($upload_num >= 1){
				$cnt = 0;
				$image_array = explode(',', $upload_image); //SPLIT TEXT
				while($cnt!=$upload_num){
					echo '<span style = "cursor:move">';
					Draggable::begin([
					'clientOptions' => ['grid' => [5, 5]],
					]);
					echo Html::img('@web/uploads/'.$image_array[$cnt].'', ['alt'=>'some', 'class'=>'choice','width'=>100, 'title'=> $image_array[$cnt]]);
					Draggable::end();
					$cnt++;
					echo '</span>';
				}//end of while loop
			}
			?>
			
			
			
			<!-------------ADD QRCODE IMAGE--------->
			<?php
			if($qrcode_num >= 1){
				$cnt = 0;
				$qrcode_array = explode(',', $text_qrcode); //SPLIT TEXT
				while($cnt!=$qrcode_num){
					echo '<span style = "cursor:move">';
					Draggable::begin([
					'clientOptions' => ['grid' => [5, 5]],
					]);
					echo '<img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl='.$qrcode_array[$cnt].'&choe=UTF-8" title="QR Code of '.$qrcode_array[$cnt].'" height = "50" width = "50" />';
					Draggable::end();
					$cnt++;
					echo '</span>';
				}//end of while loop
			}
			?>
			
			<!-------------ADD BARCODE IMAGE--------->
			<?php
			if($barcode_num >= 1){
				$cnt = 0;
				$barcode_array = explode(',', $text_barcode); //SPLIT TEXT
				while($cnt!=$barcode_num){
					echo '<span style = "cursor:move">';
					Draggable::begin([
					'clientOptions' => ['grid' => [5, 5]],
					]);
					echo '<img src = "http://www.barcodesinc.com/generator/image.php?code='.$barcode_array[$cnt].'&style=197&type=C128B&width=170&height=73&xres=1&font=5" title="BarCode of '.$barcode_array[$cnt].'"  />';
					Draggable::end();
					$cnt++;
					echo '</span>';
				}//end of while loop
			}
			?>
			
			
			<!-------------TEXT--------->
			<?php
			$cnt = 0;
			$text_array = explode(',', $text); //SPLIT TEXT
			while($cnt!=$text_num){
					echo '<span style = "cursor:move">';
					Draggable::begin([
					'clientOptions' => ['grid' => [5, 5]],
					]);
						echo $text_array[$cnt]; 	//access every array element
					Draggable::end();
					$cnt++;
					echo '</span>';
			}//end of while loop
			?>
			
		</div>
		</div>
		 <button class ="btn btn-info btn-lg" id = "generate" title = "print or save as PDF"onclick="printDiv('custom_canvas')">GENERATE</button>
	</div>
	
	<!-- Modal FOR ADD TEXT -->
	 <div class="modal fade" id="text" role="dialog"">
		<div class="modal-dialog">
		
		  <!-- Modal TEXT-->
		  <div class="modal-content" style="width:300px;">
			<div class="modal-header"  style="height:50px;">
			  
			  <button type="button" class="btn btn-default" style="margin-left:220px;" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
			
			</div>
			
			<div class="modal-body" >
				<?php $form = ActiveForm::begin([
						'id' => 'select-form',
						'method' => 'get',
						'action' => Url::to(['users/addtext']),
						]); 
				?>
				<script src="//tinymce.cachefly.net/4.2/tinymce.min.js"></script>
				<script>tinymce.init({selector:'textarea'});</script>

				<textarea name = "addtext" style="overflow:scroll;resize:none;margin-left:20px;" rows="12" cols="40"></textarea>
				

				<!--ADD TEXT BUTTON-->
				 <?= Html::submitButton('ADD TEXT', ['class' => 'btn btn-warning', 'id'=> 'add_text_button', 'name' => 'Submit']) ?>
				
							
				<? ActiveForm::end();?>
			</div>
			
		  </div>
		</div>
	</div>

	<!-- END Modal FOR ADDTEXT-->
	
	<!-- Modal FOR UPLOAD IMAGE -->
	  <div class="modal fade" id="image" role="dialog"">
		<div class="modal-dialog">
		
		  <!-- Modal UPLOAD IMAGE-->
		  <div class="modal-content" style="width:300px;">
			<div class="modal-header"  style="height:50px;">
			  
			  <button type="button" class="btn btn-default" style="margin-left:220px;" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
			
			</div>
			
			<div class="modal-body" >
			<?php $form = ActiveForm::begin([
					'action' => Url::to(['users/upload']),
					'options' => 
						['enctype' => 'multipart/form-data']
					]) ?>

			<?= $form->field($model, 'imageFile')->fileInput() ?>

			<button class = "btn btn-warning btn-lg" style = "width:150px;height:40px;">UPLOAD</button>

			<?php ActiveForm::end() ?>
				
				
				
			</div>
			
		  </div>
		  </div>
	</div>
	<!-- END Modal FOR UPLOAD IMAGE-->
	
	<!-- Modal FOR ADD QRCODE -->
	 <div class="modal fade" id="qrcode" role="dialog"">
		<div class="modal-dialog">
		
		  <!-- Modal QRCODE-->
		  <div class="modal-content" style="width:300px;">
			<div class="modal-header"  style="height:50px;">
			  
			  <button type="button" class="btn btn-default" style="margin-left:220px;" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
			
			</div>
			
			<div class="modal-body" >
				 <?php $form = ActiveForm::begin([
				'id' => 'select-form',
				'method' => 'get',
				'action' => Url::to(['users/addqrcode']),
				]); 
				?>
				<textarea name = "text_qrcode"style="overflow:scroll;resize:none;margin-left:20px;" rows="12" cols="40"></textarea>
				<!--ADD QR CODE BUTTON-->
				 <?= Html::submitButton('GENERATE', ['class' => 'btn btn-default', 'id'=> 'add_qrcode_button', 'name' => 'Submit']) ?>
				<? ActiveForm::end();?>
			</div>
			
		  </div>
		</div>
	</div>

	<!-- END Modal FOR QRCODE-->
	
	
	
	
			
</body>		
</html>
	
	