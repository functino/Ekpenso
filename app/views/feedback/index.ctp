<h2><?php __('Feedback.feedback');?></h2>
<form action="<?php echo $html->url('/feedback/'); ?>" method="post" class="buttons form">

	<table>
		<tr>
			<td>
				<?php echo $form->label('Feedback/name', __('Feedback.name', true));?>
			</td>
			<td>
			 	<?php echo $form->text('Feedback/name');?>
				<?php echo $form->error('Feedback/name');?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $form->label('Feedback/email', __('Feedback.email', true));?>
			</td>
			<td>
			 	<?php echo $form->text('Feedback/email');?>
				<?php echo $form->error('Feedback/email');?>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<?php echo $form->label('Feedback/body', __('Feedback.body', true));?><br />
			 	<?php echo $form->textarea('Feedback/body');?>
				<?php echo $form->error('Feedback/body');?>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<?php echo $button->submit(__('Feedback.send', true), 'icons/f/accept.png', 'positive');?>
			</td>
		</tr>
	</table>
</form>

