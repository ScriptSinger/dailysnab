<?php

if ($_SERVER['REMOTE_ADDR'] !== '5.18.234.111') {
    http_response_code(404);
    die;
}

echo '<pre>';
passthru('ps aux');
echo '</pre>';

//$f = fopen(__FILE__ . '.lock', 'w');
//
//if (flock($f, LOCK_EX | LOCK_NB)) {
    //echo 'Lock';
    //sleep(10);
    //flock($f, LOCK_UN);
//} else {
    //echo 'No';
//}
//
//fclose($f);