<?php

//$p1 = $_POST['resp'];
$p1 = '111';

//$p2 = $_POST['accontid'];
$p2 = '222';


$text = $p1;
$filename = 'logs/'.$p2.'_log.txt';
$fh = fopen($filename, 'w');
fwrite($fh, $text);
fclose($fh);

print_r('ok');

?>