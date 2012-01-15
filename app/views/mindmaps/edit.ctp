<h2><?php __('Mindmap.edit_mindmap');?></h2>

<?php echo $html->link(__('Mindmap.open', true), '/mindmaps/viewer/'.$mindmap['Mindmap']['id']);?>

<form action="<?php echo $html->url('/mindmaps/edit/'.$html->value('Mindmap.id')); ?>" method="post">
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
			<?php echo $form->select('Mindmap.public', array('no'=>__('no', true), 'yes'=>__('yes', true)), null, null, false);?>
			<?php echo $form->error('Mindmap.public');?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo $form->label('Mindmap.tags', __('Mindmap.tags', true));?>
		</td>
		<td>
			<?php echo $form->text('Mindmap.tags');?>
		</td>
	</tr>
</table>
<?php echo $form->hidden('Mindmap.id');?>
<?php echo $button->submit(__('form.save', true), 'icons/f/add.png');?>
</form>
<br /> <br />
<?php echo $html->link(__('Mindmap.export_xml', true), '/mindmaps/export/xml/'.$mindmap['Mindmap']['revision_id']);?><br />
<?php echo $html->link(__('Mindmap.export_freemind', true), '/mindmaps/export/freemind/'.$mindmap['Mindmap']['revision_id']);?>
<br /> 
<?php echo $html->link(__('Mindmap.duplicate', true), '/mindmaps/duplicate/'.$mindmap['Mindmap']['id']);?>
<br /> <br />

<?php if(!empty($mindmap['Group'])):?>
<h3><?php __('Mindmap.groups_with_access');?></h3>
<table>
	<tr>
		<th>
			<?php __('Group.group');?>
		</th>
		<th>
			<?php __('Group.admin');?>
		</th>
		<th>
			<?php __('Group.members');?>
		</th>
		<th>
		</th>
	</tr>
<?php foreach($mindmap['Group'] as $group):?>
	<tr>
		<td>
			<?php echo h($group['name'])?>
		</td>
		<td>
			<?php echo h($group['Admin']['username']);?>
		</td>
		<td>
			<?php foreach($group['User'] as $user):?>
				<?php echo h($user['username']);?>, 
			<?php endforeach;?>
		</td>
		<td>
			<?php echo $html->link(__('Mindmap.remove_from_group', true), '/groups/remove_mindmap/'.$group['id'].'/'.$mindmap['Mindmap']['id']);?>
		</td>
	</tr>

<?php endforeach;?>
</table>
<?php endif;?>

<h4><?php __('Mindmap.add_to_group');?></h4>
<form action="<?php echo $html->url('/groups/add_mindmap/'.$mindmap['Mindmap']['id']);?>" method="post">
<?php echo $form->select('Group.id', $groups, null, null, true);?>
<?php echo $button->submit(__('Mindmap.submit.add_to_group', true), 'icons/f/add.png');?> <br style="clear:both;" />
</form>
<br />


<h3><?php __('Revision.revisions');?></h3>
<table>
<tr>
	<th><?php __('Revision.created');?></th>
	<th><?php __('Revision.author');?></th>
	<th></th>
</tr>
<?php foreach($mindmap['Revision'] as $rev):?>
	<tr>
		<td>
			<?php echo d('d.m.Y H:i', $rev['created']);?>
		</td>
		<td>
			<?php echo $rev['User']['username'];?>
		</td>
		<td>
			<?php echo $html->link(__('Revision.open', true), '/mindmaps/viewer/'.$rev['mindmap_id'].'/'.$rev['id']);?>
		</td>
	</tr>
<?php endforeach;?>
</table>


<h2><?php __('Mindmap.embed');?></h2>
<?php __('Mindmap.embed_description');?>
<textarea style="width:70%; height:30px;">
<object width="900" height="600">
<param name="movie" value="http://<?php echo Configure::read('base_url');?>/<?php echo Configure::read('Viewer.name');?>"></param>
<param name="flashvars" value="load_url=http://<?php echo Configure::read('base_url');?>/mindmaps/embed_xml/<?php echo $mindmap['Mindmap']['id'];?>&amp;lang=de"></param>
<embed id="viewer" height="600"	width="900"	flashvars="load_url=http://<?php echo Configure::read('base_url');?>/mindmaps/embed_xml/<?php echo $mindmap['Mindmap']['id'];?>&amp;lang=de"	quality="high"	name="viewer" src="http://ekpenso.com/<?php echo Configure::read('Viewer.name');?>"	type="application/x-shockwave-flash"/>
</object>
</textarea>


<br /><br /><br />

<?php echo $html->link(__('delete', true), '/mindmaps/delete/'.$mindmap['Mindmap']['id'], null, sprintf(__('Mindmap.confirm_delete', true), $mindmap['Mindmap']['name'])); ?>
