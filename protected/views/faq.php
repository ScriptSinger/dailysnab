<?php

	//$row 	= $member['mainpage']['row'];

	
	



	$rowt = reqTicketMessages();
	
	$navPanel = empty($rowt) ? $t->SubmenuHelp(array('page'=>'faq')) : $t->NavTabsTicketsFolders();

	$code .= '

			

			<div class="container">'.$navPanel.'</div>	
		
			
			
			<section class="infopage">
				<div class="container">

					<div class="center-text">
						<h1>ЧАСТО ЗАДАВАЕМЫЕ ВОПРОСЫ</h1>
					</div>
					
					<div class="text-section center-text">
						<h5>Для чего нужен questRequest?</h1>
					</div>
					<div class="text-section justify-text">
						<p>questRequest упрощает поиск и сравнение товара, а также коммуникации между всеми участниками торговли, при этом экономит время и помогает получить максимум выгоды при покупке или продаже товаров.</p>
					</div>
						 
					<div class="center-text">
						<h5>Как работает questRequest?</h1>
					</div>
						
					<div class="justify-text">
						<p>
							Для покупателей:
						
							<ol style="text-align:left;">
								<li>Покупатель находит нужный товар, среди предложений на сайте questRequest, воспользовавшись поиском</li>
								<li>Либо Покупатель размещает потребность в товаре</li>
								<li>Получает предложения</li>
								<li>От продавцов, которые есть в платформе</li>
								<li>От продавцов, которые подписаны на покупателя</li>
								<li>От пользователей, которым покупатель отправил свои потребности</li>
								<li>Зафиксировав чье-то предложение в ручную</li>
								<li>Сравнивает предложения в одном окне</li>
								<li>Покупает лучшее предложение и может фиксировать статус исполнения.</li>
							</ol>
							Для продавцов:
							<ol>
								<li>Продавец размещает объявления и продаже своих товаров.</li>
								<li>Либо Продавец находит интересные заявки и дает на них предложения</li>
								<li>Покупатели связываются и покупают товар, если предложение их заинтересовало</li>
								<li>Продавец может подписаться на заявки конкретных покупателей, отфильтровать заявки которые ему интересны и получать оповещения только на них.</li>
							</ol>
						</p>
					</div>
						
					<div class="text-section center-text">
						<h5>Как найти нужный товар?</h1>
					</div>
					<div class="text-section justify-text">
						<p>Воспользуйтесь поиском или разместите заявку.</p>
					</div>
						
					<div class="text-section center-text">
						<h5>Как купить товар?</h1>
					</div>
					<div class="text-section justify-text">
						<p>Свяжитесь с продавцом или нажмите на кнопку купить, чтоб продавец получил оповещение и связался свами.</p>
					</div>
					
					<div class="text-section center-text">
						<h5>Как продать товар?</h1>
					</div>
					<div class="text-section justify-text">
						<p>Разместите объявление или найдите заявку, которую удовлетворит ваше предложение</p>
					</div>
					
					<div class="text-section center-text">
						<h5>Как найти поставщика?</h1>
					</div>
					<div class="text-section justify-text">
						<p>Разместите заявку и сделайте её активной, чтоб все поставщики увидели её и связались с вами.</p>
					</div>
					
					<div class="text-section center-text">
						<h5>Сколько стоит questRequest?</h1>
					</div>
					<div class="text-section justify-text">
						<p>questRequest позволяет пользоваться бесплатно всем основным функционалом. Плата взимается при подписке на более профессиональный инструменты торговли, которые необходимы при осуществлении коммерческой деятельности.</p>
					</div>
					
					<div class="text-section center-text">
						<h5>Как обращаться в поддержку?</h1>
					</div>
					<div class="text-section justify-text">
						<p>Пишите нам на почту support@qrq.ru</p>
					</div>
					
				</div>
			</section>

	
		
			';


?>