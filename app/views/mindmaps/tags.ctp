<h2><?php __('Tag.your_tags');?></h2>
<table>
	<tr>
		<th>
			<?php __('Tag.tag');?>
		</th>
		<th>
			<?php __('Tag.created');?>
		</th>
		<th>
		</th>
	</tr>
<?php if(!empty($tags)):?>
	<?php foreach($tags as $t):?>
		<tr>
			<td>
				<?php echo $html->link($t['Tag']['text'], '/mindmaps/tags/'.h($t['Tag']['text']));?>
			</td>
			<td>
				<?php echo d('d.m.Y H:i', $t['Tag']['created']);?>
			</td>
			<td>
				<?php echo $html->link(__('delete', true), '/tags/delete/'.$t['Tag']['id'], null, sprintf(__('Tag.confirm_delete', true), $t['Tag']['text'])); ?>
			</td>
		</tr>
	<?php endforeach;?>
<?php else:?>
	<tr>
		<td colspan="3">
			<?php __('Tag.no_tags');?>
		</td>
	</tr>
<?php endif;?>
</table>
<?php if($tag):?>
	<h3><?php printf(__('Tag.mindmaps_with_tag', true), h($tag['Tag']['text']));?>:</h3>
	<table cellpadding="0" cellspacing="0">
	<tr>
		<th><?php __('Mindmap.name');?></th>
		<th><?php __('Mindmap.created');?></th>
		<th><?php __('Mindmap.modified');?></th>
		<th></th>
	</tr>
	<?php foreach ($tag['Mindmap'] as $mindmap):?>
		<tr>
			<td>
				<?php echo $html->link($mindmap['name'], '/mindmaps/viewer/'.$mindmap['id']); ?>
			</td>
			<td>
				<?php echo d('d.m.Y H:i', $mindmap['created']); ?>
			</td>
			<td>
				<?php echo d('d.m.Y H:i', $mindmap['modified']); ?>
			</td>
			<td class="actions">
				<?php echo $html->link(__('edit', true), array('action'=>'edit', $mindmap['id'])); ?>
				<?php echo $html->link(__('delete', true), array('action'=>'delete', $mindmap['id']), null, sprintf(__('Mindmap.confirm_delete', true), $mindmap['name'])); ?>
			</td>
		</tr>
	<?php endforeach;?>
	</table>
<?php endif;?>

