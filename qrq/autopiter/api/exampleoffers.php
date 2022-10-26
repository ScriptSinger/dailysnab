

<?php

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



// POST - запрос
/*
$data = array('artname'=>$pArtName,'userid'=>$pUserId,'password'=>$pPassword);
$myCurl = curl_init();
curl_setopt_array($myCurl, array(
    CURLOPT_URL => 'http://dailysnab.beget.tech/qrq/autopiter/offers.php',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query($data)
));
$response = curl_exec($myCurl);
curl_close($myCurl);
*/


// GET - запрос
$response = file_get_contents('http://dailysnab.beget.tech/qrq/autopiter/api/offers.php?artname='.$pArtName.'&userid='.$pUserId.'&password='.$pPassword);


// Пример вывода на экран
$txt_result = json_decode($response);
foreach ($txt_result as $item)
{
    $pArticleId = $item->ArticleId;
    echo "ArticleId = ".$pArticleId;
    echo "<br>";

    $pCatalogName = $item->Brand;
    echo "Brand = ".$pCatalogName;
    echo "<br>";

    $pName = $item->Name;
    echo "Name = ".$pName;
    echo "<br>";
    echo "<br>";
}





?>


