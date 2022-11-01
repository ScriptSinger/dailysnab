<?php
	$row 			= $member['company_profile']['row'];
	$company 		= $member['company_profile']['row_company'];
	$company_id		= $member['company_profile']['company_id'];
	$flag_buy_sell		= $member['company_profile']['flag_buy_sell'];
	$row_1c_company	= $member['company_profile']['row_1c_company'];
	$my_company = $company_id == COMPANY_ID;

	$tr = $li_active1 = $li_active2 = '';
	
	if($flag_buy_sell==1){	// ОБЪЯВЛЕНИЯ
		
			$li_active1 = 'active';
			
			foreach($row as $i => $m){
			
					$tr .= $t->TrPageSell(array('row'=>$m,'where'=>'company_profile'));
			
			}			
		
	}else{				// ЗАЯВКИ
		
			$li_active2 = 'active';
		
			foreach($row as $i => $m){
			
					$tr .= $t->TrPageBuy(array('m'=>$m,'where'=>'company_profile'));
			
			}
			
	}


	$rrr = reqCompanyCategories(array('flag'=>'group_categories','company_id'=>$company_id));

	$kod_phone = ($company['iti_phone']=='ru')? '+7' : '';
	
	
	$code_1c_company_id = '';
	if(COMPANY_ID){
		$code_1c_company_id = '	<div id="div_1c_company_company" style="width:400px;">
										'.$e->Select1cCompanyCompany(array('1c_company_id'=>$row_1c_company['1c_company_id'],'company_id_to'=>$company_id)).'
								</div>';
	}
	$code_subscribe = '';
	if(!$my_company) {
		$code_subscribe = '<div id="div_subscriptions">
						'.$e->ButtonSubscriptions(array('flag'=>$company['flag_subscriptions'],'company_id_out'=>$company_id )).'
					</div>';
	}
	
	$code .= '

			
			<section class="request" id="request">
				<div class="container">
				
					<img src="'.$company['avatar'].'" id="" alt="" class="rounded-circle img_avatar" width="200" height="200">
					<br/>
					'.$company['legal_entity'].' '.$company['company'].'
					<br/>
					'.$kod_phone.$company['phone'].'
					<br/>
					'.$company['cities_name'].'
					<br/>
					'.$company['comments'].'
					<br/>
					'.$rrr['categories'].'
					<br/>
					'.$code_subscribe . $code_1c_company_id.'
				
					<ul class="request-menu">
						<li class="request-menu-item">
							<button>
								<a href="/company-profile/'.$company_id.'/2" class="'.$li_active2.'">
									Заявки
								</a>
							</button>
						</li>
						<li class="request-menu-item">
							<button>
								<a href="/company-profile/'.$company_id.'/1" class="'.$li_active1.'">
									Объявления
								</a>
							</button>
						</li>
					</ul>
					
					'.$tr.'
					
					<div id="div_limit"></div>
					
					<div id="div_scrol"></div>
	
				</div>
			</section>
			
<script>
$(function(){
	
	var inProgress = false;
	var start = 10;
    $(window).scroll(function() {
		//$("#div_scrol").html( "$(window).scrollTop() = "+$(window).scrollTop() );

        if ( ( ( $(window).scrollTop() + $(window).height() ) >= ( $(document).height()*0.8 - 200 ) ) && !inProgress) {
			
            $.ajax({
                url: "/scroll_page",
                method: "POST",
                data: {
                    "flag" 				: "pagebuy",
					"start_limit"		: start,
					"company_id"		: "'.$company_id.'",
					"where"				: "company_profile"
                },
                beforeSend: function() {
                    inProgress = true;
                }
            }).done(function(data){
                if (data.ok){
                    $("#div_limit").before(data.code);
                    inProgress = false;
					start = start + 10;
                }
            });
			
        }
    });
});


	$( ".select2" ).each(function( index ) {
			$(this).select2({
					placeholder: function(){
						$(this).data("placeholder");
					}
			});
	});


</script>
			
			
			';
?>
