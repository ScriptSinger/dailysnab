<?php


// http://dailysnab.beget.tech/qrq/armtek/api/result.php?artid=105310&userid=snabdaily@gmail.com&password=Ar299792458&brand=LE.MA.


use ArmtekRestClient\Http\Exception\ArmtekException as ArmtekException;
use ArmtekRestClient\Http\Config\Config as ArmtekRestClientConfig;
use ArmtekRestClient\Http\ArmtekRestClient as ArmtekRestClient;


function fResult($pUserId, $pPassword, $pArtId, $pBrand, $pPrice, $pSklad)
{



    try {


        require_once 'funUserVkorgList.php';
        $pVkorg = fUserVkorgList($pUserId, $pPassword);

        $pResult = 0;
        if ($pVkorg!='')
        {
            require_once 'funUserInfo.php';
            $pStrInfo = fUserInfo($pUserId, $pPassword, $pVkorg);
            $pKUNNR1 = fUserInfoKUNNR1($pStrInfo);
            $pKUNNR2 = fUserInfoKUNNR2($pStrInfo);


            // require_once 'funStoreList.php';
            //  $pStoreList = fStoreList($pUserId, $pPassword, $pVkorg);


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


            // init configuration
            $armtek_client_config = new ArmtekRestClientConfig($user_settings);

            // init client
            $armtek_client = new ArmtekRestClient($armtek_client_config);


            $params = [
                'VKORG'         => ''
                ,'KUNNR_RG'     => $pKUNNR1
                ,'PIN'          => $pArtId
                ,'BRAND'        => $pBrand
                ,'QUERY_TYPE'   => '2'
                ,'KUNNR_ZA'     => $pKUNNR2
                ,'INCOTERMS'    => '0'
                ,'VBELN'        => ''
            ];

            // requeest params for send
            $request_params = [

                'url' => 'search/search',
                'params' => [
                    'VKORG'         => !empty($params['VKORG'])?$params['VKORG']:(isset($ws_default_settings['VKORG'])?$ws_default_settings['VKORG']:'')
                    ,'KUNNR_RG'     => isset($params['KUNNR_RG'])?$params['KUNNR_RG']:(isset($ws_default_settings['KUNNR_RG'])?$ws_default_settings['KUNNR_RG']:'')
                    ,'PIN'          => isset($params['PIN'])?$params['PIN']:''
                    ,'BRAND'        => isset($params['BRAND'])?$params['BRAND']:''
                    ,'QUERY_TYPE'   => isset($params['QUERY_TYPE'])?$params['QUERY_TYPE']:''
                    ,'KUNNR_ZA'     => isset($params['KUNNR_ZA'])?$params['KUNNR_ZA']:(isset($ws_default_settings['KUNNR_ZA'])?$ws_default_settings['KUNNR_ZA']:'')
                    ,'INCOTERMS'    => isset($params['INCOTERMS'])?$params['INCOTERMS']:(isset($ws_default_settings['INCOTERMS'])?$ws_default_settings['INCOTERMS']:'')
                    ,'VBELN'        => isset($params['VBELN'])?$params['VBELN']:(isset($ws_default_settings['VBELN'])?$ws_default_settings['VBELN']:'')
                    ,'format'       => 'json'
                ]

            ];

            // send data
            $response = $armtek_client->post($request_params);

            // in case of json
            $json_responce_data = $response->json();


            $pResult = 0;
            $items1 = $json_responce_data->RESP;
            // Результат
            if (is_array($items1))
            {


                foreach ($items1 as $item1)
                {

                    $wBrand = $item1->BRAND;
                    $wPrice = $item1->PRICE;
                    $wSklad = $item1->KEYZAK;

                    if ( ($wBrand == $pBrand) and ($wPrice == $pPrice) and ($wSklad == $pSklad))
                    {
                        $pResult = 1;
                    }

                }

            }
            else
            {

                $wBrand = $items1->BRAND;
                $wPrice = $items1->PRICE;
                $wSklad = $items1->KEYZAK;

                if ( (mb_strtoupper($wBrand) == mb_strtoupper($pBrand)) and ($wPrice == $pPrice) and ($wSklad == $pSklad))
                {
                    $pResult = 1;
                }


            }


            return trim($pResult);


        }




    } catch (ArmtekException $e) {


    }

}



?>