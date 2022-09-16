<?php

// https://questrequest.ru/qrq/amo/basket.php?token=5c30e99e8ca9dd0904c92855622d075435c86b62&accountid=1600536

$pParam = '';
$pToken = '';
$pAccountId = '';
$pAmount = '';
$pBuy_sell_id = '';
$pWhere = '';



/*
if (isset($_GET['pparam']))
{
    $pParam = $_GET['pparam'];
    $pParam = trim($pParam);
}
if (isset($_POST['pparam']))
{
    $pParam = $_POST['pparam'];
    $pParam = trim($pParam);
}
*/

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




$filename = 'logs/'.$pAccountId.'_basket_prishlo.txt';
$fh = fopen($filename, 'w');
fwrite($fh, json_encode($pAccountId, JSON_UNESCAPED_UNICODE));
fclose($fh);


// Получаем $pParam из базы


require_once $_SERVER['DOCUMENT_ROOT'].'/protected/core/connect.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/protected/core/Requests.php';

connect();

$rap = reqAmoAccountsBasketParam(array('accounts_id'=>$pAccountId));
$pParam = $rap['param'];

disConnect();


//////////////////////////////



/*
echo "<input type='text' id='temp' >";
echo "<br><br>";
*/

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

    $filename = 'logs/'.$pAccountId.'_basket_param.txt';
    $fh = fopen($filename, 'w');
    fwrite($fh, json_encode($pParam, JSON_UNESCAPED_UNICODE));
    fclose($fh);



    $response = file_get_contents('https://userapi.qwep.ru/basket', false, $context);
    //$Resp = json_decode($response, JSON_UNESCAPED_UNICODE);
    $Resp = json_decode($response,true);
    //$Resp = json_encode($response);

    //echo "<pre>";
//    print_r($Resp);
    //  echo "</pre>";


    if (strlen(trim($response))>0)
    {



        /*
            echo '<pre>';
            print_r($Resp);
            echo '</pre>';
            echo "<br>";
            echo "<br>";
        */

        $error = $Resp['Response']['errors'];
        $warnings = $Resp['Response']['warnings'];
        $entity = $Resp['Response']['entity']['baskets']['0']['basketForm'];
        $pFormId = $entity['formId'];
        $pFormArray = $entity['fields'];



        if ( ($error==null) and ($warnings==null) )
        {

            echo '<select id="vSelect_token">';
            echo '  <option value="token,'.$pToken.'">'.$pToken.'</option>';
            echo '</select>';
            echo "<script>";
            echo "  document.getElementById('vSelect_0').style.display='none'; ";
            echo "</script>";
        }





        ?>

        <div id="basket_body"></div>


        <script>



            //alert('Начало');

            var pJson = <?echo $response; ?>;
            var pAccontId = <?echo $pAccountId; ?>;

            //alert('pJson = '+pJson);
            //alert('pAccontId = '+pAccontId);


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
                {}
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
                            funInput(pFieldName,pTitle,pFieldId);
                        }
                        if (pFormArray[i]['typeName']=='TextareaField')
                        {
                            //    var pOption = pFormArray[i];
                            //  funInputText(pOption);
                            funInputText(pFieldName,pTitle,pFieldId);
                        }
                        if (pFormArray[i]['typeName']=='SelectField')
                        {
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


                                /*funInput(pFieldName,pTitle,''+nDate+'.'+nMonth+'.'+nYear+'');*/
                                funInputData(pFieldName,pTitle,''+nDate+'.'+nMonth+'.'+nYear+'');
                            }
                            else
                            {
                                funInput(pFieldName,pTitle,pFieldId);
                            }
                        }
                    }

                    // Анализ приходящ

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

            function funInputData(zFieldName,zTitle,zFieldId)
            {
                var p = document.getElementById('basket_body');

                var vSelect = document.createElement('select');
                p.append(vSelect);
                vSelect.id = 'vSelect_'+zFieldName;






                Date.prototype.addDays = function(days) {
                    var date = new Date(this.valueOf());
                    date.setDate(date.getDate() + days);
                    return date;
                }

                let i = 0;
                while (i < 30)
                {
                    var date = new Date();
                    var rdate = date.addDays(i);

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



                    /*  alert(nDate+'.'+nMonth+'.'+nYear); */

                    zFieldId = nDate+'.'+nMonth+'.'+nYear;
                    var vOption = document.createElement('option');
                    vOption.innerHTML = zFieldId;
                    vOption.value = zFieldName+','+zFieldId;
                    vSelect.append(vOption);


                    i++;
                }



                //     document.getElementById('vSelect_'+zFieldId).style.display='none';
                //    document.getElementById('vSelect_0').style.display='none';
            }


            function funInput(zFieldName,zTitle,zFieldId)
            {
                var p = document.getElementById('basket_body');


                var vSelect = document.createElement('select');
                p.append(vSelect);
                vSelect.id = 'vSelect_'+zFieldName;
                var vOption = document.createElement('option');
                vOption.innerHTML = zFieldId;
                vOption.value = zFieldName+','+zFieldId;
                vSelect.append(vOption);

                //  document.getElementById('vSelect_'+zFieldId).style.display='none';
                // document.getElementById('vSelect_0').style.display='none';
            }

            function funInputText(zFieldName,zTitle,zFieldId)
            {

                var p = document.getElementById('basket_body');

                var vBr = document.createElement('br');
                p.append(vBr);
                var vBr = document.createElement('br');
                p.append(vBr);


                pOptionTitle = zTitle;
                var vDiv = document.createElement('div');
                vDiv.innerHTML = pOptionTitle;
                p.append(vDiv);


                var vTextInput = document.createElement('input');
                p.append(vTextInput);
                vTextInput.id = 'vTextInput_'+zFieldName;

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
                vSelect.id = 'vSelect_'+pOptionFileName;
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


            function funBut()
            {

                var pRes = '';
                var pRestIns = '';
                var elements = document.querySelectorAll('select');
                for (let elem of elements) {
                    pRes = pRes + ';' + elem.value;

                    //var e = document.getElementById("ddlViewBy");
                    //var strUser = e.options[e.selectedIndex].value;

                    //var e = document.getElementById(elem.id);
                    //var strUser = e.options[e.selectedIndex].value;
                    //alert('id = '+elem.id);
                    //alert('index = '+strUser);

                    var e = document.getElementById(elem.id);
                    var sIndex = e.selectedIndex;
                    //        alert('sIndex = '+sIndex);

                    pRestIns = pRestIns + ';select,'+elem.id+','+sIndex;

                    //   alert('pRestIns = '+pRestIns);
                }


                var pRes1 = '';
                var pRestIns1 = '';
                var elements = document.querySelectorAll('input');
                for (let elem of elements) {

                    //  alert('input id = '+elem.id);
                    pNM = elem.id.replace('vTextInput_','');
                    pRes1 = pRes1 + ';'+pNM+','+ elem.value;
                    pRestIns1 = pRestIns1 + ';input,'+elem.id+','+ elem.value;
                    //pRes2 = pRes2 + ';' + elem.id;
                }

                var pResAll = pRes+pRes1;
                var pRestInsAll = pRestIns+pRestIns1;

                //document.getElementById('temp').value = pRestInsAll;

//            alert('pResAll = '+pResAll);
                //  alert('pRestInsAll = '+pRestInsAll);


                vBut.setAttribute('disabled', true);

                funPost(pResAll,pRestInsAll);
            }

            function funPost(pRes,pRestParam)
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

                        // надо вставить эту переменную
                        // pRestParam
                        AmoBasket(request.responseText,<? echo $pAmount; ?>,<? echo $pBuy_sell_id; ?>,<? echo '"'.$pWhere.'"'; ?> , <? echo $pAccountId; ?> , pRestParam );



                        //alert(request.responseText);
                    }
                });

                request.send(params);

            }




        </script>
        <?php

        // Тут вставить код для сохраненных парметров
        $pRazbor = substr($pParam,1);
        $pMassiv = explode(";", $pRazbor);
        foreach ($pMassiv as $pValue)
        {
            $pNum = 0;
            $pDop = explode(",", $pValue);
            foreach ($pDop as $pDopValue)
            {
                $pNum=$pNum+1;
                if ($pNum==1)
                {
                    $pTextNew1 = $pDopValue;
                }
                if ($pNum==2)
                {
                    $pTextNew2 = $pDopValue;
                }
                if ($pNum==3)
                {
                    $pTextNew3 = $pDopValue;

                    /*
                    echo "text 1 = ".$pTextNew1;
                    echo "<br>";
                    echo "text 2 = ".$pTextNew2;
                    echo "<br>";
                    echo "text 3 = ".$pTextNew3;
                    echo "<br>";
                    echo "<br>";
                    */

                    if ($pTextNew1=='input')
                    {
                        echo "<script>";
                        echo " document.getElementById('".$pTextNew2."').value = '".$pTextNew3."'; ";
                        echo "</script>";
                    }
                    if ($pTextNew1=='select')
                    {
                        echo "<script>";
                        echo " var ftSelect = document.querySelector('#".$pTextNew2."').getElementsByTagName('option'); ";
                        echo " for (let i = 0; i < ftSelect.length; i++) ";
                        echo " { if (i == ".$pTextNew3.") {ftSelect[i].selected = true;} } ";
                        echo "</script>";
                    }

                }

            }

        }


    }
    else
    {
        echo '';
    }
    
    

}
else
{
    if ( strlen(trim($restaccount))==0 )
    {
        echo '111';
    }
    else
    {
        ?>
        <div id="basket_body"></div>
        <script>
        
              //  var vBr = document.createElement('br');
            //    p.append(vBr);
               // var vBr = document.createElement('br');
             //   p.append(vBr);

                var p = document.getElementById('basket_body');

                var vBut7 = document.createElement('button');
                vBut7.innerHTML = 'Ушел только в корзину';
                vBut.setAttribute("onclick","funBut();" );
                p.append(vBut7);
            
        </script>
        <?
        

                
     //    echo '{"Response":{"errors":["code":"222","message":"AccountId='.$pAccountId.' ушел только в корзину","details":null],"warnings":null}}';
    }
}

    

?>