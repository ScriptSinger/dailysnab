<?php
	$row 			= $member['admin_etp']['row'];
	
	

	$tr = '';
	foreach($row as $i => $m){
		
		// получаем accounts_id (для дальнейшего удаления)
			$accounts_ids = '';
			$r = reqAmoAccountsEtp(array('company_id_qrq'=>$m['company_id']));
			foreach($r as $ii => $mm){
				$accounts_ids .= '<div >'.$mm['accounts_id'].' - '.$mm['company'].' <span class="delete_admin_etp_accounts_id"  	data-id="'.$mm['id'].'" 
																																data-accounts_id="'.$mm['accounts_id'].'" 
																																data-name="'.$mm['accounts_id'].' - '.$mm['company'].'" 
																																style="color:#999;">Удалить</span></div>';
			}
			$accounts_ids = ($accounts_ids)? '	<div style="float:right;width:100%;border:1px solid #e6e6e6;border-radius:5px 5px;padding:10px;">
												'.$accounts_ids.'
											</div>' : '';
		///
		$tr .= '	<div style="border-radius:10px 10px;box-shadow: 0px 2px 5px 5px #ccc;margin:10px 0px;padding:10px;">
					<table border="0">
						<tr>
							<td width="300px">
								<div>'.$m['legal_entity'].' '.$m['company'].'</div>
								<div style="color:#ccc;">'.$m['cities_name'].'</div>
								<button class="modal_admin_etp" data-id="'.$m['company_id'].'">
									<img src="/image/status-edit.svg" alt="" class="status-request">
								</button>
							</td>
							<td>
								'.$accounts_ids.'
							</td>
						</tr>
					</table>
					
				</div>
				';
	}

	
	$code .= '				
				<div class="container">
				
						'.$t->NavTabsAdminEtp(array('flag'=>'etp')).'
						
						
						<div>
							'.$e->Input(	array(	'type'			=> 'button',
													'class'			=> 'profile-btn request-btn modal_amo_vendors',
													'value'			=> 'VENDORID'
											)
									).'
						</div>
						
						
						'.$tr.'
						
						
				</div>

			';

			
			
			
?>