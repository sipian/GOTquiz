<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/newfile.txt';
$myfile = fopen($path, "w");
$txt = "John Doe\n";
fwrite($myfile, $txt);
$txt = "Jane Doe\n";
fwrite($myfile, $txt);
echo "asdfds";
 echo fread($myfile,filesize("newfile.txt"));
 fclose($myfile);
?>
