<?php header('Content-Type: application/xml');?><xml>
<?php foreach($nodes as $node):?>
	<node><?php echo $node;?></node>
<?php endforeach;?>
</xml>