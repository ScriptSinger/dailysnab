<?



$fd = fopen("basket.json", 'r') or die("не удалось открыть файл");
while(!feof($fd))
{
    $str = htmlentities(fgets($fd));
   // echo $str;
}
fclose($fd);


  echo "<br><br>";
  echo "<pre>";
  echo '111';
  $Resp = json_decode($str, JSON_UNESCAPED_UNICODE);  
  print_r($Resp);
  echo "</pre>";
  echo "<br><br>";


?>