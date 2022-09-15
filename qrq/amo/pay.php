<?php


$test = substr($_POST['str'],1);
$pieces = explode(";", $test);

$Num = array();
foreach ($pieces as $value)
{
   // $Num = array("fieldName" => $value);

    $rtnum = 0;
    $super = explode(",", $value);
    foreach ($super as $superval)
    {
        $rtnum=$rtnum+1;
        if ($rtnum==1)
        {
            $q_fieldName = $superval;
        }
        if ($rtnum==2)
        {
            $q_value = $superval;

            if ($q_fieldName=='token')
            {
                $pToken = $q_value;
            }
            elseif ($q_fieldName=='FormId')
            {
                $pFormId = $q_value;
            }
            elseif ($q_fieldName=='pAccountId')
            {
                $pAccountId = $q_value;
            }
            elseif ($q_fieldName=='pBasketItemId')
            {
                $pBasketItemId[] = $q_value;
            }
            else
            {
                $Num = array("fieldName" => $q_fieldName,"value" => $q_value);
                $InfoArray[] = $Num;
            }

        }

    }

}


$restaccount = file_get_contents('https://questrequest.ru/qrq/amo/accounts.php?token='.$pToken.'&accountid='.$pAccountId);
if (strlen(trim($restaccount))>0)
{
    $restvendor = file_get_contents('https://questrequest.ru/qrq/amo/vendorsget.php?token='.$pToken.'&vid='.$restaccount);
}
else
{
    $restvendor = '';
}

if ( (strlen(trim($restaccount))>0) && (strlen(trim($restvendor))>0))
{



$mass = 1;
if(empty( $InfoArray ))
{
    $mass = 0;
}




if ($mass==1)
{
    $postData = array(
        'Request'=>array(
            'RequestData'=>array(
                'accountId'=>$pAccountId,
                'formId'=>$pFormId,
                /*'onlyItems'=>$pBasketItemId,*/
                'fieldValues'=>$InfoArray
            )
        )
    );
}
else
{
    $postData = array(
        'Request'=>array(
            'RequestData'=>array(
                'accountId'=>$pAccountId,
                'formId'=>$pFormId
            )
        )
    );
}




$context = stream_context_create(array(
    'http' => array(
        'method' => 'POST',
        'header' => "Authorization: Bearer {$pToken}\r\n".
            "Content-Type: application/json\r\n",
        'content' => json_encode($postData)
    )
));


$response = file_get_contents('https://userapi.qwep.ru/basket/order', FALSE, $context);
//$Resp = json_decode($response, JSON_UNESCAPED_UNICODE);



print_r($response);






}
else
{
    if ( strlen(trim($restaccount))==0 )
    {
        echo '111';
    }
    else
    {

        echo ('{"Response":{"errors":[{"code":"222","message":"AccountId='.$pAccountId.' ушел только в корзину","details":null}],"warnings":null}}');

    }
}



?>