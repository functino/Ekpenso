<?php

$paginator->options['url'] = $this->params['pass']; 
?>
<?php if($paginator->hasPrev() || $paginator->hasNext()):?>
<div class="pager">
	<?php if($paginator->hasPrev()):?>
	<span><?php echo $paginator->prev('<< '.__('pager.previous', true)); ?></span>
	<?php endif;?>
	<?php echo $paginator->numbers(array(
					'modulus' => 6,
					'separator' => ''
				)); ?> 
	<?php if($paginator->hasNext()):?>
	<span><?php echo $paginator->next(__('pager.next', true).' >>'); ?> </span>
	<?php endif;?>
	<br style="clear:both;">
</div>
<?php endif;?>