<?php header("Content-Type: text/html; charset=utf-8");?><?php echo $html->doctype('html4-strict');?>
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
		<?php echo $html->css('thickbox');?>
		
		<?php echo $javascript->link('jquery', true);?>
		<?php echo $javascript->link('flashmessage', true);?>
		<?php echo $javascript->link('swfobject', true);?>

		<?php echo $scripts_for_layout;?>
  <!--[if IE]><?php echo $html->css('blueprint/ie', 'stylesheet', array('media'=>'screen, projection'));?><![endif]-->
</head>
<body>
<?php $session->flash();?>
	<div style="text-align:left; float:left;">
	<?php echo $html->link(__('back_to_home', true), '/', array('style'=>'color:white; text-decoration:none;'));?>
	</div>
  <div class="container">  
	<?php echo $content_for_layout;?>
  </div>
  
<?php echo $this->element('user_tracking');?>  
</body>
</html>