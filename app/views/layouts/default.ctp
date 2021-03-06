<?php header("Content-Type: text/html; charset=utf-8");?><?php echo $html->doctype('html4-strict');?>
<html>
<head>
	<?php echo $html->charset('utf-8');?>
	<link rel="shortcut icon" href="/favicon.ico" />
	<title><?php echo $title_for_layout; ?></title>
	<?php echo $html->css('blueprint/screen', 'stylesheet', array('media'=>'screen, projection'));?>
	<?php echo $html->css('blueprint/plugins/fancy-type/screen', 'stylesheet', array('media'=>'screen, projection'));?>
	<?php echo $html->css('blueprint/print.css', 'stylesheet', array('media'=>'print'));?>

	<?php echo $html->css('button');?>
	<?php echo $html->css('style');?>	

	<?php echo $javascript->link('jquery', true);?>
	<?php echo $javascript->link('flashmessage', true);?>

	<?php echo $scripts_for_layout;?>

  <!--[if IE]><?php echo $html->css('blueprint/ie', 'stylesheet', array('media'=>'screen, projection'));?><![endif]-->
</head>
<body>
	<div class="container" id="overall">  
		<div id="navigation">
		
			<div style="float:right;text-align:right; font-size:11px; padding-right:10px;">
				<?php echo $this->element('switch_language');?>
			</div>
		
			<div id="navigation_box">
				<?php echo $this->element('navigation');?>
			</div>
		</div>
		
		<hr style="margin-bottom:5px;"/>
	
		<?php $session->flash();?>
	
		<div class="span-4" style="padding:5px;">
			<?php echo $this->element('sidebar');?>
		</div>
	
		<div class="span-18 last" id="content">
			<!-- Content goes here //-->
			<?php echo $content_for_layout;?>
		</div>
		
		<br style="clear:both;" />
		<br style="clear:both;" />
		<br style="clear:both;" />
		<?php echo $this->element('footer');?>
	</div>
<?php echo $this->element('user_tracking');?>	
</body>
</html>