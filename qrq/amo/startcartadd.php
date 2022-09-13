<?
/*
$array = array("Response"=>array("errors"=>array(	"code"=>"222",
												"message"=>"AccountId ушел только в корзину",
												"details"=>""
												),
								"warnings"=>""
								)
			);

$json = json_encode($array);
header('Content-Type: application/json');
echo $json;
*/

                $url = 'https://questrequest.ru/qrq/amo/cartadd.php';

                $parameters = [
                            'token'         => '6bc2aed632aa25cc4a384130d9a51be6491b7425',
                            'itemid'         => '3535909686',
                            'quantity'         => 1,
                            'accountid'     => '1671722'
                            ];
                
                
                $ch = curl_init();
 
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);
                
                
                $json = json_decode($response);
                
echo($response); 

?>