<?

$fuck = '';
$fd = fopen("basket.json", 'r') or die("не удалось открыть файл");
while(!feof($fd))
{
    $str = htmlentities(fgets($fd));
  //$str = fgets($fd);
  
  $fuck = $fuck+$str;
  echo $str;

}
fclose($fd);


   echo $fuck;
 
 // $serg = '';
 // $serg = $str;

  echo "<br><br>";
  echo "<pre>";
  echo '111';
//    var_dump( $serg );

  echo '333';
  echo "</pre>";
  echo "<br><br>";


?>