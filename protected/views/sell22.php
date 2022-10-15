<?php
	$row 		= $member['sell22']['row'];
	$categories_id = $member['sell22']['categories_id'];
	$cat_id 		= $member['sell22']['cat_id'];
	$etp 		= $member['sell22']['etp'];
	

	$tr = '';
	$last_etp_id = 0;
	$arr = array();
	foreach($row as $i => $m){
	
		$tr .= $t->TrPageSell22(array('row'=>$m));
		
		$arr[] = $m['id'];

	}
	
	$last_etp_id = ($tr)? max($arr) : 0;
	
	
	
	//вывод описания категорий
	$descCategory = '';
	$desc_sell = array();
	
	if (!empty($cat_id)){
		$rc = reqSlovCategories(array('id'=>$cat_id));
		$descCategory = $rc["desc_sell"];
	}
	///	
	
	// Кнопки Создать
	if(!$tr&&!$etp){
			$tr = '
					<div class="buy-sell-not-found">
						<div class="content">
							<p>По запросу <b class="buy-sell__search-text"></b> ничего не найдено</p>
							<p>Разместите заявку на покупку и ее увидят до <b>400</b> поставщиков</p>
						</div>
						<button class="btn modal_buy_sell buy-not-found__btn search-post" data-flag_buy_sell="2">Разместить заявку</button>
					</div>
				';
	}elseif(!$tr&&$etp){
			$tr = '
					<div class="buy-sell-not-found">
						<div class="content">
							<p>Ожидайте получение предложений...</p>
						</div>
					</div>
				';
	}
	


	$js = '';
	if($etp){
		$js = '	<script>
					$(function(){
							// обновить предложения (объявления) при полуении с ЭТП
							var timeOutId3 = 0;
							var ajaxFn3 = function () {
									$.post("/get_html_sell_by_infopart", { value:$(".autocomplete_search_top").val() , id:$("#last_etp_id").val() }, 
												function(data){
															if(data.code){
																$("#div_tr_sell").html(data.code);
																$("#last_etp_id").val(data.id);
																
															}
															if(data.noload){
																clearTimeout(timeOutId3);
															}else{
																timeOutId3 = setTimeout(ajaxFn3, 3000);
															}
												}
									);
							};
							timeOutId3 = setTimeout(ajaxFn3, 3000);
					});
				</script>';
	}



	
	$code .= '
			
			<section class="request" id="request">
				<div class="container">
					
					<div id="div_tr_sell" class="row list-items-ads mt-4">
							'.$tr.'
					</div>
					
					'.$e->Input(	array(	'type'			=> 'hidden',
											'id'			=> 'last_etp_id',
											'value'			=> $last_etp_id
										)
								).'
					
					<br />
					
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
		
			'.$js.'
		
			';

?>