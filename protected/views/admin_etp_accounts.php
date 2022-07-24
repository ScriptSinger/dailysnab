<?php
	$row 			= $member['admin_etp_accounts']['row'];
	
	
/*
	$tr = '';
	foreach($row as $i => $m){
		$tr .= '	<tr>
					<td>'.$m['dmy_data_insert'].'</td>
					<td><img src="/images/profile.png" alt="" class="rounded" height="50"/></td>
					<td>'.$m['company'].' '.$count_company.'</td>
					<td><button class="change-btn admin_pro_mode" data-id="'.$m['id'].'">'.$pro_mode.'</button></td>
				</tr>
		';
	}
*/	
	
	$code .= '				
				<div class="container">
				
						'.$t->NavTabsAdminEtp(array('flag'=>'accounts')).'
						
						
				</div>

			';

			
			
			
?>