<?php
	$row 	= $member['chat']['row'];
	$views 	= $member['chat']['views'];
	$value 	= $member['chat']['value'];	
	$mid 	= !empty($member['chat']['mid'])?$member['chat']['mid']:'';
	$rown 	= !empty($member['chat']['rown'])?$member['chat']['rown']:''; 
	

 	$tr = $trM = $replyMessage = $headData = $need_link ='';
	$comp = (int) COMPANY_ID;
			
		if ($_SERVER['REMOTE_ADDR'] == '178.214.251.82' && $member['menu_left']['company_info']['id'] == '1440') {
			echo "<pre>";
			print_r($member);
			echo "<pre>";
		}
			// echo '<pre>';
			// 	var_dump($member);
			// echo '</pre>'; 
			
		
$last_message = [];
        foreach ($row as $i => $m){
            $rcm = reqChatMessages(array('folder_id' => $m['id']));
            $row[$i]['timeMessage'] = end($rcm)['data_insert'];
        }

        $time = array_column($row, 'timeMessage');
        array_multisort($time, SORT_DESC, $row);

	foreach($row as $i => $m){
		if(in_array($comp, json_decode($m['companies_id']))){ //проверка прав на отображение папок
			$tr .= $t->TrPageMessagesFolders(array('m' => $m, 'views' => $views));
		}
	}   
echo $tr;
	if(!empty($mid)){ //вывод самих сообщений	
																				
			$row_f = reqAllChatMessagesCompany();			
			//$row_f = reqChatMessagesCompany();
			
			
			foreach($row_f as $i => $f){   //выделяем отдельно folder_id и companies_id
				$rowf_id[] 	 = $f['folder_id'];	 
				$rowf_comp[$f['folder_id']] = json_decode($f['companies_id']);								
			}	
/*				
 			echo '<pre>';
			vecho(json_encode($row_f));
			vecho($comp);
			vecho($mid);			
			echo '</pre>';  
*/		
			if (!empty($rown)){	
				
				foreach($rown as $i => $m){
					//vecho(json_decode($m['companies']));
					
					if(in_array($comp, json_decode($m['companies']))){ //проверка прав на чтение сообщения
						$trM .= $t->TrPageMessages(array('m' => $m, 'views' => $views));
					}
				} 				
	
			}
	

			
			$fid = $rown[0]['folder_id'];
			$theme = $rown[0]['folder_name'];			
			$avatar = ($rown[0]['ava_folder']) ? $rown[0]['ava_folder'] : '/image/profile-icon.png';
			 
			$rown_name = json_decode($rown[0]["companies_id"]);
			$need_link = $rown[0]["need"];			

			$companies_id = implode(",", $rown_name);
			$companyName = '';
			foreach($rown_name as $k){
				if($k != COMPANY_ID) {
					$companyName = PreExecSQL_one('SELECT c.*, s.legal_entity FROM company c 
                                                        LEFT JOIN slov_legal_entity s ON s.id = c.legal_entity_id
                                                        WHERE c.id = ?', [$k]);
				}
			}

			
			
/* 				if((count($needs) == 1) && ($needs[0]!='')){
					$need = implode(",", $needs);
					$row_menu = reqMenu(array('id'=>$need));
					$need_link = DOMEN.'/'.$row_menu["href"];
				} */
				
				//$rcm = reqChatMessages(array('company_id' => COMPANY_ID)); 
				//$company_name = $rcm[0]["name_rcmc"];
				?>
				<!-- <pre style="margin-left: 150px; width: calc(100vw - 150px);">
					<code>
						<?php //var_dump($rown);?>
					</code>
				</pre> -->
				<?php
				//надо будет условие поставить еще на проверку ранних сообщеницй и на заблокировать пользователя	
				$out_of_theme = '';
				if ($rown[0]['company_id'] == COMPANY_ID && $theme != '') //вывод выхода из темы для клиентов
					{
						$out_of_theme = '<button type="button" class="button-blue pull-right close_theme" data-fid="'.$fid.'">Закрыть тему</button>'; //организаторов чатов
					} 
 				else if(in_array_r( $comp, $rowf_comp ) && !in_array( $comp, end($rowf_comp) )) //кнопка для тех кто уже вышел из чата
					{
						// if () 
						$out_of_theme = '<button type="button" class="button-blue pull-right block_of_theme" data-fid="'.$fid.'">Заблокировать пользователя</button>'; // уже после выхода из чата
					} 				
				elseif($theme != '')
					{
						$out_of_theme = '<button type="button" class="button-blue out_of_theme" data-fid="'.$fid.'">Выйти из темы</button>
							<button type="button" class="button-blue close_theme_pr" data-fid="'.$fid.'">Предложить закрыть тему</button>'; //собеседников
					}
					

				$out_of_theme = ($rown[0]['status'] != 2) ? $out_of_theme : ''; // проверка, не в архиве ли чат
				
				if ($theme == ''){
                    $formPrava = (!empty($companyName['legal_entity']) ? $companyName['legal_entity'] : '');
					$headData = '
					<div class="row">
						<div class="col-md-1">
							<img src="'.$companyName['avatar'].'" class="rounded-circle" height="50">
						</div>	
						<div class="col-md-6">
							 '.$formPrava . ' ' . $companyName['company'].'<br /><small>'.$need_link.'</small>
						</div>
						<div class="col-md-5">
							'.$out_of_theme.'
						</div>				
					</div>
					';
				} else {
					$headData = '
					<div class="row">
						<div class="col-md-1">
							<img src="'.$avatar.'" class="rounded-circle" height="50">
						</div>	
						<div class="col-md-6">
							 '.$theme.'<br /><small>'.$need_link.'</small>
						</div>
						<div class="col-md-5">
							'.$out_of_theme.'
						</div>						
					</div>
					';				
				
				}
				
				
		
			if( in_array( $mid, $rowf_id )   ){ //проверка на то, что чат существет и клиент имеет право там писать  || in_array( $comp, $rowf_comp )
				
		

			
					$replyMessage = '<div class="row">
									<div class="col-md-1">


										
			<div class="form-row">		
				<input id="js-file" type="file" name="file[]" multiple>
			</div>
									
										
									</div><div class="col-md-11 send_wraper_inpt">				
											
											'.$t->Input(	array(	'type'			=> 'text',
																	'name'			=> 'message-text',
																	'class'			=> 'form-control input-message',
																	//'value'			=> $in['value'],
																	'placeholder'	=> 'Введите текст'											
													)
											).'	
											
											
											
											<div class="btn_area reply_message" data-status="'.$m['status'].'" data-theme="'.$theme.'" data-mid="'.$mid.'">Ответить  → </div>	
										
								</div>
								<br />
											<div class="img-list" id="js-file-list"></div>
											
								
								</div>';

			
				$code .= '

					<section class="message" id="message">
						<div class="container">
				
							'.$t->NavTabsMessagesFolders(array('views'=>$views)).'
							<div class="after-head m-0">'.$headData.'</div>
							<div class="message-wrapper">
								
									'.$trM.'
									<div id="div_limit"></div>							
									<div id="div_scrol"></div>
									
								<br />
								'.$replyMessage.'																
							</div>

						</div>
					</section>
					<script>
						$(function(){						

						});
					</script>
					';
			} else {
				$code .= '<section class="message" id="message">
						<div class="container">
							Нет доступа
						</div></section>
						<!--переходит в главный раздел, если нет доступа-->
						<script>
						setTimeout(function() {
						  window.location.href = "/chat/messages/";
						}, 1000);
						</script>
						
						';				
			} 
		
		} else { //вывод папок
		
			$code .= '

				<section class="message" id="message">
					<div class="container">
			
						'.$t->NavTabsMessagesFolders(array('views'=>$views)).'
					
					
						<div class="message-wrapper">
								'.$tr.'
								
								<div id="div_limit"></div>							
								<div id="div_scrol"></div>
						</div>

					</div>
				</section>
				<script>
					$(function(){
						
						var inProgress = false;
						var start = 25;
						
						$(window).scroll(function() {
							if ( ( ( $(window).scrollTop() + $(window).height() ) >= ( $(document).height()*0.8 - 200 ) ) && !inProgress) {
								data =  {
										"flag" 				: "chat",
										"start_limit"		: start,
										"views"				: "'.$views.'",
										"value"				: "'.$value.'"
									}
									console.log(data)
								$.ajax({
									url: "/scroll_page",
									method: "POST",
									data: {
										"flag" 				: "chat",
										"start_limit"		: start,
										"views"				: "'.$views.'",
										"value"				: "'.$value.'"
									},
									beforeSend: function() {
										inProgress = true;
									}
								}).done(function(data){
									if (data.ok){
										$("#div_limit").before(data.code);
										inProgress = false;
										start = start + 25;
									}
								});
								
							}
						});
					});
				</script>
					';
		}	
			
?>