<?php

// https://questrequest.ru/qrq/amo/basket.php?token=5c30e99e8ca9dd0904c92855622d075435c86b62&accountid=1600536

$pParam = '';
$pToken = '';
$pAccountId = '';
$pAmount = '';
$pBuy_sell_id = '';
$pWhere = '';



if (isset($_GET['token']))
{
    $pToken = $_GET['token'];
    $pToken = trim($pToken);
}
if (isset($_POST['token']))
{
    $pToken = $_POST['token'];
    $pToken = trim($pToken);
}

if (isset($_GET['accountid']))
{
    $pAccountId = $_GET['accountid'];
    $pAccountId = trim($pAccountId);
}
if (isset($_POST['accountid']))
{
    $pAccountId = $_POST['accountid'];
    $pAccountId = trim($pAccountId);
}

/*Димы*/
if (isset($_GET['amount']))
{
    $pAmount = $_GET['amount'];
    $pAmount = trim($pAmount);
}
if (isset($_GET['buy_sell_id']))
{
    $pBuy_sell_id = $_GET['buy_sell_id'];
    $pBuy_sell_id = trim($pBuy_sell_id);
}
if (isset($_GET['where']))
{
    $pWhere = $_GET['where'];
    $pWhere = trim($pWhere);
}
if (isset($_POST['amount']))
{
    $pAmount = $_POST['amount'];
    $pAmount = trim($pAmount);
}
if (isset($_POST['buy_sell_id']))
{
    $pBuy_sell_id = $_POST['buy_sell_id'];
    $pBuy_sell_id = trim($pBuy_sell_id);
}
if (isset($_POST['where']))
{
    $pWhere = $_POST['where'];
    $pWhere = trim($pWhere);
}



$postData = array(
    'Request'=>array(
        'RequestData'=>array(
            'accountId'=>$pAccountId
        )
    )
);


$context = stream_context_create(array(
    'http' => array(
        'method' => 'POST',
        'header' => "Authorization: Bearer {$pToken}\r\n".
            "Content-Type: application/json\r\n",
        'content' => json_encode($postData)
    )
));


$response = file_get_contents('https://userapi.qwep.ru/basket', false, $context);
//$Resp = json_decode($response, JSON_UNESCAPED_UNICODE);
$Resp = json_decode($response,true);



function fnCountMass($pJson, $pPapaId)
{
    
  $pCount = count($pJson);

  foreach ($pJson as $pValueStr) 
  {

     $pCountOptions = count($pValueStr['options']);
     $pCountFields = count($pValueStr['fields']);
     $pValue = $pValueStr['value'];
     $pOptions = $pValueStr['options'];
     $pFieldId = $pValueStr['fieldId'];
     $pFields = $pValueStr['fields'];
     $pTitle = $pValueStr['title'];
     $pText = $pValueStr['text'];
     $pTypeName = $pValueStr['typeName'];
     $pFieldName = $pValueStr['fieldName'];
     
     
     echo 'soska = '.$pPapaId;
     $pAllText = $pTypeName.' - '.$pFieldName.' - '.$pFieldId;
     
     

     $pPapaId = strlen($pPapaId);
     if ($pPapaId>0)
     {
        echo "papa = ".$pPapaId;
        echo '<script>';
        echo ' var insSelect = document.getElementById("select'.$pPapaId.'"); ';
        echo ' var insOption = document.createElement("option"); ';
        echo " insOption.innerHTML = '".$pTitleText.'-'.$pValue.'='.$pCountFields."'; "; 
        echo " insOption.value = '".$pValue."'; ";
        echo " insSelect.append(insOption); ";
        echo '</script>';
        
        if ($pCountFields>0)
        {
     //       fnCountMass($pFields,$pValue,$pValue);
        }
        
     }

     if ($pCountOptions>0)
     {
        echo "<div style='border:1px solid #000000; margin-top: 5px'>";
        echo $pTitle; 
        echo "<br>";
        echo $pAllText.' => '.$pFieldId;
        echo "<br>";
        
        echo '<select id="select'.$pFieldId.'">';
        echo '</select>';
        fnCountMass($pOptions,$pFieldId);
        echo "</div>";
     }
     
     
     if ( ($pCountOptions==0) && ($pCountFields==0) )
     {
         
         if ($pTypeName=='InputField')
         {
            echo "<div style='border:1px solid #000000; margin-top: 5px'>";
            echo $pTitle; 
            echo "<br>";
            echo $pAllText;
            echo "<br>";
            
            echo '<input type="text" />';
            echo "</div>";
         }
         if ($pTypeName=='TextareaField')
         {
            echo "<div style='border:1px solid #000000; margin-top: 5px'>";
            echo $pTitle; 
            echo "<br>";
            echo $pAllText;
            echo "<br>";

            echo '<textarea ></textarea>';
            echo "</div>";
         }
     }     
          
     
     
     
     /*
     $pAllText = $pTypeName.' - '.$pFieldId.' + '.$pEndtId;

     if (strlen($pTitle)>0)
     {
       $pTitleText = $pTitle;  
     }
     if (strlen($pText)>0)
     {
       $pTitleText = $pText;  
     }

     
     $pBeginLen = strlen($pBeginId);
     if ($pBeginLen>0)
     {

        echo '<script>';
        echo ' var insSelect = document.getElementById("select'.$pBeginId.'"); ';
        echo ' var insOption = document.createElement("option"); ';
        echo " insOption.innerHTML = '".$pTitleText.'-'.$pValue."'; "; 
        echo " insOption.value = '".$pValue."'; ";
        echo " insSelect.append(insOption); ";
        echo '</script>';
        
        if ($pCountFields>0)
        {
            fnCountMass($pFields,$pValue,$pValue);
        }
        
     }
     
     if ($pCountOptions>0)
     {
        echo "<br>";
        echo $pTitle; 
        echo "<br>";
        echo $pAllText.' => '.$pFieldId;
        echo "<br>";
        
        echo '<select id="select'.$pFieldId.'">';
        echo '</select>';
        fnCountMass($pOptions,$pFieldId,'');
        echo "<br>";
     }
     
     if ( ($pCountOptions==0) && ($pCountFields==0) )
     {
         
         if ($pTypeName=='InputField')
         {
            echo $pTitle; 
            echo "<br>";
            echo $pAllText;
            echo "<br>";
            
            echo '<input type="text" />';
            echo "<br>";
         }
         if ($pTypeName=='TextareaField')
         {
            echo "<br>";
            echo $pTitle; 
            echo "<br>";
            echo $pAllText;
            echo "<br>";

            echo '<textarea ></textarea>';
            echo "<br>";
         }
     }
     */
     
     
  } 
  
  
}
  
  echo "111";
  echo "<br><br>";

  // основной массив
  $pOsn = $Resp['Response']['entity']['baskets'][0]['basketForm']['fields'];
  

  fnCountMass($pOsn,'');




  
  
  echo "<br><br>";
  
 // print_r($serg);
  echo "<br><br>";
  echo "222";
  echo "<br><br>";

  
  echo "<br><br>";
  echo "<pre>";
  print_r($Resp);
  echo "</pre>";
  echo "<br><br>";
  
  
?>




