<?php

// http://ws.armtek.ru/api/ws_invoice/getInvoice?VKORG=5170&KUNRG=43222422&INVOICE=0352910744&format=json


// http://dailysnab.beget.tech/qrq/armtek/api/history.php?userid=snabdaily@gmail.com&password=Ar299792458&zakaz=0352910744

// http://ws.armtek.ru/api/ws_invoice/getInvoice?VKORG=".$pVkorg."&KUNRG=".$pKUNNR1."&INVOICE=0352503126&format=json


if (isset($_GET['zakaz']))
{
    $pZakaz = $_GET['zakaz'];
    $pZakaz = trim($pZakaz);
}
if (isset($_POST['artid']))
{
    $pZakaz= $_POST['zakaz'];
    $pZakaz = trim($pZakaz);
}


if (isset($_GET['userid']))
{
    $pUserId = $_GET['userid'];
    $pUserId = trim($pUserId);
}
if (isset($_POST['userid']))
{
    $pUserId = $_POST['userid'];
    $pUserId = trim($pUserId);
}

if (isset($_GET['password']))
{
    $pPassword = $_GET['password'];
    $pPassword = trim($pPassword);
}
if (isset($_POST['password']))
{
    $pPassword = $_POST['password'];
    $pPassword = trim($pPassword);
}






require_once 'funUserVkorgList.php';
$pVkorg = fUserVkorgList($pUserId, $pPassword);

require_once 'funUserInfo.php';
// RG_TAB-KUNNR
$pKUNNR1 = fUserInfo(1, $pUserId, $pPassword);



$pScrt = 'http://ws.armtek.ru/api/ws_order/getOrder?VKORG='.$pVkorg.'&KUNRG='.$pKUNNR1.'&ORDER='.$pZakaz;



$file = file_get_contents($pScrt);

print_r($file);





?>






