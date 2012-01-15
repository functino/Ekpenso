<?php 
header('Content-type: application/x-octet-stream');
header("Content-disposition: attachment; filename=$filename");
echo $xml;?>