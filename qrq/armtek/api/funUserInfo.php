<?php


use ArmtekRestClient\Http\Exception\ArmtekException as ArmtekException;
use ArmtekRestClient\Http\Config\Config as ArmtekRestClientConfig;
use ArmtekRestClient\Http\ArmtekRestClient as ArmtekRestClient;

function fUserInfo($zUserId, $zPassword, $zVkorg)
{
    error_reporting(-1);
    ini_set('display_errors', 1);

    $pVkorg = $zVkorg;

    $user_settings = array(
        'user_login'         => $zUserId   // логин
        ,'user_password'     => $zPassword  // пароль
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

    }



    $pRes = json_encode($json_responce_data, JSON_UNESCAPED_UNICODE);

    return $pRes;

}


function fUserInfoKUNNR1($zStrInfo)
{
    $zStrInfo = json_decode($zStrInfo);
    $pFirst = $zStrInfo->RESP->STRUCTURE->RG_TAB[0];
    $pResult = $pFirst->KUNNR ;

    return $pResult;
}
function fUserInfoKUNNR2($zStrInfo)
{
    $zStrInfo = json_decode($zStrInfo);
    $pFirst = $zStrInfo->RESP->STRUCTURE->RG_TAB[0];
    $pRes1 = $pFirst->ZA_TAB[0] ;
    $pResult = $pRes1->KUNNR;

    return $pResult;
}
function fUserInfoKUNWE($zStrInfo)
{
    $zStrInfo = json_decode($zStrInfo);
    $pFirst = $zStrInfo->RESP->STRUCTURE->RG_TAB[0];
    $pRes1 = $pFirst->WE_TAB[0];
    $pResult = $pRes1->KUNNR;

    return $pResult;
}
function fUserInfoPARNR($zStrInfo)
{
    $zStrInfo = json_decode($zStrInfo);
    $pFirst = $zStrInfo->RESP->STRUCTURE->RG_TAB[0];
    $pRes1 = $pFirst->CONTACT_TAB[0];
    $pResult = $pRes1->PARNR;

    return $pResult;
}
function fUserInfoVBELN($zStrInfo)
{
    $zStrInfo = json_decode($zStrInfo);
    $pFirst = $zStrInfo->RESP->STRUCTURE->RG_TAB[0];
    $pRes1 = $pFirst->DOGOVOR_TAB[0];
    $pResult = $pRes1->VBELN;

    return $pResult;
}


?>