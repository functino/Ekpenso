<h2><?php __('User.activate_account');?></h2>
<form action="<?php echo $html->url('/users/activate/'); ?>" method="post" class="buttons form">
<table>
	<tr>
	    <td>
			<?php echo $form->label('User/activate_key', __('User.activate_key', true));?>
		</td>
		<td>
 			<?php echo $form->text('User.activate_key');?>
			<?php echo $form->error('User.activate_key', __('error.User.activate_key.wrong_code', true));?>
		</td>
	</tr>
	<tr>
	    <td colspan="2">
	    	<?php echo $button->submit(__('User.submit.activate', true), 'icons/f/accept.png', 'positive');?>
		</td>
	</tr>
</table>
</form>
