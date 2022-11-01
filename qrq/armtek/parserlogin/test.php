

<?

// https://etp.armtek.ru/?login=techss%40bk.ru&password=Armtek299792458
// https://etp.armtek.ru/?login=techss%40bk.ru&password=Armtek299792458&captcha=12345

// https://etp.armtek.ru/order/report

// https://etp.armtek.ru/authorization/identify/

// login = techss@bk.ru
// password = Armtek299792458
// http://dailysnab.beget.tech/qrq/armtek/parserlogin/test.php

//$respon = file_get_contents('https://etp.armtek.ru/');

//print_r($respon) ;

// <iframe src="https://etp.armtek.ru/" width="100%" height="500"></iframe>

// include_once 'https://etp.armtek.ru/';



// https://etp.armtek.ru/authorization/identify/?login=techss%40bk.ru&password=Armtek299792458


echo "333";
echo "<br>";
echo "<br>";
echo "<br>";

// POST - запрос

/*
$data = array('LOGIN'=>'techss@bk.ru','PASSWORD'=>'Armtek299792458','REMEMBER'=>'0','LANG'=>'ru','FORMAT'=>'json','CAPTCHA'=>'');
$myCurl = curl_init();
curl_setopt_array($myCurl, array(
    CURLOPT_URL => 'https://etp.armtek.ru/authorization/identify/?0.016899694948694588',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query($data)
));
$response = curl_exec($myCurl);
curl_close($myCurl);
*/


//$respon = file_get_contents('https://etp.armtek.ru/');



// создание нового ресурса cURL
$ch = curl_init();

// установка set URL и других соответствующих параметров
$data = array('LOGIN'=>'techss@bk.ru','PASSWORD'=>'Armtek299792458','REMEMBER'=>'0','LANG'=>'ru','FORMAT'=>'json','CAPTCHA'=>'');
$options = array(
    CURLOPT_URL => 'https://etp.armtek.ru/',
    CURLOPT_HEADER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query($data)
);

curl_setopt_array($ch, $options);

// загрузка URL и ее выдача в браузер
curl_exec($ch);

// закрытие ресурса cURL и освобождение системных ресурсов
curl_close($ch);

print_r($ch) ;

?>



<!--


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<script>
    $("#login").val('techss@bk.ru');
    $("#password").val('Armtek299792458');
</script>


-->





