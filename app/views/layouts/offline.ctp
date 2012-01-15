<?php header("Content-Type: text/html; charset=utf-8");?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8" />
	<title>Mindmap</title>
  		<?php echo $html->css('blueprint/screen', 'stylesheet', array('media'=>'screen, projection'));?>
		<?php echo $html->css('blueprint/plugins/fancy-type/screen', 'stylesheet', array('media'=>'screen, projection'));?>
		<?php echo $html->css('blueprint/print.css', 'stylesheet', array('media'=>'print'));?>
		
		<?php echo $html->css('button');?>
		<?php echo $html->css('style');?>
		<?php echo $html->css('thickbox');?>
		
		<?php echo $javascript->link('jquery', true);?>
		<?php echo $javascript->link('flashmessage', true);?>
		<?php echo $javascript->link('thickbox', true);?>

  <!--[if IE]><?php echo $html->css('blueprint/ie', 'stylesheet', array('media'=>'screen, projection'));?><![endif]-->
  
  
  		<?php echo $javascript->link('gears_init', true);?>
		<?php echo $javascript->link('swfobject', true);?>
</head>
<body>
  <div class="container" id="overall">  
  	<div class="box" style="margin:0; padding:10px;">
	<?php echo $content_for_layout;?>
	</div>
  </div>
</body>
</html>