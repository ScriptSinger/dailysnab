<?php
/**
 * Крон - Проерка оплаты счетов Yookassa   http://qrq/protected/cron/cron_yookassa_pay.php  http://qrq/cron/cron_yookassa_pay
 */
	$code = '';
	$current_date = date('Y-m-d', time()); 
	
	
	require_once './protected/source/yookassa-sdk/lib/autoload.php';			
	$client = new \YooKassa\Client();
	$client->setAuth(YOOKASSA_SHOPID, YOOKASSA_API);	
	


	// компании, которым отсылаем отчет(уведомление)
	$sql = "	SELECT pi.id, pi.company_id, pi.summ, pi.type_s, pi.paid, pi.paymentId, pi.data_insert
			FROM pro_invoices pi			
			WHERE DATE_FORMAT(pi.data_insert, '%Y-%m-%d') = '".$current_date."' AND pi.paymentId IS NOT NULL AND pi.paid=0
			ORDER BY pi.data_insert ";

	
	$row = PreExecSQL_all($sql,array());
	
	//var_dump(count($row));
	//die;
	
	if(count($row)>0){
	
		foreach($row as $k=>$m){
		
			$amount = $m['summ'];
			$pay_type = $m['type_s'];
			$company_id = $m['company_id'];
			$paymentId = $m['paymentId']; // Ключ платежа
			
			$payment = $client->getPaymentInfo($paymentId); // Информацию о платеже
			$pay_check = $payment->getstatus(); // Статус оплаты	
			
		// Если платеж прошел, то обновляем статус платежа
			if ($pay_check == 'waiting_for_capture' or $pay_check == 'succeeded') {
			
				// Обновляем статус платежа
				$STH1 = PreExecSQL(" UPDATE pro_invoices SET paid=1 WHERE paymentId=?; " ,
										array( $paymentId ));
				// Обновляем баланс пользователя 																		
				$STH2 = PreExecSQL(" INSERT INTO company_balance (company_id,total,type) VALUES (?,?,?); " ,
										array( $company_id,$amount,$pay_type));			

			} 		

										
		}
	}

?>