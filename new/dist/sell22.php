<?php

			
			$cost_coefficient = ($m['cost_coefficient']>0)? '('.$this->nf($m['cost_coefficient']).')' : '';
			
			// кнопка купить на кого подписан
			$button_buy = '';
			if( (PRAVA_2||PRAVA_3) && ($m['flag_subscriptions_company_in']||$m['flag_subscriptions_company_out']) ){
			//if(COMPANY_ID&&COMPANY_ID<>$m['company_id']){
			
					$button_buy = $this->Input(	array(	'type'			=> 'button',
													'class'			=> 'pull-right btn btn-pfimary btn-sm get_form_buy_amount',
													'value'			=> 'купить',
													'data'			=> array('id'=>$m['id'],'where'=>'page_sell')
												)
										);
			}

			// Срочность
				$urgency = ($m['urgency_id']==1)? '<span class="data-month urgency-urgent">'.$m['urgency'].'</span>' : '';
			///
			
				if ($img == '') {
					$noPhoto = ' no-photo';
				} else {
					$noPhoto = '';
				}

			// количество купленных
			$kol_status = '';
			if($m['kol_status11']>0){
				$kol_status = '&nbsp;<span class="request-quantity__bought" title="куплено">('.$this->nf($m['kol_status11']).')</span>';
			}

			// Наличие
				$availability = $availability_str = '';
				if($m['availability']){
					$availability_str = $this->format_by_count($m['availability'], 'день', 'дня', 'дней');
					$availability = $m['availability'];
				}
			//


			// форма оплаты
				if($m['form_payment_id']==3){
					$form_payment = '<span class="request-money"></span>';
				}else{
					if ($m['form_payment']) {
						$form_payment = '<span class="request-nds"><span class="ndsText">'.$m['form_payment'].'</span></span>';
					} else {
						$form_payment = '';
					}
				}
			///



$sell22 = '

<div class="sell-item view_2'.$noPhoto.'">
	<div class="request-slider-wrapper">
		<div class="image-wrapper">
			<div class="inner-wrapper">
				'.$img.'
			</div>
		</div>
		<div class="slider-control"></div>
	</div>
	<div class="sell-item__info">
		<div class="sell-item_name">
			<div class="sell-item_name-top">
				<a href="/'.$m['url_cities'].'/'.$m['url_categories'].'/'.$m['url'].'" target="_blank">'.(  ($m['name'])? $m['name'] : '-'  ).'</a>
			</div>
			<div class="sell-item_name-bottom">
				<span class="sell-item_name-bottom__num">'.$availability.' </span>
				<span class="sell-item_name-bottom__time">'.$availability_str.'</span>
			</div>
		</div>
		<div class="sell-item_quantity">
			<div class="sell-item_quantity-top">
				<span class="sell-item_quantity-top__quantity">'.$this->nf($m['amount']).' '.$m['unit'].'</span>'.$kol_status.'
			</div>
			<div class="sell-item_quantity-bottom">
				<span class="sell-item_quantity-bottom__left">'.$m['min_party'].'</span>/<span class="sell-item_quantity-bottom__right">'.$m['multiplicity'].'</span>
			</div>
		</div>
		<div class="sell-item_price">
			<div class="sell-item_prop-left">
				<div class="sell-item_prop-left__top">'.$cost_coefficient.'</div>
				<div class="sell-item_prop-left__bottom"></div>
			</div>
			<div class="sell-item_prop-middle">
				<div class="sell-item_prop-middle__top">'.$this->nf($m['cost']).' <span class="sell-item_prop-top__new-currency">'.$m['currency'].'</span></div>
				<div class="sell-item_prop-middle__bottom"><div>3 000 Р</div></div>
			</div>
			<div class="sell-item_prop-right">
				<div class="sell-item_prop-right__top">'.$form_payment.'</div>
				<div class="sell-item_prop-right__bottom"></div>
			</div>
		</div>
		<div class="sell-item_prop">
			<div class="sell-item_prop-item"><span data-name="'.$arr_six[1][0].'">'.$arr_six[1][1].'</span></div>
			<div class="sell-item_prop-item"><span data-name="'.$arr_six[2][0].'">'.$arr_six[2][1].'</span></div>
			<div class="sell-item_prop-item"><span data-name="'.$arr_six[3][0].'">'.$arr_six[3][1].'</span></div>
			<div class="sell-item_prop-item"><span data-name="'.$arr_six[4][0].'">'.$arr_six[4][1].'</span></div>
			<div class="sell-item_prop-item"><span data-name="'.$arr_six[5][0].'">'.$arr_six[5][1].'</span></div>
			<div class="sell-item_prop-item"><span data-name="'.$arr_six[6][0].'">'.$arr_six[6][1].'</span></div>
		</div>
		<div class="sell-item_middle">
			<div class="sell-item_middle-comment">'.$m['comments'].'</div>
			<div class="sell-item_middle-btn">'.$button_buy.''.$button_grouping.'</div>
		</div>
		<div class="sell-item_bottom">
			<div class="sell-item_bottom-left">
				<span class="sell-item_bottom-left__sticker">'.$urgency.'</span>
				<span class="sell-item_bottom-left__city">'.$m['cities_name'].',</span>
				<span class="sell-item_bottom-left__date"> '.$m['data_status_buy_sell_23'].'</span>
				
			</div>
			<div class="sell-item_bottom-right">
				<span class="sell-item_bottom-right__cat">'.$m['categories'].'</span>
				<!--<span class="sell-item_bottom-right__icon">●</span>-->
				<span class="sell-item_bottom-right__name">
						<a href="/company-profile/'.$m['company_id'].'" target="_blank">'.$m['company'].'</a>
				</span>
			</div>
		</div>
		<div class="sell-item_status-bars status-bar">
			<button>
				<img src="/image/status-mail.svg" alt="Отправить сообщение (Чужие объявления)" class="status-request write_message_need" 
					data-need="26" 
					data-company="'.$m['company_id'].'"
					data-id="'.$m['id'].'"
					data-url="/'.$m['url_cities'].'/'.$m['url_categories'].'/'.$m['url'].'"
				>
			</button>
		</div>
	</div>
</div>


<div id="tr_'.$m['id'].'" class="request-hidden" style="display:none;">
							
</div>



';

return $sell22;
?>