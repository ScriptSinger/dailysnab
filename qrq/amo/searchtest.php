<?
   $url = 'https://questrequest.ru/qrq/amo/search.php';
    
        $parameters = [
                    'token'         => 'c2f95f338d8989cdb547eb27a22456b252bcf1f1',
                    'brand'         => 'Masuma',
                    'searchtext'     => 'MU12R',
                    'accountid'     => '1600232'
                    ];
 
 
                    
            $ch = curl_init();
 
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            
            $json = json_decode($response);
            
 
print_r($json);
?>