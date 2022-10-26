
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

if (isset($_GET['brandurl']))
{
    $BrandUrl = $_GET['brandurl'];
    $BrandUrl = trim($BrandUrl);
}
if (isset($_POST['brandurl']))
{
    $BrandUrl = $_POST['brandurl'];
    $BrandUrl = trim($BrandUrl);
}





// remsa

// http://dailysnab.beget.tech/qrq/autopiter/parse/result.php?artname=1234&brandurl=remsa&artid=23473234
// http://dailysnab.beget.tech/qrq/autopiter/parser/result.php?artname=1234&brandurl=remsa&artid=23473234
// https://autopiter.ru/goods/1234/remsa/id23473234 23473234
// https://autopiter.ru/goods/1234/remsa/id23473234

$pTemp = 'https://autopiter.ru/goods/'.$pArtName.'/'.$BrandUrl.'/id'.$pArtId;
echo "<br>";
echo "<br>";
echo $pTemp;
echo "<br>";
echo "<br>";


// ШАГ - 1
$pCont = file_get_contents('https://autopiter.ru/goods/'.$pArtName.'/'.$BrandUrl.'/id'.$pArtId);
$pContHtml = htmlspecialchars($pCont);


/*
print_r($pContHtml);
echo "<br>";
echo "<br>";
*/

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
$pStr3 = substr($pStr2, 0, $pPos3-1);

/*
// ШАГ - 4
$pLenCon4 = strlen($pStr3);
$pFind4 = "itemsByDetailUid";
$pFindLen4 = strlen($pFind4)+2;
$pPos4 = strpos($pStr3, $pFind4);
$pStr4 = substr($pStr3, $pPos4+$pFindLen4, $pLenCon4 );
*/

// ШАГ - 4.1
$pLenCon111 = strlen($pStr3);
$pFind111 = "itemGroups";
$pFindLen111 = strlen($pFind111)+2;
$pPos111 = strpos($pStr3, $pFind111);
$pStr111 = substr($pStr3, $pPos111+$pFindLen111, $pLenCon111 );

// ШАГ - 4.2
$pLenCon222 = strlen($pStr111);
$pFind222 = "[";
$pFindLen222 = strlen($pFind222);
$pPos222 = strpos($pStr111, $pFind222);
$pStr222 = substr($pStr111, $pPos222+$pFindLen222, $pLenCon222 );

// ШАГ - 4.3
$pLenCon333 = strlen($pStr222);
$pFind333 = "]}";
$pFindLen333 = strlen($pFind333);
$pPos333 = strpos($pStr222, $pFind333);
$pStr333 = substr($pStr222, 0, $pPos333 );

$pStr333_all = array('['.$pStr333.']');


echo "<br>";
echo "<br>";
echo 'stroka = ';//.$pStr333_all;
echo "<br>";
echo "<br>";


foreach ( $pStr333_all as $director )
{
  echo $director . "<br />";
}


$pLenCount = strlen($pStr3);

/*
echo "<br>";
echo "<br>";
echo $pStr3;
echo "<br>";
echo "<br>";
*/

//  itemGroups


/*
$xStr = $pStr4;
$xPosBegin = 0;
$xPosEnd = 0;
$x=0;
while ($x<$pLenCount)
{
    $x++;


    $xPosBegin = strpos($xStr, 'detailUid');

    echo "<br>";
    echo $x." = ".$xPosBegin;
    echo "<br>";

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
*/

/*
$json = json_encode($InfoArray, JSON_UNESCAPED_UNICODE);
echo $json;
*/


?>