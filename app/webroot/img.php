<?php
/**
 * This file handles image and pdf-export for the viewer-component
 */ 
	// set the memory_limit higher...
	ini_set('memory_limit', '100M');
		   
	// retrieve POST-Data
	if(!isset($_POST['height']) || !isset($_POST['width']) || !isset($_POST['img']))
	{
		die('Data missing. Script expects POST-Data height, width and img...');
	}
	
    $width = (int) $_POST['width'];
    $height = (int) $_POST['height'];
    $type = isset($_POST['type']) ? $_POST['type'] : 'png';    
	//Pixel-Colors are comma-seperated - create an array
    $data = explode(',', $_POST['img']);
    
    
    //create the image and fill it with white
    $image = imagecreatetruecolor($width, $height);
    imagefill($image, 0, 0, 0xFFFFFF);
    
    
    //Copy pixels
    $i = 0;
    for($x=0; $x<=$width; $x++)
	{
        for($y=0; $y<=$height; $y++)
		{
         	// ffffff is sent as empty string - nothing to do then
         	if($data[$i]!='')
         	{
            	$r = hexdec(substr($data[$i], 0, 2));
            	$g = hexdec(substr($data[$i], 2, 2));
            	$b = hexdec(substr($data[$i], 4, 2));
            	$color = imagecolorallocate($image, $r, $g, $b);
            	
            	imagesetpixel ($image, $x, $y, $color);
            }
            $i++;
        }
    }

	

	
	if($type == 'png')
	{
		$redirect = true;
		if($redirect)
		{
		    header('Content-Type: image/png');
		    imagepng($image, 'test.png');
		    imagedestroy($image);    
		    header('Location: test.png');		
		}
		else
		{
		    header('Content-Type: image/png');
		    imagepng($image);		
		}		
	}
	else
	{
	    imagepng($image, 'test.png');
	    imagedestroy($image); 	
		require('../vendors/fpdf/fpdf.php');
		$pdf = new FPDF('L');
		$pdf->Open();
		$pdf->AddPage();
		$pdf->Image('test.png', 0, 0);
		$pdf->Output();	
	}






    
 