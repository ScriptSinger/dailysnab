<?
$filename = 'basket.json';

$text = '';
$fh = fopen($filename, 'r');
while (!feof($fh)) {
	$line = fgets($fh);
	$text .= $line . PHP_EOL;
}
fclose($fh);
 


 
 // $serg = '';
 // $serg = $str;

  echo "<br><br>";
  echo "<pre>";
  //echo '111';
    print_r( json_decode($text) );
  //echo '333';
  echo "</pre>";
  echo "<br><br>";


?>