<?php

use ArmtekRestClient\Http\Exception\ArmtekException as ArmtekException;
use ArmtekRestClient\Http\Config\Config as ArmtekRestClientConfig;
use ArmtekRestClient\Http\ArmtekRestClient as ArmtekRestClient;


/**
 * @param $zUserId
 * @param $zPassword
 * @return string
 */
function fStoreList($zUserId, $zPassword, $zVkorg)
{
    error_reporting(-1);
    ini_set('display_errors', 1);


    $user_settings = array(
        'user_login'         => $zUserId   // логин
        ,'user_password'     => $zPassword  // пароль
    );


    $ws_default_settings = array(
        'VKORG'         => $zVkorg
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


    $pRes = $json_responce_data->RESP;

    return $pRes;

}




?>