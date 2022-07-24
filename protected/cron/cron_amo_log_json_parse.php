<?php
/**
 * Крон - 	Получаем из кода json ошибки
 */
 
  error_reporting( E_ALL | E_STRICT );
 

	// 
	$sql = "	SELECT id, json
			FROM amo_log_json
			WHERE parent_id<>0 AND (errors_code IS null OR errors_code='')
			ORDER BY data_insert ";

	$row = PreExecSQL_all($sql,array());

	foreach($row as $k=>$m){
		
				$json = json_decode($m['json']);

				if($json){
					
					$Response	= $json->Response;
					
					$errors = isset($Response->errors)? $Response->errors : '';
					
					$errors_message 	= isset($errors[0]->message)?	 	$errors[0]->message 		: '';
					$errors_code 		= isset($errors[0]->code)?	 	$errors[0]->code 		: '';
					
					$errors_message1 	= isset($errors[1]->message)?	 	$errors[1]->message 		: '';
					$errors_code1 	= isset($errors[1]->code)?	 	$errors[1]->code 		: '';

					$warnings 		= isset($Response->warnings)?	 $Response->warnings : '';//errors
					$warnings_message = isset($warnings[0]->message)? 	$warnings[0]->message 	: '';
					$warnings_code 	= isset($warnings[0]->code)? 		$warnings[0]->code 	: '';
		//var_dump($json);
		//var_dump($warnings);
					if( !$errors_message && !$warnings_message ){
						
							echo 'Не понятная ошибка <br/>';
						
							$STH = PreExecSQL(" UPDATE amo_log_json SET errors_code=? , errors_message=? WHERE id=?; " ,
												array( 1 , 'Не понятная ошибка' , $m['id'] ));
						
					}else{
							$errors_message = $errors_message.' '.$warnings_message;
							
							$errors_code = 1;
							
							if($errors_code==0 && $warnings_code>0){
									$errors_code 		= $warnings_code;
									$errors_message 	= $warnings_message;
							}
							
							if($errors_code1){
									$errors_code 		= $errors_code1;
									$errors_message 	= $errors_message1;
							}
							
							
							echo $errors_code.' '.$errors_message.' <br/>';
							
							$STH = PreExecSQL(" UPDATE amo_log_json SET errors_code=? , errors_message=? WHERE id=?; " ,
												array( $errors_code , $errors_message , $m['id'] ));
										
					}
					
					
				}
		
		
			

	}

?>