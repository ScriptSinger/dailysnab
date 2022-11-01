<?php
//Документация по веб-сервису http://service.autopiter.ru/price.asmx

/*Если ваша версия выше php 5.0.1, то вы можете воспользрваться встроенным классом
SoapClient, иначе необходимо использовать библиотеку NuSoap или др. В данном случае используем
встроенные возможности php. http://php.net/manual/en/book.soap.php */



function fConnected($zUserId, $zPassword)
{
    //при создании объекта по структуре сервиса указание "http://" в ссылке ОБЯЗАТЕЛЬНО!
    $client = new SoapClient("http://service.autopiter.ru/v2/price?WSDL");

    //http://service.autopiter.ru/price.asmx?op=IsAuthorization
    if (!($client->IsAuthorization()->IsAuthorizationResult)) {
        //http://service.autopiter.ru/price.asmx?op=Authorization
        //UserID - ваш клиентский id, Password - ваш пароль
        /*
            Вам присвоен клиентский номер: 836057
            Ваш логин: myf1vfg9w
            Ваш пароль: 470303
         */

        //$client->Authorization(array("UserID"=>"409052", "Password"=>"A0277920880", "Save"=> "true"));
        $client->Authorization(array("UserID"=>$zUserId, "Password"=>$zPassword, "Save"=> "true"));

    }

    return $client;
}


?>


