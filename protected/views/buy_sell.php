
<?php
	$flag_buy_sell 		= $member['buy_sell']['flag_buy_sell'];
	$status_buy_sell_id 	= $member['buy_sell']['status_buy_sell_id'];
	$row_buy_sell 		= $member['buy_sell']['row_buy_sell'];
	$categories_id 		= $member['buy_sell']['categories_id'];
	$cities_id 			= $member['buy_sell']['cities_id'];
	$value 				= $member['buy_sell']['value'];
	$flag_interests_invite 	= $member['buy_sell']['flag_interests_invite'];
	$group 				= $member['buy_sell']['group'];

	$tr = '';
	
	
	
	if($flag_buy_sell==1){ // О Б Ъ Я В Л Е Н И Я
		
		foreach($row_buy_sell as $i => $m){

				$tr .= $t->TrMySellCache(array('m'=>$m));
				
		}
		
	}
	elseif($flag_buy_sell==2){// З А Я В К И
			
		foreach($row_buy_sell as $i => $m){


				/*
				if($flag_buy_sell==2){
				*/
					$tr .= $t->TrMyBuyCache(array('m'=>$m , 'group'=>$group ));
					
				/*	
				}else{
				
					$tr .= $t->TrMyBuy(array('m'=>$m));
				
				}
				*/

		}
	}
	
	

	

	$code .= '
									
			<div class="clearfix"></div>
			
			<section class="request" id="request">
				<div class="container">
			
					'.$t->NavTabsBuySell(array(	'flag_buy_sell'			=> $flag_buy_sell,
												'status_buy_sell_id'	=> $status_buy_sell_id,
												'flag_interests_invite'	=> $flag_interests_invite )).'
					
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
                    "flag" 				: "buy_sell",
					"flag_buy_sell"		: "'.$flag_buy_sell.'",
					"status"			: "'.$status_buy_sell_id.'",
					"start_limit"		: start,
					"categories_id"		: "'.$categories_id.'",
					"cities_id"			: "'.$cities_id.'",
					"value"				: "'.htmlspecialchars($value).'",
					"group"				: "'.$group.'",
					"type"				: $("#share_buy_sell_1").data().change
                },
                beforeSend: function() {
                    inProgress = true;
                }
            }).done(function(data){
                if (data.ok){
                    $("#div_limit").before(data.code);
                    inProgress = false;
					start = start + 10;
					$(".dropdown-toggle").dropdown();
					window.requestSliderWrapper();
					if($("#share_buy_sell_1").data().change==2){
						$(".checkbox_share").fadeIn(0);
						if($("#checkbox_checking_buysell").data().flag==2){
							$("#checkbox_checking_buysell").click();
						}
					}
                }
            });
			
        }
    });
	
	
	$(".delete_html_teg").each(function(indx, element){
			$(element).remove();
	});
	
});
</script>
			

			';
	
			
?>