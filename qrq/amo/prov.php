<?php



// https://itel-app.ru/amo/authorization.php


// $url = 'https://questrequest.ru/qrq/amo/search.php';
// $url = 'https://dailysnab.beget.tech/qrq/amo/search.php';
 $url = 'https://itel-app.ru/amo/search.php';



$parameters = [
    'token'         => '4649d1c9db6a0f3d5e87ce37ce94bb0578008733',
    'brand'         => "Lema",
    'searchtext'     => "105310",
    'accountid'     => "1532899,1532898"
];


$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$Resp = json_decode(trim($response), JSON_UNESCAPED_UNICODE);
print_r($Resp);

// echo $Resp;


?>