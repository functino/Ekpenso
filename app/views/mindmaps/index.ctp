<div class="mindmaps index">
<h2><?php __('mindmaps');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort(__('Mindmap.name', true), 'name');?></th>
	<th><?php echo $paginator->sort(__('Mindmap.created', true), 'created');?></th>
	<th><?php echo $paginator->sort(__('Mindmap.modified', true), 'modified');?></th>
	<th></th>
</tr>
<?php
$i = 0;
foreach ($mindmaps as $mindmap):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
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
			<?php echo $html->link(__('edit', true), array('action'=>'edit', $mindmap['Mindmap']['id'])); ?>
			<?php echo $html->link(__('delete', true), array('action'=>'delete', $mindmap['Mindmap']['id']), null, sprintf(__('Mindmap.confirm_delete', true), $mindmap['Mindmap']['name'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>

<?php echo $this->element('pager');?>

<?php echo $html->link(__('Mindmap.add_map', true), '/mindmaps/add');?><br />
<?php echo $html->link(__('Mindmap.import_map', true), '/mindmaps/import');?>