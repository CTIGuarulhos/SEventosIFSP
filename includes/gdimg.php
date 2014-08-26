<?php

//require('../initialize.php');
/*
  echo "<pre>'";
  print_r($_SESSION);
  echo "'</pre><br/>";exit;
 */
$imagem = ImageCreate(80, 40); //dimensao da imagem
$fundo = ImageColorAllocate($imagem, 174, 160, 160); //cor de fundo
$fonte = ImageColorAllocate($imagem, 132, 3, 2); //cor letras
$array = str_split($_GET['letrasgd']);
//$array = str_split($_SESSION['letrasgd']);
$letras = "";

foreach ($array as $letra)
    $letras .= $letra . ' ';

/* TESTE * /
  echo '"'.$_SESSION['letrasgd'].'"<br/>';
  echo '"'.$letras.'"';
  exit();
  /* ----- */

ImageString($imagem, 5, rand(5, 25), rand(5, 25), $letras, $fonte);
//ImageString escreve na imagem, o 1 numero � o tamanho da letra
//o segundo � posi��o horizontal e o terceiro numero � vertical

header("Content-type: image/png");
imagepng($imagem);
ImageDestroy($imagem);
?>
