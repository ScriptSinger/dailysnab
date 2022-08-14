<?php // Режим PRO
	class Controllers_PRO extends core_BaseController
	{
		function __construct()
		{
			parent::__construct();
					
			$flag = $type = '';					
			$total = $sum = 0;
			$code = $name_servies = '';
			
			
			if(LOGIN_ID){
			
					$views = getArgs(1);					
					$type = getGets('type');
					$sum = getGets('sum');

					$rb = reqBalance();
					$balance = (!empty($rb[0]['total'])) ? $rb[0]['total'] : 0;
					
					$rbp = reqBalancePRO90(array('company_id'=>COMPANY_ID));		
					$count3 = ($rbp) ? (int) $rbp[0]['count3'] : 0;					
					
					
					$price_pro = ($count3 < 3) ? 399 : PRICE_PRO;
					$skidka = ($count3 < 3) ? '(скидка 90%)' : ''; 
			 

						if($type == 1){
							
							$total = $price_pro - $balance;
							//$name_servies = 'Услуга “Пакет Pro. Для упрощения закупок и снижения цен на товары” '.$skidka;
								
						} elseif($type == 2) {
							
							$total = PRICE_VIP - $balance;
							//$name_servies = 'Услуга “Пакет Vip. Для упрощения закупок и снижения цен на товары”';						
						
						} elseif($type == 0) {
							$total = $sum;
						} else {
							$code = '';
						}					
					
			
					if (!$views){
												
							$this->title = 'Кошелек';
							
					} else {	
						
						// страница - Оплата картой
						if($views == 'card'){
							$flag = 1;

								$this->title = 'Оплата по карте';
								
						} elseif ($views == 'invoice'){	
						
							$flag = 2;
							
							//Организация по ИНН 
							// https://github.com/hflabs/dadata-php

							
							require_once  './protected/source/makePDF/vendor/autoload.php';
							$mpdf = new \Mpdf\Mpdf([
								'mode' => 'utf-8', 
								'format' => 'A4', 
							]);
							

						
								$this->title = 'Оплата по счету';
								
						} elseif ($views == 'history'){	
							$flag = 3;
						
						
							$this->title = 'История платяжей';
								
						} elseif ($views == 'return_payment'){	
							$flag = 4;
							
							$paymentId = (!empty($_SESSION['paymentId'])) ? $_SESSION['paymentId'] : '';	
							
							if($paymentId){	

								//проврека, не добавлена ли оплата автоматом	 					
								$paid = reqInvoices(array('paymentId'=>$paymentId));								
								$paid = (int)$paid['paid'];				
																				
								if($paid !== 1){	
								
									require_once './protected/source/yookassa-sdk/lib/autoload.php';
									$client = new \YooKassa\Client();
									$client->setAuth(YOOKASSA_SHOPID, YOOKASSA_API);								

									try {
										$response = $client->getPaymentInfo($paymentId);
									} catch (\Exception $e) {
										$response = $e;
									}
									
									switch ($response['status'])
										{
											case 'pending':
												$status = 'Заказ еще не оплачен.';
												break;
											case 'canceled':
												$status = 'Заказ отменен.';
												break;
											case 'succeeded':
												$status = 'Поздравляем! Заказ оплачен. Средства успешно пришли и отразились на вашем баллансе.';
												break;
											case 'waiting_for_capture':
												$status = 'Заказ еще не оплачен.';
												break;
										}
									
									
									$code = 'Заказ #'.$paymentId.'<br />Статус платяжа: '.$response['status'].' <br />'.$status;	
									$amount = (int)$response['amount']['value'];

									
									if($amount == PRICE_PRO){
										$pay_type = 1;	//типа оплаты PRO								
									} elseif($amount == PRICE_VIP){
										$pay_type = 2;	//типа оплаты VIP	
									} else {
										$pay_type = 3;	// другие типы оплат
									}
									if($response['status'] == 'succeeded'){
										$STH = PreExecSQL(" UPDATE pro_invoices SET paid=1 WHERE paymentId=?; " ,
																				array( $paymentId ));
										$STH = PreExecSQL(" INSERT INTO company_balance (company_id,total,type) VALUES (?,?,?); " ,
																		array( COMPANY_ID,$amount,$pay_type));										
										}
								} else {
								
									$status = 'Поздравляем! Средства успешно пришли и отразились на вашем баллансе.';
									$code = 'Заказ #'.$paymentId.'<br />'.$status;	
													$code .= "<script>
							$( document ).ready(function() {
				    var modal_logo = $('#modal_logo');
					var modal = $('#vmodal');
					var modal_ar = $('#vmodal_ar');
					var modal_amo = $('#modal_amo');

										$.post('/checkPaymentModal', {}, 
									function(data){
										if(data.code){
											console.log(data.code);
											modal.html(data.code);
											modal.modal();							
											modal.on('shown.bs.modal',
												function(e){	

												}	
												).on('hidden.bs.modal', function (e) {									

												}); 
											}
										}
										);
});
	

				</script>";
								
								}	
									
									
							}						
							
							$this->title = 'Статус приема платяжей';
							
							
							unset($_SESSION["paymentId"]);								
						} else {					
								
							$this->e404 = '';
							$this->title = 'Ошибка 404. Страница не найдена';
						}	
					}	
					
					
			
					$this->pro = array( 	
								'flag'			=> $flag,
								'type'			=> $type,
								'row_company' 	=> reqCompany(array('login_id'=>LOGIN_ID,'flag_account'=>2)),
								'total_pay'		=> $total,
								'balance'		=> reqBalance(),
								'balanceAll'	=> reqBalanceAll(),								
								'rbp'			=> reqBalancePRO90(),
								'code'			=> $code,
							 );									
	

			}else{
				redirect('/');
			}
			
		}
	}
