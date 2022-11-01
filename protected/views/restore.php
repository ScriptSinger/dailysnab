<?php
	//$row 		= $member['restore']['restore'];
	
	$code .= '
		<div class="div_restore">
			<div class="page-header">
				<h2>Восстановление доступа</h2>
			</div>
			<p>Введите адрес электронной почты, который был указан при регистрации.</p>
			<form id="restore-form" class="" role="form">
				<div class="form-group">
					'.$e->Input(	array(	
											'type'			=> 'text',
											'id'			=> 'email',
											'class'			=> 'form-control',
											'placeholder'	=> 'Электронная Почта'
										)
								).'
				</div>
				<div class="form-group">
					'.$e->Input(	array(	
											'type'			=> 'submit',
											'class'			=> 'btn btn-primary btn-block',
											'value'			=> 'Сбросить текущий пароль'
										)
								).'
				</div>
			</form>
		</div>
			
			
			';

			
			
			
?>