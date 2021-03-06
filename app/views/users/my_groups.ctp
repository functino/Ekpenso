<h2><?php __('Group.your_groups');?></h2>

<?php if(!empty($user['GroupInvitation'])):?>
	<h3><?php __('Group.invitation');?></h3>
	<table>
		<tr>
			<th><?php __('Group.invitation');?></th>
			<th><?php __('Group.group');?></th>
			<th></th>
		</tr>
	<?php foreach($user['GroupInvitation'] as $in):?>
		<tr>
			<td>
				<?php printf(__('GroupInvitation.invitation_text', true), d('d.m.Y H:i', $in['created']), $html->link($in['Group']['Admin']['username'], '/users/profile/'.$in['Group']['Admin']['username']), h($in['Group']['name']));?>
				<br />
				<?php echo nl2br(h($in['message']));?>
			</td>
			<td>
				<?php echo h($in['Group']['name']);?>
			</td>
			<td>
				<?php echo $button->link(__('GroupInvitation.accept', true), 'icons/f/accept.png', '/groups/accept_invitation/'.$in['id']);?>
				<?php echo $html->link(__('GroupInvitation.deny', true), '/groups/delete_invitation/'.$in['id']);?>
			</td>
		</tr>
	<?php endforeach;?>
</table>
<?php endif;?>

<h3><?php __('Group.group_memberships');?></h3>
<?php if(!empty($user['Group'])):?>
<table>
	<tr>
		<th><?php __('Group.name');?></th>
		<th><?php __('Group.admin');?></th>
		<th></th>
	</tr>
	<?php foreach($user['Group'] as $group):?>
		<tr>
			<td>
				<?php echo $html->link($group['name'], '/groups/view/'.$group['id']);?>
			</td>
			<td>
				<?php echo $html->link($group['Admin']['username'], '/users/profile/'.$group['Admin']['username']);?>
			</td>

			<td>
				<?php echo $html->link(__('Group.leave', true), '/groups/leave/'.$group['id'], null, sprintf(__('Group.confirm_leave', true), $group['name']));?>
			</td>
		</tr>
	<?php endforeach;?>
</table>
<?php else:?>
	Du bist in keiner Gruppe
<?php endif;?>

<?php if(!empty($user['GroupAdmin'])):?>
<h3><?php __('Group.group_leaderships');?></h3>
<table>
	<tr>
		<th>
			<?php __('Group.group');?>
		</th>
		<th>
			<?php __('Group.created');?>
		</th>
		<th>
		</th>
	</tr>
	<?php foreach($user['GroupAdmin'] as $group):?>
		<tr>
			<td>
				<?php echo $html->link($group['name'], '/groups/view/'.$group['id']);?>
			</td>
			<td>
				<?php echo d('d.m.Y H:i', $group['created']);?>
			</td>
			<td>
				<?php echo $html->link(__('edit', true), '/groups/edit/'.$group['id']);?>
				<?php echo $html->link(__('delete', true), '/groups/delete/'.$group['id'], null, sprintf(__('Group.confirm_delete', true), $group['name']));?>
			</td>
		</tr>
	<?php endforeach;?>
</table>
<?php endif;?>

<br /> <br />
<?php echo $button->link(__('Group.submit.add', true), 'icons/f/group.png', '/groups/add');?>
