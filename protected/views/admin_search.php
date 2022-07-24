<?php
	$row 			= $member['admin_search']['row'];
	$flag 			= $member['admin_search']['flag'];
	$page 			= $member['admin_search']['page'];
	$count_page 		= $member['admin_search']['count_page'];
	$kol 			= $member['admin_search']['kol'];


	//блок пагинации
		$pagination = $g->pagination($kol,$count_page,10,$page,'admin_search/'.$flag.'?page={#}');
		$pagination = '<div style="margin:10px 0px;">'.$pagination.'</div>';
	///



	if($flag==1){

		$zagolovoc = 'Поисковые запросы';
		
		$tr = '';
		
		foreach($row as $i => $m){
			$button = '';
			
			/*$r = reqSearchRequestAdminSearch(array(	'flag_pole'		=> $m['flag_pole'],
													'categories_id'	=> $m['categories_id'],
													'value'			=> $m['name'] ));
			if(empty($r)){*/
					$button = $e->Input(	array(	'type'			=> 'button',
												'class'			=> 'btn btn-sm btn-primary add_admin_search',
												'value'			=> 'Создать',
												'data'			=> array( 	'text' 				=> $m['name'],
																			'flag' 				=> $m['flag_pole'],
																			'categories_id'		=> $m['categories_id'],
																			'value' 			=> $m['name'] )
											)
									);
			/*}else{
					$button = '<span class="text-success" data-feather="check" stroke-width="3" size="36"></span>';				
			}*/
			
			$tr .= '	<tr>
						<td>'.$m['name'].'</td>
						<td>'.$m['pole'].'</td>
						<td>'.$m['categories'].'</td>
						<td>'.$m['kol'].'</td>
						<td>'.$m['nflag_buy_sell'].'</td>
						<td>'.$button.'</td>
					</tr>
			';
		}
		
		
		$code .= '	
					<div class="container">
						<h3 class="text-center">
							'.$zagolovoc.'
						</h3>
						
						'.$t->NavTabsAdminSearch(array('flag'=>$flag)).'
						
						'.$pagination.'
						<table id="table-admin_users" class="table table-bordered table-hover" border="0" cellspacing="0" cellpadding="0" style="margin-top:10px;">
							<thead>
								<th>Словосочетание</th>
								<th>Поле</th>
								<th>Категория</th>
								<th>Частота</th>
								<th>Тип</th>
								<th></th>
							</thead>
							<tbody>
								'.$tr.'
							</tbody>
						</table>
					</div>
				';

	}elseif($flag==2){
		

			$tr = '';
			foreach($row as $i => $m){
				
					$tr .= $t->TrPageSearchCategories(array( 'm'=>$m ));

			}
			
	$code .= '
			<section class="subs" id="subs">
				<div class="container">
						
					<h3 class="text-center">
							Категории
					</h3>

					<div class="float-right">
						'.$e->Input(array(	'type'	=> 'button',
											'class'	=> 'btn btn-info btn-sm modal_search_categories',
											'value'	=> 'Создать'
									)
							).'
					</div>
					
					'.$t->NavTabsAdminSearch(array('flag'=>$flag)).'

					<div class="subs-wrapper">
					
							'.$tr.'
							
							<div id="div_limit"></div>
					
							<div id="div_scrol"></div>
							
					</div>

				</div>
			</section>
			
		<script>
			$(function(){
				
				var inProgress = false;
				var start = 25;
			    $(window).scroll(function() {
			        if ( ( ( $(window).scrollTop() + $(window).height() ) >= ( $(document).height()*0.8 - 200 ) ) && !inProgress) {
						
			            $.ajax({
			                url: "/scroll_page",
			                method: "POST",
			                data: {
			                    "flag" 				: "search_categories",
								"start_limit"		: start
			                },
			                beforeSend: function() {
			                    inProgress = true;
			                }
			            }).done(function(data){
			                if (data.ok){
			                    $("#div_limit").before(data.code);
			                    inProgress = false;
								start = start + 25;
			                }
			            });
						
			        }
			    });
			});
		</script>
			';
			/*
			$code .= '	<div class="container">
							<h3 class="text-center">
								'.$zagolovoc.'
							</h3>
							
							<div class="float-right">
								'.$e->Input(array(	'type'	=> 'button',
													'class'	=> 'btn btn-info btn-sm modal_search_categories',
													'value'	=> 'Создать'
											)
									).'
							</div>
							
							'.$t->NavTabsAdminSearch(array('flag'=>$flag)).'
							
							'.$pagination.'
							<table id="table-admin_users" class="table table-bordered table-hover" border="0" cellspacing="0" cellpadding="0" style="margin-top:10px;">
								<thead>
									<th>Словосочетание</th>
									<th>Поле</th>
									<th>Категория</th>
									<th></th>
								</thead>
								<tbody>
									'.$tr.'
								</tbody>
							</table>
						</div>
					';
			*/
	}
				
			
			
?>