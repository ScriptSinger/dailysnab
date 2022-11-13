<?php
	/*
	 *  Шаблоны писем Email Sms
	 */
	 
class HtmlTemplateEmailSms extends HtmlServive
{	

	// Пильмо на почту - Регистрация
	function LetterSendRegistration( $p=array() ){
		
		$r = reqLogin(array('email'=>$p['email']));
		$href_md5 = DOMEN.'/activate/'.$r['active_md5'];// для понимания
		
		//тема письма
		$subject = 'Аккаунт - QRQ';
		//тело письма
		$body = 'Для подтверждения регистрации перейдите по ссылке:
				<br/>		
				<span style="color:#428bca;font-size:18px;font-weight:bold;">'.$href_md5.'</span>
				<br/>
				<div>
					Логин: <b>'.$p['email'].'</b>
					<br/>
					Пароль: <b>'.$p['pass'].'</b>
				</div>';
		
		$rez = $this->sendMail(array(	'email'		=>$p['email'] , 	'name'=>$p['name'] , 
									'subject'	=>$subject , 			'body'=>$body ));
		
		// отправляем администратору письмо уведомление - Регистрация нового аккаунта
		self::LetterSendAdminNewAccount(array('email'=>$in['email']));
		
		return array('rez'=>$rez);
	}
	
	// отправляем администратору письмо уведомление - Регистрация нового аккаунта
	function LetterSendAdminNewAccount( $p=array() ){
		
		$in = fieldIn($p, array('email','company'));
		
		$body_d  = '';
		
		if($in['email']){
			$body_d  = 'Зарегистрировался новый аккаунт <span style="color:#428bca;font-size:18px;font-weight:bold;">'.$in['email'].'</span>';
		}
		if($in['company']){
			$body_d  .= '<br/>Зарегистрировалась компания <span style="color:#428bca;font-size:18px;font-weight:bold;">'.$in['company'].'</span>';
		}
		
		
		//
		$rez = $this->sendMail(array(	'email'		=>'d7758987@gmail.com' , 						'name'=>'новый аккаунт' , 
									'subject'	=>'Зарегистрировался новый аккаунт на QRQ' , 	'body'=>$body_d ));
									
		
		return array('rez'=>$rez);
	}	
	
	
	
	// Письмо на почту - Восстановления пароля
	function LetterSendRestorePassword( $p=array() ){
		//тема письма
		$subject = 'Восстановление пароля - QRQ';
		//тело письма
		$body = 'Для смены пароля Вам необходимо перейти по 
				<a href="https://'.$_SERVER['SERVER_NAME'].'/restore/'.$p['md5'].'" 
								style="color:#428bca;font-size:18px;font-weight:bold;">ссылке</a>';
		
		$rez = $this->sendMail(array(	'email'		=>$p['email'] , 	'name'=>$p['name'] , 
									'subject'	=>$subject , 			'body'=>$body ));
		
		return array('rez'=>$rez);
	}
	// Письмо на почту - Оповещение
	function LetterSendNotification( $in=array() ){
		
		// $in = array( notification_id , email , name , old_status_buy_sell_id , flag_buy_sell, login_id, company_id )
		
		$str1 = $href = $content = '';
		
		//$st_a = 'style="color:#428bca;font-size:18px;font-weight:bold;"';
		
		if($in['notification_id']==2){
				//тема письма
				$subject = 'о новых предложениях - QRQ';
				$href 	= 'https://'.$_SERVER['SERVER_NAME'].'/buy-sell/buy';
				$content	= $in['name'].', на Вашу заявку поступило предложение.';
				/*
				//тело письма
				$body = 'На Вашу заявку поступило предложение.
						<br/>
						<a href="https://'.$_SERVER['SERVER_NAME'].'/buy-sell/buy" '.$st_a.'>Посмотреть</a>';
				*/
		}
		elseif($in['notification_id']==3||$in['notification_id']==8){
				//тема письма
				$subject = 'о законченных размещениях - QRQ';
				//тело письма
				if($in['flag_buy_sell']==1){
						if($in['old_status_buy_sell_id']==2){
							$str1 = 'опубликованного';
						}elseif($in['old_status_buy_sell_id']==3){
							$str1 = 'активного';
						}
						$content = 'срок размещения '.$str1.' объявления истек. Заявка больше не видна посетителям сайта.';
				}elseif($in['flag_buy_sell']==2){
						if($in['old_status_buy_sell_id']==2){
							$str1 = 'опубликованной';
						}elseif($in['old_status_buy_sell_id']==3){
							$str1 = 'активной';
						}
						$content = 'срок размещения '.$str1.' заявки истек. Заявка больше не видна посетителям сайта.';
				}
				

				$href 	= 'https://'.$_SERVER['SERVER_NAME'].'/buy-sell/buy/1';
				$content	= $in['name'].', '.$content;
				/*
				$body = $body.'
						<br/>
						<a href="https://'.$_SERVER['SERVER_NAME'].'/buy-sell/buy/1" '.$st_a.'>Активировать</a>';
				*/
		}
		elseif($in['notification_id']==5){
				//тема письма
				$subject 	= 'о новых заказах - QRQ';
				$href 	= 'https://'.$_SERVER['SERVER_NAME'].'/buy-sell/sell/11';
				$content	= $in['name'].', у вас новый заказ';
				/*
				//тело письма
				$body = 'У вас новый заказ
						<br/>
						<a href="https://'.$_SERVER['SERVER_NAME'].'/buy-sell/sell/11" '.$st_a.'>Посмотреть</a>';
				*/
		}
		elseif($in['notification_id']==7){
				//тема письма
				$subject 	= 'о новом исполнении - QRQ';
				$href 	= 'https://'.$_SERVER['SERVER_NAME'].'/buy-sell/sell/12';
				$content	= $in['name'].', отметил свой заказ как исполненный';
				/*
				//тело письма
				$body = 'Покупатель отметил свой заказ как исполненный
						<br/>
						<a href="https://'.$_SERVER['SERVER_NAME'].'/buy-sell/sell/12" '.$st_a.'>Посмотреть</a>';
				*/
		}
		elseif($in['notification_id']==6){
				//тема письма
				$subject 	= 'на возврат - QRQ';
				$href 	= 'https://'.$_SERVER['SERVER_NAME'].'/buy-sell/sell/14';
				$content	= $in['name'].', покупатель отметил возврат';
				/*
				//тело письма
				$body = 'Покупатель отметил возврат
						<br/>
						<a href="https://'.$_SERVER['SERVER_NAME'].'/buy-sell/sell/14" '.$st_a.'>Посмотреть</a>';
				*/
		}
		elseif($in['notification_id']==13){
				//тема письма
				$subject 	= 'новые подписчики - QRQ';
				$href 	= 'https://'.$_SERVER['SERVER_NAME'].'/subscriptions/me';
				$content	= $in['name'].', новый пользователь, который подписался на Ваши потребности';
				/*
				//тело письма
				$body = 'Новый пользователь, который подписался на Ваши потребности
						<br/>
						<a href="https://'.$_SERVER['SERVER_NAME'].'/subscriptions/me" '.$st_a.'>Посмотреть</a>';
				*/
		}		
		elseif($in['notification_id']==10){
				//тема письма
				$subject 	= 'Новая заявка';
				$href 	= 'https://'.$_SERVER['SERVER_NAME'].'/buy';
				$content	= $in['name'].', посмотрите новую заявку на основе ваших интересов и подписок';
				/*//тело письма
				$body = 'Посмотрите новую заявку на основе ваших интересов и подписок
						<br/>
						<a href="https://'.$_SERVER['SERVER_NAME'].'/buy" '.$st_a.'>Посмотреть</a>';
				*/
		}
		elseif($in['notification_id']==11){
				//тема письма
				$subject 	= 'о новых срочных заявках - QRQ';
				$href 	= 'https://'.$_SERVER['SERVER_NAME'].'/buy';
				$content	= $in['name'].', посмотрите новые <strong>срочные</strong> заявки которые вам интересны (на основе ваших категорий и подписок)';
				/*
				//тело письма
				$body = 'Посмотрите новые <strong>срочные</strong> заявки которые вам интересны (на основе ваших категорий и подписок)
						<br/>
						<a href="https://'.$_SERVER['SERVER_NAME'].'/buy" '.$st_a.'>Посмотреть</a>';
				*/
		}
		
		
		$body = self::TemplateLetterNotification(array(	'href'				=> $href,
														'content'			=> $content,
														'login_id'			=> $in['login_id'],
														'company_id'		=> $in['company_id'],
														'notification_id'	=> $in['notification_id'] ));
		
		
		$rez = $this->sendMail(array(	'email'		=>$in['email'] , 	'name'=>$in['name'] , 
									'subject'	=>$subject , 			'body'=>$body ));
		
		return array('rez'=>$rez);
	}
	// Письмо на почту - отчет о событиях за сутки из (slov_notification)
	function LetterSendNotificationEmail1800( $p=array() ){
		
		$st_a = 'style="color:#428bca;font-size:18px;font-weight:bold;"';
		
		//тема письма
		$subject = 'Отчет о событиях за сутки - QRQ';
		//тело письма
		$body = $p['text'].'
				<br/>
				<a href="https://'.$_SERVER['SERVER_NAME'].'/buy-sell/buy" '.$st_a.'>Посмотреть</a>';
		
		$rez = $this->sendMail(array(	'email'		=>$p['email'] , 	'name'=>$p['name'] , 
									'subject'	=>$subject , 			'body'=>$body ));
		
		return array('rez'=>$rez);
	}
	// Письмо на почту - поделиться потребностью
	function LetterSendShareBuySell( $p=array() ){
		
		$st_a = 'style="color:#428bca;font-size:18px;font-weight:bold;"';
		
		// наименование компании отправителя
		$rc = reqCompany(array('id'=>COMPANY_ID));
		
		if($p['flag_buy_sell']==1){
			$str = 'предложения';
		}else{
			$str = 'заявку';
		}
		
		//тема письма
		$subject = $rc['company'].' отправил вам '.$str.' - QRQ';
		//тело письма
		$body = '<b>'.$rc['company'].'</b> отправил вам '.$str.'
				<br/>
				'.$p['comments'].'
				<br/>
				<a href="'.$p['url'].'" '.$st_a.'>Посмотреть</a>';
		
		$rez = $this->sendMail(array(	'email'		=>$p['email'] , 	'name'=>'' , 
									'subject'	=>$subject , 			'body'=>$body ));
		
		return array('rez'=>$rez);
	}
	// Письмо на почту - Приглашение сотруднику
	function LetterSendInviteWorkers( $p=array() ){
		
		$st_a = 'style="color:#428bca;font-size:18px;font-weight:bold;"';
		
		//тема письма
		$subject = 'Приглашение сотрудника - QRQ';
		//тело письма
		$body = 'Здравствуйте '.$p['name'].'
				<br/>
				<a href="https://'.$_SERVER['SERVER_NAME'].'/" '.$st_a.'>Приглашаем</a> Вас на QRQ';
		
		$rez = $this->sendMail(array(	'email'		=>$p['email'] , 	'name'=>$p['name'] , 
									'subject'	=>$subject , 			'body'=>$body ));
		
		return array('rez'=>$rez);
	}
	// Письмо на почту - Отправка кода подтверждения почты
	function LetterSendCode( $p=array() ){		
		
		$code = $p['phone_email_code'];
		
		//тема письма
		$subject = 'Код подтверждения почты - QRQ';
		//тело письма
		$body = 'Код для подтверждения почты:
				<br/>		
				<span style="color:#428bca;font-size:18px;font-weight:bold;">'.$code.'</span>
				<br/>';
		
		$rez = $this->sendMail(array(	'email'		=>$p['email'] , 	'name'=>'' , 
									'subject'	=>$subject , 			'body'=>$body ));
		
		return array('rez'=>$rez);
	}
	
	// Щаблон Письма на почту - для оповещения
	function TemplateLetterNotification( $p=array() ){
		// href, content
		
		$in = fieldIn($p, array('login_id','company_id','notification_id'));
		
		// формируем ссылку для отключения оповещения
		$href_stop = '';		
		if($in['login_id']&&$in['company_id']&&$in['notification_id']){
				$href_stop = $this->HrefStopEmail(array('login_id'			=> $in['login_id'],
													'company_id'		=> $in['company_id'],
													'notification_id'	=> $in['notification_id'] ));
		}
		
			$code = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">

				<head>
					<title></title>
					<meta content="text/html; charset=utf-8" http-equiv="content-type" />
					<meta name="viewport" content="width=device-width, initial-scale=1.0" />
					<meta name="format-detection" content="telephone=no" />
					<meta name="format-detection" content="date=no" />
					<meta name="format-detection" content="address=no" />
					<meta name="format-detection" content="email=no" />
					<meta http-equiv="X-UA-Compatible" content="IE=edge" />
					<link rel="preconnect" href="https://fonts.gstatic.com">
					<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
					<link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300&display=swap" rel="stylesheet">
					
					<!--[if gte mso 9]>
						<xml>
						<o:OfficeDocumentSettings>
							<o:AllowPNG/>
							<o:PixelsPerInch>96</o:PixelsPerInch>
						</o:OfficeDocumentSettings>
						</xml>
					<![endif]-->

					<style type="text/css">
						
						.ReadMsgBody {width: 100%;}
						.ExternalClass {width: 100%;}
						.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
						#outlook a {padding: 0;}
						
						a[x-apple-data-detectors] {
							color: inherit !important;
							text-decoration: none !important;
							font-size: inherit !important;
							font-family: inherit !important;
							font-weight: inherit !important;
							line-height: inherit !important;
						}
						
						html {
							-ms-text-size-adjust: none !important;
							-moz-text-size-adjust: none !important;
							-webkit-text-size-adjust: none !important;
							-webkit-font-smoothing: antialiased !important;
							margin: 0 !important;
							padding: 0 !important;
							width: 100% !important;
							min-width: 100% !important;
						}	
						
						img {
							-ms-interpolation-mode: bicubic;
						}		

						@media only screen and (max-width:480px) {
							.pad-t-25 {padding-top: 25px !important;}
							.pad-b-25 {padding-bottom: 25px !important;}
							.fz-20 {font-size: 20px !important; line-height: 24px !important;}
							.maxw-100 {max-width: 100% !important;}
							.hide {display: none !important; width: 0 !important; height: 0 !important; padding: 0 !important; font-size: 0 !important; line-height: 0 !important;}
							.pad-0 {padding: 0 !important;}
						}	
						
						
						@font-face {
							font-family: \'Comfortaa\';
							font-weight: 400;
							font-style: normal;
							src: local(\'Comfortaa\'), url(\'fonts/comfortaa.woff\') format(\'woff\');
							}
						@font-face {
							font-family: \'Comfortaa-light\';
							font-weight: 700;
							font-style: normal;
							src: local(\'Comfortaa-light\'), url(\'fonts/comfortaalight.woff\') format(\'woff\');
							}
															
					</style>
					
					<!--[if gte mso 9]>
						<style type="text/css">
							td, div, a, span {
								font-family: Arial, sans-serif !important;
							}
						</style>
					<![endif]-->
						
				</head>
				
			<body bgcolor="#82abff" style="width: 100% !important; min-width: 100%; margin: 0 !important; padding: 0 !important; -webkit-text-size-adjust: none !important; -ms-text-size-adjust: none !important; -moz-text-size-adjust: none !important; -webkit-font-smoothing: antialiased !important;">

			<!-- Preheader -->
			<div style="color: transparent; display: none; display: none !important; height: 0; width: 0; max-width: 0; opacity: 0; visibility: hidden; padding: 0; font-size: 0; line-height: 0; mso-hide: all;">
				&nbsp;
			</div>

			<table bgcolor="#82abff" width="100%" style="-webkit-text-size-adjust: none !important; background-color: #82abff;" cellpadding="0" cellspacing="0" border="0">
				
				<tr>
					<td class="pad-0" align="center" valign="top" style="padding: 64px 0 0;">
						<center style="width: 100%;">
							<div style="max-width: 895px; margin: 0 auto; min-width: 340px;">
								<!--[if (gte mso 9)|(IE)]>
								<table width="895" align="center" cellpadding="0" cellspacing="0" border="0">
								<tr>
								<td align="center" valign="top">
								<![endif]-->
								<table bgcolor="#ffffff" style="margin: 0 auto; width: 100%; max-width: 895px;" align="center" cellpadding="0" cellspacing="0" border="0">
					
									<!-- Header -->
									<tr>
										<td align="center" valign="top" style="padding: 0 15px 0;">
											<table cellpadding="0" cellspacing="0" border="0">
												<tr>
													<td width="848" align="center" valign="top">
														<table width="100%" cellpadding="0" cellspacing="0" border="0">
																
															<tr>
																<td valign="middle" style="text-align: left; font-size: 0; padding: 10px 0 10px;">
																	<!--[if (gte mso 9)(IE)]>
																	<table cellpadding="0" cellspacing="0" border="0">
																	<tr>
																	<td width="407" valign="middle" align="center">
																	<![endif]-->
																				
																	<div style="width: 100%; max-width: 404px; display: inline-block; vertical-align: middle;">
																		<table width="100%" cellpadding="0" cellspacing="0" border="0">
																			<tr>
																				<td align="left" valign="top" style="padding: 11px 0 11px;">
																					<a href="https://'.$_SERVER['SERVER_NAME'].'/" target="_blank" style="text-decoration: none;">
																						<img src="https://'.$_SERVER['SERVER_NAME'].'/infoparts_assets/img/outerImg/logo.png" width="153" height="54" border="0" alt="Logo" style="vertical-align: top; margin: 0; padding: 0; border: none; line-height: 100%; outline: none; text-decoration: none;" />
																					</a>
																				</td>
																			</tr>
																		</table>
																	</div>
																				
																	<!--[if (gte mso 9)|(IE)]>
																	</td><td width="444" valign="middle" align="center">
																	<![endif]-->
																				
																	<div style="width: 100%; max-width: 444px; display: inline-block; vertical-align: middle;">
																		<table width="100%" cellpadding="0" cellspacing="0" border="0">
																			<tr>
																				<td valign="middle" style="text-align: left; font-size: 0; padding: 0 0 0;">
																					<!--[if (gte mso 9)(IE)]>
																					<table cellpadding="0" cellspacing="0" border="0">
																					<tr>
																					<td width="220" valign="middle" align="center">
																					<![endif]-->
																								
																					<div style="width: 100%; max-width: 220px; display: inline-block; vertical-align: middle;">
																						<table width="100%" cellpadding="0" cellspacing="0" border="0" style="display:none;">
																							<tr>
																								<td width="35" align="left" valign="middle" style="padding: 13px 0 5px;">
																									<img src="https://'.$_SERVER['SERVER_NAME'].'/infoparts_assets/img/outerImg/tel.png" width="24" height="24" alt="icon" border="0" style="display: block; margin: 0; padding: 0; border: none; line-height: 100%; outline: none; text-decoration: none;" />
																								</td>
																								<td align="left" valign="middle" style="padding: 14px 0 5px;">
																									 <div style="font-size: 20px; line-height: 20px; font-family: \'Open Sans\', Arial, sans-serif; color: #595961; font-weight: 700;">
																										<a href="tel:+78002502610" target="_blank" style="text-decoration: none; color: #595961; outline: none; cursor: pointer;"><span style="color: #595961;">8 (800) 250 26 10</span></a>
																									</div>
																								</td>
																							</tr>
																						</table>
																					</div>
																								
																					<!--[if (gte mso 9)|(IE)]>
																					</td><td width="224" valign="middle" align="center">
																					<![endif]-->
																								
																					<div style="width: 100%; max-width: 224px; display: inline-block; vertical-align: middle;">
																						<table width="100%" cellpadding="0" cellspacing="0" border="0">
																								
																							<!-- Button -->
																							<tr>
																								<td valign="middle" align="center" style="padding: 10px 0 5px;">
																									<table border="0" cellspacing="0" cellpadding="0">
																										<tr>
																											<td width="224" valign="middle" align="center" style="background-color: #384bf8; border-radius: 50px;">
																												<a href="https://'.$_SERVER['SERVER_NAME'].'" target="_blank"
																													style="text-decoration: none;	
																														width: 100%;
																														font-size: 14px;
																														line-height: 20px;
																														font-weight: 400;
																														color: #ffffff;
																														border-radius: 50px;
																														background-color: #384bf8;
																														border: 0 solid #384bf8;
																														padding: 5px 0;
																														display: block;
																														vertical-align: middle;
																														font-family: \'Open Sans\', Arial, sans-serif;">
																															<span style="color: #ffffff; vertical-align: middle;">
																																<span style="font-size: 28px;vertical-align: middle;font-family: initial;">+&nbsp;</span> Разместить потребность
																															</span>
																												</a>
																											</td>
																										</tr>
																									</table>
																								</td>
																							</tr>
																								
																						</table>
																					</div>
																								
																					<!--[if (gte mso 9)|(IE)]>
																					</td>
																					</tr>
																					</table>
																				   <![endif]-->
																				</td>
																			</tr>
																		</table>
																	</div>
																				
																	<!--[if (gte mso 9)|(IE)]>
																	</td>
																	</tr>
																	</table>
																   <![endif]-->
																</td>
															</tr>
																
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									
									<!-- Text -->
									<tr>
										<td class="pad-t-25" align="center" valign="top" style="padding: 100px 15px 0;">
											<table cellpadding="0" cellspacing="0" border="0">
												<tr>
													<td width="510" align="center" valign="top">
														<table width="100%" cellpadding="0" cellspacing="0" border="0">
																
															<tr>
																<td align="center" valign="top">
																	<div class="fz-20" style="font-size: 24px; line-height: 28px; font-family: \'Comfortaa\', Arial, sans-serif; color: #000000; font-weight: 300;">
																		'.$p['content'].'	    		
																	</div>
																</td>
															</tr>
															
															<!-- Button -->
															<tr>
																<td class="pad-t-25 pad-b-25" valign="middle" align="center" style="padding: 85px 0 85px;">
																	<table border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td width="103" valign="middle" align="center" style="background-color: #36e000; border-radius: 50px;">
																				<a href="'.$p['href'].'" target="_blank"
																					style="text-decoration: none;	
																						width: 100%;
																						font-size: 14px;
																						line-height: 20px;
																						font-weight: 400;
																						color: #000000;
																						border-radius: 50px;
																						background-color: #36e000;
																						border: 0 solid #36e000;
																						padding: 5px 0;
																						display: block;
																						font-family: \'Open Sans\', Arial, sans-serif;">
																							<span style="color: #000000;">
																								Перейти
																							</span>
																				</a>
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
																
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									
					
								</table>
								<!--[if (gte mso 9)|(IE)]>
								</td>
								</tr>
								</table>
								<![endif]-->
							</div>
						</center>		
					</td>
				</tr>
				
				<!-- Footer -->
				<tr>
					<td class="pad-t-25" align="center" valign="top" style="padding: 57px 15px 25px;">
						<table cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="586" align="center" valign="top">
									<table width="100%" cellpadding="0" cellspacing="0" border="0">					
										<tr>
											<td align="center" valign="top">
												<div style="font-size: 14px; line-height: 20px; font-family: \'Open Sans\', Arial, sans-serif; color: #404040; font-weight: 400;">
													Не отвечайте на письмо - оно автоматическое<br />
													<br />
													Вы получили это письмо, потому что Вы являетесь пользователем QuestRequest.
													Если&nbsp;у&nbsp;Вас возникли вопросы, ответы можно найти в разделе <a href="https://'.$_SERVER['SERVER_NAME'].'/rules" target="_blank" style="text-decoration: underline; color: #404040; outline: none; cursor: pointer;"><span style="color: #404040;">помощь.</span></a>
													<a href="'.$href_stop.'" target="_blank" style="text-decoration: underline; color: #404040; outline: none; cursor: pointer;"><span style="color: #404040; white-space: nowrap;">Отключить&nbsp;уведомления&nbsp;о&nbsp;сообщениях</span></a>	    		
												</div>
											</td>
										</tr>						
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				
			</table>
					
			</body>
			</html>';
		
		return $code;
	}	
	// Insert - Логи SMS_RU
	function reqInsertSMSRULogs($p=array()) {
		
		$p['position'] = (isset($p['position']))? $p['position'] : '';

		$STH = PreExecSQL(" INSERT INTO sms_logs (login_id,company_id,sms_id,status_code) VALUES (?,?,?,?); " ,
														array( $p['login_id'],$p['company_id'],$p['prava_id'],$p['position'] ));
		if($STH){
			$ok = true;
		}
	
		return array('STH'=>$STH);
	}	

	// Письмо на почту - Отправка оповещения о сообщениях
	function LetterSendChat( $p=array() ){		
		
		$code = $p['link'];
		
		//тема письма
		$subject = 'У вас новое сообщение - QRQ';
		//тело письма
		$body = 'У вас новое сообщение
				<br/>		
				<span style="font-weight:bold;"><a href="'.$code.'">Посмотреть -></a></span>
				<br/>';
		
		$rez = $this->sendMail(array(	'email'		=>$p['email'] , 	'name'=>'' , 
									'subject'	=>$subject , 			'body'=>$body ));
		
		return array('rez'=>$rez);
	}
	
	
}
?>