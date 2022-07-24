<?php


// http://dailysnab.beget.tech/qrq/armtek/api/getUserInfo.php

error_reporting(-1);
ini_set('display_errors', 1);

//require_once '../config.php';
$pUserId = 'snabdaily@gmail.com';
$pPassword = 'Ar299792458';
$pVkorg = '5170';

$user_settings = array(
    'user_login'         => $pUserId   // логин
    ,'user_password'     => $pPassword  // пароль
);

$ws_default_settings = array(
    'VKORG'         => $pVkorg
,'KUNNR_RG'     => '' // RG_TAB-KUNNR
,'KUNNR_WE'     => '' // RG_TAB->WE_TAB-KUNNR
    // Для доставки - таблица RG_TAB->ZA_TAB-KUNNR
    // Для самовывоза - таблица RG_TAB->EWX_TAB-ID
,'KUNNR_ZA'     => ''
,'INCOTERMS'    => ''
,'PARNR'        => ''
,'VBELN'        => ''
,'format'       => 'json'
);

require_once 'autoloader.php';

use ArmtekRestClient\Http\Exception\ArmtekException as ArmtekException; 
use ArmtekRestClient\Http\Config\Config as ArmtekRestClientConfig;
use ArmtekRestClient\Http\ArmtekRestClient as ArmtekRestClient; 

try {

    // init configuration 
    $armtek_client_config = new ArmtekRestClientConfig($user_settings);  

    // init client
    $armtek_client = new ArmtekRestClient($armtek_client_config);


    $params = [
        'VKORG'         => ''       
        ,'STRUCTURE'    => 1
        ,'FTPDATA'      => 1
    ];

    // requeest params for send
    $request_params = [
   
        'url' => 'user/getUserInfo',
        'params' => [
            'VKORG'         => !empty($params['VKORG'])?$params['VKORG']:(isset($ws_default_settings['VKORG'])?$ws_default_settings['VKORG']:'')       
            ,'STRUCTURE'    => isset($params['STRUCTURE'])?$params['STRUCTURE']:''
            ,'FTPDATA'      => isset($params['FTPDATA'])?$params['FTPDATA']:''
            ,'format'       => 'json'
        ]

    ];

    // send data
    $response = $armtek_client->post($request_params);

    // in case of json
    $json_responce_data = $response->json();


} catch (ArmtekException $e) {

    $json_responce_data = $e -> getMessage(); 

}





$pFirst = $json_responce_data->RESP->STRUCTURE->RG_TAB[0];
$pRes1 = $pFirst->CONTACT_TAB[0] ;
echo $pRes1->PARNR;

//print_r($pRes1);
/*
foreach ($pRes1 as $pItem)
{
    $pRes = $pItem->PARNR;
}
*/
//print_r($pFirst);
//echo $pFirst->KUNNR ;
echo "<br>";
echo "<br>";



// 
//echo "<h1>Сервис получения структуры клиента</h1>";
//echo "<h2>Входные параметры</h2>";
//echo "<pre>"; print_r( $request_params ); echo "</pre>";
echo "<h2>Ответ</h2>";
echo "<pre>"; print_r( $json_responce_data ); echo "</pre>";



?>
