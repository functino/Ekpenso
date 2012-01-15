	<div id="flashcontent">
		<?php __('flash_missing');?>
	</div>

	<script type="text/javascript">
		// <![CDATA[

		function mm_save(str)
		{
			alert(decodeURI(str));
		}
		var so = new SWFObject("<?php echo $html->url('/'.Configure::read('Viewer.name'));?>", "viewer", 900, 600, "9", "#FFFFFF");
		so.addVariable("load_url", "<?php echo $html->url('/mindmaps/xml/'.$revision);?>");
		so.addVariable('save_url', "<?php echo $html->url('/mindmaps/save/'.$mindmap['Mindmap']['id']);?>");
		//so.addVariable('update_url', "<?php echo $html->url('/mindmaps/update/'.$mindmap['Mindmap']['id']);?>");
		so.addVariable('bitmap_gateway_url', "<?php echo $html->url('/img.php');?>");
		//so.addVariable('save_function', 'mm_save');
		<?php if($editable):?>
			so.addVariable('editable', 'true');
			so.addVariable('lock_url', "<?php echo $html->url('/mindmaps/lock/'.$mindmap['Mindmap']['id']);?>");
			so.addVariable('auto_node_url', "<?php echo $html->url('/mindmaps/auto_nodes/');?>");
		<?php endif;?>
		<?php
		/* 
		so.addVariable("xml_data", "<?php echo urlencode($mindmap['Data']['data']);?>");
		*/
		?>
		so.addVariable("lang", "<?php echo Configure::read('Config.language');?>");
		so.write("flashcontent");
		// ]]>
	</script>
	<?php if($editable):?>
		<?php echo $html->link(__('Mindmap.duplicate', true), '/mindmaps/duplicate/'.$mindmap['Mindmap']['id']);?>
	<?php endif;?>