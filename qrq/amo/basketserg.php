<?
$filename = 'basket.json';

$text = '';
$fh = fopen($filename, 'r');
while (!feof($fh)) {
	$line = fgets($fh);
	$text .= $line . PHP_EOL;
}
fclose($fh);
 
echo $text;

 
 // $serg = '';
 // $serg = $str;

  echo "<br><br>";
  echo "<pre>";
  echo '111';
    echo $text ;
  echo '333';
  echo "</pre>";
  echo "<br><br>";


?>