<h2><?php __('User.edit_password');?></h2>
<form action="<?php echo $html->url('/users/edit_password'); ?>" method="post">
<table>
    <tr>
        <td>
            <?php echo $form->label('User.password', __('User.password', true));?>
        </td>
        <td>
            <?php echo $form->password('User.password');?>
			<?php echo $form->error('User.password');?>	
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->label('User.password2', __('User.confirm_password', true));?>
        </td>
        <td>
            <?php echo $form->password('User.password2');?>
            <?php echo $form->error('User.password__confirm', __('error.User.password.confirm', true));?>
        </td>
    </tr>
</table>
	<?php echo $button->submit(__('User.save_password', true), 'icons/f/key_go.png', 'positive');?>
</form>



