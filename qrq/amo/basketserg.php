<?



$fd = fopen("basket.json", 'r') or die("не удалось открыть файл");
while(!feof($fd))
{
    $str = htmlentities(fgets($fd));
//  $str = fgets($fd);
   // echo $str;
}
fclose($fd);


  echo "<br><br>";
  echo "<pre>";
  echo '111';
  $Resp = json_decode($str, JSON_UNESCAPED_UNICODE);  
  print_r($str);
  echo "</pre>";
  echo "<br><br>";


?>