<?php


// http://dailysnab.beget.tech/qrq/armtek/api/offers.php?artname=105310&userid=snabdaily@gmail.com&password=Ar299792458

// http://dailysnab.beget.tech/qrq/armtek/api/offers.php?artname=4585272404&userid=snabdaily@gmail.com&password=Ar299792458



if (isset($_GET['artname']))
{
    $pArtName = $_GET['artname'];
    $pArtName = trim($pArtName);
}
if (isset($_POST['artname']))
{
    $pArtName = $_POST['artname'];
    $pArtName = trim($pArtName);
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





use ArmtekRestClient\Http\Exception\ArmtekException as ArmtekException;
use ArmtekRestClient\Http\Config\Config as ArmtekRestClientConfig;
use ArmtekRestClient\Http\ArmtekRestClient as ArmtekRestClient;


try {

    require_once 'autoloader.php';


    require_once 'funUserVkorgList.php';
    $pVkorg = fUserVkorgList($pUserId, $pPassword);

    if ($pVkorg!='')
    {
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




        // init configuration
        $armtek_client_config = new ArmtekRestClientConfig($user_settings);

        // init client
        $armtek_client = new ArmtekRestClient($armtek_client_config);



        $params = [
            'VKORG'         => ''
            ,'PIN'          => $pArtName
            ,'PROGRAM'        => ''
        ];


        // requeest params for send
        $request_params = [

            'url' => 'search/assortment_search',
            'params' => [
                'VKORG'         => !empty($params['VKORG'])?$params['VKORG']:(isset($ws_default_settings['VKORG'])?$ws_default_settings['VKORG']:'')
                ,'PIN'          => isset($params['PIN'])?$params['PIN']:''
                ,'PROGRAM'       => isset($params['PROGRAM'])?$params['PROGRAM']:''
                ,'format'       => 'json'
            ]

        ];


        // send data
        $response = $armtek_client->post($request_params);

        // in case of json
        $json_responce_data = $response->json();




        $json_responce_data = $json_responce_data->RESP;
        $mes = '';
        if (isset($json_responce_data->MSG))
        {
            // Нет данных
            $mes = $json_responce_data->MSG;
        }


        if (strlen($mes)==0)
        {

            foreach ($json_responce_data as $item)
            {

                $InfoArrayDop = array(
                    "ArticleId" => $item->PIN,
                    "Brand" => $item->BRAND,
                    "Name" => $item->NAME
                );

                $InfoArray[] = $InfoArrayDop;

            }


            $json = json_encode($InfoArray, JSON_UNESCAPED_UNICODE);
            echo $json;

        }


    }





} catch (ArmtekException $e) {

   // $json_responce_data = $e -> getMessage();

}



?>