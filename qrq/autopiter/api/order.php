<?php


/*
 *
ArticleId (SearchCatalogModel.ArticleId)
DetailUid (PriceSearchModel.DetailUid)

*/



// http://dailysnab.beget.tech/qrq/autopiter/api/order.php?detailid=24619_1625759445_1&userid=656881&password=123456&count=1&price=24




$pUserId = 0;
$pPassword = 0;


if (isset($_GET['detailid']))
{
    $pDetailId = $_GET['detailid'];
    $pDetailId = trim($pDetailId);
}
if (isset($_POST['detailid']))
{
    $pDetailId = $_POST['detailid'];
    $pDetailId = trim($pDetailId);
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

if (isset($_GET['count']))
{
    $pCount = $_GET['count'];
    $pCount = trim($pCount);
}
if (isset($_POST['count']))
{
    $pCount = $_POST['count'];
    $pCount = trim($pCount);
}

if (isset($_GET['price']))
{
    $pPrice = $_GET['price'];
    $pPrice = trim($pPrice);
}
if (isset($_POST['price']))
{
    $pPrice = $_POST['price'];
    $pPrice = trim($pPrice);
}


try
{

    require_once "connect.php";
    $client = fConnected($pUserId, $pPassword);



    // Очистка корзины (1 - корзина очищена)
    $result = $client->ClearBasket();

    // Добавляем позицию
    $insertItems = $client->InsertToBasket(
        array("Items"=> array(
            array(
                "DetailUid"=>$pDetailId,
                "Comment"=> "",
                "SalePrice"=>$pPrice,
                "Quantity"=>$pCount
            )
        ))
    );

    // Получаем все элементы корзины
    $cartItems = $client->GetBasket();


    // Покупка товара из корзины
    $cartItems = $client->MakeOrderFromBasket();


    $pNumZakaz = $cartItems->MakeOrderFromBasketResult->OrderNumber;
    $pPrice = $cartItems->MakeOrderFromBasketResult->Items->ResponseCodeItemCart->Item->SalePrice;
    $pCount = $cartItems->MakeOrderFromBasketResult->Items->ResponseCodeItemCart->Item->Quantity;


    $InfoArrayDop = array(
        "Zakaz" => $pNumZakaz, // Номер созданного заказа
        "Count" => $pCount, // Количество
        "Price" => $pPrice // Цена
    );

    $InfoArrayJson[] = $InfoArrayDop;

    $json = json_encode($InfoArrayJson, JSON_UNESCAPED_UNICODE);
    echo $json;

}
catch(Exception $e)
{

}





?>


