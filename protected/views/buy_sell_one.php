<?php
	$row 			= $member['buy_sell_one']['row'];			// данные заяки или предложения
	$row_buy 		= $member['buy_sell_one']['row_buy'];		// данные заяки (в случае предложения)
	$row_buy_offer 	= $member['buy_sell_one']['row_buy_offer'];	// данные предложения (в случае предложения)
	$row_attribute 		= $member['buy_sell_one']['row_attribute'];	// атрибуты
	$flag_offer 		= $member['buy_sell_one']['flag_offer'];		// флаг предложения
	$amount_recom 	= $member['buy_sell_one']['amount_recom'];	// рекомендуемое количество для поля купить
	
	
	if($flag_offer){// Предложение
		$zagolovoc = $row['name'].' '.$row['amount'].' '.$row['unit'];
	}else{
		$amount_unit = '';
		if($row['flag_buy_sell']==2||$row['flag_buy_sell']==3){// Заявка или Предложение
			$amount_unit = ' '.$row['amount'].' '.$row['unit'];
            // фасовка
            if ($row['unit_group_id']) {
                if ($row['unit_id2'] && $row['amount2']) {// выбрано ШТУКИ и другая ед.измерения
                    $amount_unit = $this->nf($row['amount1']).' '.$row['unit1'];
                } elseif ($row['unit_id1'] && !$row['unit_id2'] && ($row['unit_id'] <> $row['unit_id1'])) {// выбрано НЕ штуки, а другая ед.измерения отличная от "по умолчанию" у категории
                    $t_amount = ($row['status_buy_sell_id'] == 11) ? $row['amount_buy'] : $row['amount1'];
                    $amount_unit = $this->nf($t_amount).''.$row['unit1'];
                }
            }
		}
		$zagolovoc = $row['name'].$amount_unit;
	}
	
	
	$tr_attribute = '';
	foreach($row_attribute as $i => $m){
			$tr_attribute .= '
						<div class="product-info__row">
							<div class="product-info__cell">'.$m['attribute'].'</div>
							<div class="product-info__cell">'.$m['attribute_value'].'</div>
						</div>
			';

	}

	$cost = ($row['cost']>0)? $g->nf($row['cost']).' ₽' : '';
	
	$phone = '';
	//if($row['flag_buy_sell']==2||$flag_offer){
		$phone = '	<div id="div_phone'.$row['id'].'" class="product-phone">
						<p class="view_phone" data-id="'.$row['id'].'" data-amount="'.$amount_recom.'">Показать телефон</p>
					</div>';
	//}
	

	$note = $t->NoteBuySellOne(array('buy_sell_id'=>$row['id']));
	
	
	// изображение
		$arr 	= $t->getImgBuySell(array('buy_sell_id'=>$row['id']));
		$img 	= $arr['code'];
		$first_img	= $arr['first_img'];
	///	
	
	
	// сумма купленого по заявке
		$sum_cost = (isset($row_buy_offer['sum_amount']))? '<div>
													<span class="badge badge-success font14">'.$g->nf($row_buy_offer['sum_amount']).' '.$row['unit'].'</span>
												</div>' : '';
	///
			
	$code .= '
			<section class="product">
				<div class="container">
					<div class="row">
						<div class="col">
							<div class="product-title">
								<p>'.$zagolovoc.'</p>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-6 images-wrapper">
							<div class="product-images-wrapper">
								<div class="product-img-prev">
									'.$img.'
								</div>
								<div class="product-big-img">
									'.$first_img.'
								</div>
							</div>
						</div>
						<div class="col-3 product-info">
							'.$tr_attribute.'
						</div>
						<div class="col-3 product-price-wrapper">
							
							<div class="product-price">
								<span>'.$cost.'</span>
							</div>
						  
							'.$phone.'
							
							<div class="other-info">
								<p class="product-num">№'.$row['id'].'</p>
								<p class="product-name"><a href="/company-profile/'.$row['company_id'].'" target="_blank">'.$row['company'].'</a></p>
								<p class="product-location">'.$row['cities_name'].'</p>
							</div>
						  
							<div id="div_note'.$row['id'].'">'.$note.'</div>
							
							'.$sum_cost.'
							
							<div id="div_buy_offer"></div>
							
						</div>
					</div>
					<div class="comment-wrapper">
						<div class="comment-title">
							<p>Комментарий</p>
						</div>
						<div class="comment">
							<p>'.nl2br($row['comments']).'</p>
						</div>
					</div>
				</div>
			</section>
			';
	
?>