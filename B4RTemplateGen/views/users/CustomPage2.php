<!---CUSTOM PAGE2: THIS IS THE PAGE FOR THE CUSTOM LAYOUTS (DYNAMIC CREATION OF TEMPLATES)-->

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
			$('#tools').hide().removeClass('hide');
			

			$('#custom_add').click(function(event){
				$("#tools").show();
				event.preventDefault();
			});
			$('#close_tools').click(function(event){
				$("#tools").hide();
				event.preventDefault();
			});
			
			$('#add_text').appendTo("body") 
			$('#upload').appendTo("body") 
			$('#addqrcode').appendTo("body") 
			$('#addbarcode').appendTo("body") 
			$('#saved').appendTo("body") 
			
		//HEIGHT OF CANVAS 
		var height_canvas = parseInt("<?php echo $height_canvas; ?>");
		var tf_x = '';
		var tf_y = '';
		var cnt = 0;
		var tf_num = parseInt("<?php echo $textfield_num; ?>");
		
		//CANVAS
		
		$('#canvas_img').resizable({
			stop: function( event, ui ) {
				height = $("#canvas_img").height(); 
				width = $("#canvas_img").width(); 
				document.getElementById('can_h').value = height;
				document.getElementById('can_w').value = width;
				
			}
			
		});
		
		//QRCODE 
		
		var qr_x_start = parseInt("<?php echo $qrcode_x; ?>");
		var qr_y_start = parseInt("<?php echo $qrcode_y; ?>");
		
		$('#qrcode_resize').resizable({
			aspectRatio: true,
			stop: function( event, ui ) {
				height = $("#qrcode_resize").height(); 
				width = $("#qrcode_resize").width(); 
				document.getElementById('qr_h').value = height;
				document.getElementById('qr_w').value = width;
			}
			
		});
		
		
		$('#qrcode').draggable(
		{
			drag: function (){
			 
			var offset = $(this).position();
			qrcode_x = offset.left+qr_x_start;
			qrcode_y = (offset.top)+qr_y_start;
			
			document.getElementById('qr_x').value = qrcode_x;
			document.getElementById('qr_y').value = qrcode_y;
			}
		});
		
		//BARCODE
		var bar_x_start = parseInt("<?php echo $barcode_x; ?>");
		var bar_y_start = parseInt("<?php echo $barcode_y; ?>");
		
			
		$('#barcode_resize').resizable({
			stop: function( event, ui ) {
				height = $("#barcode_resize").height(); 
				width = $("#barcode_resize").width(); 
				document.getElementById('bar_h').value = height;
				document.getElementById('bar_w').value = width;
			}
		});
		
		//BARCODE: get the x and y coordinates
		$('#barcode').draggable({
				drag: function (){
				var offset = $(this).position();
				var barcode_x = offset.left+bar_x_start;
				var barcode_y = (offset.top)+bar_y_start;
				
				document.getElementById('bar_x').value = barcode_x;
				document.getElementById('bar_y').value = barcode_y;
			}
		});
		var upload_cnt_custom = parseInt("<?php echo $upload_cnt_custom; ?>");
		var temp_x = "<?php echo $img_x; ?>";
		var img_x_start = temp_x.split(',');
		var cnt;
		var temp_y = "<?php echo $img_y; ?>";
		var img_y_start = temp_y.split(',');
		
		for(cnt =img_x_start.length-1; cnt<upload_cnt_custom;cnt++){
			img_x_start[cnt] = '0';
			img_y_start[cnt] = '0';
		}
		
		
		//document.getElementById('try').value = img_y_start[0];
			$('#img_drag_0').draggable(
			{
				drag: function (){
				 
				var offset = $(this).position();
				img_x = offset.left+parseInt(img_x_start[0]);
				img_y = (offset.top)+parseInt(img_y_start[0]);
				
				document.getElementById('img_x_0').value = img_x;
				document.getElementById('img_y_0').value = img_y;
				  
				}
			});
			
			$('#img_0').resizable({
				stop: function( event, ui ) {
					height = $('#img_0').height(); 
					width = $('#img_0').width(); 
					document.getElementById('img_h_0').value = height;
					document.getElementById('img_w_0').value = width;
				}
			});
			
			$('#img_drag_1').draggable(
			{
				drag: function (){
				 
				var offset = $(this).position();
				img_x = offset.left+parseInt(img_x_start[1]);
				img_y = (offset.top)+parseInt(img_y_start[1]);
				
				document.getElementById('img_x_1').value = img_x;
				document.getElementById('img_y_1').value = img_y;
				  
				}
			});
			
			$('#img_1').resizable({
				stop: function( event, ui ) {
					height = $('#img_1').height(); 
					width = $('#img_1').width(); 
					document.getElementById('img_h_1').value = height;
					document.getElementById('img_w_1').value = width;
				}
			});
			
			$('#img_drag_2').draggable(
			{
				drag: function (){
				 
				var offset = $(this).position();
				img_x = offset.left+parseInt(img_x_start[2]);
				img_y = (offset.top)+parseInt(img_y_start[2]);
				
				document.getElementById('img_x_2').value = img_x;
				document.getElementById('img_y_2').value = img_y;
				  
				}
			});
			
			$('#img_2').resizable({
				stop: function( event, ui ) {
					height = $('#img_2').height(); 
					width = $('#img_2').width(); 
					document.getElementById('img_h_2').value = height;
					document.getElementById('img_w_2').value = width;
				}
			});
			
			$('#img_drag_3').draggable(
			{
				drag: function (){
				 
				var offset = $(this).position();
				img_x = offset.left+parseInt(img_x_start[3]);
				img_y = (offset.top)+parseInt(img_y_start[3]);
				
				document.getElementById('img_x_3').value = img_x;
				document.getElementById('img_y_3').value = img_y;
				  
				}
			});
			
			$('#img_3').resizable({
				stop: function( event, ui ) {
					height = $('#img_3').height(); 
					width = $('#img_3').width(); 
					document.getElementById('img_h_3').value = height;
					document.getElementById('img_w_3').value = width;
				}
			});
			
			$('#img_drag_4').draggable(
			{
				drag: function (){
				 
				var offset = $(this).position();
				img_x = offset.left+parseInt(img_x_start[4]);
				img_y = (offset.top)+parseInt(img_y_start[4]);
				
				document.getElementById('img_x_4').value = img_x;
				document.getElementById('img_y_4').value = img_y;
				  
				}
			});
			
			
			$('#img_4').resizable({
				stop: function( event, ui ) {
					height = $('#img_4').height(); 
					width = $('#img_4').width(); 
					document.getElementById('img_h_4').value = height;
					document.getElementById('img_w_4').value = width;
				}
			});
			
			$('#img_drag_5').draggable(
			{
				drag: function (){
				 
				var offset = $(this).position();
				img_x = offset.left+parseInt(img_x_start[5]);
				img_y = (offset.top)+parseInt(img_y_start[5]);
				
				document.getElementById('img_x_5').value = img_x;
				document.getElementById('img_y_5').value = img_y;
				  
				}
			});
			
			$('#img_5').resizable({
				stop: function( event, ui ) {
					height = $('#img_5').height(); 
					width = $('#img_5').width(); 
					document.getElementById('img_h_5').value = height;
					document.getElementById('img_w_5').value = width;
				}
			});
			
			$('#img_drag_6').draggable(
			{
				drag: function (){
				 
				var offset = $(this).position();
				img_x = offset.left+parseInt(img_x_start[6]);
				img_y = (offset.top)+parseInt(img_y_start[6]);
				
				document.getElementById('img_x_6').value = img_x;
				document.getElementById('img_y_6').value = img_y;
				  
				}
			});
			
			$('#img_6').resizable({
				stop: function( event, ui ) {
					height = $('#img_6').height(); 
					width = $('#img_6').width(); 
					document.getElementById('img_h_6').value = height;
					document.getElementById('img_w_6').value = width;
				}
			});
			
		
			$('#img_drag_8').draggable(
			{
				drag: function (){
				 
				var offset = $(this).position();
				img_x = offset.left+parseInt(img_x_start[8]);
				img_y = (offset.top)+parseInt(img_y_start[8]);
				
				document.getElementById('img_x_8').value = img_x;
				document.getElementById('img_y_8').value = img_y;
				  
				}
			});
			
			$('#img_7').resizable({
				stop: function( event, ui ) {
					height = $('#img_7').height(); 
					width = $('#img_7').width(); 
					document.getElementById('img_h_7').value = height;
					document.getElementById('img_w_7').value = width;
				}
			});
			
			$('#img_drag_8').draggable(
			{
				drag: function (){
				 
				var offset = $(this).position();
				img_x = offset.left+parseInt(img_x_start[8]);
				img_y = (offset.top)+parseInt(img_y_start[8]);
				
				document.getElementById('img_x_8').value = img_x;
				document.getElementById('img_y_8').value = img_y;
				  
				}
			});
			$('#img_8').resizable({
				stop: function( event, ui ) {
					height = $('#img_8').height(); 
					width = $('#img_8').width(); 
					document.getElementById('img_h_8').value = height;
					document.getElementById('img_w_8').value = width;
				}
			});
			
			$('#img_drag_9').draggable(
			{
				drag: function (){
				 
				var offset = $(this).position();
				img_x = offset.left+parseInt(img_x_start[9]);
				img_y = (offset.top)+parseInt(img_y_start[9]);
				
				document.getElementById('img_x_9').value = img_x;
				document.getElementById('img_y_9').value = img_y;
				  
				}
			});
			
			$('#img_9').resizable({
				stop: function( event, ui ) {
					height = $('#img_9').height(); 
					width = $('#img_9').width(); 
					document.getElementById('img_h_9').value = height;
					document.getElementById('img_w_9').value = width;
				}
			});
			
		cnt = 0;
		//TEXTFIELD
		//var tf_x_start = 0;//parseInt("<?php echo $tf_x; ?>");
		//var tf_y_start = 0;//parseInt("<?php echo $tf_y; ?>");
	
		var x = "<?php echo $tf_x; ?>";				//di niya nakukuha iyong tf_x
		var tf_x_start = x.split(',');
		
		
		var y = "<?php echo $tf_y; ?>";
		var tf_y_start = y.split(',');
		
		
		var prev_0_x = document.getElementById('tf_0_x').value;
		var prev_0_y = document.getElementById('tf_0_y').value;
		
		
		//TEXTFIELD DRAGGABLE
			$('#tf_drag_0').draggable(
			{
				
				drag: function (){
				var offset = $(this).position();
				
				if(isNaN(prev_0_x)){
					prev_0_x = '0';
				}
				if(isNaN(prev_0_y)){
					prev_0_y = '0';
				}
				
				tf_x = offset.left+parseInt(prev_0_x);
				tf_y = (offset.top)+parseInt(prev_0_y);
				
				document.getElementById('tf_0_x').value = tf_x;
				document.getElementById('tf_0_y').value = tf_y;
				
				}
			});
			
		
			$('#tf_drag_1').draggable(
			{
				drag: function (){
				var offset = $(this).position();
				
				
				tf_x = offset.left;
				tf_y = (offset.top);
				document.getElementById('tf_1_x').value = tf_x;
				document.getElementById('tf_1_y').value = tf_y;
				
				}
			});
			
			$('#tf_drag_2').draggable(
			{
				drag: function (){
				var offset = $(this).position();
				tf_x = offset.left;
				tf_y = (offset.top);
				
				document.getElementById('tf_2_x').value = tf_x;
				document.getElementById('tf_2_y').value = tf_y;
				
				}
			});
			
			$('#tf_drag_3').draggable(
			{
				drag: function (){
				var offset = $(this).position();
				tf_x = offset.left+tf_x_start;
				tf_y = (offset.top)+tf_y_start;
				
				document.getElementById('tf_3_x').value = tf_x;
				document.getElementById('tf_3_y').value = tf_y;
				
				}
			});
		
			$('#tf_drag_4').draggable(
			{
				drag: function (){
				var offset = $(this).position();
				tf_x = offset.left+tf_x_start;
				tf_y = (offset.top)+tf_y_start;
				
				document.getElementById('tf_4_x').value = tf_x;
				document.getElementById('tf_4_y').value = tf_y;
				
				}
			});
			
			$('#tf_drag_5').draggable(
			{
				drag: function (){
				var offset = $(this).position();
				tf_x = offset.left+tf_x_start;
				tf_y = (offset.top)+tf_y_start;
				
				document.getElementById('tf_5_x').value = tf_x;
				document.getElementById('tf_5_y').value = tf_y;
				
				}
			});
			
			$('#tf_drag_5').draggable(
			{
				drag: function (){
				var offset = $(this).position();
				tf_x = offset.left+tf_x_start;
				tf_y = (offset.top)+tf_y_start;
				
				document.getElementById('tf_5_x').value = tf_x;
				document.getElementById('tf_5_y').value = tf_y;
				
				}
			});
			
			$('#tf_drag_6').draggable(
			{
				drag: function (){
				var offset = $(this).position();
				tf_x = offset.left+tf_x_start;
				tf_y = (offset.top)+tf_y_start;
				
				document.getElementById('tf_6_x').value = tf_x;
				document.getElementById('tf_6_y').value = tf_y;
				
				}
			});
			
			$('#tf_drag_7').draggable(
			{
				drag: function (){
				var offset = $(this).position();
				tf_x = offset.left+tf_x_start;
				tf_y = (offset.top)+tf_y_start;
				
				document.getElementById('tf_7_x').value = tf_x;
				document.getElementById('tf_7_y').value = tf_y;
				
				}
			});
			
			$('#tf_drag_8').draggable(
			{
				drag: function (){
				var offset = $(this).position();
				tf_x = offset.left+tf_x_start;
				tf_y = (offset.top)+tf_y_start;
				
				document.getElementById('tf_8_x').value = tf_x;
				document.getElementById('tf_8_y').value = tf_y;
				
				}
			});
		
			$('#tf_drag_9').draggable(
			{
				drag: function (){
				var offset = $(this).position();
				tf_x = offset.left+tf_x_start;
				tf_y = (offset.top)+tf_y_start;
				
				document.getElementById('tf_9_x').value = tf_x;
				document.getElementById('tf_9_y').value = tf_y;
				
				}
			});
			
			
			
			$('#tf_0').resizable({
				stop: function( event, ui ) {
					height = $('#tf_0').height(); 
					width = $('#tf_0').width(); 
					document.getElementById('tf_h_0').value = height;
					document.getElementById('tf_w_0').value = width;
				}
			});
			
			$('#tf_1').resizable({
				stop: function( event, ui ) {
					height = $('#tf_1').height(); 
					width = $('#tf_1').width(); 
					document.getElementById('tf_h_1').value = height;
					document.getElementById('tf_w_1').value = width;
				}
			});
			
			$('#tf_2').resizable({
				stop: function( event, ui ) {
					height = $('#tf_2').height(); 
					width = $('#tf_2').width(); 
					document.getElementById('tf_h_2').value = height;
					document.getElementById('tf_w_2').value = width;
				}
			});
			
			$('#tf_3').resizable({
				stop: function( event, ui ) {
					height = $('#tf_3').height(); 
					width = $('#tf_3').width(); 
					document.getElementById('tf_h_3').value = height;
					document.getElementById('tf_w_3').value = width;
				}
			});
			
			$('#tf_4').resizable({
				stop: function( event, ui ) {
					height = $('#tf_4').height(); 
					width = $('#tf_4').width(); 
					document.getElementById('tf_h_4').value = height;
					document.getElementById('tf_w_4').value = width;
				}
			});
			
			$('#tf_5').resizable({
				stop: function( event, ui ) {
					height = $('#tf_5').height(); 
					width = $('#tf_5').width(); 
					document.getElementById('tf_h_5').value = height;
					document.getElementById('tf_w_5').value = width;
				}
			});
			
			$('#tf_6').resizable({
				stop: function( event, ui ) {
					height = $('#tf_6').height(); 
					width = $('#tf_6').width(); 
					document.getElementById('tf_h_6').value = height;
					document.getElementById('tf_w_6').value = width;
				}
			});
			
			$('#tf_7').resizable({
				stop: function( event, ui ) {
					height = $('#tf_7').height(); 
					width = $('#tf_7').width(); 
					document.getElementById('tf_h_7').value = height;
					document.getElementById('tf_w_7').value = width;
				}
			});
			
			$('#tf_8').resizable({
				stop: function( event, ui ) {
					height = $('#tf_8').height(); 
					width = $('#tf_8').width(); 
					document.getElementById('tf_h_8').value = height;
					document.getElementById('tf_w_8').value = width;
				}
			});
			
			$('#tf_9').resizable({
				stop: function( event, ui ) {
					height = $('#tf_9').height(); 
					width = $('#tf_9').width(); 
					document.getElementById('tf_h_9').value = height;
					document.getElementById('tf_w_9').value = width;
				}
			});
			})
		</script>
		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
</head>

<body>
	
	<div id = "all">
		
	
		<!------------------SIDE BAR------------->
		<div id ="custom_side_bar">
		<br>
		<ul class= "img-list">
		
		<!--------ADD button-------->
		<li>
			<button type="button" title="Add" class="btn btn-default" id = "custom_add">  <span id ="custom_icon" class="glyphicon glyphicon-plus"></span> </button>
		</li>
		
		<!--------SAVE DRAFT BUTTON---------->
		<li>
		  <?php $form = ActiveForm::begin([
				'id' => 'select-form',
				'method' => 'get',
				'action' => Url::to(['users/savetemplate']),
				]); 
				
				echo '<input type="hidden" id="try" name="try" value=""></input>';
			//CANVAS
			echo '<input type="hidden" id="can_h" name="can_h" value="'.$height_canvas.'"></input>';
			echo '<input type="hidden" id="can_w"  name="can_w" value="'.$width_canvas.'"/>';
			
			
			//TEXTFIELD 
		$textfield_x_array = explode(',', $tf_x);					//SPLIT TEXT
		$textfield_y_array = explode(',', $tf_y);					//SPLIT TEXT
		$textfield_h_array = explode(',', $height_textfield);		//SPLIT TEXT
		$textfield_w_array = explode(',', $width_textfield);		//SPLIT TEXT
		
		$cnt=0;
		while($cnt!=$textfield_num){
			echo '<input type="hidden" id="tf_'.$cnt.'_x" name="tf_'.$cnt.'_x"  value="'.$textfield_x_array[$cnt].'" />';
			echo '<input type="hidden" id="tf_'.$cnt.'_y" name="tf_'.$cnt.'_y"  value="'.$textfield_y_array[$cnt].'" />';
			
			echo '<input type="hidden" id="tf_h_'.$cnt.'" name="tf_h_'.$cnt.'"  value="'.$textfield_h_array[$cnt].'" />';
			echo '<input type="hidden" id="tf_w_'.$cnt.'" name="tf_w_'.$cnt.'"  value="'.$textfield_w_array[$cnt].'" />';
			
			$cnt++;
		}
			
			//QRCODE
			echo '<input type="hidden" id="qr_h" name="qr_h" value="'.$height_qrcode.'"></input>';
			echo '<input type="hidden" id="qr_w"  name="qr_w" value="'.$width_qrcode.'"/>';
			echo '<input type="hidden" id="qr_x" name="qr_x" value="'.$qrcode_x.'"></input>';
			echo '<input type="hidden" id="qr_y"  name="qr_y" value="'.$qrcode_y.'"/>';
			
			//BARCODE
			echo '<input type="hidden" id="bar_h" name="bar_h"  value="'.$height_barcode.'" />';
			echo '<input type="hidden" id="bar_w" name="bar_w"  value="'.$width_barcode.'" />';
			echo '<input type="hidden" id="bar_x" name="bar_x"  value="'.$barcode_x.'" />';
			echo '<input type="hidden" id="bar_y" name="bar_y"  value="'.$barcode_y.'" />';
		

			
			
		
		$cnt=0;
		
			$image_array_height = explode(',', $image_height); 
			$image_array_width = explode(',', $image_width);
			$image_array_x = explode(',', $img_x); 
			$image_array_y = explode(',', $img_y);
					
		while($cnt!=$upload_cnt_custom){
			echo '<input type="hidden" id="img_x_'.$cnt.'" name="img_x_'.$cnt.'"  value="'.$image_array_x[$cnt].'" />';
			echo '<input type="hidden" id="img_y_'.$cnt.'" name="img_y_'.$cnt.'"  value="'.$image_array_y[$cnt].'" />';
			echo '<input type="hidden" id="img_h_'.$cnt.'" name="img_h_'.$cnt.'"  value="'.$image_array_height[$cnt].'" />';
			echo '<input type="hidden" id="img_w_'.$cnt.'" name="img_w_'.$cnt.'"  value="'.$image_array_width[$cnt].'" />';
			$cnt++;
		}
		
		
			echo '<button type="submit" title="Save as Draft" class="btn btn-default" id = "custom_buttons_add" data-toggle="modal" data-target="#saved">  <span id ="custom_icon" class="glyphicon glyphicon-save" style="font-size:20px;"></span> </button>';
	
			ActiveForm::end() ?>
		</li>
		
		<!--------TRANSFER TO DEFINED Template---------->
		<li>
			<?php $form = ActiveForm::begin([
				'id' => 'select-form',
				//'method' => 'get',
				'action' => Url::to(['users/transfer']),
				]); 
			?>
			<button type="submit" title="Transfer to Defined" class="btn btn-default" id = "custom_buttons_add">  <span id ="custom_icon" class="glyphicon glyphicon-transfer"></span> </button>
		 
			<?php ActiveForm::end() ?>
		</li>
		<!---DELETE-->
		
		<li>
			<?php $form = ActiveForm::begin([
				'id' => 'select-form',
				//'method' => 'get',
				'action' => Url::to(['users/reset']),
				]); 
			?>
			<button type="submit" title="Delete" class="btn btn-default" id = "custom_buttons_add">  <span id ="custom_icon" class="glyphicon glyphicon-trash"></span> </button>
		 
			<?php ActiveForm::end() ?>
		</li>
	</ul>
		
	</div>
	
	<div id = "info_div">
		
			<span style="font-size:2.0em;" class="glyphicon glyphicon-text-size"></span>
			<br><br>
			
			<span style="font-size:2.0em;" class="glyphicon glyphicon-camera"></span>
			<br><br>
		
			<span style="font-size:2.0em;" class="glyphicon glyphicon-qrcode"></span>
			<br><br>
			
			<span style="font-size:2.0em;" class="glyphicon glyphicon-barcode"></span>
			
		<?php	
			if($textfield_num>=1){
				$textfield_attrib_array = explode(',', $attribute_textfield);		//SPLIT TEXT
				$cnt = 0;
				while($cnt!=$textfield_num){
					echo "<br><input type = 'checkbox' name = 'attrib_barcode[]' value =".$textfield_attrib_array[$cnt].">".$textfield_attrib_array[$cnt]."</input>";
					$cnt++;
				}
			}
			
		?>
		
		
	</div>
		
	<!--TOOLS-->
	<div id = "tools" class = "hide" >
			<div class="modal-header"  style="height:50px;">
			  <button id = "close_tools" type="button" class="btn btn-default" style="margin-left:130px;height:30px;" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
			
			</div>
		<ul class= "img-list">
		<!--------ADD TEXT FIELD BUTTON---------->
		<li>
			<button type="button" title="Add Text" class="btn btn-default" data-toggle="modal" data-target="#add_text" id = "custom_buttons"> <span style="font-size:3.5em;"  class="glyphicon glyphicon-text-size"></span></button>
		</li>
		<!--------UPLOAD IMAGE BUTTON---------->
		<li>
			  <button type="submit" title="Upload Image" class="btn btn-default" data-toggle="modal" data-target="#upload" id = "custom_buttons">  <span style="font-size:3.5em;" class="glyphicon glyphicon-camera"></span> </button>
		</li>
		
		<!--------ADD QRCODE BUTTON---------->
		<li>
		  <button type="submit" title="Add Qrcode" class="btn btn-default" data-toggle="modal" data-target="#addqrcode" id = "custom_buttons">  <span style="font-size:3.5em;" class="glyphicon glyphicon-qrcode"></span> </button>
		</li>
		
		<!--------ADD BARCODE BUTTON---------->
		<li>
	
		 <button type="submit" title="Add Barcode" class="btn btn-default" id = "custom_buttons" data-toggle="modal" data-target="#addbarcode">  <span style="font-size:3.5em;" class="glyphicon glyphicon-barcode"></span> </button>
		
		
		</li>
		</div>
	<!-------------------main div-------------------->
	<div id = "main_edit_custom" draggable = "true">
		<!--CANVAS-->
		
		<?php		
			/*echo '<span style = "cursor:move">';
					Draggable::begin([
						'clientOptions' => ['grid' => [5, 5]],
					]);*/
		echo'<div id = "canvas">';
			echo Html::img('@web/img/canvas.png', ['alt'=>'some', 'class'=>'choice','width'=>$width_canvas, 'height'=>$height_canvas, 'id'=>'canvas_img']);
		echo'</div>';
			//Draggable::end();
			//echo '</span style>';
			
		?>
		
		<!--TEXTFIELD-->
		<?php
		if($textfield_num>=1){
			$cnt = 0;
			$textfield_height_array = explode(',', $height_textfield);		//SPLIT TEXT
			$textfield_width_array = explode(',', $width_textfield);		//SPLIT TEXT
			$textfield_attrib_array = explode(',', $attribute_textfield);		//SPLIT TEXT
			$textfield_x_array = explode(',', $tf_x);		//SPLIT TEXT
			$textfield_y_array = explode(',', $tf_y);		//SPLIT TEXT
			$textfield_fs_array = explode(',', $font_size);		//SPLIT TEXT
			$textfield_ff_array = explode(',', $font_family);		//SPLIT TEXT
		
			while($cnt!=$textfield_num){
					echo '<span style = "cursor:move">';
					Draggable::begin([
						'clientOptions' => ['grid' => [5, 5]],
						]);
					
					$textfield_width_array[$cnt] = ($textfield_width_array[$cnt]).'px';
					$textfield_height_array[$cnt] = ($textfield_height_array[$cnt]).'px';
					
					echo '<div id = "tf_drag_'.$cnt.'"><input id = "tf_'.$cnt.'" type="text" style="font-family:'.$textfield_ff_array[$cnt].';font-size:'.$textfield_fs_array[$cnt].'px;position:relative;margin-left:'.$textfield_x_array[$cnt].'px;margin-top:'.$textfield_y_array[$cnt].'px;width:'.$textfield_width_array[$cnt].';height:'.$textfield_height_array[$cnt].';" placeholder='.$textfield_attrib_array[$cnt].'></input></div>';
					
					Draggable::end();
					echo '</span style>';
					
					$cnt++;
			}//end of while loop
		}
		?>
		
		<!--IMAGE-->
		<?php
				
				if($upload_cnt_custom >= 1){
					$cnt = 0;
					$image_array_custom = explode(',', $upload_image_custom); 
					$image_array_height = explode(',', $image_height); 
					$image_array_width = explode(',', $image_width);
					$image_array_x = explode(',', $img_x); 
					$image_array_y = explode(',', $img_y);
					
					//SPLIT TEXT
					while($cnt!=$upload_cnt_custom){
						echo '<span style = "cursor:move">';
						Draggable::begin([
						'clientOptions' => ['grid' => [5, 5]],
						]);
						
						$image_array_height[$cnt] = $image_array_height[$cnt];
						$image_array_width[$cnt] = $image_array_width[$cnt];
						
					
					echo '<div id = "img_drag_'.$cnt.'">';	
						echo Html::img('@web/uploads/'.$image_array_custom[$cnt].'', ['alt'=>'some','title'=> $image_array_custom[$cnt], 'width'=>$image_array_width[$cnt], 'height'=>$image_array_height[$cnt], 'id'=>'img_'.$cnt.'','style'=>'postion:relative;margin-left:'.$image_array_x[$cnt].'px;margin-top:'.$image_array_y[$cnt].'px;']);
					echo '</div>';
						
						
						Draggable::end();
						
						$cnt++;
						echo '</span>';
					}//end of while loop
				}
		?>
		<!--QRCODE-->
		
		<?php 
			if($custom_qrcode_num >= 1){
				echo '<span style = "cursor:move">';
						Draggable::begin([
						'clientOptions' => ['grid' => [5, 5]],
						]);
				if($textfield_num>=1&&(!empty($text_attrib_qrcode))){
						
						$text_qrcode = '';
						$text = explode(',', $text_attrib_qrcode);	
						$cnt=0;
						while($cnt!=count($text)){
							$text_qrcode = $text[$cnt].'|'.$text_qrcode;
							$cnt++;
						}
				}
				$height_qrcode = $height_qrcode;
				$width_qrcode = $width_qrcode;
				//$qrcode_y = 0;
				//$qrcode_x = 0;
				
			echo '<div id = "qrcode">';
				echo '<img id = "qrcode_resize" src = "http://chart.apis.google.com/chart?cht=qr&chs=200x200&chl='.$text_qrcode.'" title="QR Code" height = '.$height_qrcode.' width = '.$width_qrcode.' style="position:relative;margin-left:'.$qrcode_x.'px;margin-top:'.$qrcode_y.'px;"';
			
				Draggable::end();
				echo '</span></div>';
			}
		?>

		<!--BARCODE-->
		<?php 
		
			if($custom_barcode_num >= 1){
				echo '<span style = "cursor:move">';
						Draggable::begin([
						'clientOptions' => ['grid' => [5, 5]],
						]);
					
				$height_barcode = $height_barcode;
				$width_barcode = $width_barcode;
				//$barcode_x = 0;
				//$barcode_y = 0;
			
			echo '<div id = "barcode">';
				echo '<img id = "barcode_resize" src = "http://www.barcodesinc.com/generator/image.php?code='.$text_barcode.'&style=197&type=C128B&width=170&height=73&xres=1&font=5" title="Barcode of '.$text_barcode.'" height = '.$height_barcode.' width = '.$width_barcode.' style="position:relative;margin-left:'.$barcode_x.'px;margin-top:'.$barcode_y.'px;"';
				
				Draggable::end();
				echo '</span></div>';
			}
		?>
		</div>
	</div>	<!--end of main div-->
	
	
	 <!-- Modal FOR ADD TEXTFIELD -->
	  <div class="modal fade" id="add_text" role="dialog"">
		<div class="modal-dialog">
		
		  <!-- Modal content-->
		  <div class="modal-content" style="width:500px;">
		  <!-- Modal header-->
		  <div class="modal-header"  style="height:50px;">
			  <button type="button" class="btn btn-default" style="margin-left:420px;" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
		  </div>
		 <!-- Modal body-->
		 	<div class="modal-body">
			
				<?php 
				
				$form2 = ActiveForm::begin([
					'id' => 'select-form',
					'method' => 'get',
					'action' => Url::to(['users/textfielddetails']),
				]); 
	
				?>
				
				Enter textfield size:<br>
				<!--height-->
				<div class="col-xs-2">
					<input class= 'form-control' type = 'text' placeholder ='height' style = 'width:65px;' name = 'height_textfield'></input>
				</div>
				
				<!--width-->
				<div class="col-xs-2">
					<input type = 'text' class= 'form-control' placeholder ='width' style = 'width:65px;' name = 'width_textfield'></input>
				</div>
				
				<!--dimenstion: px;in;cm-->
				<div class="col-xs-2">
					<select class="form-control" name="dim" style="width:70px;">
						<option value="px">px</option>
						<option value="cm">cm</option>
						<option value="in">in</option>
					</select>
				</div>			
				
				<!--attribute-->
				<div class="col-xs-2" style="margin-left:0px;margin-right:40px;">
					<input type = 'text' class= 'form-control' placeholder ='attribute' style = 'width:120px;' name='attribute_textfield'></input>
				</div>
				<!--font size-->
				<div class="col-xs-3">
					<input type = 'text' class= 'form-control' placeholder ='font size' style = 'margin-top:10px;margin-right:-30px;width:85px;' name = 'font_size'></input>
				</div>
				
			
				<!--font family-->
				<div class="col-xs-2">
					<select class="form-control" name="font_family" style="margin-top:10px;width:200px;">
						<option style = "font-family:Times New Roman;" value="Times New Roman">Times New Roman</option>
						<option style = "font-family:Georgia;" value="Georgia">Georgia</option>
						<option style = "font-family:Palatino Linotype;" value="Palatino Linotype">Palatino Linotype</option>
						<option style = "font-family:Arial;" value="Arial">Arial</option>
						<option style = "font-family:Arial Black;" value="Arial Black">Arial Black</option>
						<option style = "font-family:Comic Sans MS;" value="Comic Sans MS">Comic Sans MS</option>
						<option style = "font-family:Impact;" value="Impact">Impact</option>
						<option style = "font-family:Lucida Sans Unicode;" value="Lucida Sans Unicode">Lucida Sans Unicode</option>
						<option style = "font-family:Tahoma;" value="Tahoma">Tahoma</option>
						<option style = "font-family:Trebuchet MS;" value="Trebuchet MS">Trebuchet MS</option>
						<option style = "font-family:Verdana;" value="Verdana">Verdana</option>
						<option style = "font-family:Courier New;" value="Courier New">Courier New</option>
						<option style = "font-family:Lucida Console;" value="Lucida Console">Lucida Console</option>
					</select>
				</div>

				<!--Submit button-->
				<div class="modal-footer" style="height:40px;margin-top:100px;">
				
				<?= Html::submitButton('OK', ['class' => 'btn btn-success', 'title'=>'Submit', 'id' => 'submit']) ?>
				
				<?php ActiveForm::end() ?>
				
			</div>
			
		  </div>
		  
		</div>
	  </div>
	<!-- END Modal FOR ADD TEXTFIELD-->
	
	
	<!-- Modal FOR UPLOAD -->
	  <div class="modal fade" id="upload" role="dialog"">
		<div class="modal-dialog">
		
		  <!-- Modal content-->
		  <div class="modal-content" style="width:300px;">
			<div class="modal-header"  style="height:50px;">
			  
			  <button type="button" class="btn btn-default" style="margin-left:220px;" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
			
			</div>
			
			<div class="modal-body" >
				<?php 	$form = ActiveForm::begin([
					'action' => Url::to(['users/customuploadimage']),
					'options' => 
						['enctype' => 'multipart/form-data',
						 'method' => 'get',
						],
				
						]);
						

						echo $form->field($model, 'imageFile')->fileInput();
						
						echo '<button type="submit" title="Upload Image" class="btn btn-success" style="margin-left:80px;margin-top:10px;">  <span style="font-size:1.5em;" class="glyphicon glyphicon-open"></span>UPLOAD </button>';
		
						ActiveForm::end(); ?>
				
				
			</div>
			
		  </div>
		  
		</div>
	<!-- END Modal FOR UPLOAD-->
	
	<!-- Modal FOR QRCODE -->
	  <div class="modal fade" id="addqrcode" role="dialog"">
		<div class="modal-dialog">
		
		  <!-- Modal content-->
		  <div class="modal-content" style="width:300px;">
			<div class="modal-header"  style="height:50px;">
			  
			  <button type="button" class="btn btn-default" style="margin-left:220px;" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
			
			</div>
			
			<div class="modal-body" >
				<?php 	$form2 = ActiveForm::begin([
						'id' => 'select-form',
						'method' => 'get',
						'action' => Url::to(['users/customaddqrcode']),
					]); 
					
					if($textfield_num>=1){
						$textfield_attrib_array = explode(',', $attribute_textfield);		//SPLIT TEXT
						
						$cnt = 0;
						while($cnt!=$textfield_num){
							echo "<br><input type = 'checkbox' name = 'attrib_qrcode[]' value =".$cnt.">".$textfield_attrib_array[$cnt]."</input>";
							$cnt++;
						}
					}
				
					echo "<input class = 'form-control' type = 'text' placeholder = 'text', style = 'width:250px;margin-left:3px;' name = 'text_qrcode'</input>";
					
					echo Html::submitButton('OK',['class'=>'btn btn-warning', 'style'=>'margin-left:100px;margin-top:10px;']);
					
					ActiveForm::end();?>
				
				
			</div>
			
		  </div>
		  
	</div>
	<!-- END Modal FOR QRCODE-->
	
	<!-- Modal FOR BARCODE -->
	  <div class="modal fade" id="addbarcode" role="dialog"">
		<div class="modal-dialog">
		
		  <!-- Modal content-->
		  <div class="modal-content" style="width:300px;">
			<div class="modal-header"  style="height:50px;">
			  
			  <button type="button" class="btn btn-default" style="margin-left:220px;" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
			
			</div>
			
			<div class="modal-body" >
				<?php 	$form2 = ActiveForm::begin([
						'id' => 'select-form',
						'method' => 'get',
						'action' => Url::to(['users/customaddbarcode']),
					]); 
					
				
					echo "<input class = 'form-control' type = 'text' placeholder = 'text', style = 'width:250px;margin-left:3px;' name = 'text_barcode'</input>";
					
					echo Html::submitButton('OK',['class'=>'btn btn-warning', 'style'=>'margin-left:100px;margin-top:10px;']);
					
					ActiveForm::end();?>
				
				
			</div>
			
		  </div>
		  
	</div>
	<!-- END Modal FOR BARCODE-->
	
	<!-- Modal FOR SAVE -->
	  <div class="modal fade" id="saved" role="dialog"">
		<div class="modal-dialog">
		
		  <!-- Modal content-->
		  <div class="modal-content" style="width:300px;">
			<div class="modal-header"  style="height:50px;">
			
			</div>
			
			<div class="modal-body" >
				<p style="font-family:Arial;font-size:18px;">Draft successfully <b>SAVED!<b></p>
				
			</div>
			
		  </div>
		  
		</div>
	<!-- END Modal FOR save-->
	
	
	

	

</body>
</html>
	
	