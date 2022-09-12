<?

echo '111';
echo '<br>';

                $url = 'https://questrequest.ru/qrq/amo/cartadd.php';
                
                $parameters = [
                            'token'         => '121e454b37b7316ec91ecadcd05392a3d9bd07ae',
                            'itemid'         => '3468156582',
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
                

echo '222';
echo '<br>';                

?>