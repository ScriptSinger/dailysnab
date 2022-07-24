<?php // Автопроверка оплаты YooKassa
	class Controllers_PaymentCheck extends core_BaseController
	{
		function __construct()
		{
			parent::__construct();
			
				require_once './protected/source/yookassa-sdk/lib/autoload.php';			
				$client = new \YooKassa\Client();
				$client->setAuth(YOOKASSA_SHOPID, YOOKASSA_API);	
				
				
			// Получите данные из POST-запроса от Яндекс.Кассы
				$source = file_get_contents('php://input');
				$requestBody = json_decode($source, true);	
			
			if($requestBody) {
				
				//$payment = $client->getPaymentInfo('2932a692-000f-5000-8000-12f370dc9cc2'); // Получаем информацию о платеже
				$payment = $client->getPaymentInfo($requestBody['event']['id']); // Получаем информацию о платеже
				$pay_check = $payment->getstatus(); // Получаем статус оплаты
				
				$amount = (int)$payment['amount']['value'];
				//var_dump($payment);
				
				if ( $pay_check == 'succeeded') {
								if($amount == PRICE_PRO){
									$pay_type = 1;	//типа оплаты PRO								
								} elseif($amount == PRICE_VIP){
									$pay_type = 2;	//типа оплаты VIP	
								} else {
									$pay_type = 3;	// другие типы оплат
								}
										
								$STH1 = PreExecSQL(" UPDATE pro_invoices SET paid=1 WHERE paymentId=?; " ,
																					array( $requestBody['event']['id'] ));
								$STH2 = PreExecSQL(" INSERT INTO company_balance (company_id,total,type) VALUES (?,?,?); " ,
																			array( COMPANY_ID,$amount,$pay_type));										

						
							// Отправка сообщения
							$email = "xrustit@gmail.com"; 
							$subject = "На сайте совершен платеж"; 

							$message = "Платеж на сумму: " . $payment->amount->value . "<br/>";
							$message .= "Детали платежа: " . $payment->description . "<br/>";					
							
							// отправляем письмо на почту 
						//	$rez = $tes->LetterSendCode(array('email'	=> $email,											  
						//							  'phone_email_code' => $message ));
			
				}
			
				die;		 
			}	
			
			
			
				
							
				//$this->paymentcheck = '';					
				//$this->title = 'Автопроверка оплаты YooKassa';
		
		
		}
	}
?>