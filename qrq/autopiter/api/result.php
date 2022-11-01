
<?php


// http://dailysnab.beget.tech/qrq/autopiter/api/result.php?artid=48436969&userid=656881&password=123456



$pUserId = 0;
$pPassword = 0;

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


try
{

    require_once "connect.php";
    $client = fConnected($pUserId, $pPassword);


    //$result = $client->GetPriceId(array("ArticleId"=>$pArtId,"DetailUid"=>null,"SearchCross"=>0));
    $result = $client->GetPriceId(array("ArticleId"=>$pArtId,"SearchCross"=>0));
    $items = $result->GetPriceIdResult->PriceSearchModel;

    $x1 = 0;
    // Результат
    if (is_array($items))
    {
        foreach ($items as $item)
        {
            $pStoreTypeOrig = $item->StoreType;
            if ( ($pStoreTypeOrig==0) or ($pStoreTypeOrig==1) or ($pStoreTypeOrig==4) )
            {
                $InfoArrayDop = array(
                    "DetailId" => $item->DetailUid, // ID детали
                    "Region" => $item->Region, // Регион паставщика
                    "Brand" => $item->CatalogName, // Производитель
                    "Number" => $item->Number, // Номер
                    "Name" => $item->Name, // Наименование
                    "NumberOfAvailable" => $item->NumberOfAvailable, // Наличае (шт)
                    "NumberOfDaysSupply" => $item->NumberOfDaysSupply, // Срок (дн)
                    "SalePrice" => $item->SalePrice, // Цена
                    "RealTimeInProc" => $item->RealTimeInProc // процент успешных заказов в %
                );

                $x1 = $x1 + 1;
                $InfoArray[] = $InfoArrayDop;
            }
        }
    }
    else
    {
        $pStoreTypeOrig = $items->StoreType;
        if ( ($pStoreTypeOrig==0) or ($pStoreTypeOrig==1) or ($pStoreTypeOrig==4) )
        {
            $InfoArrayDop = array(
                "DetailId" => $items->DetailUid, // ID детали
                "Region" => $items->Region, // Регион паставщика
                "Brand" => $items->CatalogName, // Производитель
                "Number" => $items->Number, // Номер
                "Name" => $items->Name, // Наименование
                "NumberOfAvailable" => $items->NumberOfAvailable, // Наличае (шт)
                "NumberOfDaysSupply" => $items->NumberOfDaysSupply, // Срок (дн)
                "SalePrice" => $items->SalePrice, // Цена
                "RealTimeInProc" => $items->RealTimeInProc // процент успешных заказов в %
            );

            $x1 = $x1 + 1;

            $InfoArray[] = $InfoArrayDop;
        }
    }




    //$result1 = $client->GetPriceId(array("ArticleId"=>$pArtId,"DetailUid"=>null,"SearchCross"=>1));
    $result1 = $client->GetPriceId(array("ArticleId"=>$pArtId,"SearchCross"=>1));
    $items1 = $result1->GetPriceIdResult->PriceSearchModel;

    $x2 = 0;
    // Результат
    if (is_array($items1))
    {
        foreach ($items1 as $item1)
        {
            $pStoreTypeAn = $item1->StoreType;
            if ( ($pStoreTypeOrig!=0) or ($pStoreTypeOrig!=1) or ($pStoreTypeOrig!=4) )
            {
                $InfoArrayDop1 = array(
                    "DetailId" => $item1->DetailUid, // ID детали
                    "Region" => $item1->Region, // Регион паставщика
                    "Brand" => $item1->CatalogName, // Производитель
                    "Number" => $item1->Number, // Номер
                    "Name" => $item1->Name, // Наименование
                    "NumberOfAvailable" => $item1->NumberOfAvailable, // Наличае (шт)
                    "NumberOfDaysSupply" => $item1->NumberOfDaysSupply, // Срок (дн)
                    "SalePrice" => $item1->SalePrice, // Цена
                    "RealTimeInProc" => $item1->RealTimeInProc // процент успешных заказов в %
                );

                $x2 = $x2 + 1;

                $InfoArray1[] = $InfoArrayDop1;
            }
        }
    }
    else
    {
        $pStoreTypeAn = $items1->StoreType;
        if ( ($pStoreTypeOrig!=0) or ($pStoreTypeOrig!=1) or ($pStoreTypeOrig!=4) )
        {
            $InfoArrayDop1 = array(
                "DetailId" => $items1->DetailUid, // ID детали
                "Region" => $items1->Region, // Регион паставщика
                "Brand" => $items1->CatalogName, // Производитель
                "Number" => $items1->Number, // Номер
                "Name" => $items1->Name, // Наименование
                "NumberOfAvailable" => $items1->NumberOfAvailable, // Наличае (шт)
                "NumberOfDaysSupply" => $items1->NumberOfDaysSupply, // Срок (дн)
                "SalePrice" => $items1->SalePrice, // Цена
                "RealTimeInProc" => $items1->RealTimeInProc // процент успешных заказов в %
            );

            $x2 = $x2 + 1;

            $InfoArray1[] = $InfoArrayDop1;
        }


    }




    // Запрошенный номер
    if (is_array($InfoArray))
    {
        $InfoArrayAll = array(
            "product" => "0",
            "info" => $InfoArray
        );
        $InfoArrayJson[] = $InfoArrayAll;
    }


    // Аналоги
    if (is_array($InfoArray1))
    {
        $InfoArrayAll = array(
            "product" => "1",
            "info" => $InfoArray1
        );
        $InfoArrayJson[] = $InfoArrayAll;
    }




    $json = json_encode($InfoArrayJson, JSON_UNESCAPED_UNICODE);
    echo $json;
}
catch(Exception $e)
{

}





?>