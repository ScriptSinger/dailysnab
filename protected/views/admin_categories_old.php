<?php
//$row 		= $member['admin_categories']['row'];


$arr_attribute = array();
$th = '';
$row = reqSlovAttribute(array('parent_id'=>0));
foreach($row as $i => $m){
    $arr_attribute[ $m['id'] ] = $m['attribute'];
    $cl_span = ($m['active']==2)? 'text-muted' : '';
    $th .= '<th>
					<span class="'.$cl_span.' sp_a modal_admin_attribute" title="Редактировать"
														data-toggle="tooltip" 
														data-placement="bottom"
														data-id="'.$m['id'].'">'.$m['attribute'].'</span>
					'.$e->Input(	array(	'type'			=> 'text',
                'id'			=> 'sort'.$m['id'],
                'class'			=> 'form-control form-control-sm float-right text-center change_sort',
                'value'			=> $m['sort'],
                'placeholder'	=> '',
                'dopol'			=> 'style="width:50px;"',
                'data'			=> array('table'=>'categories_attribute','id'=>$m['id'])
            )
        ).'
				</th>
		';
}



$tr = $t->TableTrAdminCategories(array('parent_id'=>0,'level'=>0,'arr_attribute'=>$arr_attribute));

$code .= '				
					
					<h3 class="text-center">Категории</h3>
					
					<div >
						'.$e->Input(array(	'type'	=> 'button',
            'class'	=> 'btn btn-info btn-sm modal_admin_categories',
            'value'	=> 'Добавить категорию 1'
        )
    ).'
						'.$e->Input(array(	'type'	=> 'button',
            'class'	=> 'btn btn-info btn-sm modal_admin_attribute',
            'value'	=> 'Добавить поле'
        )
    ).'
					</div>
					
					<table id="table-admin_categories" class="table table-bordered" border="0" cellspacing="0" cellpadding="0" style="margin-top:10px;">
						<thead>
							<th>Категория1 Категория2 Категория3 Категория4</th>
							'.$th.'
						</thead>
						<tbody>
							'.$tr.'
						</tbody>
					</table>

			';




?>