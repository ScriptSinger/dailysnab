<?php
	$row 			= $member['admin_etp_cities']['row'];
	
	

	$tr = '';
	foreach($row as $i => $m){
		$tr .= '	<div style="border-radius:10px 10px;box-shadow: 0px 2px 5px 5px #ccc;margin:10px 0px;padding:10px;">
					<div>'.$m['cities_name'].'</div>
					<div style="color:#ccc;">'.$m['title'].'</div>
					<button class="modal_admin_etp_cities" data-id="'.$m['id'].'">
						<img src="/image/status-edit.svg" alt="" class="status-request">
					</button>
				</div>
				';
	}

	
	$code .= '				
				<div class="container">
				
						'.$t->NavTabsAdminEtp(array('flag'=>'cities')).'
						
						<div>
							'.$e->Input(	array(	'type'			=> 'button',
													'class'			=> 'profile-btn request-btn modal_admin_etp_cities',
													'value'			=> 'Создать привязку'
											)
									).'
						</div>
						
						'.$tr.'
						
				</div>

			';

			
			
			
?>