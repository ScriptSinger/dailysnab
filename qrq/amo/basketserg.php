<?

$fd = fopen("basket.json", 'r') or die("не удалось открыть файл");
while(!feof($fd))
{
    $str = htmlentities(fgets($fd));
  //$str = fgets($fd);
  

}
fclose($fd);


   echo $str;
 
  $serg = '';
  $serg = $str;

  echo "<br><br>";
  echo "<pre>";
  echo '111';
    var_dump( $serg );

  echo '333';
  echo "</pre>";
  echo "<br><br>";


?>