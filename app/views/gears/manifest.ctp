{
  "betaManifestVersion": 1,
  "version": "v2",
  "entries": [
  	<?php for($i=0; $i<count($files); $i++):?>
  		{ "url": "<?php echo $files[$i];?>"}<?php if($i+1<count($files)):?>,<?php endif;?>	
  	<?php endfor;?>
    ]
}