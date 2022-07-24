<?php
	$row = $member['admin_attribute_users']['row'];
	

	echo mb_strtolower('Пользователь');

	$tr = '';
	foreach($row as $i => $m){
		$flag_insert = '';
		if($m['flag_insert']==2){
			$flag_insert = 'qrq';
		}elseif($m['flag_insert']==3){
			$flag_insert = 'Пользователь';
		}
		$tr .= '	<tr>
					<td>'.$m['attribute'].'</td>
					<td>'.$m['attribute_value'].'</td>
					<td>'.$flag_insert.'</td>
				</tr>
		';
	}
	
	
	$code .= '				
					
					<h3 class="text-center">
							Значения Полей (пользователей, qrq)
					</h3>
					
					
					<table id="table-admin_users" class="table table-bordered" border="0" cellspacing="0" cellpadding="0" style="margin-top:10px;">
						<thead>
							<th>Поле</th>
							<th>Значение</th>
							<th>Кто внес</th>
						</thead>
						<tbody>
							'.$tr.'
						</tbody>
					</table>

			';

			
			
			
?>