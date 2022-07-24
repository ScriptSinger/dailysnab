
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



/*
echo "<br>";
$pArtNameURL = idn_to_utf8('https://autopiter.ru/goods/'.$pArtName);
//echo idn_to_utf8('https://autopiter.ru/goods/'.$pArtName);
echo "<br>";
//echo $pArtNameURL;
echo "<br>";

*/

// ��� - 1
//$pCont = file_get_contents('https://autopiter.ru/goods/'.$pArtName);
/*
echo "111";

$str1 = "ÑÑÑÐ»ÐºÐ°";
         Ñ„Ñ‚ÑƒÐ»ÐºÐ°
echo "<br>";
echo $str1;

$pDect = 'detected = '.mb_detect_encoding($str1);
echo "<br>";
echo $pDect;

// конветим
$fuck = mb_convert_encoding($str1, 'WINDOWS-1252');
echo "<br>";
echo '1 = '.$fuck;
*/


//$str = 'фтулка';
//$fuck = mb_convert_encoding($str, 'UTF-8');
//echo "<br>";
//echo '2 = '.$fuck;

//$fuck = $str;

/*
echo "<br>";
echo "123 000000 wqe00";
echo "<br>";
*/

// https://itel-app.ru/example/autopiter/parser/offers_test.php
// https://it-el.ru/example/autopiter/parser/offers_test.php
// http://dailysnab.beget.tech/qrq/autopiter/parser/offers_test.php?artname=1234


$ddd = 'https://autopiter.ru/goods/фтулка';
//$ddd = mb_convert_encoding($ddd, 'UTF-8');
//$ddd = mb_convert_encoding($ddd, 'UTF-8', 'ANSI');
//$text = iconv('WINDOWS-1252', 'UTF-8//IGNORE', $ddd);
//$text = iconv('UTF-8', 'ANSI', $ddd);
//$ddd = 'https://autopiter.ru/goods/фтулка';

//mb_detect_encoding($ddd, array('UTF-8', 'Windows-1251', 'KOI8-R', 'ISO-8859-5'));

//$text = $ddd;
/*
 *
 byte2be
byte2le
byte4be
byte4le
  UCS-4*
UCS-4BE
UCS-4LE*
UCS-2
UCS-2BE
UCS-2LE
UTF-32*
UTF-32BE*
UTF-32LE*
UTF-16*
UTF-16BE*
UTF-16LE*

UTF7-IMAP

ASCII*
EUC-JP*
SJIS*
eucJP-win*
SJIS-win*
ISO-2022-JP
ISO-2022-JP-MS


SJIS-Mobile#DOCOMO** (alias: SJIS-DOCOMO)
SJIS-Mobile#KDDI** (alias: SJIS-KDDI)
SJIS-Mobile#SOFTBANK** (alias: SJIS-SOFTBANK)
UTF-8-Mobile#DOCOMO** (alias: UTF-8-DOCOMO)



 */

$ddd = "фтулка";
//$text = idn_to_ascii($ddd);

//$text = idn_to_utf8($ddd);

$text = iconv('UTF-8*', 'UTF-8', $ddd);

//$text = $ddd;

//$text ='';

echo "<br>";
echo 'super = '.$text;
echo "<br>";
echo '333';
echo "<br>";

$text = "https://autopiter.ru/goods/".$text." ";


$pCont = file_get_contents($text);
$pContHtml = htmlspecialchars($pCont);

  //  echo $pContHtml;

/*
echo "<br>";
echo "<br>";
echo $pContHtml;
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


// ��� - 2
$pLenCon2 = strlen($pStr1);
$pFind2 = "{";
$pPos2 = strpos($pStr1, $pFind2);
$pStr2 = substr($pStr1, $pPos2, $pLenCon2-$pPos2);


// ��� - 3
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


        echo "<br>";
        echo "<br>";
        print_r($xStrT);
        echo "<br>";
        echo "<br>";


        $item1 = json_decode($xStrT);

        $InfoArrayDop = array(
            "ArticleId" => $item1->articleId,
            "CatalogName" => $item1->brandName,
            "Name" => $item1->name,
            "BrandUrl" => $item1->brandUrl
        );

        $InfoArray[] = $InfoArrayDop;


    }


}


$json = json_encode($InfoArray, JSON_UNESCAPED_UNICODE);
echo $json;



?>


