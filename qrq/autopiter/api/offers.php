<?php


// http://dailysnab.beget.tech/qrq/autopiter/api/offers.php?artname=1769800&userid=656881&password=123456
// 409052
//

$pUserId = 0;
$pPassword = 0;

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

echo '000';

try
{
    echo '1111';

    require_once "connect.php";
    $client = fConnected($pUserId, $pPassword);

    print_r($client);

    $result = $client->FindCatalog(array("Number"=>$pArtName));
    $items = $result->FindCatalogResult->SearchCatalogModel;


    // Предложения
    if (is_array($items))
    {
        foreach ($items as $item)
        {
            $InfoArrayDop = array(
                "ArticleId" => $item->ArticleId,
                "Brand" => $item->CatalogName,
                "Name" => $item->Name
            );

            $InfoArray[] = $InfoArrayDop;
        }
    }
    else
    {
        $InfoArrayDop = array(
            "ArticleId" => $items->ArticleId,
            "Brand" => $items->CatalogName,
            "Name" => $items->Name
        );

        $InfoArray[] = $InfoArrayDop;

    }


    $json = json_encode($InfoArray, JSON_UNESCAPED_UNICODE);
    echo $json;

}
catch(Exception $e)
{

}



?>