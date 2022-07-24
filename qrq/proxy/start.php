<?php


// http://dailysnab.beget.tech/qrq/proxy/start.php


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://etp.armtek.ru/');
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$content = curl_exec($ch);
if (curl_errno($ch))
{
    echo "Error = ".curl_error($ch);
}
curl_close($ch);

echo $content;

?>