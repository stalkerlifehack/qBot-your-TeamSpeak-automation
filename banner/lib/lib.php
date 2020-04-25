<?php
function centerAlignText(&$im, $size, $angle, $x, $y, $color, $fontfile, $text)
{
	$bbox = imagettfbbox($size, $angle, $fontfile, $text);
	$dx = ($bbox[2]-$bbox[0])/2.0 - ($bbox[2]-$bbox[4])/2.0;
	$dy = ($bbox[3]-$bbox[1])/2.0 + ($bbox[7]-$bbox[1])/2.0;
	$px = $x-$dx;
	$py = $y-$dy;

	return imagettftext($im, $size, $angle, $px, $py, $color, $fontfile, $text);
}

 ?>
