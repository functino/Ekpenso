<?php header("Content-Type: text/html; charset=utf-8");?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<?php echo $html->charset('utf-8');?>
	<link rel="shortcut icon" href="/favicon.ico" />
	<title><?php echo $title_for_layout;?></title>
  		<?php echo $html->css('blueprint/screen', 'stylesheet', array('media'=>'screen, projection'));?>
		<?php echo $html->css('blueprint/plugins/fancy-type/screen', 'stylesheet', array('media'=>'screen, projection'));?>
		<?php echo $html->css('blueprint/print.css', 'stylesheet', array('media'=>'print'));?>
		
		<?php echo $html->css('button');?>
		<?php echo $html->css('style');?>
		
		<?php echo $javascript->link('jquery', true);?>
		<?php echo $javascript->link('flashmessage', true);?>

  <!--[if IE]><?php echo $html->css('blueprint/ie', 'stylesheet', array('media'=>'screen, projection'));?><![endif]-->
<style type="text/css">
#overall
{
	background-image:none;
}
#navigation 
{
	text-align:center;
	padding-top:3px;
}
</style>
</head>
<body>
  <div class="container" id="overall">  
  
  

<div id="navigation">
	<div id="navigation_box">
	<?php echo $html->image('layout/logo.png');?>
	</div>
</div>

	<hr style="margin-bottom:5px;"/>
	<?php $session->flash();?>
	<div class="span-22 last" id="content">
	<?php echo $content_for_layout;?>
	</div>
	<br style="clear:both;" />
	<br style="clear:both;" />
	<div style="text-align:right; font-size:11px; padding-right:10px;">
			<?php echo $html->link(__('back_to_home', true), '/');?>
	</div>
	<br style="clear:both;" />
		
  </div>
  <?php echo $this->element('user_tracking');?>
</body>
</html>