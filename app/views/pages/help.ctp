<div class="span-10">
	<h2><?php __('Help.help');?></h2>
      <?php echo $html->link('deutsche Anleitung', '/pages/hilfe');?>
      <br /><br /><br /><br />
</div>
<div class="span-8 last">
	<h2><?php __('Help.video');?></h2>
	<?php echo $html->link('Videoanleitung allgemein', '/files/tutorial/allgemein.html');?> <br />
	<?php echo $html->link('Videoanleitung zum Viewer', '/files/tutorial/viewer.html');?>
</div>
<div class="span-18 first">
<h2><?php __('Help.cheatsheet');?></h2>

<?php echo $this->element(Configure::read('Config.language').'_cheatsheet');?>
</div>