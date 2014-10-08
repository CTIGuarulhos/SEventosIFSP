<?php

  include('php-barcode.php');

  // -------------------------------------------------- //
  //                  PROPERTIES
  // -------------------------------------------------- //
  
  // download a ttf font here for example : http://www.dafont.com/fr/nottke.font
  //$font     = './NOTTB___.TTF';
  // - -
  
  $fontSize = 10;   // GD1 in px ; GD2 in point
  $marge    = 0;   // between barcode and hri in pixel
  $x        = 115;  // barcode center
  $y        = 10;  // barcode center
  $height   = 20;   // barcode height in 1D ; module size in 2D
  $width    = 2;    // barcode height in 1D ; not use in 2D
  $angle    = 0;   // rotation in degrees : nb : non horizontable barcode might not be usable because of pixelisation
  
  $code     = (isset($_GET["text"]) ? $_GET["text"] : "0"); // barcode, of course ;)
  $type     = 'code128';
  $im     = imagecreatetruecolor(234, 20);
  $black  = ImageColorAllocate($im,0x00,0x00,0x00);
  $white  = ImageColorAllocate($im,0xff,0xff,0xff);
  $red    = ImageColorAllocate($im,0xff,0x00,0x00);
  $blue   = ImageColorAllocate($im,0x00,0x00,0xff);
  imagefilledrectangle($im, 0, 0, 300, 300, $white);
  $data = Barcode::gd($im, $black, $x, $y, $angle, $type, array('code'=>$code), $width, $height);
  header('Content-type: image/gif');
  imagegif($im);
  imagedestroy($im);
