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
  print_r($str);
  echo "</pre>";
  echo "<br><br>";


?>