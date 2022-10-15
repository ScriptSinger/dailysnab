<?php

if ($_SERVER['REMOTE_ADDR'] !== '5.18.234.111') {
    http_response_code(404);
    die;
}
