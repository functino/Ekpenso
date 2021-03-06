<h2><?php echo h($group['Group']['name']);?></h2>

<form action="<?php echo $html->url('/groups/edit/'.$group['Group']['id']);?>" method="post">

<table>
	<tr>
		<td>
			<?php echo $form->label('Group.name');?>
		</td>
		<td>
			<?php echo $form->text('Group.name');?>
			<?php echo $form->error('Group.name');?>
		</td>
	</tr>
</table>

<?php echo $button->submit(__('save', true), 'icons/f/disk.png');?><br style="clear:both;"/>
</form>


<br /> <br />
<h3><?php __('Group.members');?></h3>
<table>
	<tr>
		<th>
			<?php __('Group.name');?>
		</th>
		<th>
		</th>
	</tr>
<?php foreach($group['User'] as $user):?>
	<tr>
		<td>
			<?php echo $html->link($user['username'], '/users/profile/'.$user['username']);?>
		</td>
		<td>
			<?php echo $html->link(__('Group.remvoe_user', true), '/groups/remove_user/'.$group['Group']['id'].'/'.$user['id']);?>
		</td>
	</tr>
<?php endforeach;?>
</table>

<h3><?php __('mindmaps');?></h3>
<?php if(!empty($group['Mindmap'])):?>
	<table>
		<tr>
			<th>
				<?php __('Mindmap.name');?>
			</th>
			<th>
			</th>
		</tr>
	<?php foreach($group['Mindmap'] as $mindmap):?>
		<tr>
			<td>
				<?php echo $html->link($mindmap['name'], '/mindmaps/viewer/'.$mindmap['id']);?><br />
			</td>
			<td>
				<?php echo $html->link(__('Group.remove_mindmap', true), '/groups/remove_mindmap/'.$group['Group']['id'].'/'.$mindmap['id']);?>
			</td>
		</tr>
	<?php endforeach;?>
	</table>
<?php else:?>
	<?php __('Group.no_mindmaps');?>
<?php endif;?>



<h3><?php __('GroupInvitation.invite_users');?></h3>
<form action="<?php echo $html->url('/groups/invite/'.$group['Group']['id']);?>" method="post">
<?php echo $form->label('GroupInvitation.username', __('GroupInvitation.username', true));?>
<?php echo $form->text('GroupInvitation.username');?> <br />
<?php echo $form->textarea('GroupInvitation.message', array('style'=>'height:50px;'));?><br />
<?php echo $button->submit(__('GroupInvitation.submit.invite', true), 'icons/f/user_add.png');?>
</form>