<?php
	$flag 		= $member['registration_activate']['flag'];

	if($flag==1){
		$podpis = 'Активация не возможна';
	}elseif($flag==2){
		$podpis = 'Активация не возможна, возможно ссылка устарела';
	}
	


	$code .= '
				<h3 class="text-center">'.$podpis.'</h3>
			';

			
			
			
?>