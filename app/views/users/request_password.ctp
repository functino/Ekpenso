<h2><?php __('User.lost_password');?></h2>

<?php __('User.lost_password_text');?>

<form action="<?php echo $html->url('/users/request_password'); ?>" method="post" class="buttons form">
<table>
    <tr>
        <td>
            <?php echo $form->label('User.email', __('User.email', true));?>
        </td>
        <td>
            <?php echo $form->text('User.email');?>
        </td>
    </tr>
</table>
	<?php echo $button->submit(__('User.request_password', true), 'icons/f/key_go.png', 'positive');?>
</form>

