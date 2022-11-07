<?

$fuck = '';
$fd = fopen("basket.json", 'r') or die("не удалось открыть файл");
while(!feof($fd))
{
    $str = htmlentities(fgets($fd));
  //$str = fgets($fd);
  
  echo $str;
$fuck = $fuck+$str;
  
}
fclose($fd);


 
 // $serg = '';
 // $serg = $str;

  echo "<br><br>";
  echo "<pre>";
  echo '111';
    var_dump( $fuck );
  echo '333';
  echo "</pre>";
  echo "<br><br>";


?>