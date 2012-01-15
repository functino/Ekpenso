<?php 
	//@TODO find better solution
	function currentCssClass($tab, $current)
	{
		if($tab==$current)
		{
			echo ' class="current"';
		}
	}
?><ul>
	<li <?php currentCssClass('home', $_tab);?> id="navigation_home"><a href="<?php echo $html->url('/');?>"><span><?php __('navigation.home');?></span></a></li>
	<li <?php currentCssClass('public_maps', $_tab);?>><a href="<?php echo $html->url('/mindmaps/public_maps');?>"><span><?php __('navigation.public_maps');?></span></a></li>
	<li <?php currentCssClass('help', $_tab);?>><a href="<?php echo $html->url('/help');?>"><span><?php __('navigation.help');?></span></a></li>
	<li <?php currentCssClass('contact', $_tab);?>><a href="<?php echo $html->url('/contact');?>"><span><?php __('navigation.contact');?></span></a></li>
	<li <?php currentCssClass('downloads', $_tab);?>><a href="<?php echo $html->url('/downloads');?>"><span><?php __('navigation.downloads');?></span></a></li>
</ul>