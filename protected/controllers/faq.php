<?php // Частые вопросы
	class Controllers_Faq extends core_BaseController
	{
		function __construct()
		{
			parent::__construct();

				$this->faq = '';
					
				$this->title = 'Частые вопросы';
				
				/*
				$url = 'https://questrequest.ru/qrq/amo/cartadd.php';
				
				$parameters = [
							'token' 		=> '121e454b37b7316ec91ecadcd05392a3d9bd07ae',
							'itemid' 		=> '3468156582',
							'quantity' 		=> 1,
							'accountid' 	=> '1671722'
							];
				
				
				$ch = curl_init();

				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$response = curl_exec($ch);
				curl_close($ch);
				
				
				$json = json_decode($response);
				
				vecho($json);
				*/
				/*
				$api		= new ClassApi();
				$arr = $api->Save1cBuySellId_Out1cBuy11_12(array( 'id_1c' 		=> 'd46cc13b-995d-11e9-9415-000c29ba794a' , 
																'company_id' 	=> 1087 ));
				*/

/*				
				$sql = "	SELECT 	json
						FROM amo_log_json
						WHERE id=45 ";

				$row = PreExecSQL_one($sql,array());
				
				$json = json_decode($row['json']);
				
				vecho($json);
				
		if($json){
			
			$Response	= $json->Response;
			
			$errors = isset($Response->errors)? $Response->errors : '';
			$errors_message 	= isset($errors[0]->message)?	 	$errors[0]->message 		: '';
			$errors_code 		= isset($errors[0]->code)?	 	$errors[0]->code 		: '';
			
			$errors_message1 	= isset($errors[1]->message)?	 	$errors[1]->message 		: '';
			$errors_code1 	= isset($errors[1]->code)?	 	$errors[1]->code 		: '';

			$warnings = isset($Response->warnings)? $Response->warnings : '';//errors
			$warnings_message = isset($warnings[0]->message)? 	$warnings[0]->message 	: '';
//var_dump($json);
//var_dump($warnings);
			if( !$errors_message && !$warnings_message ){
				
				vecho('ok');
				
			}else{
					$errors_message = $errors_message.' '.$warnings_message;
					
					vecho($errors_code);
			}
			
		}
	
*/
	
		}
	}
?>