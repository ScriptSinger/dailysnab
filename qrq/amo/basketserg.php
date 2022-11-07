<?

$fd = fopen("basket.json", 'r') or die("не удалось открыть файл");
while(!feof($fd))
{
//    $str = htmlentities(fgets($fd));
  $str = fgets($fd);
//    echo $str;
      var_dump( json_encode($str) );


}
fclose($fd);


  echo "<br><br>";
  echo "<pre>";
  echo '111';

  echo '333';
  echo "</pre>";
  echo "<br><br>";


?>