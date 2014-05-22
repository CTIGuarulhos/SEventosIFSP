<?php

global $Esta_Pagina;
require "initialize.php";
$SESSION->Destroy();
header("Location: {$CONFIG->URL_ROOT}");
?>

