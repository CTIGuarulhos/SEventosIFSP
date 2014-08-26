<li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=anais<?php
       if (isset($_GET['SCT'])) {
       echo "&SCT=" . $_GET['SCT'];
       }
       ?>">ANAIS</a></li> 
<li><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=tmpresultados<?php
       if (isset($_GET['SCT'])) {
       echo "&SCT=" . $_GET['SCT'];
       }
       ?>">TRABALHOS</a></li>