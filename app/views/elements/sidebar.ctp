<?php if($session->check('User')):?>
	<?php echo $html->link(sprintf(__('hello_user', true), $session->read('User.username')), '/users/hello', array('style'=>'font-weight:bold; font-size:14px;'));?> <br /> <br />
	
	<ul id="subnavigation">
		<li><?php echo $html->link(__('navigation.my_maps', true), '/mindmaps/');?></li>
		<li><?php echo $html->link(__('navigation.tags', true), '/mindmaps/tags');?></li>
		<li><?php echo $html->link(__('navigation.groups', true), '/users/my_groups');?></li>
		<li><?php echo $html->link(__('navigation.edit_user', true), '/users/edit');?></li>
	</ul>
	
	<br /><br />
	<?php echo $html->link(__('Gears.go_offline', true), '/gears/go_offline');?>
	<br /><br /><br />
	<?php echo $button->link(__('logout', true), 'icons/f/stop.png', '/users/logout', 'negative');?>	
<?php else:?>
	<?php echo $form->create('User', array('action'=>'login'));?>
		<?php echo $form->error('User.login', __('error.User.login.failed', true));?>
		<?php echo $form->label('User.email', __('User.email', true));?> 
		<?php echo $form->text('User.email');?> <br />
		<?php echo $form->label('User.password', __('User.password', true));?>
		<?php echo $form->password('User.password');?> <br />
		<?php echo $button->submit(__('login', true), 'icons/f/user_add.png');?>
		<?php echo $html->link(__('User.lost_password_short', true), '/users/request_password', array('style'=>'font-size:11px;'));?>
		<br /> <br />
		<?php echo $form->checkbox('User.auto_login');?> <?php echo $form->label('User.auto_login', __('User.auto_login', true), array('style'=>'font-weight:normal; font-size:10px;'));?>
<br />
		<?php echo $html->image('openid_small_logo.png');?> 
		<?php echo $html->link(__('Openid.notice', true), '/openid/login', array('style'=>'font-size:11px;'));?>
	<?php echo $form->end();?>
	<br /><br /><br /><br /><br />
	<?php echo $button->link(__('register', true), 'icons/f/user_add.png', '/users/register', 'positive');?>		
<?php endif;?>



<br /> <br /> <br />


<b class="feedback_form_toggle"><?php __('Feedback.feedback');?></b>
<form action="<?php echo $html->url('/feedback/'); ?>" method="post" id="feedback_form">
	<table style="font-size:13px; width:300px; background-color:#efefef; margin-top:100px;">
		<tr>
			<th colspan="2">
				<?php __('Feedback.feedback');?>
			</th>
		</tr>
		<?php if(!$session->check('User')):?>
		<tr>
			<td>
				<?php echo $form->label('Feedback/name', __('Feedback.name', true));?>
			</td>
			<td>
			 	<?php echo $form->text('Feedback/name');?>
				<?php echo $form->error('Feedback/name');?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $form->label('Feedback/email', __('Feedback.email', true));?>
			</td>
			<td>
			 	<?php echo $form->text('Feedback/email');?>
				<?php echo $form->error('Feedback/email');?>
			</td>
		</tr>
		<?php endif;?>
		<tr>
			<td colspan="2">
				<?php echo $form->label('Feedback/body', __('Feedback.feedback', true));?><br />
			 	<?php echo $form->textarea('Feedback/body', array('style'=>'width:290px; height:150px;'));?>
				<?php echo $form->error('Feedback/body');?>
				<?php echo $form->hidden('Feedback/url', array('value'=>$_SERVER['REQUEST_URI']));?>
			
				<?php echo $button->submit(__('Feedback.send', true), 'icons/f/add.png');?>
				<div class="feedback_form_toggle" style="text-align:right; font-size:11px"><?php __('Feedback.close');?></div>
			</td>
		</tr>
	</table>
</form>

<script type="text/javascript">
	$('#feedback_form').hide();
	$('.feedback_form_toggle').click(function(){
		$('#feedback_form').css('position', 'absolute');
		$('#feedback_form').css('top', '0px');
		$('#feedback_form').css('left', '200px');
		$('#feedback_form').toggle('slow');
	});
</script>



