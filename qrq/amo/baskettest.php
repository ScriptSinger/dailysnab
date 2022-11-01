<?php

// https://itel-app.ru/amo/basket.php?token=bb53bcac8486be2c36dde75ec9d9a7e354643d12&accountid=1534115

// https://questrequest.ru/qrq/amo/baskettest.php?token=3925f0954a22d5ee6ce68bb1cde6ee66ba369a96&accountid=1600299

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

$filename = 'logs/'.$pAccountId.'_basket_data.txt';
$fh = fopen($filename, 'w');
fwrite($fh, json_encode($postData, JSON_UNESCAPED_UNICODE));
fclose($fh);



$response = file_get_contents('https://userapi.qwep.ru/basket', false, $context);
//$Resp = json_decode($response, JSON_UNESCAPED_UNICODE);
$Resp = json_decode($response,true);
//$Resp = json_encode($response);

$filename = 'logs/'.$pAccountId.'_basket1.txt';
$fh = fopen($filename, 'w');
fwrite($fh, json_encode($response, JSON_UNESCAPED_UNICODE));
fclose($fh);


// print_r($Resp);


$error = $Resp['Response']['errors'];
$warnings = $Resp['Response']['warnings'];
$entity = $Resp['Response']['entity']['baskets']['0']['basketForm'];
$pFormId = $entity['formId'];
$pFormArray = $entity['fields'];


if ( ($error==null) and ($warnings==null) )
{

    echo '<select id="vSelect_0">';
    echo '  <option value="token,'.$pToken.'">'.$pToken.'</option>';
    echo '</select>';
    echo "<script>";
    echo "  document.getElementById('vSelect_0').style.display='none'; ";
    echo "</script>";
}




?>

<div id="basket_body"></div>

<script>



    function funInput(zFieldName,zTitle,zFieldId)
    {
        var p = document.getElementById('basket_body');


        var vSelect = document.createElement('select');
        p.append(vSelect);
        vSelect.id = 'vSelect_'+zFieldId;
        var vOption = document.createElement('option');
        vOption.innerHTML = zFieldId;
        vOption.value = zFieldName+','+zFieldId;
        vSelect.append(vOption);

        document.getElementById('vSelect_'+zFieldId).style.display='none';
        document.getElementById('vSelect_0').style.display='none';
    }

    function funSelectOption(zOption)
    {

        var p = document.getElementById('basket_body');

        var vBr = document.createElement('br');
        p.append(vBr);
        var vBr = document.createElement('br');
        p.append(vBr);



        pOptionTitle = zOption['title'];
        pOptionFileName = zOption['fieldName'];
        var vDiv = document.createElement('div');
        vDiv.innerHTML = pOptionTitle;
        p.append(vDiv);


        var pOption = zOption['options'];
        var pOptionLen = pOption.length;
        var vSelect = document.createElement('select');
        p.append(vSelect);

        for(var z = 0; z < pOptionLen; z++)
        {

            
            //vOption.value = pOption[z]['value'];
            if (pOption[z]['fields'])
            {

                vSelect.append(vOption); 

                var pwOptionFileName = pOption[z]['fields'][0]['fieldName'];
                var pwOption = pOption[z]['fields'][0]['options'];
                

                if (pwOption==null)
                {

                    var pwrOption = pOption[z]['fields'];
                    var pwrOptionLen = pwrOption.length;

                    for(var zzwr = 0; zzwr < pwrOptionLen; zzwr++)
                    {
                        var vOption = document.createElement('option');
                        
                        vOption.value = pOptionFileName+','+pOption[z]['value']+';'+pwrOption[zzwr]['fieldName']+','+pwrOption[zzwr]['fieldId'];  
                        vOption.text = pOption[z]['text']+' = '+pwrOption[zzwr]['title'];
                        vSelect.append(vOption);
                    }
                    
                }
                else
                {
                    var pwOptionLen = pwOption.length;
                    for(var zzw = 0; zzw < pwOptionLen; zzw++)
                    {
                        var vOption = document.createElement('option');
                        vOption.value = pOptionFileName+','+pOption[z]['value']+';'+pwOptionFileName+','+pwOption[zzw]['value'];
                        vOption.text = pOption[z]['text']+' = '+pwOption[zzw]['text'];//+' - '+pOption[z]['value']+' - '+pwOption[zzw]['value'];
                        vSelect.append(vOption);
                    }
                }


            }
            else
            {

                if (zOption==null)
                {
                    var vOption = document.createElement('option');
                    vOption.innerHTML = '';//+' = '+pOption[z]['value'];
                    vOption.value = pOptionFileName+','+pOption[z]['value'];
                    vSelect.append(vOption);
                }
                else
                {
                    var vOption = document.createElement('option');
                    vOption.innerHTML = pOption[z]['text'];//+' = '+pOption[z]['value'];
                    vOption.value = pOptionFileName+','+pOption[z]['value'];
                    vSelect.append(vOption);
                }

            }

        }


    }






    var pJson = <? echo $response; ?>;
    var pAccontId = <? echo $pAccountId; ?>;

    var pError = pJson['Response']['errors'];
    var pWarnings = pJson['Response']['warnings'];


    if ( (pError==null) && (pWarnings==null) )
    {
        var pBasketItemId = pJson["Response"]['entity']['baskets']['0']['basketItems']['0']['basketItemId'];
        var pEntity = pJson["Response"]['entity']['baskets']['0']['basketForm'];
        var pFormId = pEntity['formId'];
        funInput('FormId','FormId',pFormId);
        funInput('pAccountId','pAccountId',pAccontId);
        funInput('pBasketItemId','pBasketItemId',pBasketItemId);


        if (pJson["Response"]['entity']['baskets']['0']['basketForm']['fields']==null)
        {

        }
        else
        {
            var pFormArray = pEntity['fields'];
            var pFormArrayLen = pFormArray.length;

            for(var i = 0; i < pFormArrayLen; i++)
            {
                var pTitle = pFormArray[i]['title'];
                var pFieldName = pFormArray[i]['fieldName'];
                var pFieldId = pFormArray[i]['fieldId'];

                if (pFormArray[i]['typeName']=='InputField')
                {
                    //alert('1');
                    funInput(pFieldName,pTitle,pFieldId);
                }
                if (pFormArray[i]['typeName']=='SelectField') 
                {
                    //  alert('1 = '+pFormArray[i]);

                    var pOption = pFormArray[i];
                    funSelectOption(pOption);
                }
                if (pFormArray[i]['typeName']=='DateField')
                {
                    funInput(pFieldName,pTitle,pFieldId);
                }
                if (pFormArray[i]['typeName']=='DateField')
                {
                    var pOpt = pFormArray[i]['options'];
                    if (pOpt==null)
                    {

                        var rdate = new Date();
                        rdate = new Date(rdate.getFullYear(), rdate.getMonth(), rdate.getDate()+0);


                        var nYear = rdate.getFullYear();


                        var nDate = rdate.getDate();
                        nDate = String(nDate);
                        var lenDate = nDate.length;
                        if ( lenDate == 1)
                        { nDate = '0'+nDate; }


                        var nMonth = rdate.getMonth()+1;
                        nMonth = String(nMonth);
                        var lenMonth = nMonth.length;
                        if ( lenMonth == 1)
                        { nMonth = '0'+nMonth; }


                        funInput(pFieldName,pTitle,''+nDate+'.'+nMonth+'.'+nYear+'');
                    }
                    else
                    {
                        funInput(pFieldName,pTitle,pFieldId);
                    }
                }

            }
        }



        var p = document.getElementById('basket_body');

        var vBr = document.createElement('br');
        p.append(vBr);
        var vBr = document.createElement('br');
        p.append(vBr);

        var vBut = document.createElement('button');
        vBut.innerHTML = 'Купить';
        vBut.setAttribute("onclick","funBut();" );
        p.append(vBut);


    }
    else
    {
        alert('Error = '+pError+' ; Warnings = '+pWarnings);
    }




    function funBut()
    {

        var pRes = '';
        var elements = document.querySelectorAll('select');
        for (let elem of elements) {
            pRes = pRes + ';' + elem.value;
        }

      //  vBut.setAttribute('disabled', true);
     //   funPost(pRes);
    }

    /*
    function funLogs(pResp,pAcountid)
    {
        var request = new XMLHttpRequest();
        var url = "/qrq/amo/logs.php";
        var params = 'resp='+pResp+'&accontid='+pAcountid;
        request.open("POST", url, true);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.addEventListener("readystatechange", () => {
            if(request.readyState === 4 && request.status === 200)
            {

            }
        });
        request.send(params);
    }
    */

    function funPost(pRes)
    {


        var request = new XMLHttpRequest();
        var url = "/qrq/amo/pay.php";
        var params = 'str='+pRes;
        request.open("POST", url, true);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.addEventListener("readystatechange", () => {

            //funLogs(request.responseText,pAcountid);

            if(request.readyState === 4 && request.status === 200)
            {

               // alert(request.responseText);

                //alert(request.responseText);
                // ТУТ НАДО ТЕБЕ ВСЕ ДЕЛАТЬ


                //alert(request.responseText);
            }
        });

        request.send(params);

    }



</script>