<?



$fd = fopen("basket.json", 'r') or die("не удалось открыть файл");
while(!feof($fd))
{
    $str = htmlentities(fgets($fd));
//  $str = fgets($fd);
    echo $str;
}
fclose($fd);


  echo "<br><br>";
  echo "<pre>";
  echo '111';
  $Resp = json_encode($str, JSON_UNESCAPED_UNICODE);  
  echo $Resp;
  echo '222';
  echo "</pre>";
  echo "<br><br>";


?>