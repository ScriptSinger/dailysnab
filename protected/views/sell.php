<?php
	$row 	= $member['sell']['row'];
	$categories_id 	= $member['sell']['categories_id'];
	$cat_id 	= $member['sell']['cat_id'];

	$tr = '';
	foreach($row as $i => $m){
	
		$tr .= $t->TrPageSell(array('row'=>$m));

	}
	//вывод описания категорий
	$descCategory = '';
	$desc_sell = array();
	
	if (!empty($cat_id)){
		$rc = reqSlovCategories(array('id'=>$cat_id));
		$descCategory = $rc["desc_sell"];
	}	
	
	// Кнопки Создать
	if(!$tr){
			$tr = '
					<div class="buy-sell-not-found">
						<div class="content">
							<p>По запросу <b class="buy-sell__search-text"></b> ничего не найдено</p>
							<p>Разместите заявку на покупку и ее увидят до <b>400</b> поставщиков</p>
						</div>
						<button class="btn modal_buy_sell buy-not-found__btn search-post" data-flag_buy_sell="2">Разместить заявку</button>
					</div>
				';
	}
	
	
	$code .= '
			
			<section class="request" id="request">
				<div class="container">
					
					<div class="row list-items-ads mt-4">
							'.$tr.'
					</div>
					<br />'.$descCategory.'
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
			';

?>