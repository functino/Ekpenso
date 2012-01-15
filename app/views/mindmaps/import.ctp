<?php if(!isset($type)):?>
<h2><?php __('Mindmap.import');?></h2>

<?php echo $html->link('Import Freemind', '/mindmaps/import/freemind');?><br />
<?php echo $html->link('Import Ekpenso', '/mindmaps/import/ekpenso');?>

<?php else:?>
<h2><?php __('Mindmap.import');?>: <?php echo h(ucfirst($type));?></h2>
<form action="<?php echo $html->url('/mindmaps/import/'.h($type));?>" enctype="multipart/form-data" method="post">
    <input type="file" name="import"/>
    <?php echo $button->submit(__('Mindmap.submit.import', true), 'icons/f/user_add.png');?>
</form>

<?php endif;?>
