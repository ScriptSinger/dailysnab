<?

$text = '';
$fd = fopen("basket.json", 'r') or die("не удалось открыть файл");
while(!feof($fd))
{
    $str = htmlentities(fgets($fd));
  //$str = fgets($fd);
  
  echo $str;


$text .= $line . PHP_EOL;
  
}
fclose($fd);


 
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