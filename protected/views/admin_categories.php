<?php
	//$row 		= $member['admin_categories']['row'];

	
	$arr_attribute = array();
	$th = '';
	/*// рабочие, тормозит надо на AJAX при переходе по уровням
	$row = reqSlovAttribute(array('parent_id'=>0));
	foreach($row as $i => $m){
		$arr_attribute[ $m['id'] ] = $m['attribute'];
		$cl_span = ($m['active']==2)? 'text-muted' : '';
		$th .= '<th>
					<span class="'.$cl_span.' sp_a modal_admin_attribute" title="Редактировать"
														data-toggle="tooltip" 
														data-placement="bottom"
														data-id="'.$m['id'].'">'.$m['attribute'].'</span>
				</th>
		';
	}
	*/
	
	
	$tr = $t->TableTrAdminCategories(array('parent_id'=>0,'level'=>0,'arr_attribute'=>$arr_attribute));
	
	$code .= '		
				<div class="container">
		            <div class="admin-head-panel">

                        <h3>Категории</h3>
                    
                        <button class="filter">Фильтр</button>
                    
                        '.$e->Input(array(	'type'	=> 'button',
                                'class'	=> 'btn btn-add-cat modal_admin_categories btn-add',
                                'value'	=> 'Создать',
                                'data' => 'data-toggle="modal" data-target="#exampleModal"'
                            )
                        ).'
                                        
                    </div>		
					
					<table id="table-admin_categories" class="table" border="0" cellspacing="0" cellpadding="0">
						<thead>
							<th></th>
							'.$th.'
						</thead>
						<tbody>
							'.$tr.'
						</tbody>
					</table>
                </div>		
			';

			
			
			
?>