
<?php


if (isset($_GET['artid']))
{
    $ArtId = $_GET['artid'];
    $ArtId = trim($ArtId);
}
if (isset($_POST['artid']))
{
    $ArtId = $_POST['artid'];
    $ArtId = trim($ArtId);
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


// POST - запрос
/*
$data = array('artid'=>$ArtId,'userid'=>$pUserId,'password'=>$pPassword);
$myCurl = curl_init();
curl_setopt_array($myCurl, array(
    CURLOPT_URL => 'http://dailysnab.beget.tech/qrq/autopiter/result.php',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query($data)
));
$response = curl_exec($myCurl);
curl_close($myCurl);
*/


// GET - запрос
$response = file_get_contents('http://dailysnab.beget.tech/qrq/autopiter/api/result.php?artid='.$ArtId.'&userid='.$pUserId.'&password='.$pPassword);


// Пример вывода на экран
$txt_result = json_decode($response);
foreach ($txt_result as $item)
{

    if ($item->product == 0)
    {
        echo "<b>Запрошенный номер</b>";
        echo "<br>";
    }
    if ($item->product == 1)
    {
        echo "<b>Аналоги</b>";
        echo "<br>";
    }


    $iteminfo = $item->info;
    foreach ($iteminfo as $iteminfo1)
    {
        $pRegion = $iteminfo1->Region;
        echo "Регион паставщика = ".$pRegion;
        echo "<br>";

        $pCatalogName = $iteminfo1->Brand;
        echo "Производитель = ".$pCatalogName;
        echo "<br>";

        $pNumber = $iteminfo1->Number;
        echo "Номер = ".$pNumber;
        echo "<br>";

        $pName = $iteminfo1->Name;
        echo "Наименование = ".$pName;
        echo "<br>";

        $pNumberOfAvailable = $iteminfo1->NumberOfAvailable;
        echo "Наличае (шт) = ".$pNumberOfAvailable;
        echo "<br>";

        $pNumberOfDaysSupply = $iteminfo1->NumberOfDaysSupply;
        echo "Срок (дн) = ".$pNumberOfDaysSupply;
        echo "<br>";

        $pSalePrice = $iteminfo1->SalePrice;
        echo "Цена = ".$pSalePrice;
        echo "<br>";

        $pRealTimeInProc = $iteminfo1->RealTimeInProc;
        echo "Процент успешных заказов в % = ".$pRealTimeInProc;
        echo "<br>";
        echo "<br>";
    }


    echo "<br>";
    echo "<br>";

}




?>



