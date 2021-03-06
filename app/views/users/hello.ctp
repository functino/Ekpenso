<h2><?php printf(__('hello_user', true), $session->read('User.username'));?></h2>

<div style="text-align:center">
<h3><?php __('User.what_to_do');?></h3>
<div class="span-9" style="text-align:left;">
<h4><?php __('User.add_mindmap');?></h4>
	<form action="<?php echo $html->url('/mindmaps/add'); ?>" method="post">
	<?php echo $form->text('Mindmap.name');?><br />
	<?php echo $button->submit(__('Mindmap.add_map', true), 'icons/f/add.png');?>
	</form>
	<?php echo $html->link(__('Mindmap.import_map', true), '/mindmaps/import');?>
</div>
<div class="span-9 last" style="text-align:right;">
<h4><?php __('User.browse_mindmaps');?></h4>
<?php echo $html->link(__('User.to_mindmap_list', true), '/mindmaps/');?>
</div>
<div class="span-18 last">
<?php __('or');?><br />
<h4><?php __('User.open_last_edited');?>:</h4>
<?php if($mindmaps):?>
	<table>
	<tr>
		<th><?php echo __('Mindmap.name');?></th>
		<th><?php echo __('Mindmap.created');?></th>
		<th><?php echo __('Mindmap.modified');?></th>
		<th></th>
	</tr>
	<?php foreach ($mindmaps as $mindmap):?>
		<tr>
			<td>
				<?php echo $html->link($mindmap['Mindmap']['name'], '/mindmaps/viewer/'.$mindmap['Mindmap']['id']); ?>
			</td>
			<td>
				<?php echo d('d.m.Y H:i', $mindmap['Mindmap']['created']); ?>
			</td>
			<td>
				<?php echo d('d.m.Y H:i', $mindmap['Mindmap']['modified']); ?>
			</td>
			<td class="actions">
				<?php echo $html->link(__('edit', true), array('controller'=>'mindmaps', 'action'=>'edit', $mindmap['Mindmap']['id'])); ?>
				<?php echo $html->link(__('delete', true), array('controller'=>'mindmaps', 'action'=>'delete', $mindmap['Mindmap']['id']), null, sprintf(__('Mindmap.confirm_delete', true), $mindmap['Mindmap']['name'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php else:?>
	<?php __('User.no_mindmaps_created');?>
<?php endif;?>
</div>
</div>
<hr />
<div class="span-18 first" style="margin-top:30px;">
<h2><?php __('Help.cheatsheet');?></h2>
<?php echo $this->element(Configure::read('Config.language').'_cheatsheet');?>
</div>



