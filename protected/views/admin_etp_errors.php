<?php
	$row 			= $member['admin_etp_errors']['row'];
	
	
	$tr = '';
	foreach($row as $i => $m){
		$next_etp = ($m['next_etp'])? '<code>Оформить/Пропустить</code>' : '';
		$tr .= '	<div style="border-radius:10px 10px;box-shadow: 0px 2px 5px 5px #ccc;margin:10px 0px;padding:10px;">
					<div><span class="" style="font-weight:bold;">'.$m['name_error'].'</span></div>
					<div>'.$next_etp.'</div>
					<button class="modal_admin_etp_errors" data-id="'.$m['id'].'">
						<img src="/image/status-edit.svg" alt="" class="status-request">
					</button>
					<div style="float:right;"><span class="delete_admin_etp_errors" data-name="'.$m['name_error'].'" data-id="'.$m['id'].'">Удалить</span></div>
				</div>
				';
	}
	
	$code .= '				
				<div class="container">
				
						'.$t->NavTabsAdminEtp(array('flag'=>'errors')).'
						
						
						<div>
							'.$e->Input(	array(	'type'			=> 'button',
													'class'			=> 'profile-btn request-btn modal_admin_etp_errors',
													'value'			=> 'Создать обработку ошибки'
											)
									).'
						</div>
						
						
						'.$tr.'
						
				</div>

			';

			
			
			
?>