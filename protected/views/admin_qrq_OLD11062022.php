<?php
	$row 		= $member['admin_qrq']['row'];
	$row_n 		= $member['admin_qrq']['row_n'];

	$tr = '';
	
	foreach($row as $i => $m){
		$tr .= '	<tr>
					<td>'.$m['id'].'</td>
					<td><span class="modal_admin_qrq" data-id="'.$m['id'].'" style="cursor:pointer;">'.$m['qrq'].'</span></td>
					<td>'.$m['vendorid'].'</td>
					<td>'.$m['company_id'].'</td>
				</tr>
		';
	}
	
	
	$tr_n = '';
	foreach($row_n as $i => $m){
		$tr_n .= '<tr class="table-danger">
					<td>'.$m['accounts_title'].'</td>
					<td>'.$m['vendorid'].'</td>
					<td>'.$m['accounts_ids'].'</td>
				</tr>
		';
	}
	
	
	$table_not = '';
	if($tr_n){
		$table_not = '<code style="font-size:22px;">Аккаунт амо добавлен, но нет в справочники Slov_qrq и соответственно не создан в company</code>
					<table id="table-admin_qrq_n" class="table" border="0" cellspacing="0" cellpadding="0">
						<thead class="thead-dark">
							<th>Наименование</th>
							<th>vendorid</th>
							<th>accounts_ids</th>
						</thead>
						<tbody>
							'.$tr_n.'
						</tbody>
					</table>';
	}
	
	
	$code .= '	
				<div class="container">
				
					'.$t->NavTabsAdminAmo(array('flag'=>'qrq')).'
				
		            <div class="admin-head-panel" style="margin-top:20px;">
                    
                        '.$e->Input(array(	'type'	=> 'button',
											'class'	=> 'btn btn-add-cat modal_admin_qrq btn-add',
											'value'	=> 'Создать'
                            )
                        ).'
                                        
                    </div>

					'.$table_not.'
					
					<h3>Поставщики AMO</h3>
					<table id="table-admin_qrq" class="table" border="0" cellspacing="0" cellpadding="0">
						<thead>
							<th>id</th>
							<th>Наименование</th>
							<th>vendorid</th>
							<th>company_id</th>
						</thead>
						<tbody>
							'.$tr.'
						</tbody>
					</table>
					
                </div>		
			';

			
			
			
?>