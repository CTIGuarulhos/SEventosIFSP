<?
//***************************************
// This is downloaded from www.plus2net.com //
/// You can distribute this code with the link to www.plus2net.com ///
//  Please don't  remove the link to www.plus2net.com ///
// This is for your learning only not for commercial use. ///////
//The author is not responsible for any type of loss or problem or damage on using this script.//
/// You can use it at your own risk. /////
//*****************************************
?>
<!doctype html public "-//w3c//dtd html 3.2//en">

<html>

    <head>
        <title>Multiple image upload script from plus2net.com</title>
        <meta name="GENERATOR" content="Arachnophilia 4.0">
        <meta name="FORMATTER" content="Arachnophilia 4.0">
    </head>

    <body bgcolor="#ffffff" text="#000000" link="#0000ff" vlink="#800080" alink="#ff0000">
        <?
        while (list($key, $value) = each($_FILES['images']['name'])) {
            if (!empty($value)) {
                $filename = $value;
                $filename = str_replace(" ", "_", $filename); // Add _ inplace of blank space in file name, you can remove this line

                $add = "upimg/$filename";
                //echo $_FILES['images']['type'][$key];
                // echo "<br>";
                copy($_FILES['images']['tmp_name'][$key], $add);
                chmod("$add", 0777);
            }
        }
        ?>

    <center><a href='http://www.plus2net.com'>PHP SQL HTML free tutorials and scripts</a></center> 
</body>

</html>
