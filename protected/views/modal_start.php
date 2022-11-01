<?php
	$flag 	= $member['modal_start']['flag'];

	if($flag=='modal_start_welcome'){
		$code .= '
				<script>
						$(window).on("load",function(){
							createModalCompany();
						});
				</script>
			';
	}elseif($flag=='modal_qrq_search'){
		$code .= '
				<script>
						$(window).on("load",function(){
							getModalQrqSearch();
						});
				</script>
			';
	}elseif($flag=='modal_service_bind1c'){
		$code .= '
				<script>
						$(window).on("load",function(){
							ModalServiceBind1C();
						});
				</script>
			';
	}
	
	

			
			
			
?>