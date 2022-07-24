<?php
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
    ];

    // requeest params for send
    $request_params = [

        'url' => 'user/getStoreList',
        'params' => [
            'VKORG'         => !empty($params['VKORG'])?$params['VKORG']:(isset($ws_default_settings['VKORG'])?$ws_default_settings['VKORG']:'')       
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

// 
echo "<h1>Сервис получения списка складов</h1>";
echo "<h2>Входные параметры</h2>";
echo "<pre>"; print_r( $request_params ); echo "</pre>"; 
echo "<h2>Ответ</h2>";
echo "<pre>"; print_r( $json_responce_data ); echo "</pre>";
?>
