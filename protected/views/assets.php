<?php
	$row 			= $member['assets']['row'];
	$status_buy_sell_id	= $member['assets']['status_buy_sell_id'];


	$tr = '';
	foreach($row as $i => $m){
		
			$tr .= $t->TrMySell(array( 'm'=>$m ));

	}
	
	

	

	$code .= '
			<section class="subs" id="subs">
				<div class="container">

						'.$e->Input(array(	'type'			=> 'button',
											'class'			=> 'request-btn modal_buy_sell',
											'value'			=> 'Добавить актив',
											'data'			=> array('flag_buy_sell'=>4)
										)
									).'


						'.$t->NavTabsAssets(array( 'status_buy_sell_id'	=> $status_buy_sell_id )).'
					
							'.$tr.'
							
							<div id="div_limit"></div>
					
							<div id="div_scrol"></div>


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
			                    "flag" 				: "assets",
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

	

	
			
			
?>