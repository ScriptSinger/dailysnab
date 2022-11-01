<?php


use ArmtekRestClient\Http\Exception\ArmtekException as ArmtekException;
use ArmtekRestClient\Http\Config\Config as ArmtekRestClientConfig;
use ArmtekRestClient\Http\ArmtekRestClient as ArmtekRestClient;


function fUserVkorgList($zUserId, $zPassword)
{

    try {

        $user_settings = array(
            'user_login'         => $zUserId   // логин
        ,'user_password'     => $zPassword // пароль
        );


        require_once 'autoloader.php';



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


        $pStatus = $json_responce_data->STATUS;
        if ($pStatus==200)
        {
            $pFirst = $json_responce_data->RESP[0];
            $pRes = $pFirst->VKORG;
        }
        else
        {
            $pRes = '';
        }





    } catch (ArmtekException $e) {

       // $json_responce_data = $e -> getMessage();

    }



    return $pRes;
}



?>