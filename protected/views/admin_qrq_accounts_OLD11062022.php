<?php
	$row 		= $member['admin_qrq_accounts']['row'];

	$tr = '';
	
	foreach($row as $i => $m){
			
			$tr .= '	<tr id="div_form_accountsadd'.$m['vendorid'].'">
						<td>
							'.$m['accounts_id'].'
						</td>
						<td>
							'.$m['company'].'
						</td>
						<td>
							'.$m['accounts_title'].'
						</td>
						<td>
							<span class="blue-button delete_amo_accounts" data-id="'.$m['id'].'" 
																		data-id_v="'.$m['vendorid'].'" 
																		data-name="'.$m['accounts_title'].'"
																		data-company_id="'.$m['company_id'].'">удалить</span>
						</td>
					</tr>';
	}
	
	
	$code .= '	
		
				<div class="container">

					'.$t->NavTabsAdminAmo(array('flag'=>'accounts')).'

					<h3>Аккаунты пользователей</h3>
					<table id="table-admin_qrq" class="table" border="0" cellspacing="0" cellpadding="0">
						<thead>
							<th>id</th>
							<th>Профиль</th>
							<th>Поставщик</th>
							<th></th>
						</thead>
						<tbody>
							'.$tr.'
						</tbody>
					</table>
					
                </div>		
			';

			
			
			
?>