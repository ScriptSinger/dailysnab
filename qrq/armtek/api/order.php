<?php

// http://dailysnab.beget.tech/qrq/armtek/api/order.php?artid=105310&userid=snabdaily@gmail.com&password=Ar299792458&price=10&count=1&codesklad=MOV0000013&brand=LE.MA.

// http://dailysnab.beget.tech/qrq/armtek/api/order.php?artid=4585272404&userid=snabdaily@gmail.com&password=Ar299792458&price=791.70&count=1&codesklad=0000135777&brand=COSIBO



if (isset($_GET['artid']))
{
    $pArtId = $_GET['artid'];
    $pArtId = trim($pArtId);
}
if (isset($_POST['artid']))
{
    $pArtId = $_POST['artid'];
    $pArtId = trim($pArtId);
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

if (isset($_GET['brand']))
{
    $pBrand = $_GET['brand'];
    $pBrand = trim($pBrand);
}
if (isset($_POST['brand']))
{
    $pBrand = $_POST['brand'];
    $pBrand = trim($pBrand);
}

if (isset($_GET['codesklad']))
{
    $pCodeSklad = $_GET['codesklad'];
    $pCodeSklad = trim($pCodeSklad);
}
if (isset($_POST['codesklad']))
{
    $pCodeSklad = $_POST['codesklad'];
    $pCodeSklad = trim($pCodeSklad);
}

if (isset($_GET['count']))
{
    $pCount = $_GET['count'];
    $pCount = trim($pCount);
}
if (isset($_POST['count']))
{
    $pCount = $_POST['count'];
    $pCount = trim($pCount);
}


if (isset($_GET['price']))
{
    $pPrice = $_GET['price'];
    $pPrice = trim($pPrice);
}
if (isset($_POST['price']))
{
    $pPrice = $_POST['price'];
    $pPrice = trim($pPrice);
}


use ArmtekRestClient\Http\Exception\ArmtekException as ArmtekException;
use ArmtekRestClient\Http\Config\Config as ArmtekRestClientConfig;
use ArmtekRestClient\Http\ArmtekRestClient as ArmtekRestClient;


try {

    require_once 'funUserVkorgList.php';
    $pVkorg = fUserVkorgList($pUserId, $pPassword);

    require_once 'funResult.php';
    $pResultOk = fResult($pUserId, $pPassword, $pArtId, $pBrand, $pPrice, $pCodeSklad);


    if ( ($pVkorg!='') and ($pResultOk == 1) )
    {
        require_once 'funUserInfo.php';
        $pStrInfo = fUserInfo($pUserId, $pPassword, $pVkorg);
        $pKUNNR1 = fUserInfoKUNNR1($pStrInfo);
        $pKUNNR2 = fUserInfoKUNNR2($pStrInfo);
        $pKUNWE = fUserInfoKUNWE($pStrInfo);
        $pPARNR = fUserInfoPARNR($pStrInfo);
        $pVBELN = fUserInfoVBELN($pStrInfo);


        $user_settings = array(
            'user_login'         => $pUserId   // логин
        ,'user_password'     => $pPassword  // пароль
        );

        $ws_default_settings = array(
            'VKORG'         => $pVkorg
        ,'KUNNR_RG'     => ''
        ,'KUNNR_WE'     => ''
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
            'VKORG'         => $pVkorg
            ,'KUNNR_RG'     => $pKUNNR1
            ,'KUNNR_WE'     => $pKUNWE
            ,'KUNNR_ZA'     => $pKUNNR2
            ,'INCOTERMS'    => '0'
            ,'PARNR'        => $pPARNR
            ,'VBELN'        => $pVBELN
            ,'TEXT_ORD'     => ''
            ,'TEXT_EXP'     => ''
            ,'DBTYP'        => 3
        ];


        // requeest params for send
        $request_params = [

            'url' => 'order/createOrder',
            'params' => [
                'VKORG'             => !empty($params['VKORG'])?$params['VKORG']:(isset($ws_default_settings['VKORG'])?$ws_default_settings['VKORG']:'')
                ,'KUNRG'            => isset($params['KUNNR_RG'])?$params['KUNNR_RG']:(isset($ws_default_settings['KUNNR_RG'])?$ws_default_settings['KUNNR_RG']:'')
                ,'KUNWE'            => isset($params['KUNNR_WE'])?$params['KUNNR_WE']:(isset($ws_default_settings['KUNNR_WE'])?$ws_default_settings['KUNNR_WE']:'')
                ,'KUNZA'            => isset($params['KUNNR_ZA'])?$params['KUNNR_ZA']:(isset($ws_default_settings['KUNNR_ZA'])?$ws_default_settings['KUNNR_ZA']:'')
                ,'INCOTERMS'        => isset($params['INCOTERMS'])?$params['INCOTERMS']:(isset($ws_default_settings['INCOTERMS'])?$ws_default_settings['INCOTERMS']:'')
                ,'PARNR'            => isset($params['PARNR'])?$params['PARNR']:(isset($ws_default_settings['PARNR'])?$ws_default_settings['PARNR']:'')
                ,'VBELN'            => isset($params['VBELN'])?$params['VBELN']:(isset($ws_default_settings['VBELN'])?$ws_default_settings['VBELN']:'')
                ,'TEXT_ORD'         => isset($params['TEXT_ORD'])?$params['TEXT_ORD']:''
                ,'TEXT_EXP'         => isset($params['TEXT_EXP'])?$params['TEXT_EXP']:''
                ,'DBTYP'            => isset($params['DBTYP'])?$params['DBTYP']:''

                ,'ITEMS'        => [
                    0 => array(
                        'PIN'           => $pArtId
                    ,'BRAND'        => $pBrand
                    ,'KWMENG'       => $pCount
                    ,'KEYZAK'       => $pCodeSklad
                    ,'PRICEMAX'     => $pPrice
                    ,'DATEMAX'      => ''
                    ,'COMMENT'      => ''
                    ,'COMPL_DLV'    => ''
                    )
                ]
                ,'format'       => 'json'
            ]

        ];


        // send data
        $response = $armtek_client->post($request_params);

        // in case of json
        $json_responce_data = $response->json();

        $res = $json_responce_data->RESP;
        $item = $res->ITEMS;


        $pNum = 0;
        if (is_array($item))
        {

            foreach ($item as $item1)
            {
                $pResult1 = $item1->RESULT;

                foreach ($pResult1 as $item2)
                {
                    $pNum = $pNum + 1;
                    $pNumZakaz = $item2->VBELN;
                    $pBlock = $item2->BLOCK;
                    $pCount = $item2->KWMENG;
                    $pPrice = $item2->PRICE;

                    $InfoArrayDop = array(
                        "Zakaz" => $pNumZakaz, // Номер созданного заказа
                        "Block" => $pBlock, // Блокировка заказа
                        "Count" => $pCount, // Количество
                        "Price" => $pPrice, // Цена
                    );
                }
            }
        }


        if ($pNum > 0)
        {
            $InfoArrayJson[] = $InfoArrayDop;

            $json = json_encode($InfoArrayJson, JSON_UNESCAPED_UNICODE);
            echo $json;
        }


    }




} catch (ArmtekException $e) {

}


?>