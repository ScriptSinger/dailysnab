<?php
	$active_md5	= $member['restore_password']['active_md5'];
	$email 		= $member['restore_password']['email'];

	if(LOGIN_ID){
		$code .= '
				<div class="bs-callout bs-callout-info">
					<h4>Вы Авторизованы как <b>'.$email.'</b></h4>
					<p>Для восстановления доступа надо <a href="#" class="exit bold" data-redirect="'.$_SERVER['REQUEST_URI'].'">выйти</a> из данной учетной записи</p>
				</div>
				';
	}else{
		$arr = $f->FormChangePass(array('active_md5'=>$active_md5));
		$code .= '
			<div class="container div_restore">
				<div class="page-header">
					<h2>Восстановление доступа</h2>
				</div>
				<p>Введите новый пароль для входа на сайт.</p>
				<form id="change-pass-form" class="" role="form">
					'.$arr['content'].'
					'.$arr['bottom'].'
				</form>
			</div>
			
			
		<script>
			ChangePass();
		</script>
			';
	}

			
			
			
?>