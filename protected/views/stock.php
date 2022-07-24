<?php
	//$row 			= $member['stock']['row'];
	$stock_id 		= $member['stock']['stock_id'];
	$status_buy_sell_id	= $member['stock']['status_buy_sell_id'];
	$value 			= $member['stock']['value'];
	
	
	$tr = $t->NextTrPageStock(array(	'start_limit' 		=> 0,
									'stock_id' 			=> $stock_id,
									'status_buy_sell_id'=> $status_buy_sell_id,
									'value'				=> $value ));

	

	$code .= '
			<section class="subs" id="subs">
				<div class="container">

					'.$e->Input(array(	'type'			=> 'button',
										'class'			=> 'request-btn modal_buy_sell',
										'value'			=> '+ Добавить товар',
										'data'			=> array('flag_buy_sell'=>5)
									)
								).'

					'.$t->NavTabsStock(array( 	'stock_id'				=> $stock_id,
												'status_buy_sell_id' 	=> $status_buy_sell_id )).'
					
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
			        if ( ( ( $(window).scrollTop() + $(window).height() ) >= ( $(document).height()*0.8 - 200 ) ) && !inProgress) {
						
			            $.ajax({
			                url: "/scroll_page",
			                method: "POST",
			                data: {
			                    "flag" 				: "stock",
								"start_limit"		: start,
								"stock_id"			: "'.$stock_id.'",
								"status_buy_sell_id": "'.$status_buy_sell_id.'",
								"value"				: "'.$value.'"
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
		</script>
			';

	

	
			
			
?>