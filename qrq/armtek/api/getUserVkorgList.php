<?php
error_reporting(-1);
ini_set('display_errors', 1);

$user_settings = array(
    'user_login'         => 'snabdaily@gmail.com'   // логин
    ,'user_password'     => 'Ar299792458'  // пароль
);

$ws_default_settings = array(

    'VKORG'         => ''
    ,'KUNNR_RG'     => ''
    ,'KUNNR_WE'     => ''
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

    // requeest params for send
    $request_params = [
        'url' => 'user/getUserVkorgList',
    ];

    // send data
    $response = $armtek_client->get($request_params);

    // in case of json
    $json_responce_data = $response->json();


} catch (ArmtekException $e) {

    $json_responce_data = $e -> getMessage(); 

}



$pFirst = $json_responce_data->RESP[0];
//print_r($pFirst);
echo $pFirst->VKORG ;



?>