<?php
	$row 		= $member['subscriptions_profile_buy_sell']['row'];
	$views 		= $member['subscriptions_profile_buy_sell']['views'];
	$value 		= $member['subscriptions_profile_buy_sell']['value'];

	//echo '<pre>';
	//var_dump($member['subscriptions_profile_buy_sell']);
	
	$tr = '';
	foreach($row as $i => $m){

			$tr .= $t->TrPageSubscrProfile(array( 'm'=>$m , 'views'=>$views ));

	}


	$code .= '
	
		<section class="subs" id="subs">
			<div class="container">
	
				'.$t->NavTabsSubscriptions(array('views'=>$views)).'
			
			
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
			                    "flag" 				: "subscr_profile",
								"start_limit"		: start,
								"views"				: "'.$views.'",
								"value"				: "'.$value.'"
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