<?php
	$row 			= $member['buy']['row'];
	$row_np 			= $member['buy']['row_np'];
	$row_share 		= $member['buy']['row_share'];
	$row_subscriptions 	= $member['buy']['row_subscriptions'];
	$flag_interests		= $member['buy']['flag_interests'];
	$flag_interests2		= $member['buy']['flag_interests2'];
	$categories_id 	= $member['buy']['categories_id'];
	$cat_id 	= $member['buy']['cat_id'];
	$cities_id 		= $member['buy']['cities_id'];
	$value			= $member['buy']['value'];
	$share_url		= $member['buy']['share_url'];
	$flag_search		= $member['buy']['flag_search'];
	

	$tr = '';
	foreach($row as $i => $m){
	
			$tr .= $t->TrPageBuy(array('m'=>$m,'row_share'=>$row_share,'row_np'=>$row_np));
	
	}
	//вывод описания категорий
	$descCategory = '';
	$desc_buy = array();
	if (!empty($cat_id)){
		$rc = reqSlovCategories(array('id'=>$cat_id));
		$descCategory = $rc["desc_buy"];	
	}
	
	$code_interests = '';
	if(!$flag_interests2 && COMPANY_ID){
			$code_interests = '<div class="request-heading">
								<a href="/profile#interests" class="request-btn heading-btn choose-client inline-button">Выберите свои интересы</a>
							</div>';
	}
	
	// Кнопки Создать
	if(!$tr){
			$tr = '	
					<div class="buy-sell-not-found buy-not-found">
						<div class="content">
							<p>По запросу <b class="buy-sell__search-text"></b> ничего не найдено</p>
							<p>Разместите заявку на покупку и ее увидят до <b>400</b> поставщиков</p>
						</div>
						<button class="btn modal_buy_sell buy-not-found__btn search-post" data-flag_buy_sell="1">Разместить объявление</button>
					</div>
				';
	}
	
	// Подписка
	$code_subscribe = '';
	if( $row_share['share_url'] && empty($row_subscriptions) && $row_share['company_id_from']<>COMPANY_ID ){// share сылка и не подписан на отправившего ссылку
			$class_action = (COMPANY_ID)? 'action_subscriptions' : 'action_subscriptions_no_autorize';
			$code_subscribe = '<div class="subscribe-requests '.$class_action.'" data-id="'.$row_share['company_id_from'].'" data-where="share">Подпишись на все заявки</div>';
	}
	///
	
	
	$code .= '
		
			<section class="request" id="request">
				<div class="container">
				
					'.$code_interests.'
					
					'.$tr.'
					
					<div id="div_limit"></div>
					
					<div id="div_scrol"></div>
					
					Описание: '.$descCategory.'
	
				</div>
				<div id="footer_message">
					<div class="__status-bar" style="width:27px;float:right">
						<button class="status-bar__convert">
							<img style="background:red" src="/image/status-mail.png" alt="Отправить сообщение (Помощь)" class="status-request write_message_need" 
								data-need="24" 
								data-company="1247" 
								data-url="/help/">
							<span class="bttip" style="display: none;">Нажмите, чтобы отправить сообщение</span>
						</button>
					</div>				
				</div>				
			</section>
			
			'.$code_subscribe.'
			
<script>
$(function(){
	
	var inProgress = false;
	var start = 10;
    $(window).scroll(function() {
		//$("#div_scrol").html( "$(window).scrollTop() = "+$(window).scrollTop() );

        if ( ( ( $(window).scrollTop() + $(window).height() ) >= ( $(document).height()*0.8 - 200 ) ) && !inProgress) {
			
            $.ajax({
                url: "/scroll_page",
                method: "POST",
                data: {
                    "flag" 				: "pagebuy",
					"start_limit"		: start,
					"categories_id"		: "'.$categories_id.'",
					"cities_id"			: "'.$cities_id.'",
					"value"				: "'.$value.'",
					"share_url"			: "'.$share_url.'",
					"flag_interests"	: "'.$flag_interests.'",
					"flag_search"		: "'.$flag_search.'"
                },
                beforeSend: function() {
                    inProgress = true;
                }
            }).done(function(data){
                if (data.ok){
                    $("#div_limit").before(data.code);
                    inProgress = false;
					start = start + 10;
                }
            });
			
        }
    });
});
</script>
			
			
			';
			
?>
