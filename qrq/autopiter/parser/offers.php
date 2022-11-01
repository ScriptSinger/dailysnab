

<?php

// http://dailysnab.beget.tech/qrq/autopiter/parser/offers.php?artname=фтулка

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



// ШАГ - 1
$pArtNameUrl = urlencode($pArtName);
$pCont = file_get_contents('https://autopiter.ru/goods/'.$pArtNameUrl);
$pContHtml = htmlspecialchars($pCont);


$pContHtml = str_replace('&amp;', '&', $pContHtml);
$pContHtml = str_replace('&quot;', '"', $pContHtml);
$pContHtml = str_replace('&lt;', '<', $pContHtml);
$pContHtml = str_replace('&gt;', '>', $pContHtml);




$pLenCon1 = strlen($pContHtml);

$pFind1 = "window['__INITIAL_STATE__']";
$pPos1 = strpos($pContHtml, $pFind1);
$pStr1 = substr($pContHtml, $pPos1, $pLenCon1-$pPos1);


// ШАГ - 2
$pLenCon2 = strlen($pStr1);
$pFind2 = "{";
$pPos2 = strpos($pStr1, $pFind2);
$pStr2 = substr($pStr1, $pPos2, $pLenCon2-$pPos2);


// ШАГ - 3
$pLenCon3 = strlen($pStr2);
$pFind3 = "/script";
$pPos3 = strpos($pStr2, $pFind3);
$pStr3 = substr($pStr2, 0, $pPos3);


$pLenCount = strlen($pStr3);

$xStr = $pStr3;
$xPosBegin = 0;
$xPosEnd = 0;
$x=0;
while ($x<$pLenCount)
{
    $x++;


    $xPosBegin = strpos($xStr, 'articleId');
    $xStr = substr($xStr, $xPosBegin-2, $pLenCount);
    $xPosEnd = strpos($xStr, ']}');


    if ( ($xPosBegin>0) and ($xPosEnd>0) )
    {
        $xStrT = substr($xStr, 0, $xPosEnd+2);
        $xStr = substr($xStr, $xPosEnd, $pLenCount);

        $xStrT = $xStrT;
        $xStrT = trim($xStrT);
        $xStrT = (string)$xStrT;

        $item1 = json_decode($xStrT);

        $InfoArrayDop = array(
            "ArticleId" => $item1->articleId,
            "Brand" => $item1->brandName,
            "Name" => $item1->name,
            "BrandUrl" => $item1->brandUrl
        );

        $InfoArray[] = $InfoArrayDop;

    }


}


$json = json_encode($InfoArray, JSON_UNESCAPED_UNICODE);
echo $json;



?>




