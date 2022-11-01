<?


// http://dailysnab.beget.tech/qrq/armtek/api/testbuy.php



// $response = file_get_contents('https://dasnab.ru/qrq/armtek/api/order.php?artid=105310&userid=snabdaily@gmail.com&password=Ar299792458&price=25.31&count=1&codesklad=MOV0007109&brand=LE.MA.');
/*
$response = file_get_contents('http://dailysnab.beget.tech/qrq/armtek/api/order.php?artid=105310&userid=snabdaily@gmail.com&password=Ar299792458&price=25.31&count=1&codesklad=MOV0007109&brand=LE.MA.');


$json = json_encode($ProfilArray, JSON_UNESCAPED_UNICODE);

echo "<br>";
print_r($json);

echo "<br>";
print_r($response);
echo "<br>";
echo strlen($response);
echo "<br>";
*/

/*
if ((empty($response)) or ($response=='') )
{
    $error = 'Покупка не прошла на стороннем ресурсе';
}
*/

// $response = str_replace(array("\r\n", '\r\n',"\n\r", '\n\r', "\n", '\n', " "), "", $response);
/*
if(empty($response)||$response==''){// покупка не прошла
    $error = 'Покупка не прошла на стороннем ресурсе';
}
*/
// echo '***'.$response.'***'.$error;




$parameters = [
    //'artname' 		=> '',
    'artid' 		=> '84-02160-SX',
    'userid'        => 'snabdaily@gmail.com',
    'password'      => 'Ar299792458',
    'price'     	=> '240.02',
    'count'     	=> '1',
    'codesklad'     => 'MOV0007109',
    'brand'     	=> 'Stellox'
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://dasnab.ru/qrq/armtek/api/order.php');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


$response = curl_exec($ch);

//print_r($response);

$error = 'OK';
if(empty($response)||$response=='')
{// покупка не прошла
    $error = 'Покупка не прошла на стороннем ресурсе';
}
echo '***'.$response.'***'.$error;

curl_close($ch);



?>