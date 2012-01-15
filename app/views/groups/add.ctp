<h2><?php __('Group.create');?></h2>
<form action="<?php echo $html->url('/groups/add'); ?>" method="post">
<table>
	<tr>
		<td>
			<?php echo $form->label('Group.name', __('Group.name', true));?>
		</td>
		<td>
			<?php echo $form->text('Group.name');?>
			<?php echo $form->error('Group.name');?>
		</td>
	</tr>
</table>
<?php echo $button->submit(__('Group.submit.add', true), 'icons/f/group.png');?>
</form>

