<?php

	$row_vip 		= $member['skills']['row_vip'];

	$active = array(1=>'',2=>'',3=>'',4=>'',5=>'',6=>'',7=>'',8=>'',9=>'',10=>'',11=>'',12=>'',13=>'');

	foreach($row_vip as $n => $m){

		$active[ $m['vip_function_id'] ] = 1;
	
	}
	
   
/*
	$tr = '';
	foreach($row_notification as $i => $m){

			$tr .= '	<tr>
						<td style="'.$st_td1.'">
							'.$m['notification'].'
						</td>
						<td>
							'.$td2.'
						</td>
						<td>
							'.$td3.'
						</td>
					</tr>';
	}
*/

	$code .= '
			<section class="profile profile-company" id="profile-company">
			
				<div class="container">
				
						<h4>Опытный снабженец</h4>
						
						<div id="div_action_enter_cancel_vip_7">
							'.$e->ButtonEnterCancelVip(array('id'=>7,'active'=>$active[7])).'
						</div>
						
						<div style="color:#0000ff;font-size:22px;">Анализ предыдущих покупок</div>
						- Не закупайте лишнее - система предупредит, если товар уже заказан;
						<br/>
						- Не переплачивайте на новых закупках - своевременное отображение информации о предыдущих покупках;
						<br/>
						- Не повторяйте ошибки - система отобразит, если был возврат

						<div style="color:#0000ff;font-size:22px;">Быстрое создание заявок</div>
						- Не тратьте время на заполнение хатакреристик - система ведет номенклатуру и подгружает характеристики товара к новой заявке
						<br/>
						- Не тратьте время на заполнение условий заявки - система подгружает условия заявки из предыдущей

						<div style="color:#0000ff;font-size:22px;">Объединение заказов</div>
						- Отслеживайте исполнение глобально - вы присваиваете имя заказа и отслеживаете исполнение на весь заказ
						<br/>
						- Отслеживайте, кто внутренний заказчик - вы можете фиксировать ответственного за заказ
						
				</div>
	
	
				<div class="container" style="margin-top:40px;">
				
						<h4>Управляющий активами</h4>
						
						<div id="div_action_enter_cancel_vip_9">
							'.$e->ButtonEnterCancelVip(array('id'=>9,'active'=>$active[9])).'
						</div>
						
						<div style="color:#0000ff;font-size:22px;">Отображение местонахождения активов</div>
						- Фиксируйте выдачу и возврат активов
						<br/>
						- Указывайте данные по активу, которые видны только вам

						<div style="color:#0000ff;font-size:22px;">Более точное назначение заявки</div>
						- Указывайте в заявке в назначении, конкретный актив
						
				</div>
				
				
				<div class="container" style="margin-top:40px;">
				
						<h4>Юный продавец</h4>
						
						<div id="div_action_enter_cancel_vip_8">
							'.$e->ButtonEnterCancelVip(array('id'=>8,'active'=>$active[8])).'
						</div>
						
						<div style="color:#0000ff;font-size:22px;">Простая CRM</div>
						- Указывайте в заявке, для кого заявка
						<br/>
						- Выставляйте фиксированную наценку для всех и индивидуально для каждого заказчика
						
				</div>
				
				
				<div class="container" style="margin-top:40px;">
				
						<h4>Управляющий остатками</h4>
						
						<div id="div_action_enter_cancel_vip_10">
							'.$e->ButtonEnterCancelVip(array('id'=>10,'active'=>$active[10])).'
						</div>
						
						<div style="color:#0000ff;font-size:22px;">Товар никогда не кончится</div>
						- Выставляйте на какой период минимум и максимум должно хватать товара и 
							управляющий своевременно предложит закупить нужное количество исходя из расхода
						<br/>
						- Управляющий предложит скорректировать или добавить на отслеживание товары по которым есть движение.
						
				</div>				
				
				
				<div class="container" style="margin-top:40px;">
				
						<h4>Финансист</h4>
						
						<div id="div_action_enter_cancel_vip_11">
							'.$e->ButtonEnterCancelVip(array('id'=>11,'active'=>$active[11])).'
						</div>
						
						<div style="color:#0000ff;font-size:22px;">Пересчет реальной стоимости</div>
						- Не тратьте время на пересчеты - укажите коэффиценты для каждой формы оплаты (НДС, без НДС, наличные) 
							и система будет сортировать предложения по реальной цене
						
				</div>
				
				
				<div class="container" style="margin-top:40px;">
				
						<h4>Менеджер</h4>
						
						<div id="div_action_enter_cancel_vip_12">
							'.$e->ButtonEnterCancelVip(array('id'=>12,'active'=>$active[12])).'
						</div>
						
						<div style="color:#0000ff;font-size:22px;">Добавление сотрудников</div>
						- Работайте в команде - добавляйте любое количество сотрудников
						
						<div style="color:#0000ff;font-size:22px;">Настройка прав</div>
						- У каждого своя роль - назначайте сотрудникам права:
						<br/>Исполнитель - совершает любые действия, при закупе
						<br/>- Наблюдатель - размещает не опубликованные заявки,
							контролирует их исполнение (можно включать или отключать отображение цен и компаний
						
				</div>


				<div class="container" style="margin-top:40px;">
				
						<h4>Кладовщик</h4>
						
						<div id="div_action_enter_cancel_vip_13">
							'.$e->ButtonEnterCancelVip(array('id'=>13,'active'=>$active[13])).'
						</div>
						
						<div style="color:#0000ff;font-size:22px;">Полноценное управление складом</div>
						- Добавляйте, перемещайте и продавайте товар со склада
						<br/>
						Резервируйте товар на складе
						
				</div>
				
				
				<div class="container" style="margin-top:40px;">
				
						<h4>Интеграция с 1С</h4>
						
						<div style="color:#0000ff;font-size:22px;">Исполнение</div>
						- Все что вы покупаете отображается в 1С и если в 1С указать, что товар пришел, то исполнение отобразиться и в платформе
						<div id="div_action_enter_cancel_vip_1">
							'.$e->ButtonEnterCancelVip(array('id'=>1,'active'=>$active[1])).'
						</div>
						
						
						<div style="color:#0000ff;font-size:22px;margin-top:20px;">Остатки</div>
						- остатки подгружаются из 1С
						<div id="div_action_enter_cancel_vip_2">
							'.$e->ButtonEnterCancelVip(array('id'=>2,'active'=>$active[2])).'
						</div>
						
						
						<div style="color:#0000ff;font-size:22px;margin-top:20px;">Продажи</div>
						- при продаже в 1С формируетсчя документ "Заявка на реализацию"
						<br/>
						- Реализация из 1С подгружается в плотформу 
						<div id="div_action_enter_cancel_vip_3">
							'.$e->ButtonEnterCancelVip(array('id'=>3,'active'=>$active[3])).'
						</div>
						
						
						<div style="color:#0000ff;font-size:22px;margin-top:20px;">Выдача товаров</div>
						- товары выданные через 1С отображаются на платформе
						<div id="div_action_enter_cancel_vip_4">
							'.$e->ButtonEnterCancelVip(array('id'=>4,'active'=>$active[4])).'
						</div>
						
						
						<div style="color:#0000ff;font-size:22px;margin-top:20px;">Оплаты</div>
						- оплаты отмеченные в 1С отображаются на платформе
						<div id="div_action_enter_cancel_vip_5">
							'.$e->ButtonEnterCancelVip(array('id'=>5,'active'=>$active[5])).'
						</div>
						
						
						<div style="color:#0000ff;font-size:22px;margin-top:20px;">Резерв</div>
						- резерв на платформе резервирует товар в 1С
						<div id="div_action_enter_cancel_vip_6">
							'.$e->ButtonEnterCancelVip(array('id'=>6,'active'=>$active[6])).'
						</div>
						
						
						
						
				</div>
				
			</section>	

		';			
?>