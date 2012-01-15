<h2><?php echo h($group['Group']['name']);?></h2>
<?php __('Group.admin');?>: 
<?php echo $html->link($group['Admin']['username'], '/users/profile/'.$group['Admin']['username']);?> 
<br/> <br />

<h3><?php __('Group.members');?></h3>
<?php foreach($group['User'] as $user):?>
	<?php echo $html->link($user['username'], '/users/profile/'.$user['username']);?><br />
<?php endforeach;?>

<h3><?php __('mindmaps');?></h3>
<?php foreach($group['Mindmap'] as $mindmap):?>
	<?php echo $html->link($mindmap['name'], '/mindmaps/viewer/'.$mindmap['id']);?>
	(<?php echo $html->link($mindmap['User']['username'], '/users/view/'.$mindmap['User']['username']);?> - 
	<?php echo $html->link(__('Mindmap.duplicate', true), '/mindmaps/duplicate/'.$mindmap['id']);?>)<br />
<?php endforeach;?>