<h2><?php __('public_mindmaps');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort(__('Mindmap.name', true), 'name');?></th>
	<th><?php echo $paginator->sort(__('Mindmap.owner', true), 'user_id');?></th>
	<th><?php echo $paginator->sort(__('Mindmap.created', true), 'created');?></th>
	<th><?php echo $paginator->sort(__('Mindmap.modified', true), 'modified');?></th>
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
			<?php echo $html->link($mindmap['User']['username'], '/users/profile/'.h($mindmap['User']['username']));?>
		<td>
			<?php echo d('d.m.Y H:i', $mindmap['Mindmap']['created']); ?>
		</td>
		<td>
			<?php echo d('d.m.Y H:i', $mindmap['Mindmap']['modified']); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>



<?php echo $this->element('pager');?>