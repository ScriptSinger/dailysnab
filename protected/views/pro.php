<?php
	$rc 		= $member['pro']['row_company'];
	$flag 		= $member['pro']['flag'];
	$type 		= $member['pro']['type'];
	$total		= (int)$member['pro']['total_pay'];
	$balance	= $member['pro']['balance'];
	$balanceAll	= $member['pro']['balanceAll'];
	$rbp 		= $member['pro']['rbp'];
	$text		= $member['pro']['code'];	
	
			
	if($flag == 1){ //по карте
		//$pay = 'По карте'; 
		$content_p = '
			<div class="card-form-block">
				
			</div>
		';
	}elseif($flag == 2){ //по счету
		//$pay = 'По счету';		
		$content_p = '
					<div class="invoice-form-block _form-wrapper">										
						<div class="invoice-form-block__title"><h3>Формирование счета на оплату</h3></div>
						
						<form id="invoice_pdf_form">
						<input type="hidden" id="login_id" name="login_id" value="'.LOGIN_ID.'" />
						<input type="hidden" id="type_skills" name="type_skills" value="'.$type.'" />
						<input type="hidden" id="total" name="total" value="'.$total.'"/>			
						
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<input type="text" class="form-control" id="inn" name="inn" placeholder="Введите ваш ИНН" value="" >
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<input type="text" class="form-control" id="kpp" name="kpp" placeholder="КПП" value="" >
																
								</div>		
							</div>
						</div>
						
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<input type="text" style="pointer-events:none;" class="form-control" id="company" name="company" placeholder="Наименование" value="" >
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">							
									<input type="text" class="form-control" id="ur_adr" name="ur_adr" placeholder="Юридический адрес" value="" >							
								</div>		
							</div>
						</div>
						<!--
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<input type="text" class="form-control" id="rschet" name="rschet"  placeholder="Расчетный счет" value="" >
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">							
									<input type="text" class="form-control" id="korr_schet" name="korr_schet" placeholder="Корр. счет" value="" >							
								</div>		
							</div>
						</div>	
						
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<input type="text" class="form-control" id="bik" name="bik" placeholder="БИК" value="" >
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">							
																
								</div>		
							</div>
						</div>	
						-->
				
						</form>
				
						<span id="pdf" class="btn button-blue" 
							data-inn=""							
							data-kpp=""
							data-company=""							 
							data-ur_adr=""
							data-rschet=""
							data-korr_schet=""
							data-bik=""
							target="_blank">скачать счет в формате PDF</span>	
					</div>
		
		';
	}elseif($flag == 3){ //История платяжей	
	
		$tr = $type = '';
		$i = 0;
		
		foreach($balanceAll as $i => $m){
		
			$dateB = date_parse($m['data_insert']);
			switch ($m['type'])
			{
				case 1:
					$type = 'Оплата за пакет Pro';
				break;
				case 2:
					$type = 'Оплата за пакет Vip';
				break;
				case 3:
					$type = 'Пополнение';
				break;				
			}		
			//if($dateB["year"]<$dateB["year"])
			$tr .= '	<tr>
						<td>'.$dateB["year"].'</td>
						<td>'.$dateB["month"].'</td>
						<td>'.$type.'</td>
						<td>'.$m['total'].'</td>
					</tr>
			';
			
		}	

		$content_p = '
			<br />	
			<section class="pro history" id="history">
				
				<div class="container">
					<div class="row">
					
						<h3>История платяжей</h3>
						
						<table id="table-admin_users" class="table table-bordered" border="0" cellspacing="0" cellpadding="0" style="margin-top:10px;">
							<thead>
								<th>Год</th>
								<th>Месяц</th>
								<th>Наименование платяжа</th>
								<th>Баланс</th>
							</thead>
							<tbody>
								'.$tr.'
							</tbody>
						</table>						
					
					</div>
				</div>
			</section>			
		';
	}elseif($flag == 4){ //Статус приема платяжей	

		$content_p = '
			<br />	
			<section class="pro payment_status" id="payment_status">
				
				<div class="container">
					<div class="row">
					
					'.$text.'
					
					</div>
				</div>
			</section>			
		';
				
	} else {

		$content_p = '
			<section class="naviki">
			
				<div class="row">
				  <div class="col-sm-6">
				  
					<div class="card" style="height:100%">
					  <div class="card-body">
						<h5 class="card-title">Опытный снабженец <a href="#" class="btn btn-danger pull-right">Отменить</a></h5>
						<p class="card-text">Текст</p>
						
					  </div>
					</div>				  

				  </div>
				  <div class="col-sm-6">
				  
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title">Финансист <a href="#" class="btn btn-info pull-right">Подключить</a></h5>
						<p class="card-text">Текст</p>
						
					  </div>
					</div>
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title">Менеджер <a href="#" class="btn btn-info pull-right">Подключить</a></h5>
						<p class="card-text">Текст</p>
						
					  </div>
					</div>					
					
					
				  </div>
				</div>
			
		
			</div>
		';
	
		
	} 
	
	//находим последнюю дату оплаты + 1 месяц
	$lastPay= 0;
	foreach($balanceAll as $date){
	  $curDate = strtotime($date["data_insert"]);
	  if ($curDate > $lastPay) {
		 $lastPay = date("d.m.Y", strtotime("+1 month", $curDate));
	  }
	}

	$count3 = ($rbp) ? (int) $rbp[0]['count3'] : 0;						
					
	$price_pro = ($count3 < 3) ? 399 : PRICE_PRO;
	$skidka = ($count3 < 3) ? '(скидка 90%)' : '';

	$balance = (!empty($balance[0]['total'])) ? $balance[0]['total'] : 0; // кол-во денег на счету	
	$pro_mode = ($rc[0]['pro_mode'])? 'Подписка оформлена' : 'Оформить подписку'; 	
	$pro_mode_text = ($rc[0]['pro_mode'])? 'Включен ежемесячный платеж банковской картой.<br> Следующий платеж произойдет '.$lastPay : ''; 
	$code .= '

	
			<br />	
			<section class="pro pro-mode" id="pro-mode">
				
				<div class="container">
					<div class="row">
						<div class="col-md-2"> 
							
							<select name="skills_select" class="skills_select">
								<option value="1" data-totalpay="'.$price_pro.'" selected>Навыки Pro</option>
								<option value="2" data-totalpay="'.PRICE_VIP.'" >Навыки Vip</option>
							</select>
							<div class="skills_div"></div>
						</div>
						<div class="col-md-2"> 
							<span class="btn button-grey podpiska" data-podpiska="'.$rc[0]['pro_mode'].'" data-balance="'.$balance.'" data-id="'.COMPANY_ID.'" >'.$pro_mode.'</span>						
						</div>
						<div class="col-md-5"> 
							<small>'.$pro_mode_text.'</small>						
						</div>
						<div class="col-md-3 text-right">
							<p class="add_balance">Пополнить</p>
							<h5><a href="/pro/history">'.$balance.' руб.</a></h5>
							
						</div>						
					</div>	

							<div class="pro-wrapper">
								<div class="pro-info-wrapper">
									<div class="pro-info">
										<div class="form-group">											
    
											<hr />
											'.$content_p.'
											
										</div>
									</div>
								</div>
							</div>
							


						
				</div>
				

<link href="https://cdn.jsdelivr.net/npm/suggestions-jquery@21.6.0/dist/css/suggestions.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@21.6.0/dist/js/jquery.suggestions.min.js"></script>

<script>
    $("#inn").suggestions({
        token: "'. DADATA_API .'",
        type: "PARTY",
        /* Вызывается, когда пользователь выбирает одну из подсказок */
        onSelect: function(suggestion) {
            console.log(suggestion);			
			$("#inn").val(suggestion.data.inn);
			$("#company").val(suggestion.value);
			$("#kpp").val(suggestion.data.kpp);
			$("#ur_adr").val(suggestion.data.address.value);			

			$("#pdf").attr("data-inn", suggestion.data.inn);
			$("#pdf").attr("data-company", suggestion.value);
			$("#pdf").attr("data-kpp", suggestion.data.kpp);
			$("#pdf").attr("data-ur_adr", suggestion.data.address.value);
			
        }
    });
</script>';		
?>