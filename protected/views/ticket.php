<?php
	$views 	= !empty($member['ticket']['views'])?$member['ticket']['views']:'';
	$rowt 	= !empty($member['ticket']['rowt'])?$member['ticket']['rowt']:'';
	$rtcro  = !empty($member['ticket']['rtcro'])?$member['ticket']['rtcro']:'';

	$tid 	= !empty($member['ticket']['tid'])?$member['ticket']['tid']:'';
	$kol 	= !empty($member['ticket']['kol'])?$member['ticket']['kol']:'';

 	$tr 	= $trM = $replyMessage = $headData = $need_link = $navPanel = $tfo = $select_wraper_tfo = $img_file = $vazhnost = $ticket_attach = '';
	$attach_no_class = 'col-7';

	$rowtAll = reqTicketMessages();


	// условия вывода тикетов
	if($views == 'active' && empty($rowtAll)){
		include 'protected/views/faq.php';
	} else {
		$navPanel = $t->NavTabsTicketsFolders(array('views'=>$views, 'kol'=>$kol));
	}

/*
vecho($rowt);
vecho(LOGIN_ID);
vecho(COMPANY_ID);
echo '<pre>';
			vecho($rtcro);
echo '</pre>';
*/
	if(!empty($rowt)){

			$admins = reqTicketAdmins();
			$adminsArr = explode(",", $admins['admins']);

		//вывод опции выбора разрешения роли пользователя для select для разных вариантов

			if(!empty($rtcro)){
				foreach($rtcro as $i => $r){
					$tfo .= '<option value="'.$r['status_2'].'">'.$r['status_name_out'].'</option>';
				}



			} else {

				if(COMPANY_ID>0) {

					$ticket_flag = $rowt[0]["ticket_flag"];

					//var_dump($ticket_flag);

						if (!in_array(LOGIN_ID, $adminsArr)) {

							if ($ticket_flag == 1) {
									$tfo = '<option value="2">В предложения</option>';

								} else if (($ticket_flag == 2)) {
									$tfo = '<option value="1">В ошибки</option>';
								} else {
									$tfo = '';
								}

						}

					}

			}

		foreach($rowt as $i => $t){

			switch ($t["vazh"]) {
				case 1:
					$vazhnost = '<span class="badge badge-danger">Важно</span>';
					break;
				case 2:
					$vazhnost = '<span class="badge bg-success">Средняя</span>';
					break;
				case 3:
					$vazhnost = '<span class="badge badge-secondary">Не важно</span>';
					break;
			}
			//vecho($t);
			$rtf = reqTicketsFiles(array('ticket_id'=>$t["id"]));

		//	vecho(search($rtf, 0, 'video'));

			if(!empty($rtf[0])) {
                
                //echo $rtf[0]['file_name'];
                $typeFile = explode(".", $rtf[0]['file_name']);
                //vecho($typeFile);
                if (substr($rtf[0]['file_name'], 0, 5) == 'video') {
                    //echo 'еесть!';
                    $ticket_attach = '<div class="subs-img col-2"><img src="/image/thumbs-video.png" alt="" class="img-fluid"></div>';
                    $attach_no_class = 'col-7';
                } elseif($typeFile[1] == 'png' ||$typeFile[1] == 'jpg') {
                    $ticket_attach = '<div class="subs-img col-2"><img src="/files/tickets/' . $t['owner_id'] . '/img/' . $rtf[0]['file_name'] . '" alt="" class="img-fluid"></div>';
                    $attach_no_class = 'col-7';
                }

			}
            else {
                $ticket_attach = '';
                $attach_no_class = '';
            }



			$ticket_text = !empty($t["ticket_exp"])?$t["ticket_exp"]:'';
			$name_company = !empty($t["company"])?$t["company"]:'';

			$ticket_inv = !empty($t["inv"])?$t["inv"]:'';
				//$img_file = __DIR__ ."\\files\\tickets\\".$t['owner_id']."\img\\".$rtf[0]['file_name'];


			//$ticket_attach = !empty($rtf[0])? '<div class="subs-img col-2"><img src="'. __DIR__ ."\\files\\tickets\\".$t['owner_id']."\img\\".$rtf[0]['file_name'].'" alt="" class="img-fluid"></div>' :'';
			//$ticket_attach = !empty($rtf[0])? '<div class="subs-img col-2"><img src="'. __DIR__ ."\\files\\tickets\\".$t['owner_id']."\img\\".$rtf[0]['file_name'].'" alt="" class="img-fluid"></div>' :'';

			//$attach_no_class = !empty($rtf[0])? 'col-7' :'col-9';


			$ticket_flag = $t["ticket_flag"];
			$tecket = ($t['mail'] != '')?$t['mail'] : $t['tel'];
			if (($ticket_flag == 1 || $ticket_flag == 2) && !in_array(LOGIN_ID, $adminsArr) && COMPANY_ID>0) {

				$select_wraper_tfo = '
							<div class="form-group">
								<select name="ticket_flag" class="form-control select_'.$t["id"].'">
									'.$tfo.'									
								</select>	
								<button type="button" data-bid="'.$t["id"].'" class="button-blue change_ticket">Применить</button>
							</div>';

				} else {



				$select_wraper_tfo = (!empty($rtcro)) ? '
							<div class="form-group">
								<select name="ticket_flag" class="form-control select_'.$t["id"].'">
									'.$tfo.'									
								</select>	
								<button type="button" data-bid="'.$t["id"].'" class="button-blue change_ticket">Применить</button>
							</div>' : '';

				}

			$tr .= '<div class="subs-item row si_'.$t["id"].'">
						
							 '.$ticket_attach.'							
						
						<div class="subs-info '.$attach_no_class.'">							 
							<div class="theme positionTickets"><a href="/ticket/?tid='.$t["id"].'">'.$ticket_text.'</a></div>
							<div class="autor">'.$tecket.'</div>
							
							<br />
							<div class="status">'.$vazhnost.'</div><div class="links"> <small>'.$ticket_inv.'</small></div>
						</div>

						<div class="subs-place col-3 text-center">								
							<div class="ticket_flag">'.$t["status_name"].'</div>
							<span class="small">'.$t["data_insert"].'</span>
										<div class="status-bar" style="opacity:0.9;">
											<button class="status-bar__convert">
												<img src="/image/status-mail.png" alt="Отправить сообщение (Тикеты)" class="status-request write_message_need" 
													data-need="30" 
													data-company="'.COMPANY_ID.'" 
													data-id="'.$t["id"].'" 
													data-url="/ticket/'.$t["id"].'">
												<span class="bttip" style="display: none;">Нажмите, чтобы отправить сообщение</span>
											</button>
										</div>
										'.$select_wraper_tfo.'
								   
								
						</div>							
					</div>
			';


		}


		/* ------- Вывод внутрянки тикета --------------- */


	if($tid){
		$sl = $sl_thumbs = $sl_video ='';
		$rtf = reqTicketsFiles(array('ticket_id'=>$t["id"]));

		$i = 1;



		/*
			https://bbbootstrap.com/snippets/carousel-slider-thumbnails-25493000
		   	https://mdbootstrap.com/docs/standard/extended/video-carousel/
		*/

		foreach($rtf as $key){
			$active = ($i == 1) ? ' class="active" aria-current="true" ' : '';
			$active2 = ($i == 1) ? ' active ' : '';

//			//$sl .= '<div class="carousel-item '.$active2.'"> <img src="/files/tickets/1585/'.$p['file_name'].'" alt=""> </div>';
            $source = explode(".", $key['file_name']);

            if($source[1] == 'png' || $source[1] == 'jpg'){
                $sl_video .= '<div class="carousel-item '.$active2.'"><div class="carousel-item active"> <img class="d-block w-100" src="/files/tickets/'. $t['owner_id'] .'/img/'.$key['file_name'].'" alt="First slide"> </div></div>';

            }else {
                $sl_video .= '<div class="carousel-item ' . $active2 . '"> <video class="img-fluid" autoplay loop><source src="/files/tickets/' . $t['owner_id'] . '/video/' . $key['file_name'] . '" type="video/mp4"> </video> </div>';
            }
            if(count($rtf) > 1)
            	$sl_thumbs .= '<button type="button" data-mdb-target="#carouselVideo" data-mdb-slide-to="'.$i.'" '.$active.' aria-label="Slide '.$i.'"></button>';
			$i++;

		}

			$photoAndVideo = '';
			$buttonNextPrev = '';
			if(count($rtf) > 1){
				$buttonNextPrev = '<button  class="carousel-control-prev" type="button" data-mdb-target="#carouselVideo" data-mdb-slide="prev" >
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Назад</span>
			  </button>
			  <button lass="carousel-control-next" type="button" data-mdb-target="#carouselVideo" data-mdb-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Дальше</span>
			  </button>';
			}
			if(count($rtf) > 0){
				$photoAndVideo = '<div id="carouselVideo" class="carousel slide carousel-fade" data-mdb-ride="carousel">
			 
			  <div class="carousel-indicators">
				'.$sl_thumbs.'
			  </div>
			 
			  <div class="carousel-inner">
			  
			  '.$sl_video.'
			 
			  </div>
			 '.$sl_thumbs.'
			 
			</div>';
			}
				//var_dump($rowt[0]);
				// $tel = (!empty($rowt[0]['tel'])) ? $rowt[0]['tel'] : 'Отсутсвует';
				// $mail = (!empty($rowt[0]['mail'])) ? $rowt[0]['mail'] : 'Отсутсвует';
				$email = (!empty($rowt[0]['email'])) ? $rowt[0]['email'] : 'Отсутсвует';

		$tr = '<section class="product ticket">
				<div class="container">
					<div class="row">
						<div class="col">
							<div class="product-title">
								<p>Тикет № '.$tid.'</p>
							</div>
						</div>
					</div>
					<div class="row">
					<div class="col-9">
						<p style="word-wrap: break-word;">'.$rowt[0]['ticket_exp'].'</p>
					</div>
						
						<div class="col-3 product-info">
							
						
						
						<p> <a href="/company-profile/'.$rowt[0]['owner_id'].'" target="_blank">'.$rowt[0]['company'].'</a></p>
						
						<p>Логин: '.$еmail.'</p>
			
						</div>
						<div class="col-3 product-price-wrapper">
							
							<div class="product-price"> 
								<span></span>
							</div>
							<!--
								<div id="div_phone" class="product-phone">
									<p class="view_phone" data-id="" data-amount="">Показать телефон</p>
								</div>
							-->
							<!--<div class="other-info">
								
								<p class="product-name"><a href="/company-profile/'.$rowt[0]['owner_id'].'" target="_blank">'.$rowt[0]['owner_id'].'</a></p>
								<p class="product-location"></p>
							</div>
						  -->

							<!--
							<div id="div_note"><div class="text-left">
								Заметка 
								<img src="/image/status-edit.svg" alt="" class="status-request _edit_buy_sell_note" data-flag="1">
								<div id="div_note_view" class="text-muted font12"></div>
									<div id="div_note_edit" style="display:none;">
										<form id="form_note-form" class="bv-form" role="form" novalidate="novalidate">
											<button type="submit" class="bv-hidden-submit" style="display: none; width: 0px; height: 0px;"></button>
												<div class="form-group">										
													<textarea class="product-area" id="note" name="note" placeholder="Заметка" cols="30" rows="10"></textarea>
												</div>
												<div class="form-group">													
													<input type="submit" class="product-button change-btn" id="" name="" placeholder="" value="Сохранить" title="">
												</div>												
													<input type="hidden" class="" id="id" name="id" placeholder="" value="" title="">
													<input type="hidden" class="" id="buy_sell_id" name="buy_sell_id" placeholder="" value="2118737" title="">
											
										</form>
									</div>
								</div>
							</div>
							
							-->
							
						</div>
					</div>
					<div class="row">
					<div class="col-6 images-wrapper">
						
 
						'. $photoAndVideo .'
 




							
							
						</div>
					</div>
				</div>
			</section>';

		}


		/* ---------------------- */



	}

		//vecho($rtf);
		//vecho($rowt);
		//vecho($views);
		//die;

			$code .= '
				<section class="message" id="message">
					<div class="container">
			
						'.$navPanel.'
					
					
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
								
								$.ajax({
									url: "/scroll_page",
									method: "POST",
									data: {
										"flag" 				: "ticket",
										"start_limit"		: start,
										"views"				: "'.$views.'"
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




?>