<?php


// http://dailysnab.beget.tech/qrq/armtek/api/result.php?artid=105310&userid=snabdaily@gmail.com&password=Ar299792458&brand=LE.MA.

// http://dailysnab.beget.tech/qrq/armtek/api/result.php?artid=4585272404&userid=snabdaily@gmail.com&password=Ar299792458&brand=РФ



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





use ArmtekRestClient\Http\Exception\ArmtekException as ArmtekException;
use ArmtekRestClient\Http\Config\Config as ArmtekRestClientConfig;
use ArmtekRestClient\Http\ArmtekRestClient as ArmtekRestClient;




try {


    require_once 'funUserVkorgList.php';
    $pVkorg = fUserVkorgList($pUserId, $pPassword);

    if ($pVkorg!='')
    {
        require_once 'funUserInfo.php';
        $pStrInfo = fUserInfo($pUserId, $pPassword, $pVkorg);
        $pKUNNR1 = fUserInfoKUNNR1($pStrInfo);
        $pKUNNR2 = fUserInfoKUNNR2($pStrInfo);

        require_once 'funStoreList.php';
        $pStoreList = fStoreList($pUserId, $pPassword, $pVkorg);


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




        $items1 = $json_responce_data->RESP;
        // Результат
        if (is_array($items1))
        {



            foreach ($items1 as $item1)
            {


                $pRegion1 = $item1->KEYZAK;
                foreach ($pStoreList as $itemList)
                {
                    if($itemList->KEYZAK == $pRegion1 )
                    {
                        $pRegion = $itemList->SKLNAME;
                        break;
                    }
                }


                $pDate = substr($item1->DLVDT,0,8)-date('Ymd');
                $InfoArrayDop = array(
                    "Region" => $pRegion, // Регион паставщика
                    "Brand" => $item1->BRAND, //, // Производитель
                    "Number" => $item1->PIN, // Номер
                    "Name" => $item1->NAME, // Наименование
                    "NumberOfAvailable" => $item1->RVALUE, // Наличае (шт)
                    "NumberOfDaysSupply" => $pDate, // Срок (дн)
                    "SalePrice" => $item1->PRICE, // Цена
                    "RealTimeInProc" => $item1->VENSL, // процент успешных заказов в %
                    "CodeSklad" => $item1->KEYZAK // процент успешных заказов в %
                );


                $InfoArray[] = $InfoArrayDop;
            }
        }
        else
        {

            $pRegion1 = $items1->KEYZAK;
            foreach ($pStoreList as $itemList)
            {
                if($itemList->KEYZAK == $pRegion1 )
                {
                    $pRegion = $itemList->SKLNAME;
                    break;
                }
            }

            $pDate = substr($items1->DLVDT,0,8)-date('Ymd');
            $InfoArrayDop = array(
                "Region" => $pRegion, // Регион паставщика
                "Brand" => $items1->BRAND, //, // Производитель
                "Number" => $items1->PIN, // Номер
                "Name" => $items1->NAME, // Наименование
                "NumberOfAvailable" => $items1->RVALUE, // Наличае (шт)
                "NumberOfDaysSupply" => $pDate, // Срок (дн)
                "SalePrice" => $items1->PRICE, // Цена
                "RealTimeInProc" => $items1->VENSL, // процент успешных заказов в %
                "CodeSklad" => $items1->KEYZAK // процент успешных заказов в %
            );

            $InfoArray[] = $InfoArrayDop;

        }

        // Запрошенный номер
        $InfoArrayAll = array(
            "product" => "0",
            "info" => $InfoArray
        );
        $InfoArrayJson[] = $InfoArrayAll;


        $json = json_encode($InfoArrayJson, JSON_UNESCAPED_UNICODE);
        echo $json;


    }




} catch (ArmtekException $e) {

//    $json_responce_data = $e -> getMessage();

}



?>