<h2><?php __('Openid.your_openids');?></h2>

<?php if(!empty($user['Openid'])):?>
<table>
	<tr>
		<th>Openid</th>
		<th></th>
	<?php foreach($user['Openid'] as $openid):?>
		<tr>
		<td>
			<?php echo h($openid['openid_url']);?>
		</td>
		<td>
			<?php echo $html->link(__('delete', true), '/openid/detach/'.$openid['id']);?>
		</td>
		</tr>
	<?php endforeach;?>
</table>
<?php else:?>
	<?php __('Openid.no_openid_yet');?>
<?php endif;?>

<h3><?php __('Openid.add_openid');?></h3>
<?php echo $html->link(__('Openid.add', true), '/openid/login');?>

