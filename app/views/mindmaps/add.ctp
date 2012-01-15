<h2><?php __('Mindmap.add_map');?></h2>
<form action="<?php echo $html->url('/mindmaps/add'); ?>" method="post">
<table>
	<tr>
		<td>
			<?php echo $form->label('Mindmap.name', __('Mindmap.name', true));?>
		</td>
		<td>
			<?php echo $form->text('Mindmap.name');?>
			<?php echo $form->error('Mindmap.name');?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo $form->label('Mindmap.public', __('Mindmap.public', true));?>
		</td>
		<td>
			<?php echo $form->select('Mindmap.public', array('no'=>__('no', true), 'yes'=>__('yes', true)), 'no', null, false);?>
			<?php echo $form->error('Mindmap.public');?>
		</td>
	</tr>
</table>
<?php echo $button->submit(__('Mindmap.add_map', true), 'icons/f/add.png');?>
</form>

