<?php
	$row 		= $member['nomenclature']['row'];
	$value 		= $member['nomenclature']['value'];


	$tr = '';
	foreach($row as $i => $m){
		
			$tr .= $t->TrPageNomenclature(array( 'm'=>$m ));

	}
	
	

	

	$code .= '
			<section class="subs" id="subs">
				<div class="container">

					'.$e->Input(array(	'type'			=> 'button',
										'class'			=> 'request-btn modal_nomenclature',
										'value'			=> 'Добавить номенклатуру'
									)
								).'

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
			                    "flag" 				: "nomenclature",
								"start_limit"		: start,
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