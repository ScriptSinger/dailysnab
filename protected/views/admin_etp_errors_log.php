<?php
	$row 			= $member['admin_etp_errors_log']['row'];
	
	
	$tr = '';
	foreach($row as $i => $m){
		$tr .= '	<div style="border-radius:10px 10px;box-shadow: 0px 2px 5px 5px #ccc;margin:10px 0px;padding:10px;">
					<div><span class="" style="font-weight:bold;">Текст ошибки:</span></div>
					<div>'.$m['errors_message'].'</div>
					<div>
						<code>
							Код ошибки: <span class="" style="font-weight:bold;">'.$m['errors_code'].'</span>, 
							Количество ошибок: <span class="" style="font-weight:bold;">'.$m['kol'].'</span>
						</code>
					</div>
				</div>
				';
	}
	
	$code .= '				
				<div class="container">
				
						'.$t->NavTabsAdminEtp(array('flag'=>'errors_log')).'
						
						'.$tr.'
						
				</div>

			';

			
			
			
?>