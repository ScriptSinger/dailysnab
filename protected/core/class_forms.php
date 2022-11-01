<?php
	/*
	 *  класс форм и элементов форм
	 */

class HtmlForms extends HtmlTemplate
{

	// Регистрация Модаль "Старт"
	function FormModalStartWelcome( $p=array() ){

		$top 	= '';

		$content = '
			<div class="modal-body__head">
				<div class="modal__title">Добро пожаловать</div>
				<img src="/image/quest-request-logo.svg" alt="Логотип">				
			</div>
			<div class="modal-body__content">
				<div class="reg-company sp_a modal_my_company">Зарегистрировать компанию</div>
			</div>
			<div class="modal-body__footer">
				<button type="button" class="button-blue" data-dismiss="modal">Старт</button>
			</div>
			';
		$bottom = '';

		return array('top'=>$top,'content'=>$content,'bottom'=>$bottom);
	}


	// Форма Авторизации
	function FormAutorize( $p=array() ){

		$code = (!LOGIN_ID)? '		 
				<div class="enter-btn">
					<p>Войти</p>
					<form id="login-form" class="form-wrapper d-none">
						<div class="form-group">
							'.$this->Input(	array(	'type'			=> 'text',
													'id'			=> 'email',
													'placeholder'	=> 'Логин'
												)
										).'
						</div>
						<div class="form-group">
							'.$this->Input(	array(	'type'			=> 'password',
													'id'			=> 'pass',
													'placeholder'	=> 'Пароль',
												)
										). '
						</div>
						<a class="restore-btn" href="/restore">Забыли пароль?</a>
						
						<button type="submit" class="login-form-button login-in">Войти</button>
						
						<span class="form-text">Если у Вас нет аккаунта?</span>
						<div class="login-form-button modal_registration">Создать сейчас</div>
					</form>
					<div class="restore-form-block form-wrapper">
						<div class="restore-form-block__title">Восстановление доступа</div>
						<div class="restore-form-block__subtitle">Введите адрес электронной почты, который был указан при регистрации.</div>
						<form id="restore-form" class="" role="form">
							<div class="form-group">
								'.$this->Input(	array(
														'type'			=> 'text',
														'id'			=> 'email',
														'class'			=> 'form-control',
														'placeholder'	=> 'Почта'
													)
											).'
							</div>
							<div class="form-group">
								'.$this->Input(	array(
														'type'			=> 'submit',
														'class'			=> 'login-form-button',
														'value'			=> 'Сбросить пароль'
													)
											). '
							</div>
						</form>
					</div>
				</div>'
				: '';

		return $code;
	}


	// Администрирование Категории
	function FormSlovCategories( $p=array() ){
		$dop_top = $code_add_attribute = '';
		if(!$p['id']){
			$r 		= array('id'=>0,'categories'=>'','active'=>1,'no_empty_name'=>0,'no_empty_file'=>0,'assets'=>0,
							'unit_id'=>'','unit_group_id'=>'','limit_sell'=>'','limit_buy'=>'','desc_sell'=>'','desc_buy'=>'','keywords_buy'=>'','keywords_sell'=>'','description_buy'=>'','description_sell'=>'');
			$level = 1;
			if($p['level']){
				$level = $p['level']+1;
				$rt 		= reqSlovCategories(array('id' => $p['parent_id']));
				$dop_top = ' <small class="text-muted">к '.$rt['categories'].'</small>';
			}
			$top 	= 'Добавить Категорию '.$level.$dop_top;
		}else{
			$r 		= reqSlovCategories(array('id' => $p['id']));
			// $top 	= 'Редактировать';
			$top 	= '';
			$code_add_attribute = ($r['level']==3)? '<div class="amc-col-22">
													'.$this->Input(	array(	'type'		=> 'button',
																			'id'		=> 'add_select_attribute',
																			'class'		=> 'btn-success',
																			'value'		=> 'Добавить поле',
																			'data'		=> array('categories_id'=>$p['id'])
																		)
																).'
												</div>' : '';
		}


		$code = ($p['id'])? $this->AdminRowCategoriesAttribute(array('categories_id'=>$p['id'])) : '';

		$content ='
				<div class="container">
                    <div class="amc-row">
                        <div class="amc-col-number amc-col-4"></div>
                        <div class="amc-col-22 form-group">
								'.$this->Input(	array(	'type'			=> 'text',
														'id'			=> 'categories',
														'class'			=> 'form-control',
														'value'			=> $r['categories'],
														'placeholder'	=> 'Категория'
													)
											).'
                        </div>
                        <div class="amc-col-22 form-group">
								'.$this->Select(	array(	'id'		=> 'unit_id',
														'class'		=> 'form-control select2',
														'value'		=> $r['unit_id'],
														'data'		=> array('placeholder'=>'Ед.изм.')
													),
												array(	'func'		=> 'reqSlovUnit',
														'param'		=> array('' => ''),
														'option'	=> array('id'=>'','name'=>''),
														'option'	=> array('id'=>'id','name'=>'unit')
													)
											).'
                        </div>
						<div class="amc-col-22 form-group">
								Группа ед.изм.(фасовка)
								'.$this->Select(	array(	'id'		=> 'unit_group_id',
														'class'		=> 'form-control select2',
														'value'		=> $r['unit_group_id'],
														'data'		=> array('placeholder'=>'Группа ед.изм.(фасовка)')
													),
												array(	'func'		=> 'reqSlovUnitGroup',
														'param'		=> array('' => ''),
														'opt'	=> array('id'=>'0','name'=>'-'),
														'option'	=> array('id'=>'id','name'=>'unit_group')
													)
											).'
                        </div>
                        <div class="amc-col-10 form-group">
								'.$this->Input(	array(	'type'			=> 'text',
														'id'			=> 'limit_sell',
														'class'			=> 'form-control',
														'value'			=> $r['limit_sell'],
														'placeholder'	=> 'Количество объявлений'
													)
											).'
                        </div>
                        <div class="amc-col-10 form-group">
                            	'.$this->Input(	array(	'type'			=> 'text',
														'id'			=> 'limit_buy',
														'class'			=> 'form-control',
														'value'			=> $r['limit_buy'],
														'placeholder'	=> 'Количество заявок'
													)
											).'
                        </div>
						<div class="form-group">
							<label for="active" class="">Активна</label>
							<label class="switch">
								'.$this->Input(	array(	'type'		=> 'checkbox',
														'id'		=> 'active',
														'class'		=> 'primary',
														'value'		=> ($r['active']==1)? '1' 		: '',
														'dopol'		=> ($r['active']==1)? 'checked' 	: ''
														)
												).'
								<span class="slider round"></span>
							</label>
						</div>
						<div class="form-group">
							<label for="no_empty_name" class="">Обязательно Наименование</label>
							<label class="switch">
								'.$this->Input(	array(	'type'		=> 'checkbox',
														'id'		=> 'no_empty_name',
														'class'		=> 'primary',
														'value'		=> ($r['no_empty_name']==1)? '1' 		: '',
														'dopol'		=> ($r['no_empty_name']==1)? 'checked' 	: ''
														)
												).'
								<span class="slider round"></span>
							</label>
						</div>
						<div class="form-group">
							<label for="no_empty_file" class="">Обязательно Файл</label>
							<label class="switch">
								'.$this->Input(	array(	'type'		=> 'checkbox',
														'id'		=> 'no_empty_file',
														'class'		=> 'primary',
														'value'		=> ($r['no_empty_file']==1)? '1' 		: '',
														'dopol'		=> ($r['no_empty_file']==1)? 'checked' 	: ''
														)
												).'
								<span class="slider round"></span>
							</label>
						</div>
						<div class="form-group">
							<label for="assets" class="">В активы</label>
							<label class="switch">
								'.$this->Input(	array(	'type'		=> 'checkbox',
														'id'		=> 'assets',
														'class'		=> 'primary',
														'value'		=> ($r['assets']==1)? '1' 		: '',
														'dopol'		=> ($r['assets']==1)? 'checked' 	: ''
														)
												).'
								<span class="slider round"></span>
							</label>
						</div>

                    </div>
					<div class="amc-row">

						<div class="form-group">
							<label for="desc_buy" class="">Описание категории в заявках</label>								
									'.$this->Textarea(array('id'			=> 'desc_buy',
															'class'			=> 'form-control richtext',
															'value'			=> $r['desc_buy'],
															'placeholder'	=> 'Описание категории в заявках',
															'dopol'			=> 'cols="110" rows="5"'
											)).'
						</div>	
						<div class="form-group">
							<label for="desc_sell" class="">Описание категории в объявлениях</label>
								'.$this->Textarea(	array(	'type'			=> 'text',
														'id'			=> 'desc_sell',
														'class'			=> 'form-control richtext',
														'value'			=> $r['desc_sell'],
														'placeholder'	=> 'Описание категории в объявлениях',
														'dopol'			=> 'cols="110" rows="5"'
													)
								).'								
						</div>	
						
					</div>
					<div class="amc-row">
						<div class="form-group">
							<label for="keywords_buy" class="">Keywords заявок</label>
								'.$this->Input(	array(	'type'			=> 'text',
														'id'			=> 'keywords_buy',
														'class'			=> 'form-control',
														'value'			=> $r['keywords_buy'],
														'placeholder'	=> 'Keywords'
													)
								).'								
						</div>
						<div class="form-group">
							<label for="keywords_sell" class="">Keywords объявлений</label>
								'.$this->Input(	array(	'type'			=> 'text',
														'id'			=> 'keywords_sell',
														'class'			=> 'form-control',
														'value'			=> $r['keywords_sell'],
														'placeholder'	=> 'Keywords'
													)
								).'								
						</div>						
						<div class="form-group">
							<label for="description_buy" class="">Description заявок</label>
								'.$this->Input(	array(	'type'			=> 'text',
														'id'			=> 'description_buy',
														'class'			=> 'form-control',
														'value'			=> $r['description_buy'],
														'placeholder'	=> 'Description'
													)
								).'								
						</div>	
						<div class="form-group">
							<label for="Description_sell" class="">Description объявлений</label>
								'.$this->Input(	array(	'type'			=> 'text',
														'id'			=> 'description_sell',
														'class'			=> 'form-control',
														'value'			=> $r['description_sell'],
														'placeholder'	=> 'Description'
													)
								).'								
						</div>							

					</div>
                    <div class="amc-row amc-table-head">
                        <div class="amc-col-number">Сорт-ка</div>
                        <div class="amc-col-22 amc-col-name">Наименование</div>
                        <div class="amc-col-22">В заявках</div>
						<div class="amc-col-22">В объявлениях</div>
						<div class="amc-col-22">Значение</div>
						<div class="amc-col-10">Заявки</div>
						<div class="amc-col-10">Об-ния</div>
						<div class="amc-col-10">Груп-ка</div>
						<div class="amc-col-10">Только актив</div>
                    </div>
                    '.$code.'
		
					
                    <div class="amc-row buttons-row">
                        <div class="amc-col-number amc-col-4"></div>
                        <div class="amc-col-22">
							'.$this->Input(	array(		'type'			=> 'hidden',
														'id'			=> 'id',
														'value'			=> $r['id']
													)
											).'
							'.$this->Input(	array(		'type'			=> 'hidden',
														'id'			=> 'parent_id',
														'value'			=> $p['parent_id']
													)
											).'
							'.$this->Input(	array(		'type'			=> 'hidden',
														'id'			=> 'level',
														'value'			=> $p['level']
													)
											).'
							'.$this->Input(	array(		'type'			=> 'submit',
														'class'			=> 'save btn-blue',
														'value'			=> 'Сохранить'
													)
											).'
                        </div>
                        <div class="amc-col-22">
                            <button class="cancel" type="button" data-dismiss="modal" aria-label="Close">Отмена</button>
                        </div>
						'.$code_add_attribute.' 
                    </div>
                </div>

				';

/*
		$content ='
					<div class="row">
						<div class="col-sm-9">
							<div class="form-group">
								'.$this->Input(	array(	'label'		=> array('name'=>'Категория'),
														'type'			=> 'text',
														'id'			=> 'categories',
														'class'			=> 'form-control',
														'value'			=> $r['categories'],
														'placeholder'	=> 'Категория'
													)
											).'
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								'.$this->Select(	array(	'label'		=> array('name'=>'Ед.изм.'),
														'id'		=> 'unit_id',
														'class'		=> 'form-control select2',
														'value'		=> $r['unit_id'],
														'data'		=> array('placeholder'=>'Ед.изм.')
													),
												array(	'func'		=> 'reqSlovUnit',
														'param'		=> array('' => ''),
														'option'	=> array('id'=>'','name'=>''),
														'option'	=> array('id'=>'id','name'=>'unit')
													)
											).'
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								'.$this->Input(	array(	'label'		=> array('name'=>'Количество доступных размещений объявлений'),
														'type'			=> 'text',
														'id'			=> 'limit_sell',
														'class'			=> 'form-control',
														'value'			=> $r['limit_sell'],
														'placeholder'	=> 'Количество'
													)
											).'
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								'.$this->Input(	array(	'label'		=> array('name'=>'Количество доступных размещений заявок'),
														'type'			=> 'text',
														'id'			=> 'limit_buy',
														'class'			=> 'form-control',
														'value'			=> $r['limit_buy'],
														'placeholder'	=> 'Количество'
													)
											).'
							</div>
						</div>
					</div>

					<div class="form-group">
							<label for="active" class="">Активна</label>
							<label class="switch">
								'.$this->Input(	array(	'type'		=> 'checkbox',
														'id'		=> 'active',
														'class'		=> 'primary',
														'value'		=> ($r['active']==1)? '1' 		: '',
														'dopol'		=> ($r['active']==1)? 'checked' 	: ''
														)
												).'
								<span class="slider round"></span>
							</label>
					</div>

					'.$code.'

					'.$code_add_attribute.'

			';

		$bottom = $this->Input(	array(		'type'			=> 'hidden',
											'id'			=> 'id',
											'value'			=> $r['id']
										)
								).'
				'.$this->Input(	array(		'type'			=> 'hidden',
											'id'			=> 'parent_id',
											'value'			=> $p['parent_id']
										)
								).'
				'.$this->Input(	array(		'type'			=> 'hidden',
											'id'			=> 'level',
											'value'			=> $p['level']
										)
								).'
				'.$this->Input(	array(		'type'			=> 'submit',
											'class'			=> 'btn btn-primary',
											'value'			=> 'Сохранить'
										)
								);
*/
		return array('top'=>$top,'content'=>$content/*,'bottom'=>$bottom*/);
	}


	// Администрирование Администрирование Изменить родителя у Категории
	function FormChangeLevelCategories( $p=array() ){
		$code = '';

		$r = reqSlovCategories(array('id' => $p['id']));


		$content ='
					<h3>Изменить родителя у Категории</h3>
					<div class="form-group">
						'.$this->Select(	array(	'id'		=> 'parent_id',
												'class'		=> 'form-control select2',
												'value'		=> $r['parent_id'],
												'data'		=> array('placeholder'=>'')
											),
										array(	'func'		=> 'reqSlovCategories',
												'param'		=> array('level' => ($r['level']-1) ),
												'opt'		=> array('id'=>'','name'=>''),
												'option'	=> array('id'=>'id','name'=>'categories')
											)
									).'
					</div>
					
					
				'.$this->Input(	array(		'type'			=> 'hidden',
											'id'			=> 'id',
											'value'			=> $r['id']
										)
								).'
				'.$this->Input(	array(		'type'			=> 'submit',
											'class'			=> 'btn btn-primary',
											'value'			=> 'Сохранить'
										)
								);

		return array('content'=>$content);
	}


	// Администрирование Поля
	function FormSlovAttribute( $p=array() ){
		$code = '';
		if(!$p['id']){
			$r 		= array('id'=>0,'attribute'=>'','active'=>1);
			$top 	= 'Добавить Поле';
		}else{
			$r 		= reqSlovAttribute(array('id' => $p['id']));
			$top 	= 'Редактировать';
			$code = $this->AdminRowAttributeValue(array('attribute_id'=>$p['id']));
		}



		$content ='
					<div class="form-group">
						'.$this->Input(	array(	'label'		=> array('name'=>'Поле'),
												'type'			=> 'text',
												'id'			=> 'attribute',
												'class'			=> 'form-control',
												'value'			=> $r['attribute'],
												'placeholder'	=> 'Поле'
											)
									).'
					</div>
					
					<div class="form-group">
							<label for="active" class="">Активна</label>
							<label class="switch">
								'.$this->Input(	array(	'type'		=> 'checkbox',
														'id'		=> 'active',
														'class'		=> 'primary',
														'dopol'		=> ($r['active']==1)? 'checked' : ''
														)
												).'
								<span class="slider round"></span>
							</label>
					</div>
					
					'.$code.'
					
			';
		$bottom = $this->Input(	array(		'type'			=> 'hidden',
											'id'			=> 'id',
											'value'			=> $r['id']
										)
								).'
				'.$this->Input(	array(		'type'			=> 'hidden',
											'id'			=> 'parent_id',
											'value'			=> $p['parent_id']
										)
								).'
				'.$this->Input(	array(		'type'			=> 'hidden',
											'id'			=> 'level',
											'value'			=> $p['level']
										)
								).'
				'.$this->Input(	array(		'type'			=> 'submit',
											'class'			=> 'btn btn-primary',
											'value'			=> 'Сохранить'
										)
								);

		return array('top'=>$top,'content'=>$content,'bottom'=>$bottom);
	}

	// Регистрация
	function FormRegistration( $p=array() ){

		$in = fieldIn($p, array('email','name','phone'));

		$content =' 
		
		        <div class="before-form">
				  <p class="wrapper-text">
					<span class="pro active">Pro режим</span>
					<span class="eff">Для максимальной эффективности</span>
				  </p>
				</div>
				<p class="form-title">
						ЭФФЕКТИВНО <br>
						БЫСТРО<br>
						УДОБНО<br>
						БЕСПЛАТНО 
				</p>
				<div class="form-group">
					<label for="name">
						<input type="text" class="new-user-name" name="name" placeholder="Имя" value="'.$in['name'].'">
					</label>
				</div>
				<div class="form-group">
					<label for="email">
						<input type="text" class="new-user-mail" name="email" placeholder="E-mail" value="'.$in['email'].'">
					</label>
				</div>
				<div class="form-group">				
					<label for="phone" class="phone">
						<input type="phone" class="new-user-phone" id="phone" name="phone" value="'.$in['phone'].'">
					</label>
				</div>
				
				
				

				<div class="btn-wrapper d-inline-flex">
					<button type="submit" class="register-submit">Старт</button>
					<p class="personal-data">Нажимая на кнопку вы соглашаетесь с политикой <a href="/confidentiality" target="_blank">конфиденциальности</a> и <a href="/rules" target="_blank">пользовательским соглашением</a></p>
				</div>
				<div class="reg-changer">
					<span class="pro active"></span>
					<span class="eff"></span>
				</div>';

		return array('content'=>$content);
	}

	// Получение пароля
	function _GetPasswordForm( $p=array() ){

		$in = fieldIn($p, array('email_phone','email','phone'));

		$content =' 
		
		        <div class="before-form">
				  <p class="wrapper-text">
					<span class="pro active">Pro режим</span>
					<span class="eff">Для максимальной эффективности</span>
				  </p>
				</div>
				<p class="form-title">
						ЭФФЕКТИВНО <br>
						БЫСТРО<br>
						УДОБНО<br>
						БЕСПЛАТНО 
				</p>
				<div class="form-group">
					<label for="phone_email">
						<input type="text" class="new-user-name phone_email" name="phone_email" placeholder="Телефон или E-mail" value="'.$in['phone_email'].'">
					</label>
				</div>
				

				<div class="btn-wrapper d-inline-flex">
					<button type="submit" class="register-submit">Получить код</button>
				</div>
				<div class="reg-changer">
					<span class="pro active"></span>
					<span class="eff"></span>
				</div>';

		return array('content'=>$content);
	}

	// Забыли пароль / Сменить пароль
	function _FormChangePass( $p=array() ){
		$in = fieldIn($p, array('flag','active_md5'));

		$top = $code_route = '';

		if($in['flag']=='profile'){
			$top = 'Сменить пароль';
			$code_route = '	<div class="form-group">
										'.$this->Input(	array(
																'type'			=> 'hidden',
																'id'			=> 'route',
																'value'			=> 'change_pass_profile'
															)
													).'
								</div>';
		}

		$code_active_md5 = '';
		if($in['active_md5']){
			$code_active_md5 = '	<div class="form-group">
										'.$this->Input(	array(
																'type'			=> 'hidden',
																'id'			=> 'value',
																'value'			=> $in['active_md5']
															)
													).'
								</div>';
			$code_route = '	<div class="form-group">
										'.$this->Input(	array(
																'type'			=> 'hidden',
																'id'			=> 'route',
																'value'			=> 'change_pass'
															)
													).'
								</div>';
		}

		$content ='
					<div class="form-group">
						'.$this->Input(	array(	'type'			=> 'password',
												'id'			=> 'pass',
												'class'			=> 'form-control',
												'placeholder'	=> 'Пароль',
											)
									).'
					</div>
					<div class="form-group">
						'.$this->Input(	array(	'type'			=> 'password',
												'id'			=> 'pass_again',
												'class'			=> 'form-control',
												'placeholder'	=> 'Повторно пароль',
											)
									).'
					</div>
					'.$code_active_md5.'
					'.$code_route.'					
			';
		$bottom = $this->Input(	array(
												'type'			=> 'submit',
												'class'			=> 'btn btn-primary btn-block',
												'value'			=> 'Сохранить новый пароль',
												'data'			=> array('route'=>'change_pass')
											)
									);

		return array('top'=>$top,'content'=>$content,'bottom'=>$bottom);
	}


	// Моя Компания
	function FormMyCompany( $p=array() ){
		$in = fieldIn($p, array('id'));
		if(!$in['id']){
			$r 			= array('id'=>0,'legal_entity_id'=>'','company'=>'','tax_system_id'=>'','position'=>'','cities_id'=>'','who1'=>'','who2'=>'', 'active' => '');
			$top 		= ' <div class="modal-body__head">
								<div class="modal__title">Добро пожаловать</div>
								<img src="/image/quest-request-logo.svg" alt="Логотип">				
							</div>';
			$submit_value	= 'Зарегистрировать';
		}else{
			$r 			= reqCompany(array('id' => $in['id']));
			$top 		= '<small class="text-muted">Редактировать</small> '.$r['company'];
			$submit_value	= 'Сохранить';
		}

		$content = '
		<div class="modal-body__content">
			<div class="modal__title">Регистрация компании</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							'.$this->Select(	array(	'id'		=> 'legal_entity_id',
													'class'		=> 'form-control select2',
													'value'		=> $r['legal_entity_id'],
													'data'		=> array('placeholder'=>'Правовая форма')
												),
											array(	'func'		=> 'reqSlovLegalEntity',
													'param'		=> array('' => ''),
													'opt'		=> array('id'=>'','name'=>''),
													'option'	=> array('id'=>'id','name'=>'legal_entity')
												)
										).'
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							'.$this->Input(	array(	'type'			=> 'text',
													'id'			=> 'company',
													'class'			=> 'form-control',
													'value'			=> $r['company'],
													'placeholder'	=> 'Наименование'
												)
										).'
						</div>		
					</div>
				</div>
				
				<div class="row">
					<div class="col-sm-6">
							'.$this->SelectCategoriesCompany(array( 'company_id' => $r['id'] )).'
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							'.$this->Select(	array(	'id'		=> 'tax_system_id',
													'class'		=> 'form-control select2',
													'value'		=> $r['tax_system_id'],
													'data'		=> array('placeholder'=>'Система налогообложения')
												),
											array(	'func'		=> 'reqSlovTaxSystem',
													'param'		=> array('' => ''),
													'opt'		=> array('id'=>'','name'=>''),
													'option'	=> array('id'=>'id','name'=>'tax_system')
												)
										).'
						</div>
					</div>
				</div>
					
				<div class="row">
					<div class="col-sm-6">
							<div class="form-group">
								<label for="cities_id">Город</label>
								'.$this->SelectCities(array('cities_id'=>$r['cities_id'])).'
							</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							'.$this->SelectWhoCompany(array(	'who1'	=> $r['who1'],
																'who2'	=> $r['who2'],
																'placeholder'	=> 'Продавец или Покупатель' )). '
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							'.$this->Input(	array(	'type'			=> 'text',
													'id'			=> 'position',
													'class'			=> 'form-control',
													'value'			=> $r['position'],
													'placeholder'	=> 'Должность'
												)
										).'
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group" style="display: inline-flex;">
							'.$this->Input(	array(	'type'			=> 'checkbox',
													'id'			=> 'companyIn',
													'class'			=> 'form-control',
													'checked' 		=> true,
													'placeholder'	=> 'Продолжить как компания'
												)
										).'
							
						</div>
						</div>
					</div>
				</div>
		</div>
			';
		$bottom =  $this->Input(
			array(
				'type'			=> 'hidden',
				'id'			=> 'id',
				'value'			=> $r['id']
			)
		) . '<div class="modal-body__footer">
                <div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<button type="button" class="modal-close button-grey" onclick="SkipRegistCompany()">Пропустить</button>
						</div>
					</div>
					
					<div class="col-sm-6">
						<div class="form-group">
							<button type="submit" class="button-blue" >Сохранить</button>
						</div>
					</div>
				</div>
			
		</div>';

		return array('top'=>$top,'content'=>$content,'bottom'=>$bottom);
	}

	// Заявка/Объявление
	function FormBuySell( $p=array() ){
		$in = fieldIn($p, array('id','flag_buy_sell','share_url','status','flag'));

		$code_categories_buy_sell = $code_cost = $code_categories = $file_list = $st_prava = $button23 = $comments_company = $responsible = $code_assets = '';
		$st_dn = $save_button = $count_status_buysell = $availability = $select_categories = $span_clear_form = $st_span_select_categories = $required_name = $required_file = $code_company_id3 = '';
		$code_1ctransport = $_1ctransport = $_1c_transport_id = '';

		// скрываем по правам
			if(PRAVA_4||PRAVA_5){
				$st_prava = 'display:none;';
			}
		///


		if($in['flag_buy_sell']==1){// продажа
			$str1	 = 'Объявление';
		}elseif($in['flag_buy_sell']==2){// покупка
			$str1	 = 'Заявку';
		}elseif($in['flag_buy_sell']==4){// актив
			$str1	 = 'Актив';
		}elseif($in['flag_buy_sell']==5){// склад
			$str1	 = 'Склад';
		}

		$status1	= 3;// по умолчанию, выбор размещения
		$nstatus1	= 'в Активные';
		$status2	= 2;// по умолчанию, выбор размещения
		$nstatus2	= 'Опубликовать';


		$select_categories = 'Категории';
		$class_categories = '';
		$assets_id = '';


		if( !$in['id'] ){

								// выбераем последнюю срочность, если создавалась заявка в течении 15 минут
								//$ru = reqBuySellUrgency15min();
								//$t_urgency_id = ($ru['urgency_id'])? $ru['urgency_id'] : 5;// по умолчанию "не срочно"
								//'urgency_id'=>$t_urgency_id,
			$r 			= array('id'=>0,'name'=>'','categories_id'=>0,'comments'=>'','urgency_id'=>5,'form_payment_id'=>'',
								'cost'=>'','cost1'=>'','status_buy_sell_id'=>1,'comments_company'=>'','responsible'=>'','responsible_id'=>0,
								'currency_id'=>1,'availability'=>'','multiplicity'=>'','min_party'=>'','delivery_id'=>'',
								'stock_id'=>'','company_id2'=>'','id_1c'=>'','nomenclature_id'=>'','1c_transport_id'=>'' /*,'unit'=>'','amount'=>''*/);

			if($in['flag_buy_sell']==2 || $in['flag_buy_sell']==1){
				$rb 		= reqBuySell_LastId(array('flag_buy_sell'=>$in['flag_buy_sell']));
				$rbs 	= ($rb['id'])? reqBuySell_FormBuyAmount(array('id' => $rb['id'])) : '';
				$r['delivery_id'] 	= (!empty($rbs))? $rbs['delivery_id'] : '';

				// заявка, склад, обьявление только при включенном ("Опытный снабженец" или "Юный продавец" в навыках)
				$rv		= reqCompanyVipFunction(array('company_id'=>COMPANY_ID,'vip_function_id'=>'7,8'));
				$r['flag_vip_function_stock'] = !empty($rv)? true : false;
			}

			if( ($in['flag_buy_sell']==2) && PRO_MODE && ($in['flag']<>'clear_form') ){// предзаполненные поля, Значения, которые предзаполняются, берутся из предыдущей заявки.



				if(!empty($rbs)){

					// Очистить
					$span_clear_form = '<span id="span_clear_form" class="modal_buy_sell change-btn change-btn_red" data-flag_buy_sell="2" data-flag="clear_form">Очистить</span>';


					//$st_span_select_categories = 'display:none;';// скрыть выбор категории
					//$select_categories 	= '<span style="font-weight:bold;color: #1cb6ff !important;">'.$rbs['categories'].'</span>';
					$select_categories 	= $rbs['categories'];
					$class_categories = 'active';
					$arr 	= $this->CategoriesAttributeBuySell(array(	'row_bs'		=> $rbs,
																		'buy_sell_id'	=> $rbs['id'],
																		'parent_id'		=> $rbs['parent_id'],
																		'status'		=> $rbs['status_buy_sell_id'],
																		'flag_buy_sell'	=> 2,
																		'categories_id'	=> $rbs['categories_id'],
																		'flag'			=> 'last_form'	));
					$code_categories_buy_sell = $arr['code'];

					$r['categories_id'] 	= $rbs['categories_id'];
					$r['cities_id'] 		= $rbs['cities_id'];
					$r['cities_name'] 	= $rbs['cities_name'];
					$r['urgency_id'] 	= $rbs['urgency_id'];
					$r['comments'] 		= $rbs['comments'];
					$r['comments_company'] 	= $rbs['comments_company'];
					$r['responsible_id'] 	= $rbs['responsible_id'];
					$r['responsible'] 		= $rbs['responsible'];

					// параметры категории
					$categories = reqSlovCategories(array('id'=>$rbs['categories_id']));
					if($categories['no_empty_name']){
						$required_name = 'required="required"';
					}
					if($categories['no_empty_file']){
						$required_file = 'required="required"';
					}
					///

				}else{
					$arr_cities = $this->CitiesIdByCompanyOrIp();
					$r['cities_id']		= $arr_cities['cities_id'];
					$r['cities_name']	= $arr_cities['cities_name'];
				}

			}else{
				$arr_cities = $this->CitiesIdByCompanyOrIp();
				$r['cities_id']		= $arr_cities['cities_id'];
				$r['cities_name']	= $arr_cities['cities_name'];

			}


			$class_name = 'autocomplete_search_buy_sell';


			$r_last = reqBuySellLastStatusBuySellId();
			if($r_last['status_buy_sell_id']==2){
				$status1	= 2;
				$nstatus1	= 'Опубликовать';
				$status2	= 3;
				$nstatus2	= 'в Активные';
			}

		}else{//редактировать

			$st_span_select_categories = 'display:none;';// скрыть выбор категории
			$r 			= reqBuySell_FormBuyAmount(array('id' => $in['id']));
			$assets_id = $r['assets_id'];
			if($r['availability']){
				$str = $this->format_by_count($r['availability'], 'день', 'дня', 'дней');
				$availability = $r['availability'].' '.$str;
			}else{
				$availability = 'в наличии';
			}


			$class_name = (!$r['nomenclature_id'])? 'autocomplete_search_buy_sell' : '';

			$arr = $this->FilesListBuySell(array('buy_sell_id' => $in['id']));
			$file_list = $arr['code'];

			// исключения, если ранее "Предложение" редактируем
			$flag = '';
			if($r['status_buy_sell_id']==10){
				$in['flag_buy_sell'] = 1;
				$flag 				= 'offer_edit';
				$st_dn				= 'display:none;';
			}

			$arr = $this->CategoriesAttributeBuySell(array('row_bs'		=> $r,
														'buy_sell_id'	=> $r['id'],
														'parent_id'		=> $r['parent_id'],
														'status'		=> $r['status_buy_sell_id'],
														'flag_buy_sell'	=> $in['flag_buy_sell'],
														'categories_id'	=> $r['categories_id'],
														'flag'			=> $flag	));
			$code_categories_buy_sell	= $arr['code'];
			$row_categories 			= $arr['row_categories'];// параметры категории

			if($row_categories['no_empty_name']){
				$required_name = 'required="required"';
			}
			if($row_categories['no_empty_file']){
				$required_file = 'required="required"';
			}
			///


			//$select_categories = '<span style="font-weight:bold;color: #1cb6ff !important;">'.$r['categories'].'</span>';
			$select_categories 	= $r['categories'];

		}


		if(PRO_MODE){

			$currency = '	<div class="col-sm-2">
							<div class="form-group bttip-wrap">
								'.$this->Select(	array(	'id'		=> 'currency_id',
														'class'		=> 'form-control select2',
														'value'		=> $r['currency_id'],
														'data'		=> array('placeholder'=>'Валюта')
													),
												array(	'func'		=> 'reqSlovCurrency',
														'param'		=> array('' => ''),
														'opt'		=> array('id'=>'','name'=>''),
														'option'	=> array('id'=>'id','name'=>'currency')
													)
											). '
								<span class="bttip" style="display: none;">Валюта</span>
							</div>
						</div>';
		}else{
			$currency = $this->Input(	array(	'type'			=> 'hidden',
											'id'			=> 'currency_id',
											'value'			=> 1
										)
								);
		}


		if($in['flag_buy_sell']==1 || $in['flag_buy_sell']==4 || $in['flag_buy_sell']==5){// продажа, актив, склад

			$availability_required = (COMPANY_ID)? 'required' : '';
			$code_availability = ($in['flag_buy_sell']==1)? '	<div class="col-sm-2">
															<div class="form-group bttip-wrap">
																'.$this->Input(	array(	'type'			=> 'text',
																						'name'			=> 'availability',
																						'class'			=> 'form-control',
																						'value'			=> $availability,
																						'placeholder'	=> 'Наличие',
																						'dopol'			=> ''.$availability_required.' list="availability" data-bv-notempty-message="Введите наличие" autocomplete="off"'
																					)
																			). '
																	<datalist id="availability">
																		<option value="в наличии" />
																		<option value="1 день" />
																		<option value="2 дня" />
																		<option value="3 дня" />
																		<option value="4 дня" />
																	</datalist>
																<span class="bttip" style="display: none;">Наличие</span>
															</div>
														</div>' : '';

			$r['cost1'] = ($r['cost1']>0)? $r['cost1'] : $r['cost'];
			$cost_required = (COMPANY_ID)? 'required' : '';
			$code_cost = '<div class="row">
							<div class="col-sm-3">
								<div class="form-group bttip-wrap">
									'.$this->Input(	array(	'type'			=> 'text',
															'id'			=> 'cost',
															'class'			=> 'form-control vmask',
															'value'			=> $r['cost1'],
															'placeholder'	=> 'Цена',
															'dopol'			=> ''.$cost_required.' data-bv-notempty-message="Введите цену" autocomplete="off"'
														)
												). '
									<span class="bttip" style="display: none;">Цена</span>
								</div>
							</div>
							'.$currency. '
							<div class="col-sm-2">
								<div class="form-group bttip-wrap">
									'.$this->Select(	array(	'id'		=> 'form_payment_id',
															'class'		=> 'form-control select2',
															'value'		=> $r['form_payment_id'],
															'data'		=> array('placeholder'=>'Форма оплаты'),
															'dopol'		=> (FLAG_ACCOUNT==2)? 'data-bv-notempty-message="Выберите" required' : ''
														),
													array(	'func'		=> 'reqSlovFormPayment',
															'param'		=> array('' => ''),
															'opt'		=> array('id'=>'','name'=>'Форма оплаты', 'dopol'=>'selected disabled'),
															'option'	=> array('id'=>'id','name'=>'form_payment')
														)
												). '
									<span class="bttip" style="display: none;">Форма оплаты</span>
								</div>
							</div>
							'.$code_availability.'
						</div>';
						
			// привязка актива из 1С к нашему активу
			if($in['flag_buy_sell']==4){
					// если актив , проверяем привязан ли к активу 1с
					if($in['id']){
						$rt = req1cTransportBuySell(array('buy_sell_id'=>$in['id']));
						$_1c_transport_id 	= $rt['1c_transport_id'];
						$_1ctransport 		= $rt['modelname_regnumber'];
						
					}
					$code_1ctransport = '	<div class="col-sm-12">
											<div class="form-group">
																'.$this->Input(array(	'type'			=> 'text',
																					'id'			=> '1ctransport',
																					'class'			=> 'form-control autocomplete_1ctransport',
																					'value'			=> $_1ctransport,
																					'placeholder'	=> 'Актив 1C',
																					'dopol'			=> 'autocomplete="new_off"'
																		)).'
											</div>
															'.$this->Input(	array(	'type'			=> 'hidden',
																					'id'			=> '1c_transport_id',
																					'value'			=> $_1c_transport_id
																				)
															).'
										</div>';
			}		

		}

		// Кнопка "Опубликовать/Активировать" и "Имя заказа"
		if( ($in['flag_buy_sell']==1||$in['flag_buy_sell']==2) && ($r['status_buy_sell_id']==1||$r['status_buy_sell_id']==2||$r['status_buy_sell_id']==3) ){
			$button23 = '	<div class="btn-group" style="'.$st_prava.'">
							<button type="submit" id="submit23" data-status="'.$status1.'" class="btn btn-info">'.$nstatus1.'</button>
							<button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="sr-only"></span>
							</button>
							<div class="dropdown-menu">
								<a id="change_status_buy_sell" class="dropdown-item" data-status="'.$status2.'">'.$nstatus2.'</a>
							</div>
						</div>';
			if( PRO_MODE && ($in['flag_buy_sell']==2) ){
				$comments_company = '		<div class="col-sm-3 bttip-wrap">
											<div class="form-group">
												'.$this->Input(array(	'type'			=> 'text',
																	'id'			=> 'comments_company',
																	'class'			=> 'form-control autocomplete_comments_company',
																	'value'			=> $r['comments_company'],
																	'placeholder'	=> 'Имя заказа'
														)). '
												<span class="bttip" style="display: none;">Имя заказа</span>
											</div>
										</div>';
				$responsible 		= '	
										<div class="col-sm-3 bttip-wrap">
											<div class="form-group">
												'.$this->Input(array(	'type'			=> 'text',
																	'id'			=> 'responsible',
																	'class'			=> 'form-control autocomplete_responsible',
																	'value'			=> $r['responsible'],
																	'placeholder'	=> 'Ответственный'
														)). '
												<span class="bttip" style="display: none;">Ответственный</span>
											</div>
										</div>';

				// Заказчик (для кого заведена заявка), проверяем включен ли функционал в навыках
				$rv	= reqCompanyVipFunction(array('company_id'=>COMPANY_ID,'vip_function_id'=>'8'));
				if(!empty($rv)){
					$code_company_id3 = '<div class="form-group offer-form__item">
												'.$this->Input(	array(	'type'			=> 'text',
																		'id'			=> 'autocomplete_facompany_id3',
																		'class'			=> 'form-control require-input autocomplete_facompany_id3',
																		'value'			=> '',
																		'placeholder'	=> 'Заказчик'
																	)
															).'
												'.$this->Input(	array(	'type'			=> 'hidden',
																		'id'			=> 'company_id3',
																		'value'			=> ''
																		)
																).'
										</div>';
				}

			}

		}


		$code_multiplicity_min_party = '';
		if( $in['flag_buy_sell']==1 || $r['status_buy_sell_id']==10 ){// объявление или предложение
			$code_multiplicity_min_party = '
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group bttip-wrap">
									'.$this->Input(	array(	'type'			=> 'text',
															'id'			=> 'multiplicity',
															'class'			=> 'form-control vmask1',
															'value'			=> ($r['multiplicity'])? $r['multiplicity'] : '',
															'placeholder'	=> 'Кратность',
															'dopol'			=> 'autocomplete="off"'
														)
												). '
									<span class="bttip" style="display: none;">Кратность</span>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group bttip-wrap">
									'.$this->Input(	array(	'type'			=> 'text',
															'id'			=> 'min_party',
															'class'			=> 'form-control vmask1',
															'value'			=> ($r['min_party'])? $r['min_party'] : '',
															'placeholder'	=> 'Минимальная Партия',
															'dopol'			=> 'autocomplete="off"'
														)
												). '
									<span class="bttip" style="display: none;">Минимальная Партия</span>
								</div>
							</div>
						</div>';

		}


		// кнопки сохранить...
		if(!$in['id']){
			if($in['flag_buy_sell']==4){
				$save_button = '	<button type="submit" class="request-btn" data-status="21" title="">Добавить актив</button>';
			}
			elseif($in['flag_buy_sell']==5){
				$save_button = '	<button type="submit" class="request-btn" data-status="31" title="">Добавить на склад</button>';
			}
			else{
				$save_button = '	<button type="button" id="save_buy_sell_formnovalidate"  data-status="1" class="btn btn-outline-primary"><span data-feather="save"></span></button>
								'.$button23.'';

			}
		}else{
			if($r['login_id_bs']<>LOGIN_ID){
				$status = $r['status_buy_sell_id'];
				$nstatus = 'Сохранить';
				if( $in['status']==2 && $status<>2 ){
					$status 	= $status2;
					$nstatus 	= $nstatus2;
				}elseif( $in['status']==3 && $status<>3 ){
					$status 	= $status1;
					$nstatus 	= $nstatus1;
				}
				$save_button = '<button type="submit" data-status="'.$status.'" class="request-btn request-hidden-btn">'.$nstatus.'</button>';
			}else{
				$save_button = '<button  type="button" id="save_buy_sell_formnovalidate" data-status="1" class="request-btn request-hidden-btn">Сохранить</button>';
			}
		}
		///


		$code_delivery = '';
		if($in['flag_buy_sell']==1||$in['flag_buy_sell']==2){
			$required_delivery = ($in['flag_buy_sell']==1&&COMPANY_ID)? 'required="required"' : '';
			$code_delivery = '	<div class="row">
								<div class="col-sm-3">
									<div class="form-group bttip-wrap">
										'.$this->Select(	array(	'id'		=> 'delivery_id',
																'class'		=> 'form-control select2',
																'value'		=> $r['delivery_id'],
																'data'		=> array('placeholder'=>'Доставка'),
																'dopol'		=> ''.$required_delivery.' data-bv-notempty-message="Выберите способ доставки"'
															),
														array(	'func'		=> 'reqSlovDelivery',
																'param'		=> array('' => ''),
																'opt'		=> array('id'=>'','name'=>''),
																'option'	=> array('id'=>'id','name'=>'delivery')
															)
													). '
										<span class="bttip" style="display: none;">Доставка</span>
									</div>
								</div>
							</div>';
		}


		$code_stock = $code_company_id2 = '';
		// заявка, склад, обьявление только при включенном ("Опытный снабженец" или "Юный продавец" в навыках)
		if( $in['flag_buy_sell']==2 || $in['flag_buy_sell']==5 || ($in['flag_buy_sell']==1&&$r['flag_vip_function_stock']) ){
			// проверяем, есть ли у пользователя склад (при включении в админке "функции склад", создается склад по умолчанию)
			$rs = (COMPANY_ID)? reqStock(array('flag'=>'add_stock','company_id'=>COMPANY_ID)) : array('id'=>'');
			if($rs['id']){
				$stock_id = ($r['stock_id'])? $r['stock_id'] : $rs['id'];
				$code_stock = '	<div class="col-sm-3">
										<div class="form-group bttip-wrap">
											'.$this->Select(	array(	'id'		=> 'stock_id',
																	'class'		=> 'form-control select2',
																	'value'		=> $stock_id,
																	'data'		=> array('placeholder'=>'Склад'),
																	'dopol'		=> 'required="required" data-bv-notempty-message="Выберите"'
																),
															array(	'func'		=> 'reqStock',
																	'param'		=> array('' => ''),
																	'opt'		=> array('id'=>'','name'=>''),
																	'option'	=> array('id'=>'id','name'=>'stock')
																)
														). '
											<span class="bttip" style="display: none;">Склад</span>
										</div>
								</div>';
				// выбираем поставщика (только в "Склад")
				if( $in['flag_buy_sell']==5 ){
					$rc 	= ($r['company_id2'])? reqCompany(array( 'id' => $r['company_id2'] )) : array('company'=>'');
					$code_company_id2 = '	<div class="col-sm-3">
											<div class="form-group bttip-wrap">
												'.$this->Input(	array(	'type'			=> 'text',
																		'id'			=> 'autocomplete_fastock',
																		'class'			=> 'form-control require-input autocomplete_fastock',
																		'value'			=> $rc['company'],
																		'placeholder'	=> 'Поставщик',
																		'dopol'			=> 'required data-bv-notempty-message="Не выбран поставщик"'
																	)
															).'
												'.$this->Input(	array(	'type'			=> 'hidden',
																		'id'			=> 'company_id2',
																		'value'			=> $r['company_id2'],
																		'dopol'			=> 'style="height:1px;"'
																		)
																). '
												<span class="bttip" style="display: none;">Поставщик</span>
											</div>
										</div>';
					/*
					$code_id_1c = '	<div class="col-sm-3">
										<div class="form-group bttip-wrap">
											'.$this->Input(	array(	'type'			=> 'text',
																	'id'			=> 'id_1c',
																	'class'			=> 'form-control',
																	'value'			=> $r['id_1c'],
																	'placeholder'	=> '1C',
																	'dopol'			=> 'autocomplete="off"'
																)
														). '
											<span class="bttip" style="display: none;">Минимальная Партия</span>
										</div>
									</div>';
					*/
				}
			}
		}



		if( $in['flag_buy_sell']==2 ){
			$assets = '';
			if( $in['id'] && $assets_id ){// редактируем
				$ra = reqAutocompleteAssets(array('buy_sell_id'=>$assets_id));
				$assets = $ra['attribute_value'];
			}

			$code_assets = '<div class="row">
								<div class="col-sm-3">
									<div class="form-group">
										'.$this->Input(array(	'type'			=> 'text',
															'id'			=> 'assets',
															'class'			=> 'form-control autocomplete_assets',
															'value'			=> $assets,
															'placeholder'	=> 'Актив',
															'dopol'			=> 'autocomplete="new_off"'
												)).'
									</div>
								</div>
								'.$this->Input(	array(	'type'			=> 'hidden',
														'id'			=> 'assets_id',// id из buy_sell
														'value'			=> $assets_id
													)
								).'
							</div>
							';
		}


		// для предложения запрещаем менять категорию
		$cl_change_categories = 'part';
		if($r['status_buy_sell_id']==10){
			$cl_change_categories = '';
		}
		

		$content = '
			<div class="app-form-wrapper btn-option">
			
				<label for="" class="app-q-wrapper" style="">
						<div class="app-q-wrapper-before"></div>
						<div class="form-group">
							<input type="text" id="name" name="name" class="app-q '.$class_name.'" placeholder="Что требуется?" value="'.$r['name'].'"
														data-bv-notempty-message="Введите наименование"
														data-flag_buy_sell="'.$in['flag_buy_sell'].'" '.$required_name. '>
						</div>
				</label>
				
				<p class="app-changer">
					<span id="span_select_categories" class="'.$cl_change_categories.' '.$class_categories.'" style=""> <span class="naming">'.$select_categories.'</span>
					</span>
					<span class="location"> <span id="get_span_cities" class="naming">'.$r['cities_name']. '</span>
					</span>
				</p>
				
				<div class="app-location-input d-none">
					<input type="text" placeholder="Введите город" class="city-input autocomplete_cities" value="'.$r['cities_name']. '" autocomplete="new_off">
					<div class="city-thumbs"></div>
				</div>
				
				<div class="cat-wrapper app-cat-wrapper d-none">
					<div class="list-wrapper d-inline-flex">
						'.$this->CategoriesListElement(array('flag'=>'buy_sell','flag_buy_sell'=>$in['flag_buy_sell'])).'
					</div>
				</div>
				
				
				
				<div class="row">
					<div class="col-sm-3" style="'.$st_dn. '">
						<div class="form-group bttip-wrap">
							'.$this->Select(	array(	'id'		=> 'urgency_id',
													'class'		=> 'form-control select2',
													'value'		=> $r['urgency_id'],
													'data'		=> array('placeholder'=>'Срочность')
												),
											array(	'func'		=> 'reqSlovUrgency',
													'param'		=> array('' => ''),
													'opt'		=> array('id'=>'','name'=>''),
													'option'	=> array('id'=>'id','name'=>'urgency')
												)
										). '
							<span class="bttip" style="display: none;">Срочность</span>
						</div>
					</div>
					
					<div class="col-sm-8" style="" bttip-wrap>
						<div class="form-group">
							'.$this->Input(array(	'type'			=> 'text',
												'id'			=> 'comments',
												'class'			=> 'form-control',
												'value'			=> $r['comments'],
												'placeholder'	=> 'Комментарий'
									)). '
							<span class="bttip" style="display: none;">Комментарий</span>
						</div>
					</div>
					
					<div class="col-sm-1">
						<div class="form-group">
							<label for="cam" class="file none-req">
								<input type="buttom" id="cam" onclick="$$(\'upload_files_buy_sell\').fileDialog();" '.$required_file.'>
							</label>
						</div>
					</div>
				</div>
				
				'.$code_delivery.'
				
				<div class="row">
					'.$comments_company.'	
					
					'.$code_company_id3.'
	
					'.$responsible.'
					
					'.$code_stock.'
					
					'.$code_company_id2.'
					
					'.$span_clear_form.'
				</div>
				
				'.$code_1ctransport.'
				
				'.$code_assets.'
				
				'.$code_cost.'
			
				'.$code_multiplicity_min_party.'
				
				<div id="div_categories_buy_sell">'.$code_categories_buy_sell.'</div>
				
				
				'.$file_list.'
				<div id="container_upload_files"></div>
				
				<div class="button-wrapper">
						<div id="div_count_status_buysell"></div>
						'.$save_button.'
				</div>
				
				'.$this->Input(	array(	'type'			=> 'hidden',
										'id'			=> 'id',
										'value'			=> $r['id']
									)
							).'
				'.$this->Input(	array(	'type'			=> 'hidden',
										'id'			=> 'flag_buy_sell',
										'value'			=> $in['flag_buy_sell']
									)
							).'
				'.$this->Input(	array(	'type'			=> 'hidden',
										'id'			=> 'share_url',
										'value'			=> $in['share_url']
									)
							).'			
				'.$this->Input(	array(	'type'			=> 'hidden',
										'id'			=> 'categories_id',
										'value'			=> $r['categories_id']
									)
							).'
				'.$this->Input(	array(	'type'			=> 'hidden',
										'id'			=> 'cities_id',
										'value'			=> $r['cities_id']
									)
							).'
				'.$this->Input(	array(	'type'			=> 'hidden',
										'id'			=> 'nomenclature_id',
										'value'			=> $r['nomenclature_id']
									)
							).'
				'.$this->Input(	array(	'type'			=> 'hidden',
										'id'			=> 'responsible_id',
										'value'			=> $r['responsible_id']
									)
							).'
			';


		return array('content'=>$content);
	}

	// Купить Количество (возвращается после "Купить" на кого подписан)
	function FormBuyAmount( $p=array() ){
		$in = fieldIn($p, array('buy_sell_id','amount','where'));

		$row	= reqBuySell_FormBuyAmount(array('id' => $in['buy_sell_id']));

		$code = '';

		//if(COMPANY_ID&&COMPANY_ID<>$row['company_id']){
		if( $row['flag_subscriptions_company_in']||$row['login_id_bs']==LOGIN_ID||$row['flag_subscriptions_company_out']||$row['qrq_id'] ){


				if($row['unit_group_id']){
					$placeholder 	= $row['unit1'];
					$opt_datalist	= $row['amount1'];
					$unit_id		= $row['unit_id1'];
				}else{
					$placeholder 	= $row['unit'];
					$opt_datalist	= $in['amount'];
					$unit_id		= $row['unit_id'];
				}

				$code_submit = ($row['qrq_id'])? 'Записать' : 'Купить';

				$code =  '
							<form id="form_buy-form'.$in['buy_sell_id'].'" class="" role="form">
								<div class="form-group text-left">
										'.$this->Input(	array(	'label'			=> array('name'=>'Укажите количество'),
																'type'			=> 'text',
																'name'			=> 'amount',
																'class'			=> 'form-control vmask',
																'value'			=> '',
																'placeholder'	=> $placeholder,
																'dopol'			=> 'list="amount" autocomplete="off"',
																'data'			=> array('unit_id'=>$unit_id)
															)
													).'
										<datalist id="amount">
											<option value="'.$opt_datalist.'" />
										</datalist>
								</div>
								<div class="form-group">
										'.$this->Input(	array(	'type'			=> 'submit',
																'class'			=> 'btn btn-block btn-primary',
																'value'			=> $code_submit
															)
													).'
								</div>
								'.$this->Input(	array(		'type'			=> 'hidden',
															'id'			=> 'buy_sell_id',
															'value'			=> $in['buy_sell_id']
														)
												).'
							</form>
							<div id="div_after_form'.$in['buy_sell_id'].'" class="div_after_form"></div>
							<script>
									$("#form_buy-form'.$in['buy_sell_id'].'").bootstrapValidator({
										feedbackIcons: {
											valid: "glyphicon glyphicon-ok",
											invalid: "glyphicon glyphicon-remove",
											validating: "glyphicon glyphicon-refresh"
										},
										fields: {
											amount: {
												validators: {
													notEmpty: {
														message: "Введите"
													}
												}
											}
										}
									}).on("success.form.bv", function(e) {
										e.preventDefault();
										var $form = $(e.target);
										var bv = $form.data("bootstrapValidator");
											$.post("/save_buy_offer", $form.serialize()+"&where='.$in['where'].'",
												function(data){
														if(data.error_qrq){
															alert(data.error_qrq);	
														}	
														if(data.ok){
															if(data.code_qrq){// покупка со стороннего ресурса, форму предлагает
																$("#div_after_form'.$in['buy_sell_id'].'").html(data.code_qrq);
																$("#form_buy-form'.$in['buy_sell_id'].'").remove();
															}else{
																	if("'.$in['where'].'"=="modal_offer11"){
																																	
																		$("#div_offer'.$row['id'].'").html(data.code);
																		if(data.flag_clear_parent){
																			$("#div_mybs'.$row['parent_id'].'").remove();
																		}
																	}else if("'.$in['where'].'"=="page_sell"){
																		onReload("");
																	}
															}
														}else{
															webix.message({type:"error", text:data.code});
														}
														if (bv.getInvalidFields().length > 0) {
															bv.disableSubmitButtons(false);
														}
												}
											);
									});
							</script>';
		}

		return array('code'=>$code);
	}



	// Создать несущ поставщика
	function FormAddFa3( $p=array() ){
		$in = fieldIn($p, array('value'));

		$top 		= 'Создать поставщика';

		$content ='
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							'.$this->Input(	array(	'type'			=> 'text',
													'id'			=> 'company',
													'class'			=> 'form-control',
													'value'			=> $in['value'],
													'placeholder'	=> 'Наименование'
												)
										).'
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							'.$this->Input(	array(	'type'			=> 'text',
													'id'			=> 'email',
													'class'			=> 'form-control',
													'value'			=> '',
													'placeholder'	=> 'e-mail'
												)
										).'
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							'.$this->Input(	array(	'type'			=> 'text',
													'id'			=> 'comments',
													'class'			=> 'form-control',
													'value'			=> '',
													'placeholder'	=> 'Примечание'
												)
										).'
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-sm-8">
						<div class="form-group">
							'.$this->Input(	array(	'type'			=> 'tel',
													'id'			=> 'phone',
													'class'			=> 'form-control phone',
													'value'			=> '',
													'dopol'			=> 'inputmode="tel"'
												)
										).'
						</div>
					</div>
				</div>

			';
		$bottom =  $this->Input(	array(		'type'			=> 'submit',
											'class'			=> 'btn btn-primary',
											'value'			=> 'Сохранить'
										)
								);

		return array('top'=>$top,'content'=>$content,'bottom'=>$bottom);
	}

	// Создать Ответственного
	function FormAddResponsible( $p=array() ){
		$in = fieldIn($p, array('value'));

		$top 		= 'Создать ответственного';

		$content ='
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							'.$this->Input(	array(	'label'			=> array('name'=>'Ответственный'),
													'type'			=> 'text',
													'id'			=> 'company',
													'class'			=> 'form-control',
													'value'			=> $in['value'],
													'placeholder'	=> 'Ответственный'
												)
										).'
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							'.$this->Input(	array(	'label'			=> array('name'=>'Примечание'),
													'type'			=> 'text',
													'id'			=> 'comments',
													'class'			=> 'form-control',
													'value'			=> '',
													'placeholder'	=> 'Примечание'
												)
										).'
						</div>
					</div>
				</div>

			';
		$bottom =  $this->Input(	array(		'type'			=> 'submit',
											'class'			=> 'btn btn-primary',
											'value'			=> 'Сохранить'
										)
								);

		return array('top'=>$top,'content'=>$content,'bottom'=>$bottom);
	}



	// Расчеты формы оплаты
	function FormCompanyFormPayment( $p=array() ){
		$in = fieldIn($p, array('tax_system_id'));

		$top 		= 'Расчеты';

		$row = reqSlovFormPayment();

		$pole = '';
		if($in['tax_system_id']==2){
			$pole = 'coefficient2';
		}elseif($in['tax_system_id']==3){
			$pole = 'coefficient3';
		}elseif($in['tax_system_id']==4){
			$pole = 'coefficient4';
		}


		$tr = '';
		foreach($row as $i => $m){
				if($m['coefficient']){
					$checked 	= 'checked';
					$coefficient 	= ($m['coefficient']>0)? $m['coefficient'] : '';
				}else{
					$checked 	= '';
					$coefficient 	= ($pole)? $m[ $pole ] : '';
				}

				$tr .= '	<tr>
							<td>
								'.$this->Input(	array(	'type'		=> 'checkbox',
														'class'		=> '',
														'name'		=> 'check[]',
														'value'		=> $m['id'],
														'data'		=> '',
														'dopol'		=> $checked
													)
											).'
							</td>
							<td>
								'.$m['form_payment'].'
							</td>
							<td>
								'.$this->Input(	array(	'type'			=> 'text',
														'name'			=> 'coefficient'.$m['id'],
														'class'			=> 'form-control vmask_coefficient',
														'value'			=> $coefficient,
														'placeholder'	=> '0.0'
													)
											).'
							</td>
						</tr>';

		}

		$content = '	<table id="" class="table table-borderless" border="0" cellspacing="0" cellpadding="0" style="">
						<thead>
							<th></th>
							<th></th>
							<th>Коэффициент</th>
						</thead>
						<tbody>
							'.$tr.'
						</tbody>
					</table>';

		$bottom =  $this->Input(	array(		'type'			=> 'submit',
											'class'			=> 'btn btn-primary',
											'value'			=> 'Сохранить'
										)
								);

		return array('top'=>$top,'content'=>$content,'bottom'=>$bottom);
	}


	// Поделиться Заявками/Объявлениями
	function FormShareBuySell( $p=array() ){
		$in = fieldIn($p, array('company_id','flag_buy_sell','value'));

		if($in['company_id']){
			$r = reqCompany(array('id' => $in['company_id']));
		}else{
			$r = array('id'=>'','company'=>'','email'=>'');
		}

		$content = '	Отправка потребностей ('.$in['value'].')
		
					<br/>
					
					<div id="div_form_share" class="row">
						
						<div class="col-sm-4">
							<div class="form-group">
									'.$this->Input(	array(	'type'			=> 'text',
															'id'			=> 'name',
															'class'			=> 'form-control autocomplete_fashare',
															'value'			=> $r['company'],
															'placeholder'	=> 'Название'
														)
												).'
									'.$this->Input(	array(	'type'			=> 'hidden',
															'id'			=> 'company_id',
															'value'			=> $r['id']
															)
													).'
							</div>
						</div>
						
						<div class="col-sm-4">
							<div class="form-group">
								'.$this->Input(array(	'id'			=> 'email',
													'class'			=> 'form-control',
													'value'			=> $r['email'],
													'placeholder'	=> 'E-mail'
										)).'
							</div>
						</div>
						
						<div class="col-sm-4">
							<div class="form-group">
								'.$this->Input(array(	'id'			=> 'comments',
													'class'			=> 'form-control',
													'value'			=> '',
													'placeholder'	=> 'Примечание'
										)).'
							</div>
						</div>
						
					</div>
					

					'.$this->Input(	array(	'type'			=> 'button',
											'class'			=> 'btn btn-primary send_copy_share',
											'value'			=> 'Отправить E-mail',
											'data'			=> array('flag'=>1,'flag_buy_sell'=>$in['flag_buy_sell'])
										)
								).'
					'.$this->Input(	array(	'type'			=> 'button',
											'class'			=> 'btn btn-primary send_copy_share',
											'value'			=> 'Копировать ссылку',
											'data'			=> array('flag'=>2,'flag_buy_sell'=>$in['flag_buy_sell'])
										)
								).'
					
					';


		return array('content'=>$content);
	}

	// Пригласить сотрудника
	function FormInviteWorkers( $p=array() ){
		$in = fieldIn($p, array('id','flag'));
		$str = $form_interest_invite = '';
		$row_interests	= array();

		if(!$in['id']){// создаем
			$str 		= 'Приглашение в компанию';
			$r 			= array('id'=>0,'position'=>'','prava_id'=>'');
			$submit_value 	= 'Отправить приглашение';
			$st_dn		= '';
		}else{// редактируем
			if($in['flag']==1){// зарегистрированный аккаунт
					$r = reqLoginCompanyPrava(array('id'=>$in['id']));
					$login_id_invite = $r['login_id'];
					$row_interests	= reqInterestsCompanyParamGroupInterestsId(array('flag'=>2,'login_id'=>$login_id_invite));
					$form_interest_invite = $this->TrInterestsCompanyParam(array('row_interests'=>$row_interests,'flag'=>2,'login_id'=>$login_id_invite)).'
										<span class="interests-more blue-button add_interests" data-login_id="'.$login_id_invite.'" data-flag="2">
											Добавить условия
										</span>';
			}elseif($in['flag']==2){// не зарегистрированный аккаунт
					$r = reqInviteWorkers(array('id'=>$in['id']));
			}
			$submit_value 	= 'Сохранить';
			$st_dn		= 'display:none;';
		}





		$content = '	'.$str.'
		
					<br/>
					
					<div class="row">
						
						<div class="col-sm-3" style="'.$st_dn.'">
							<div class="form-group">
									'.$this->Input(	array(	'type'			=> 'text',
															'id'			=> 'name',
															'class'			=> 'form-control',
															'value'			=> '',
															'placeholder'	=> 'Обращение'
														)
												).'
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="form-group">
								'.$this->Input(	array(	'type'			=> 'text',
														'id'			=> 'position',
														'class'			=> 'form-control',
														'value'			=> $r['position'],
														'placeholder'	=> 'Должность'
													)
											).'
							</div>
						</div>
						
						<div class="col-sm-3" style="'.$st_dn.'">
							<div class="form-group">
								'.$this->Input(array(	'id'			=> 'email',
													'class'			=> 'form-control',
													'value'			=> '',
													'placeholder'	=> 'E-mail'
										)).'
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="form-group">
								'.$this->Select(	array(	'id'		=> 'prava_id',
														'class'		=> 'form-control select2',
														'value'		=> $r['prava_id'],
														'data'		=> array('placeholder'=>'Роль')
													),
												array(	'func'		=> 'reqSlovPrava',
														'param'		=> array('flag' => (PRAVA_1) ? 3 : 2 ),
														'opt'		=> array('id'=>'','name'=>''),
														'option'	=> array('id'=>'id','name'=>'nprava')
													)
											).'
							</div>
						</div>
						
					</div>
					
					'.$this->Input(	array(	'type'			=> 'hidden',
											'id'			=> 'flag',
											'value'			=> $in['flag']
										)
								).'
					'.$this->Input(	array(	'type'			=> 'hidden',
											'id'			=> 'id',
											'value'			=> $r['id']
										)
								).'
					'.$this->Input(	array(	'type'			=> 'submit',
											'class'			=> 'btn btn-primary',
											'value'			=> $submit_value
										)
								).'
					
					'.$form_interest_invite.'
					
					';


		return array('content'=>$content);
	}


	// Номенклатура
	function FormNomenclature( $p=array() ){
		$in = fieldIn($p, array('id'));

		$code_categories_buy_sell = $code_categories = $_1cnomenclature = '';

		if(!$in['id']){
			$flag = 'insert';

			$r 	= array('id'=>0,'name'=>'','categories_id'=>'','1c_nomenclature_id'=>'');

			$select_categories	= '
							<span class="part"> <span class="naming">Категории</span>
							</span>';

		}else{
			$flag = 'update';

			$r 	= reqNomenclature(array('id' => $in['id']));

			$arr = $this->CategoriesAttributeBuySell(array('nomenclature_id'	=> $r['id'],
														'flag_buy_sell'		=> 2,
														'nomenclature'		=> true,
														'categories_id'		=> $r['categories_id']	));
			$code_categories_buy_sell = $arr['code'];

			$select_categories = '<span style="font-weight:bold;color: #1cb6ff !important;">'.$r['categories'].'</span>';

			if($r['1c_nomenclature_id']>0){
				$ra = req1cNomenclature(array('id'=>$r['1c_nomenclature_id']));
				$_1cnomenclature = $ra['name_article'];
			}
		}






		$content ='
			<div class="app-form-wrapper btn-option">
			
				<label for="" class="app-q-wrapper" style="">
						<div class="app-q-wrapper-before"></div>
						<div class="form-group">
							<input type="text" id="name" name="name" class="" placeholder="Номенклатура" class="app-q" value="'.$r['name'].'">
						</div>
				</label>
				
				
				<div class="col-sm-12">
					<div class="form-group">
										'.$this->Input(array(	'type'			=> 'text',
															'id'			=> '1cnomenclature',
															'class'			=> 'form-control autocomplete_1cnomenclature',
															'value'			=> $_1cnomenclature,
															'placeholder'	=> 'Номенклатура 1C',
															'dopol'			=> 'autocomplete="new_off"'
												)).'
									</div>
								</div>
								'.$this->Input(	array(	'type'			=> 'hidden',
														'id'			=> '1c_nomenclature_id',// id из buy_sell
														'value'			=> $r['1c_nomenclature_id']
													)
								).'
				</div>
			
				<p class="app-changer">
					'.$select_categories.'
				</p>
				
				
				<div class="cat-wrapper app-cat-wrapper d-none">
					<div class="list-wrapper d-inline-flex">
						'.$this->CategoriesListElement(array('flag'=>'nomenclature','flag_buy_sell'=>2)).'
					</div>
				</div>
				
			
				
				<div id="div_categories_buy_sell">'.$code_categories_buy_sell.'</div>

				
				<div class="button-wrapper">
						<button type="submit" class="request-btn request-hidden-btn">Сохранить</button>
				</div>
				
				'.$this->Input(	array(	'type'			=> 'hidden',
										'id'			=> 'id',
										'value'			=> $r['id']
									)
							).'		
				'.$this->Input(	array(	'type'			=> 'hidden',
										'id'			=> 'categories_id',
										'value'			=> $r['categories_id']
									)
							).'
				'.$this->Input(	array(	'type'			=> 'hidden',
										'id'			=> 'flag',
										'value'			=> $flag
									)
							).'
			';


		return array('content'=>$content);
	}


	// Поисковый запрос
	function FormSearchCategories( $p=array() ){
		$in = fieldIn($p, array('id'));

		$code_categories_buy_sell = $code_categories = '';

		if(!$in['id']){
			$flag = 'insert';

			$r 	= array('id'=>0,'name'=>'','categories_id'=>'');

			$select_categories	= '
							<span class="part"> <span class="naming">Категории</span>
							</span>';

		}else{
			$flag = 'update';

			$r 	= reqSearchCategories(array('id' => $in['id']));

			$arr = $this->CategoriesAttributeBuySell(array('search_categories_id'	=> $r['id'],
														'flag_buy_sell'			=> 2,
														'search_categories'		=> true,
														'categories_id'			=> $r['categories_id']	));
			$code_categories_buy_sell = $arr['code'];

			$select_categories = '<span style="font-weight:bold;color: #1cb6ff !important;">'.$r['categories'].'</span>';
		}






		$content ='
			<div class="app-form-wrapper btn-option">
			
				<label for="" class="app-q-wrapper" style="">
						<div class="app-q-wrapper-before"></div>
						<div class="form-group">
							<input type="text" id="name" name="name" class="" placeholder="Наименование" class="app-q" value="'.$r['name'].'">
						</div>
				</label>
				

				<p class="app-changer">
					'.$select_categories.'
				</p>
				
				
				<div class="cat-wrapper app-cat-wrapper d-none">
					<div class="list-wrapper d-inline-flex">
						'.$this->CategoriesListElement(array('flag'=>'search_categories','flag_buy_sell'=>2)).'
					</div>
				</div>
				
			
				
				<div id="div_categories_buy_sell">'.$code_categories_buy_sell.'</div>

				
				<div class="button-wrapper">
						<button type="submit" class="request-btn request-hidden-btn">Сохранить</button>
				</div>
				
				'.$this->Input(	array(	'type'			=> 'hidden',
										'id'			=> 'id',
										'value'			=> $r['id']
									)
							).'		
				'.$this->Input(	array(	'type'			=> 'hidden',
										'id'			=> 'categories_id',
										'value'			=> $r['categories_id']
									)
							).'
				'.$this->Input(	array(	'type'			=> 'hidden',
										'id'			=> 'flag',
										'value'			=> $flag
									)
							).'
			';


		return array('content'=>$content);
	}


	// Склад (добавить/редактировать)
	function FormStock( $p=array() ){
		$in = fieldIn($p, array('id'));
		$str = $form_interest_invite = '';
		$row_interests	= array();

		if(!$in['id']){// создаем

			$r = array('id'=>0,'stock'=>'','address'=>'');

		}else{// редактируем

			$r = reqStock(array('id'=>$in['id']));

		}


		$content = '
					
					<div class="row">
						
						<div class="col-sm-3">
							<div class="form-group">
									'.$this->Input(	array(	'type'			=> 'text',
															'id'			=> 'stock',
															'class'			=> 'form-control',
															'value'			=> $r['stock'],
															'placeholder'	=> 'Наименование'
														)
												).'
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="form-group">
								'.$this->Input(	array(	'type'			=> 'text',
														'id'			=> 'address',
														'class'			=> 'form-control',
														'value'			=> $r['address'],
														'placeholder'	=> 'Адрес'
													)
											).'
							</div>
						</div>
						
						
					</div>
					
					'.$this->Input(	array(	'type'			=> 'hidden',
											'id'			=> 'id',
											'value'			=> $r['id']
										)
								).'
					'.$this->Input(	array(	'type'			=> 'submit',
											'class'			=> 'btn btn-primary',
											'value'			=> 'Сохранить'
										)
								).'
					
					
					';


		return array('content'=>$content);
	}



	// Продано (актив)
	function FormAssetsSell( $p=array() ){

		$in = fieldIn($p, array('buy_sell_id','company_id'));

		//if($in['company_id']){
		//	$r = reqCompany(array('id' => $in['company_id']));
		//}else{
			$r = array('id'=>'','company'=>'');
		//}

		$content = '
					<div class="row">
						
						<div class="col-sm-4">
							<div class="form-group">
									'.$this->Input(	array(	'type'			=> 'text',
															'id'			=> 'autocomplete_faassets',
															'class'			=> 'form-control autocomplete_faassets',
															'value'			=> '',
															'placeholder'	=> 'Покупатель'
														)
												).'
									'.$this->Input(	array(	'type'			=> 'hidden',
															'id'			=> 'company_id',
															'value'			=> ''
															)
													).'
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="form-group">
								'.$this->Input(	array(	'type'			=> 'text',
														'id'			=> 'cost',
														'class'			=> 'form-control',
														'value'			=> '',
														'placeholder'	=> 'Цена',
														'dopol'			=> 'required data-bv-notempty-message="Введите цену" autocomplete="off"'
													)
											).'
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								'.$this->Select(	array(	'id'		=> 'currency_id',
														'class'		=> 'form-control select2',
														'value'		=> '',
														'data'		=> array('placeholder'=>'Валюта'),
														'dopol'		=> 'data-bv-notempty-message="Выберите" required'
													),
												array(	'func'		=> 'reqSlovCurrency',
														'param'		=> array('' => ''),
														'opt'		=> array('id'=>'','name'=>''),
														'option'	=> array('id'=>'id','name'=>'currency')
													)
											).'
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								'.$this->Select(	array(	'id'		=> 'form_payment_id',
														'class'		=> 'form-control select2',
														'value'		=> '',
														'data'		=> array('placeholder'=>'Форма оплаты'),
														'dopol'		=> 'data-bv-notempty-message="Выберите" required'
													),
												array(	'func'		=> 'reqSlovFormPayment',
														'param'		=> array('' => ''),
														'opt'		=> array('id'=>'','name'=>'Форма оплаты', 'dopol'=>'selected disabled'),
														'option'	=> array('id'=>'id','name'=>'form_payment')
													)
											).'
							</div>
						</div>
						
					</div>
					

					'.$this->Input(	array(	'type'			=> 'hidden',
											'id'			=> 'buy_sell_id',
											'value'			=> $in['buy_sell_id']
										)
								).'
					'.$this->Input(	array(	'type'			=> 'submit',
											'class'			=> 'btn btn-primary',
											'value'			=> 'Сохранить'
										)
								).'
								
					
					';


		return array('content'=>$content);
	}


	// Выдать (актив)
	function FormAssetsIssue( $p=array() ){

		$in = fieldIn($p, array('buy_sell_id'));


		$content = '
					<h4>Выдача актива</h4>
		
					<div class="row">
						
						<div class="col-sm-3">
							<div class="form-group">
								'.$this->Input(array(	'type'			=> 'text',
													'id'			=> 'responsible',
													'class'			=> 'form-control autocomplete_responsible',
													'value'			=> '',
													'placeholder'	=> 'Ответственный',
													'dopol'			=> 'autocomplete="new_off"'
										)).'
							</div>
						</div>
						
						<div class="col-sm-3 bttip-wrap">
							<div class="form-group">
								'.$this->Input(array(	'type'			=> 'text',
													'id'			=> 'comments_company',
													'class'			=> 'form-control autocomplete_comments_company',
													'value'			=> '',
													'placeholder'	=> 'Участок',
													'data'			=> array('flag_buy_sell' => 4),
													'dopol'			=> 'autocomplete="off"'
										)). '
								<span class="bttip" style="display: none;">Участок</span>
							</div>
						</div>
						
					</div>
					
					'.$this->Input(	array(	'type'			=> 'hidden',
											'id'			=> 'responsible_id',
											'value'			=> ''
										)
								).'
					'.$this->Input(	array(	'type'			=> 'hidden',
											'id'			=> 'buy_sell_id',
											'value'			=> $in['buy_sell_id']
										)
								).'
					'.$this->Input(	array(	'type'			=> 'submit',
											'class'			=> 'btn btn-primary',
											'value'			=> 'Сохранить'
										)
								).'
								
					
					';


		return array('content'=>$content);
	}

	// Сдать (актив)
	function FormAssetsHandover( $p=array() ){

		$in = fieldIn($p, array('buy_sell_id'));


		$content = '
					<h4>Сдача актива</h4>
		
					<div class="row">
						
						<div class="col-sm-3">
							<div class="form-group">
								'.$this->Select(	array(	'id'		=> 'stock_id',
														'class'		=> 'form-control select2',
														'value'		=> '',
														'data'		=> array('placeholder'=>'Склад'),
														'dopol'		=> 'required="required" data-bv-notempty-message="Выберите"'
													),
												array(	'func'		=> 'reqStock',
														'param'		=> array('' => ''),
														'opt'		=> array('id'=>'','name'=>''),
														'option'	=> array('id'=>'id','name'=>'stock')
													)
											).'
							</div>
						</div>
						
					</div>
					
					'.$this->Input(	array(	'type'			=> 'hidden',
											'id'			=> 'buy_sell_id',
											'value'			=> $in['buy_sell_id']
										)
								).'					
					
					'.$this->Input(	array(	'type'			=> 'submit',
											'class'			=> 'btn btn-primary',
											'value'			=> 'Сохранить'
										)
								).'
								
					
					';


		return array('content'=>$content);
	}


	// Продано (Склад)
	function FormStockSell( $p=array() ){

		$in = fieldIn($p, array('buy_sell_id'));


		$content = '
					<div class="row">
						
						<div class="col-sm-4">
							<div class="form-group">
									'.$this->Input(	array(	'type'			=> 'text',
															'id'			=> 'autocomplete_fastock_sell',
															'class'			=> 'form-control autocomplete_fastock_sell',
															'value'			=> '',
															'placeholder'	=> 'Покупатель'
														)
												).'
									'.$this->Input(	array(	'type'			=> 'hidden',
															'id'			=> 'company_id',
															'value'			=> ''
															)
													).'
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="form-group">
								'.$this->Input(	array(	'type'			=> 'text',
														'id'			=> 'cost',
														'class'			=> 'form-control',
														'value'			=> '',
														'placeholder'	=> 'Цена',
														'dopol'			=> 'required data-bv-notempty-message="Введите цену" autocomplete="off"'
													)
											).'
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								'.$this->Select(	array(	'id'		=> 'currency_id',
														'class'		=> 'form-control select2',
														'value'		=> '',
														'data'		=> array('placeholder'=>'Валюта'),
														'dopol'		=> 'data-bv-notempty-message="Выберите" required'
													),
												array(	'func'		=> 'reqSlovCurrency',
														'param'		=> array('' => ''),
														'opt'		=> array('id'=>'','name'=>''),
														'option'	=> array('id'=>'id','name'=>'currency')
													)
											).'
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								'.$this->Select(	array(	'id'		=> 'form_payment_id',
														'class'		=> 'form-control select2',
														'value'		=> '',
														'data'		=> array('placeholder'=>'Форма оплаты'),
														'dopol'		=> 'data-bv-notempty-message="Выберите" required'
													),
												array(	'func'		=> 'reqSlovFormPayment',
														'param'		=> array('' => ''),
														'opt'		=> array('id'=>'','name'=>'Форма оплаты', 'dopol'=>'selected disabled'),
														'option'	=> array('id'=>'id','name'=>'form_payment')
													)
											).'
							</div>
						</div>
						
						<div class="col-sm-2">
							<div class="form-group">
								'.$this->Input(	array(	'type'			=> 'text',
														'name'			=> 'amount',
														'class'			=> 'form-control',
														'value'			=> '',
														'placeholder'	=> 'Количество',
														'dopol'			=> 'autocomplete="off"'
													)
											).'
							</div>
						</div>
					</div>
					

					'.$this->Input(	array(	'type'			=> 'hidden',
											'id'			=> 'buy_sell_id',
											'value'			=> $in['buy_sell_id']
										)
								).'
					'.$this->Input(	array(	'type'			=> 'submit',
											'class'			=> 'btn btn-primary',
											'value'			=> 'Сохранить'
										)
								).'
								
					
					';


		return array('content'=>$content);
	}


	// Резерв (Склад)
	function FormStockReserve( $p=array() ){

		$in = fieldIn($p, array('buy_sell_id'));


		$content = '
					<div class="row">
						<div class="col-sm-2">
							<div class="form-group">
								'.$this->Input(	array(	'type'			=> 'text',
														'name'			=> 'amount',
														'class'			=> 'form-control vmask1',
														'value'			=> '',
														'placeholder'	=> 'Количество',
														'dopol'			=> 'autocomplete="off"'
													)
											).'
							</div>
						</div>
						
						<div class="col-sm-4">
							<div class="form-group">
								'.$this->Input(array(	'id'			=> 'comments',
													'class'			=> 'form-control',
													'value'			=> '',
													'placeholder'	=> 'Примечание'
										)).'
							</div>
						</div>
						
					</div>
					

					'.$this->Input(	array(	'type'			=> 'hidden',
											'id'			=> 'buy_sell_id',
											'value'			=> $in['buy_sell_id']
										)
								).'
					'.$this->Input(	array(	'type'			=> 'submit',
											'class'			=> 'btn btn-primary',
											'value'			=> 'в Резерв'
										)
								).'
								
					
					';


		return array('content'=>$content);
	}


	// Выдать (актив)
	function FormStockIssue( $p=array() ){

		$in = fieldIn($p, array('buy_sell_id'));


		$content = '
					<h4>Выдача товара</h4>
		
					<div class="row">
					
						<div class="col-sm-2">
							<div class="form-group">
								'.$this->Input(	array(	'type'			=> 'text',
														'name'			=> 'amount',
														'class'			=> 'form-control',
														'value'			=> '',
														'placeholder'	=> 'Количество',
														'dopol'			=> 'autocomplete="off"'
													)
											).'
							</div>
						</div>
					
						<div class="col-sm-3">
							<div class="form-group">
								'.$this->Input(array(	'type'			=> 'text',
													'id'			=> 'assets',
													'class'			=> 'form-control autocomplete_assets',
													'value'			=> '',
													'placeholder'	=> 'Актив',
													'dopol'			=> 'autocomplete="new_off"'
										)).'
							</div>
						</div>
					
						
						<div class="col-sm-3">
							<div class="form-group">
								'.$this->Input(array(	'type'			=> 'text',
													'id'			=> 'responsible',
													'class'			=> 'form-control autocomplete_responsible',
													'value'			=> '',
													'placeholder'	=> 'Ответственный',
													'dopol'			=> 'autocomplete="new_off"'
										)).'
							</div>
						</div>
						
						
						
					</div>
					
					'.$this->Input(	array(	'type'			=> 'hidden',
											'id'			=> 'responsible_id',
											'value'			=> ''
										)
								).'
					'.$this->Input(	array(	'type'			=> 'hidden',
											'id'			=> 'assets_id',// id из buy_sell
											'value'			=> ''
										)
								).'
					'.$this->Input(	array(	'type'			=> 'hidden',
											'id'			=> 'buy_sell_id',
											'value'			=> $in['buy_sell_id']
										)
								).'
					'.$this->Input(	array(	'type'			=> 'submit',
											'class'			=> 'btn btn-primary',
											'value'			=> 'Сохранить'
										)
								).'
								
					
					';


		return array('content'=>$content);
	}


	// Поставщики AMO
	function FormSlovQrq( $p=array() ){

		$in = fieldIn($p, array('id'));

		if(!$p['id']){
			$r 		= array('id'=>0,'qrq'=>'','vendorid'=>'');
			$top 	= 'Добавить Поставщика';
		}else{
			$r 		= reqSlovQrq(array('id' => $p['id']));
			$top 	= 'Редактировать';
		}

		$content = '
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								'.$this->Input(	array(	'type'			=> 'text',
														'name'			=> 'name',
														'class'			=> 'form-control',
														'value'			=> $r['qrq'],
														'placeholder'	=> 'Наименование',
														'dopol'			=> 'autocomplete="off"'
													)
											).'
							</div>
						</div>
						
						<div class="col-sm-6">
							<div class="form-group">
								'.$this->Input(	array(	'type'			=> 'text',
														'name'			=> 'value',
														'class'			=> 'form-control',
														'value'			=> $r['vendorid'],
														'placeholder'	=> 'vendorid',
														'dopol'			=> 'autocomplete="off"'
										)).'
							</div>
						</div>
						
					</div>
					

					'.$this->Input(	array(	'type'			=> 'hidden',
											'id'			=> 'id',
											'value'			=> $r['id']
										)
								).'
					'.$this->Input(	array(	'type'			=> 'submit',
											'class'			=> 'btn btn-primary',
											'value'			=> 'Сохранить'
										)
								).'
								
					
					';


		return array('top'=>$top,'content'=>$content);
	}

	// Авторизации на стороних ресурсах ЭТП (AMO)
	function FormAmoAccountsEtp( $p=array() ){

		$in = fieldIn($p, array('company_id'));

		$company = reqCompany(array('id'=>$in['company_id']));

		$content = '
					<h4>Подписка на '.$company['company'].'</h4>
		
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								'.$this->Input(	array(	'type'			=> 'text',
														'id'			=> 'login',
														'class'			=> 'form-control',
														'value'			=> '',
														'placeholder'	=> 'Логин',
														'dopol'			=> 'autocomplete="off"'
													)
											).'
							</div>
						</div>
						
						<div class="col-sm-6">
							<div class="form-group">
								'.$this->Input(	array(	'type'			=> 'text',
														'id'			=> 'pass',
														'class'			=> 'form-control',
														'value'			=> '',
														'placeholder'	=> 'Пароль',
														'dopol'			=> 'autocomplete="off"'
										)).'
							</div>
						</div>
						
					</div>
					
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								'.$this->SelectSlovQrqVendorid(array('company_id'=>$in['company_id'],'qrq_id'=>0)).'
							</div>
						</div>						
					</div>
					
					'.$this->Input(	array(	'type'			=> 'button',
											'id'			=> 'button_etp_no_autorize',
											'class'			=> 'btn btn-primary connect_users_etp',
											'value'			=> 'Без Входа',
											'data'			=> array(	'company_id'=> $in['company_id'],
																		'flag'		=> 'no_autorize' ),
											'dopol'			=> 'style="display:none;"'										)
								).'			
					'.$this->Input(	array(	'type'			=> 'button',
											'class'			=> 'btn btn-primary connect_users_etp',
											'value'			=> 'Добавить',
											'data'			=> array(	'company_id	'=> $in['company_id'],
																		'flag'		=> 'add' )
										)
								).'
					
					';


		return array('content'=>$content);
	}



/*----------------------------------------------*/


	// Регистрация Модаль "PRO" шаг 1
	// Регистрация Модаль "PRO" шаг 1
	function FormModalProStep1( $p=array() ){




		$top 	= '';
        //$companyAdd = $member['profile']['flag_count_company'];
        $member = application();
        $entity = $member["menu_left"]["company_info"]["legal_entity"];
        if(!empty($entity)) {
            $content = '
							<div class="modal-body__head">
								<div class="modal__title">Подключение навыков</div>							
							</div>
							
							<div class="modal-body__content">
								<p class="form-title">
										ЕЩЕ БЫСТРЕЕ <br>
										ЕЩЕ ЭФФЕКТИВНЕЕ<br>
										ЕЩЕ УДОБНЕЕ<br>
										ПЛАТНО 
								</p>
									
									
									
				<div id="accordion" class="myaccordion">
				  <div class="card">
					<div class="card-header" id="headingPro">
					  <h2 class="mb-0">
						<span class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapsePro" aria-expanded="false" aria-controls="collapsePro">
						  PRO
							<span><a target="_blank" class="" href="/infopro">?</a></span>
						</span>
					  </h2>
					</div>
					<div id="collapsePro" class="collapse" aria-labelledby="headingPro" data-parent="#accordion" data-type_skills="1">
					  <div class="card-body">

						<div class="btn-group" role="group" aria-label="pay">
							<a type="button" class="btn btn-secondary card-pro" href="#" target="_blank">Картой</a>
							<a type="button"  id="invoice_pay" class="btn btn-secondary  invoice-pay" data-type_skills="1">По счету</a>
						</div>	
						
						<p>Стоимость подписки Pro в первые три месяца составляет ' . PRICE_PRO_3m . ' рублей в месяц, далее ' . PRICE_PRO . ' рублей в месяц и будет списываться с вашего баланса календарный месяц. 
						<strong>Отменить подписку можно в любой момент</strong> в разделе Баланс. Нажимая "Картой" или "По счету", вы подтверждаете, что ознакомились и безоговорочно соглашаетесь 
						с настоящими условиями.</p>

					  </div>
					</div>
				  </div>
				  <div class="card">
					<div class="card-header" id="headingVip">
					  <h2 class="mb-0">
						<span class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapseVip" aria-expanded="false" aria-controls="collapseVip">
						  VIP
							<span><a target="_blank" class="" href="/infovip">?</a></span>
						</span>
					  </h2>
					</div>
					<div id="collapseVip" class="collapse" aria-labelledby="headingVip" data-parent="#accordion" data-type_skills="2">
					  <div class="card-body">

						<div class="btn-group" role="group" aria-label="pay">
							<a class="btn btn-secondary card-vip" href="#" target="_blank">Картой</a>
							
							<a class="btn btn-secondary invoice-pay" id="invoice_pay" data-type_skills="2" >По счету</a>
						</div>		
						
						<p>Стоимость подписки Vip в составляет ' . PRICE_VIP . ' рублей в месяц и будет списываться с вашего баланса календарный месяц. 
						<strong>Отменить подписку можно в любой момент</strong> в разделе Баланс. Нажимая "Картой" или "По счету", вы подтверждаете, что ознакомились и безоговорочно соглашаетесь 
						с настоящими условиями. </p>

					  </div>
					</div>
				  </div>
				</div>	
								
							</div>
							<div class="modal-body__footer">
								<a type="button" class="btn" href="/profile">Пропустить</a>
							</div>
							';
        }else{
            $content = '
							<div class="modal-body__head">
								<div class="modal__title">Подключение навыков</div>							
							</div>
							
							<div class="modal-body__content">
								<p class="form-title">
										ЕЩЕ БЫСТРЕЕ <br>
										ЕЩЕ ЭФФЕКТИВНЕЕ<br>
										ЕЩЕ УДОБНЕЕ<br>
										ПЛАТНО 
								</p>
									
									
									
				<div id="accordion" class="myaccordion">
				  <div class="card">
					<div class="card-header" id="headingPro">
					  <h2 class="mb-0">
						<span class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapsePro" aria-expanded="false" aria-controls="collapsePro">
						  PRO
							<span><a target="_blank" class="" href="/infopro">?</a></span>
						</span>
					  </h2>
					</div>
					<div id="collapsePro" class="collapse" aria-labelledby="headingPro" data-parent="#accordion" data-type_skills="1">
					  <div class="card-body">

						<div class="btn-group" role="group" aria-label="pay">
							<a type="button" class="btn btn-secondary card-pro" href="#" target="_blank">Картой</a>
							
						</div>	
						
						<p>Стоимость подписки Pro в первые три месяца составляет ' . PRICE_PRO_3m . ' рублей в месяц, далее ' . PRICE_PRO . ' рублей в месяц и будет списываться с вашего баланса календарный месяц. 
						<strong>Отменить подписку можно в любой момент</strong> в разделе Баланс. Нажимая "Картой" или "По счету", вы подтверждаете, что ознакомились и безоговорочно соглашаетесь 
						с настоящими условиями.</p>

					  </div>
					</div>
				  </div>
				  <div class="card">
					<div class="card-header" id="headingVip">
					  <h2 class="mb-0">
						<span class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapseVip" aria-expanded="false" aria-controls="collapseVip">
						  VIP
							<span><a target="_blank" class="" href="/infovip">?</a></span>
						</span>
					  </h2>
					</div>
					<div id="collapseVip" class="collapse" aria-labelledby="headingVip" data-parent="#accordion" data-type_skills="2">
					  <div class="card-body">

						<div class="btn-group" role="group" aria-label="pay">
							<a class="btn btn-secondary card-vip" href="#" target="_blank">Картой</a>
							
							
						</div>		
						
						<p>Стоимость подписки Vip в составляет ' . PRICE_VIP . ' рублей в месяц и будет списываться с вашего баланса календарный месяц. 
						<strong>Отменить подписку можно в любой момент</strong> в разделе Баланс. Нажимая "Картой" или "По счету", вы подтверждаете, что ознакомились и безоговорочно соглашаетесь 
						с настоящими условиями. </p>

					  </div>
					</div>
				  </div>
				</div>	
								
							</div>
							<div class="modal-body__footer">
								<a type="button" class="btn" href="/profile">Пропустить</a>
							</div>
							';
        }
            $bottom = '
				
				<script>
			

$( document ).ready(function() {
    var modal_logo = $("#modal_logo");
	var modal = $("#vmodal");
	var modal_ar = $("#vmodal_ar");
	var modal_amo = $("#modal_amo");
	$("body").on("click", "#invoice_pay", function(){
		$("#vmodal").removeData();
		
		var type_skills = $(this).data(\'type_skills\');
		var d = $(this).data();
		console.log(type_skills)
		$.post("/FormGetInvoice", {type: type_skills}, 
			function(data){
				if(data.code){
					modal.html(data.code);
					modal.modal();
					modal.on("shown.bs.modal",
						function(e){
							$(".select2").select2({
								placeholder: function(){
									$(this).data("placeholder");
								}
							});
							
						}
						).on("hidden.bs.modal", function (e) {
								//onReload("/profile");
							});
					}
				}
				);
	});	
	});
		
				
				</script>';


		return array('top'=>$top,'content'=>$content,'bottom'=>$bottom);
	}
	// Форма Авторизации 2
	function FormAutorize2( $p=array() ){

		$code = (!LOGIN_ID)? '		 
				<div class="enter-btn">
					<p>Войти</p>
					<form id="login-form" class="form-wrapper d-none">
						<p>Вход и Регистрация</p>
						<p class="form-title">
								ЭФФЕКТИВНО <br>
								БЫСТРО<br>
								УДОБНО<br>
								БЕСПЛАТНО 
						</p>					
						<div class="form-group">
							'.$this->Input(	array(	'type'			=> 'text',
													'id'			=> 'email',
													'placeholder'	=> 'Телефон или E-mail'
												)
										).'
						</div>
						<div class="form-group">
							'.$this->Input(	array(	'type'			=> 'password',
													'id'			=> 'pass',
													'placeholder'	=> 'Пароль',
												)
										). '
						</div>
						
						<div class="_login-form-button modal_getpassword" >Получить пароль</div>
						<button type="submit" class="login-form-button login-in">Войти</button>
						
						<small>При входе вы подтверждаете согласие с политикой с политикой конфиденциальности и пользовательским соглашением</small>
					</form>
					<div class="restore-form-block form-wrapper">
						<div class="restore-form-block__title">Восстановление доступа</div>
						<div class="restore-form-block__subtitle">Введите адрес электронной почты, который был указан при регистрации.</div>
						<form id="restore-form" class="" role="form">
							<div class="form-group">
								'.$this->Input(	array(
														'type'			=> 'text',
														'id'			=> 'email',
														'class'			=> 'form-control',
														'placeholder'	=> 'Почта'
													)
											).'
							</div>
							<div class="form-group">
								'.$this->Input(	array(
														'type'			=> 'submit',
														'class'			=> 'login-form-button',
														'value'			=> 'Сбросить пароль'
													)
											). '
							</div>
						</form>
					</div>
				</div>'
				: '';

		return $code;
	}
	// Получение пароля
	function GetPasswordForm( $p=array() ){

		$in = fieldIn($p, array('phone_email'));

		$content =' 
				<p>Получение пароля</p>

				<p class="form-title">
						ЭФФЕКТИВНО <br>
						БЫСТРО<br>
						УДОБНО<br>
						БЕСПЛАТНО 
				</p>
				<div class="form-group">
					<label for="phone_email">
						<input type="text" class="phone_email" name="phone_email" placeholder="Телефон или E-mail" value="'.$in['phone_email'].'">
					</label>
				</div>
				

				<div class="btn-wrapper d-inline-flex">
					<button type="submit" class="get-code">Получить код</button>					
				</div>';

		return array('content'=>$content);
	}
	// Получение кода подтверждения
	function GetCodeForm( $p=array() ){

		$in = fieldIn($p, array('id','phone_email_code','phone_email','flag'));  //, code_type

		$flag = $in['flag'];


        $from_type1 = "";
        $from_type2 = "";


		switch ($flag) {
			case 1:
				$from_type1 = "почты";
				$from_type2 = "почту";
				break;
			case 2:
				$from_type1 = "номера";
				$from_type2 = "номер";
				break;
		}

		$content ='			
		<script>
			run_timer(); 
		</script>	
		<div class="form-wrapper2"><p class="form-title">Подтверждение '.$from_type1.'</p>
			<p class="form-title">
						ЭФФЕКТИВНО <br>
						БЫСТРО<br>
						УДОБНО<br>
						БЕСПЛАТНО 
				</p>
				<div class="form-group">
					<label for="phone_email_code">
						<input type="text" class="phone_email_code" name="phone_email_code" placeholder="Код подтверждения" inputmode="numeric" pattern="[0-9]*" value="'.$in['phone_email_code'].'">
						<input type="hidden" class="login_id" name="login_id" value="'.$in['id'].'">
					</label>
				</div>
				<div class="">
					В течении двух минут вы получите сообщение<br /> с кодом подтверждения на '.$from_type2.' '.$in['phone_email'].'
					<br />
					<small>
						<span id="again_link_text" class="show">Получить новый код можно через <span id="timer"></span></span>
						<span id="again_link" class="hidden">Получить код еще раз</span>
					</small>
				</div></div>';

		return array('content'=>$content);
	}
	// Получение кода подтверждения
	function SetNewPasswordForm( $p=array() ){
		$in = fieldIn($p, array('id','flag','active_md5'));
		//$in = fieldIn($p, array('id','new_pass','new_pass_again'));

		$top = $code_route = '';


		$code_id = '';
		if($in['id']){
			$code_id = '	<div class="form-group">
										'.$this->Input(	array(
																'type'			=> 'hidden',
																'id'			=> 'value',
																'value'			=> $in['id']
															)
													).'
								</div>';
			$code_route = '	<div class="form-group">
										'.$this->Input(	array(
																'type'			=> 'hidden',
																'id'			=> 'route',
																'value'			=> 'save_password'
															)
													).'
								</div>';
		}

		$content ='
					<div class="form-group">
						'.$this->Input(	array(	'type'			=> 'password',
												'id'			=> 'new_pass',
												'class'			=> 'form-control',
												'placeholder'	=> 'Пароль',
											)
									).'
					</div>
					<div class="form-group">
						'.$this->Input(	array(	'type'			=> 'password',
												'id'			=> 'new_pass_again',
												'class'			=> 'form-control',
												'placeholder'	=> 'Повторно пароль',
											)
									).'
					</div>
					'.$code_id.'
					'.$code_route.'					
			';
		$bottom = $this->Input(	array(
												'type'			=> 'submit',
												'class'			=> 'btn btn-primary btn-block',
												'value'			=> 'Сохранить пароль',
												'data'			=> array('route'=>'save_password')
											)
									);

		return array('top'=>$top,'content'=>$content,'bottom'=>$bottom);
	}
	// Получение кода подтверждения old
	function SetNewPasswordForm2( $p=array() ){

		$in = fieldIn($p, array('id','new_pass','new_pass_again'));  //, code_type

		$content ='<p class="form-title">Создание нового пароля</p>
				<div class="form-group">
					<label for="new_pass">
						<input type="text" class="new_pass" name="new_pass" placeholder="Введите пароль" value="'.$in['new_pass'].'">
					</label>
				</div>
				<div class="form-group">
					<label for="new_pass_again">
						<input type="text" class="new_pass_again" name="new_pass_again" placeholder="Введите пароль" value="'.$in['new_pass_again'].'">
					</label>
				</div>				
				<input type="hidden" name="login_id" value="'.$in['id'].'">
				<div class="form-group">
					<label for="save_new_password">
						<span class="btn btn-primary btn-block save_new_password" >Сохранить</span>
					</label>
				</div>				
				';

		return array('content'=>$content);
	}
	// Забыли пароль / Сменить пароль
	function FormChangePass( $p=array() ){
		$in = fieldIn($p, array('flag','active_md5'));

		$top = $code_route = '';

		if($in['flag']=='profile'){
			$top = 'Сменить пароль';
			$code_route = '	<div class="form-group">
										'.$this->Input(	array(
																'type'			=> 'hidden',
																'id'			=> 'route',
																'value'			=> 'change_pass_profile'
															)
													).'
								</div>';
		}

		$code_active_md5 = '';
		if($in['active_md5']){
			$code_active_md5 = '	<div class="form-group">
										'.$this->Input(	array(
																'type'			=> 'hidden',
																'id'			=> 'value',
																'value'			=> $in['active_md5']
															)
													).'
								</div>';
			$code_route = '	<div class="form-group">
										'.$this->Input(	array(
																'type'			=> 'hidden',
																'id'			=> 'route',
																'value'			=> 'change_pass'
															)
													).'
								</div>';
		}

		$content ='
					<div class="form-group">
						'.$this->Input(	array(	'type'			=> 'password',
												'id'			=> 'pass',
												'class'			=> 'form-control',
												'placeholder'	=> 'Пароль',
											)
									).'
					</div>
					<div class="form-group">
						'.$this->Input(	array(	'type'			=> 'password',
												'id'			=> 'pass_again',
												'class'			=> 'form-control',
												'placeholder'	=> 'Повторно пароль',
											)
									).'
					</div>
					'.$code_active_md5.'
					'.$code_route.'					
			';
		$bottom = $this->Input(	array(
												'type'			=> 'submit',
												'class'			=> 'btn btn-primary btn-block',
												'value'			=> 'Сохранить новый пароль',
												'data'			=> array('route'=>'change_pass')
											)
									);

		return array('top'=>$top,'content'=>$content,'bottom'=>$bottom);
	}
	// Подписка Отмена
	function FormCancelPodpiska( $p=array() ){
		$in = fieldIn($p, array('id'));

		$top 	= '<div class="form-wrapper2">
				<div class="modal-body__head">
					<div class="modal__title"><h3>Подписка оформлена</h3></div>							
				</div>';

		$content = '<div class="modal-body__content">
					<p>Отменить подписку?</p>
				</div>';
		$bottom = '<div class="modal-body__footer">
					<span class="btn button-grey action_podpiska" data-id="'.$in['id'].'">Отменить подписку</span>
				</div>
			</div>';

		return array('top'=>$top,'content'=>$content,'bottom'=>$bottom);
	}
	// Подтверждение платежа
	function FormCheckPayment( $p=array() ){
		$in = fieldIn($p, array('id'));

		$top 	= '<div class="form-wrapper2">
				<div class="modal-body__head">
					<div class="modal__title"><h3>Платеж получен</h3></div>							
				</div>';

		$content = '<div class="modal-body__content">
					<p>Ура! Теперь Вы можете<br> подключать Навыки и<br> экономить деньги и время!</p>
				</div>';
		$bottom = '<br><div class="modal-body__footer">
					<a href="/pro" class="btn button-blue" ">Старт</a>
				</div>
			</div>';

		return array('top'=>$top,'content'=>$content,'bottom'=>$bottom);
	}


	// Подтверждение платежа
	function FormGetInvoice( $p=array() ){
		$in = fieldIn($p, array('id', 'balance', 'type'));

		$top 	= '<div class="form-wrapper2">
				<div class="modal-body__head">
					<div class="modal__title"><h3>Формирование счета на оплату</h3></div>							
				</div>';

		$content = '<div class="invoice-form-block _form-wrapper">										
						
						
						<form id="invoice_pdf_form">
						<input type="hidden" id="login_id" name="login_id" value="'.LOGIN_ID.'" />
						<input type="hidden" id="type_skills" name="type_skills" value="' . $in['type'] .'"/>
						<input type="hidden" id="total" name="total" value="' . $in['balance'] . '"/>			
						
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<input type="text" class="form-control" id="inn" name="inn" placeholder="Введите ваш ИНН" value="" >
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<input type="text" class="form-control" id="kpp" name="kpp" placeholder="КПП" value="" >
																
								</div>		
							</div>
						</div>
						
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<input type="text" style="pointer-events:none;" class="form-control" id="companyName" name="companyName" placeholder="Наименование" value="" >
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">							
									<input type="text" class="form-control" id="ur_adr" name="ur_adr" placeholder="Юридический адрес" value="" >							
								</div>		
							</div>
						</div>
						<!--
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<input type="text" class="form-control" id="rschet" name="rschet"  placeholder="Расчетный счет" value="" >
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">							
									<input type="text" class="form-control" id="korr_schet" name="korr_schet" placeholder="Корр. счет" value="" >							
								</div>		
							</div>
						</div>	
						
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<input type="text" class="form-control" id="bik" name="bik" placeholder="БИК" value="" >
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">							
																
								</div>		
							</div>
						</div>	
						-->
				
						</form>
				
						<span id="pdf" class="btn button-blue" 
							data-inn=""							
							data-kpp=""
							data-company=""							 
							data-ur_adr=""
							data-rschet=""
							data-korr_schet=""
							data-bik=""
							target="_blank">скачать счет в формате PDF</span>	
					</div>

					';
		$bottom = '<br>

				<script>
    $("#inn").suggestions({
        token: "'. DADATA_API .'",
        type: "PARTY",
        /* Вызывается, когда пользователь выбирает одну из подсказок */
        onSelect: function(suggestion) {
            console.log(suggestion);			
			$("#inn").val(suggestion.data.inn);
			$("#companyName").val(suggestion.value);
			$("#kpp").val(suggestion.data.kpp);
			$("#ur_adr").val(suggestion.data.address.value);			

			$("#pdf").attr("data-inn", suggestion.data.inn);
			$("#pdf").attr("data-company", suggestion.value);
			$("#pdf").attr("data-kpp", suggestion.data.kpp);
			$("#pdf").attr("data-ur_adr", suggestion.data.address.value);
			
        }
    });
</script>
			</div>';

		return array('top'=>$top,'content'=>$content,'bottom'=>$bottom);
	}


	// Подписка
	function FormPodpiska( $p=array() ){
		$in = fieldIn($p, array('id','type_skills')); //type_skills - тип выбранного плана (Pro/Vip)

		$rbp = reqBalancePRO90();
		$count3 = ($rbp) ? (int) $rbp[0]['count3'] : 0;
		$skidka = ($count3 < 3) ? '(скидка 90%)' : '';

		$type_skills = $in['type_skills'];
		if($type_skills == 1){
			$name_servies = 'Pro '.$skidka;
			$total = ($count3 < 3) ? 399 : PRICE_PRO; //скидка 90% до 3-х раз включительно
		} elseif($type_skills == 2) {
			$name_servies = 'Vip';
			$total = PRICE_VIP;
		}

		$rb = reqBalance();
		$balance = (!empty($rb[0]['total'])) ? $rb[0]['total'] : 0; // текущий баланс компании
		$sum_to_pay = $total - $balance; //к оплате с учетом баланса

		if ($sum_to_pay>0){

				/* формирование ссылки для оплаты картой - yookassa */

				if(!empty($_SESSION["paymentId"]))
					{
						unset($_SESSION["paymentId"]); //если сессия paymentId не пуста, читим его
					}

				require_once './protected/source/yookassa-sdk/lib/autoload.php';
				$client = new \YooKassa\Client();
				$client->setAuth(YOOKASSA_SHOPID, YOOKASSA_API);

				$idempotenceKey = gen_uuid();

				$response = $client->createPayment(
								array(
									'amount' => array(
										'value' => $sum_to_pay,
										'currency' => 'RUB',
									),
									'confirmation' => array(
										'type' => 'redirect',
										'return_url' => DOMEN.'/pro/return_payment',
									),
									'capture' => true,
									'description' => 'Услуга “Пакет '.$name_servies.'. Для упрощения закупок и снижения цен на товары”',
									'metadata' => array(
										'order_id' => '0000',
									)
								),
					$idempotenceKey
				);


				$paymentId = $response['id'];
				$_SESSION['paymentId'] = $paymentId;
				//get confirmation url
				$confirmationUrl = $response->getConfirmation()->getConfirmationUrl();

				/* -------- */

				$s_pay = 'Для подписки Вам не хватает <span class="pay_sum">'.$sum_to_pay.'</span> рублей.<br />Пополнить Баланс можно следующими способами:<br />';
				$pay_buttons = '<div class="form-group">
						<a class="btn button-blue pay_selector" id="card_pay" data-type="card" target="_blank" href="'.$confirmationUrl.'">По карте</a>			
						<a class="btn button-blue pay_selector" id="invoice_pay" data-type="invoice" data-type_skills="'. $type_skills.'">По счету</a>
					</div>
					<script>
			

$( document ).ready(function() {
    var modal_logo = $("#modal_logo");
	var modal = $("#vmodal");
	var modal_ar = $("#vmodal_ar");
	var modal_amo = $("#modal_amo");
	$("body").on("click", "#invoice_pay", function(){
		$("#vmodal").removeData();
		
		var type_skills = $(this).data(\'type_skills\');
		var d = $(this).data();
		console.log(type_skills)
		$.post("/FormGetInvoice", {type: type_skills}, 
			function(data){
				if(data.code){
					modal.html(data.code);
					modal.modal();
					modal.on("shown.bs.modal",
						function(e){
							$(".select2").select2({
								placeholder: function(){
									$(this).data("placeholder");
								}
							});
							
						}
						).on("hidden.bs.modal", function (e) {
								//onReload("/profile");
							});
					}
				}
				);
	});	
	});
		
				
				</script>
					';
				$submit_button = '';


				//Добавление информации об оплате
				$STH = PreExecSQL(" INSERT INTO pro_invoices (company_id,summ,type_s,paymentId) VALUES (?,?,?,?); " ,
										array( COMPANY_ID,$sum_to_pay,$type_skills,$paymentId));



			} else {
				$s_pay = '';
				$pay_buttons = '';
				$submit_button = '<span class="btn button-blue action_podpiska" data-id="'.$in['id'].'" data-type_skills="'.$type_skills.'">Подписаться?</span>';

			}

		$top 	= '<div class="form-wrapper2">
				<div class="modal-body__head">
					<div class="modal__title"><h3>Подписка</h3></div>							
				</div>';

		$content = '<div class="modal-body__content">					
					<div>'.$s_pay.'</div>
					<div>'.$pay_buttons.'</div>
				</div>';
		$bottom = '<div class="modal-body__footer">
					'.$submit_button.'					
				</div>
			</div>';

		return array('top'=>$top,'content'=>$content,'bottom'=>$bottom);
	}
	// Пополнить Баланс
	function FormAddBalance( $p=array() ){
		$in = fieldIn($p, array('balance'));

		$top 	= '';

		$content = '
			<div class="modal-body__head">
				<div class="modal__title">Пополнение баланса</div>			
			</div>
			
			<div class="modal-body__content">
				<br />
				<div class="form-group">
							'.$this->Input(	array(	'type'			=> 'text',
													'id'			=> 'balance',
													'class'			=> 'form-control',
													'value'			=> '',
													'placeholder'	=> 'Сумма',
                                                    'onlyNumber'       => true
												)
										).'
				</div>					
			</div>
			<div class="modal-body__footer">
				<button type="button" class="button-blue buy_b">Оплатить</button>
				<div class="btn-group btn-group-lg nb hide" role="group" aria-label="Pay group">
				  <a type="button" class="btn btn-warning" id="card_pay" data-type="card" target="_blank" href="#">По карте</a>
				  <a type="button" class="btn btn-success" id="invoice_pay" data-type="invoice" data-sumpay="" href="#">По счету</a>
				</div>				
			</div>
			';
		$bottom = '
		<script>
			$("body").on("click", ".buy_b", function() {
			var balance = $("#balance").val();
				$(".nb").addClass("show").removeClass("hide");
				$(".buy_b").addClass("hide").removeClass("show");
				$("#balance").val(balance);
				$("#invoice_pay").attr("data-sumpay", balance);							
				
				$.post("/add_balance", {balance:balance}, function(data){	
					if(data.ok){
						$("#card_pay").attr("href", data.code);
						$("#invoice_pay");
						
					}								
				});				
			});		

$( document ).ready(function() {
    var modal_logo = $("#modal_logo");
	var modal = $("#vmodal");
	var modal_ar = $("#vmodal_ar");
	var modal_amo = $("#modal_amo");
	$("body").on("click", "#invoice_pay", function(){
		$("#vmodal").removeData();
		var balance = $("#balance").val();
		var d = $(this).data();
		console.log(d.id)
		$.post("/FormGetInvoice", {balance:balance, type: 0}, 
			function(data){
				if(data.code){
					modal.html(data.code);
					modal.modal();
					modal.on("shown.bs.modal",
						function(e){
							$(".select2").select2({
								placeholder: function(){
									$(this).data("placeholder");
								}
							});
							
						}
						).on("hidden.bs.modal", function (e) {
								//onReload("/profile");
							});
					}
				}
				);
	});	
	});
		</script>
		';

		return array('top'=>$top,'content'=>$content,'bottom'=>$bottom);
	}
	// Написать сообщение
	function FormWriteMessage( $p=array() ){
		$in = fieldIn($p, array('id'));

		$top 	= '
		<script>
			$(document).ready(function() {
				
				var readURL = function(input) {
					if (input.files && input.files[0]) {
						var reader = new FileReader();

						reader.onload = function (e) {
							$(".profile-pic").attr("src", e.target.result);
							$(".avatar").val(e.target.result);		
						}
				
						reader.readAsDataURL(input.files[0]);

					}
				}
			   
				$(".file-upload").on("change", function(){
					readURL(this);
				});
				
				$(".upload-button").on("click", function() {
				   $(".file-upload").click();
				});
			});		
		</script>		
		';

		$content = '
			<div class="modal-body__head">
				<div class="modal__title"><h3>Написать сообщение</h3></div>			
			</div>
			
			<div class="modal-body__content">
				<br />
				<div class="row">
					<div class="col-sm-5">
						<div class="form-group">
							'.$this->HtmlUsersSelectComp(array('company_id'=>COMPANY_ID)).'
						</div>	
					</div>
					<div class="col-sm-5">
						<div class="form-group">						
									'.$this->Input(	array(	'type'			=> 'text',
															'id'			=> 'subject',
															'class'			=> 'form-control',
															'value'			=> '',
															'placeholder'	=> 'Название темы'
														)
												).'
						</div>	
					</div>
					<div class="col-sm-2">
						<div class="avatar-wrapper">
							<img class="profile-pic" src="/image/profile-icon.png" />
							<div class="upload-button">
								<i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
							</div>
							<input class="file-upload" type="file" accept="image/jpeg,image/png">
							<input class="avatar" name="avatar" type="hidden">
						</div>
					</div>
				</div>	
				<div class="row">
					<div class="col-sm-1">
						<div class="form-group">
							<label for="cam" class="file none-req">
								<input type="buttom" id="cam" onclick="$$(\'upload_files_buy_sell\').fileDialog();" >
							</label>
						</div>
					</div>	
					<div class="col-sm-11">
						<div class="form-group">						
									'.$this->Input(	array(	'type'			=> 'text',
															'id'			=> 'messagetext',
															'class'			=> 'form-control',
															'value'			=> '',
															'placeholder'	=> 'Текст сообщения'
														)
												).'
						</div>						
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
					
						<div class="form-group">
							'.$this->HtmlUsersSelectNeed(array('company_id'=>COMPANY_ID)).'
						</div>					
					</div>
					<div class="col-sm-6">
					
					</div>
				</div>
			</div>
			<div class="modal-body__footer">
				<button type="button" class="button-blue write-message">Начать</button>				
			</div>
			';
		$bottom = '';

		return array('top'=>$top,'content'=>$content,'bottom'=>$bottom);
	}
	// Редактировать тему
	function FormEditTheme( $p=array() ){
		$in = fieldIn($p, array('id'));

		$rcf = reqChatFolders(array('id' => $in['id']));

		$comp_ids = json_decode($rcf[0]["companies_id"], true);
		$need_ids = json_decode($rcf[0]["needs_id"], true);
		$theme 	  = $rcf[0]["folder_name"];
		$avatar   = $rcf[0]["avatar"];

		$top 	= '
		<script>
			$(document).ready(function() {
				
				var readURL = function(input) {
					if (input.files && input.files[0]) {
						var reader = new FileReader();

						reader.onload = function (e) {
							$(".profile-pic").attr("src", e.target.result);
							$(".avatar").val(e.target.result);		
						}
				
						reader.readAsDataURL(input.files[0]);

					}
				}
			   
				$(".file-upload").on("change", function(){
					readURL(this);
				});
				
				$(".upload-button").on("click", function() {
				   $(".file-upload").click();
				});
			});		
		</script>		
		';

		$content = '
			<div class="modal-body__head">
				<div class="modal__title"><h3>Редактирование темы</h3></div>			
			</div>
			
			<div class="modal-body__content">
				<br />
				<input type="hidden" name="id" value="'.$in['id'].'">
				<div class="row">
					<div class="col-sm-5">
						<div class="form-group">
							'.$this->HtmlUsersSelectComp(array('ids'=>$comp_ids,'company_id'=>COMPANY_ID)).'
						</div>	
					</div>
					<div class="col-sm-5">
						<div class="form-group">						
									'.$this->Input(	array(	'type'			=> 'text',
															'id'			=> 'subject',
															'class'			=> 'form-control',
															'value'			=> $theme,
															'placeholder'	=> 'Название темы '
														)
												).'
						</div>	
					</div>
					<div class="col-sm-2">
						<div class="avatar-wrapper">
							<img class="profile-pic" src="'.$avatar.'" />
							<div class="upload-button">
								<i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
							</div>
							<input class="file-upload" type="file" accept="image/jpeg,image/png">
							<input class="avatar" name="avatar" type="hidden">
						</div>
					</div>
				</div>	
				<!--
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							'.$this->HtmlUsersSelectNeed(array('ids'=>$need_ids,'company_id'=>COMPANY_ID)).'
						</div>
						
					</div>
					<div class="col-sm-6">
					
					</div>
				</div>
				-->
			</div>
			<div class="modal-body__footer">
				<button type="button" class="button-blue edit-theme">Сохранить</button>				
			</div>
			';
		$bottom = '
		<script>
		
		</script>
		';

		return array('top'=>$top,'content'=>$content,'bottom'=>$bottom);
	}
	// Написать сообщение из сущностей
	function FormWriteMessageFromPotrb( $p=array() ){
		$in = fieldIn($p, array('id','url','company'));

		$top 	= '
		<script>
			$(document).ready(function() {
				
				var readURL = function(input) {
					if (input.files && input.files[0]) {
						var reader = new FileReader();

						reader.onload = function (e) {
							$(".profile-pic").attr("src", e.target.result);
							$(".avatar").val(e.target.result);		
						}
				
						reader.readAsDataURL(input.files[0]);

					}
				}
			   
				$(".file-upload").on("change", function(){
					readURL(this);
				});
				
				$(".upload-button").on("click", function() {
				   $(".file-upload").click();
				});
			});		
		</script>		
		';

		$content = '
			<div class="modal-body__head">
				<div class="modal__title"><h3>Написать сообщение</h3></div>			
			</div>
			
			<div class="modal-body__content">
				<br />
				<input type="hidden" name="id" value="'.$in['id'].'">
				<div class="row">
					<div class="col-sm-5">
						<div class="form-group">
							'.$this->HtmlUsersSelectComp(array('ids'=>array($in['company']),'company_id'=>COMPANY_ID)).'
						</div>	
					</div>
					<div class="col-sm-5">
						<div class="form-group">						
									'.$this->Input(	array(	'type'			=> 'text',
															'id'			=> 'subject',
															'class'			=> 'form-control',
															'value'			=> $in['id'],
															'placeholder'	=> 'Название темы '
														)
												).'
						</div>	
					</div>
					<div class="col-sm-2">
						<div class="avatar-wrapper">
							<img class="profile-pic" src="/image/profile-icon.png" />
							<div class="upload-button">
								<i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
							</div>
							<input class="file-upload" type="file" accept="image/jpeg,image/png">
							<input class="avatar" name="avatar" type="hidden">
						</div>
					</div>
				</div>	
				<div class="row">
					<div class="col-sm-1">
						<div class="form-group">
							<label for="cam" class="file none-req">
								<input type="buttom" id="cam" onclick="$$(\'upload_files_buy_sell\').fileDialog();" >
							</label>
						</div>
					</div>	
					<div class="col-sm-11">
						<div class="form-group">						
									'.$this->Input(	array(	'type'			=> 'text',
															'id'			=> 'messagetext',
															'class'			=> 'form-control',
															'value'			=> 'Вопрос по '.$in['id'],
															'placeholder'	=> 'Текст сообщения'
														)
												).'
						</div>						
					</div>
				</div>				
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
									'.$this->Input(	array(	'type'			=> 'text',
															'id'			=> 'url',
															'class'			=> 'form-control',
															'value'			=>  DOMEN.$in['url'],
															'placeholder'	=> 'Ссылка на необходимость'
														)
												).'	
						</div>
						
					</div>
				</div>
				
			</div>
			<div class="modal-body__footer">
				<button type="button" class="button-blue write-message_potrb">Начать</button>						
			</div>
			';
		$bottom = '
		<script>
		
		</script>
		';

		return array('top'=>$top,'content'=>$content,'bottom'=>$bottom);
	}

	// Написать тикет
	function FormWriteTicket( $p=array() ){
		$in = fieldIn($p, array('id'));

		$top 	= '';

		$content = '
			<div class="modal-body__head">
				<div class="modal__title"><h3>Написать тикет</h3></div>			
			</div>
			
			<div class="modal-body__content">
				<br />
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
						<div class="img-list" id="js-file-list"></div>
						
							<!--<label for="ticket_text" class="">Напишите об ошибке, предложениях и доработке</label>-->								
									'.$this->Textarea(array('id'			=> 'ticket_text',
															'class'			=> 'form-control',
															'value'			=> '',
															'placeholder'	=> 'Напишите об ошибке, предложениях и доработке',
															'dopol'			=> 'cols="110" rows="5"'
											)).'
						</div>		
					</div>
				</div>	
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<select name="vaznost" class="form-control">
							  <option value="" disabled selected>Важность</option>
								<option value="1">Важно</option>
								<option value="2">Средняя</option>
								<option value="3">Не важно</option>
							</select						
						</div>	
						</div>
					</div>	
					<div class="col-sm-1">
						<div class="form-row">		
							<input id="js-file-ticket" type="file" name="file[]" multiple accept=".jpg,.jpeg,.png,.gif,.mp4,.avi,.3gp">
						</div>						
					</div>	
					<div class="col-sm-4">					
						<div class="form-group">
							<select name="ticket_flag" class="form-control">
							  	<option value="1">Сообщить об ошибке</option>
								<option value="2">Дать предложение</option>								
							</select>	
						</div>					
					</div>
					<div class="col-sm-3">
						<button type="button" class="button-blue write-ticket">Отправить</button>
					</div>
					
											

				</div>

			</div>
			<div class="modal-body__footer">
								
			</div>
			';
		$bottom = '
		<script>
	$("#js-file-ticket").change(function(){
		//console.log("загрузка картинок в тикет");
		if (window.FormData === undefined) {
			console.log("В вашем браузере загрузка файлов не поддерживается");
		} else {
			var formData = new FormData();
			$.each($("#js-file-ticket")[0].files, function(key, input){
				formData.append("file[]", input);
			});
			
			$.ajax({
				type: "POST",
				url: "/upload_files_tickets",
				cache: false,
				contentType: false,
				processData: false,
				data: formData,
				dataType : "json",
				success: function(data){
					//console.log(data.mfiles);
					$.each(data.mfiles, function(index, value){
						console.log("INDEX: " + index + " VALUE: " + value);
						$("#js-file-list").append(value);
					});				

					$("#js-file").val("");				

				} 
			});
		}
	});			
		</script>
		';

		return array('top'=>$top,'content'=>$content,'bottom'=>$bottom);
	}


	// Форма ЕТП (промо)
	function FormEtpAccount( $p=array() ){

		$qrq		= new ClassQrq();

		$in = fieldIn($p, array('id'));

		$code_tr_vendorid = '';

		if(!$in['id']){
			$company = array('id'=>0,'avatar'=>'/image/profile-logo.png','legal_entity_id'=>'','phone'=>'','comments'=>'',
							'cities_id'=>'','company'=>'','tax_system_id'=>'','who1'=>'','who2'=>'','email'=>'');
			$row_lp		= array('login'=>'','pass'=>'');

			$code_tr_vendorid = 'Создайте аккаунт, после чего сможете привязать различные vendorid';

		}else{
			$company = reqCompany(array('id' => $in['id']));

			$row_lp = reqCompanyQrq(array('company_id' => $in['id']));

			$code_tr_vendorid = '	<div id="div_etp_account'.$in['id'].'">
									'.$qrq->AdminTrEtpAccountVendorid(array('company_id'=>$in['id'])).'
								</div>';

		}


		$content = '
					<h4>Настройка ЭТП</h4>
		
						<div class="profile-wrapper company-wrapper">
							<div class="profile-img">
								<!--
								<div id="div_upload_company" style="display:none;">
									<button id="upload_result_company" class="btn btn-success btn-sm upload-result" data-id="'.$company['id'].'"data-div_id="upload_demo_company" data-img_id="img_avatar_company"><span data-feather="check">Сохранить изображение</span></button>
								</div>
								-->
								<img src="'.$company['avatar'].'" id="img_avatar_company" alt="" class="rounded-circle img_avatar" height="200" data-file_id="upload_avatar_company">
								<!--
								<div id="upload_demo_company" style="visibility:hidden;"></div>
								
								<input type="file" id="upload_avatar_company" class="upload_avatar" data-div_id="upload_demo_company" data-div_upload_id="div_upload_company" style="visibility:hidden;" accept="image/jpeg,image/png">
								-->
							</div>
							<div class="profile-info-wrapper">
								<div class="profile-info">
									<div class="form-group">
										'.$this->Select(	array(	'id'		=> 'legal_entity_id',
																'class'		=> 'form-control select2',
																'value'		=> $company['legal_entity_id'],
																'data'		=> array('placeholder'=>'Правовая форма')
															),
														array(	'func'		=> 'reqSlovLegalEntity',
																'param'		=> array('' => ''),
																'opt'		=> array('id'=>'','name'=>'-'),
																'option'	=> array('id'=>'id','name'=>'legal_entity')
															)
													).'
									</div>
									<div class="form-group">
										'.$this->Input(	array(	'type'			=> 'text',
																'id'			=> 'company',
																'class'			=> 'form-control',
																'value'			=> $company['company'],
																'placeholder'	=> 'Наименование'
															)
													).'
									</div>
									<div class="form-group">
										'.$this->Input(	array(	'type'			=> 'text',
																'id'			=> 'email',
																'class'			=> 'form-control',
																'value'			=> $company['email'],
																'placeholder'	=> 'E-mail'
															)
													).'
									</div>
									<div class="form-group">
										'.$this->Input(	array(	'type'			=> 'text',
																'id'			=> 'comments',
																'class'			=> 'form-control',
																'value'			=> $company['comments'],
																'placeholder'	=> 'Комментарий'
															)
													).'
									</div>
								</div>
								
								<div class="profile-info">
									<div class="form-group">
										&nbsp;<br/>&nbsp;
									</div>
									<div class="form-group">
										'.$this->SelectCities(array('cities_id'=>$company['cities_id'])).'
									</div>
									<div class="form-group">
										'.$this->Input(	array(	'type'			=> 'tel',
																'id'			=> 'phone',
																'class'			=> 'form-control phone',
																'value'			=> $company['phone'],
																'dopol'			=> 'inputmode="tel"',
																'placeholder'	=> 'телефон'
															)
													).'
									</div>
																	
								</div>
								
								<div class="profile-info">
									<div class="form-group">
										&nbsp;<br/>&nbsp;
									</div>
									<div class="form-group">
										'.$this->SelectWhoCompany(array(	'who1'	=> $company['who1'],
																		'who2'	=> $company['who2'] )).'
									</div>	
									<div class="form-group">
										'.$this->Select(	array(	'id'		=> 'tax_system_id',
																'class'		=> 'form-control select2',
																'value'		=> $company['tax_system_id'],
																'data'		=> array('placeholder'=>'Система налогообложения')
															),
														array(	'func'		=> 'reqSlovTaxSystem',
																'opt'		=> array('id'=>'','name'=>''),
																'option'	=> array('id'=>'id','name'=>'tax_system')
															)
													).'
									</div>
								</div>
							</div>
						</div>
						
						'.$code_tr_vendorid.'
						
						через "*" добавить, если есть parent_id (второй vendorid)
						
						<div class="profile-wrapper company-wrapper">
							<div class="profile-info">
								<div class="form-group">
									'.$this->Input(	array(	'type'			=> 'text',
															'id'			=> 'login',
															'class'			=> 'form-control',
															'value'			=> $row_lp['login'],
															'placeholder'	=> 'Логин'
														)
												).'
								</div>
							</div>
							<div class="profile-info">
								<div class="form-group">
									'.$this->Input(	array(	'type'			=> 'text',
															'id'			=> 'pass',
															'class'			=> 'form-control',
															'value'			=> $row_lp['pass'],
															'placeholder'	=> 'Пароль'
														)
												).'
								</div>
							</div>
						</div>
						
						
						
						<div class="">
							'.$this->Input(	array(		'type'			=> 'hidden',
														'id'			=> 'id',
														'value'			=> $company['id']
													)
											).'			
							'.$this->Input(	array(		'type'			=> 'submit',
														'class'			=> 'save btn-blue',
														'value'			=> 'Сохранить'
													)
											).'
                        </div>
						
					';



		return array('content'=>$content);
	}


	// Форма ЕТП (Ошибки)
	function FormEtpErrors( $p=array() ){

		$qrq		= new ClassQrq();

		$in = fieldIn($p, array('id'));

		if($in['id']){
			$row = reqAmoNameErrorEtp(array('id'=>$in['id']));
		}else{
			$row = array('id'=>'','name_error'=>'','name_error_qrq'=>'','name_error_etp'=>'','next_etp'=>'');
		}

		$content = '
		
				<div style="padding:10px 30px;">
				
					<h4>Ошибки ЭТП</h4>
		
		
					<div class="form-group">
						'.$this->Input(	array(	'type'			=> 'text',
												'id'			=> 'name_error',
												'class'			=> 'form-control',
												'value'			=> $row['name_error'],
												'placeholder'	=> 'Наименование ошибки'
											)
									).'
					</div>
					
					<div class="form-group">
						'.$this->Input(	array(	'type'			=> 'text',
												'id'			=> 'name_error_qrq',
												'class'			=> 'form-control',
												'value'			=>  $row['name_error_qrq'],
												'placeholder'	=> 'Ошибка QRQ'
											)
									).'
					</div>
					
					<div class="form-group">
						'.$this->Input(	array(	'type'			=> 'text',
												'id'			=> 'name_error_etp',
												'class'			=> 'form-control',
												'value'			=>  $row['name_error_etp'],
												'placeholder'	=> 'Ошибка QWEP'
											)
									).'
					</div>
										
					<div class="form-group">
						<label for="active" class="">Оформить/Пропустить</label>
						<label class="switch">
							'.$this->Input(	array(	'type'		=> 'checkbox',
													'id'		=> 'next_etp',
													'class'		=> 'primary',
													'value'		=> ($row['next_etp']==1)? '1' 		: '',
													'dopol'		=> ($row['next_etp']==1)? 'checked' 	: ''
													)
											).'
							<span class="slider round"></span>
						</label>
					</div>
					
					<div class="">
							'.$this->Input(	array(		'type'			=> 'hidden',
														'id'			=> 'id',
														'value'			=> $row['id']
													)
											).'
							'.$this->Input(	array(		'type'			=> 'submit',
														'class'			=> 'save btn-blue',
														'value'			=> 'Сохранить'
													)
											).'
					</div>
					
					
				</div>
									
						
					';



		return array('content'=>$content);
	}


	// Форма Администрирования компании
	function FormAdminCompany( $p=array() ){

		$qrq		= new ClassQrq();

		$in = fieldIn($p, array('id'));

		$row = reqCompany(array('id'=>$in['id']));

		$content = '
		
				<div style="padding:10px 30px;">
				
					<h4>Компания id='.$in['id'].'</h4>
		
		
					<div class="form-group">
						'.$this->Input(	array(	'type'			=> 'text',
												'id'			=> 'company',
												'class'			=> 'form-control',
												'value'			=> $row['company'],
												'placeholder'	=> 'Наименование компании'
											)
									).'
					</div>
					
										
					<div class="form-group">
						<label for="active" class="">Не активна</label>
						<label class="switch">
							'.$this->Input(	array(	'type'		=> 'checkbox',
													'id'		=> 'active',
													'class'		=> 'primary',
													'value'		=> ($row['active']==1)? '1' 			: '',
													'dopol'		=> ($row['active']==2)? 'checked' 	: ''
													)
											).'
							<span class="slider round"></span>
						</label>
					</div>
					
					<div class="">
							'.$this->Input(	array(		'type'			=> 'hidden',
														'id'			=> 'id',
														'value'			=> $row['id']
													)
											).'
							'.$this->Input(	array(		'type'			=> 'submit',
														'class'			=> 'save btn-blue',
														'value'			=> 'Сохранить'
													)
											).'
					</div>
					
					
				</div>
									
						
					';



		return array('content'=>$content);
	}


	// Форма Администрирования города Етп (связка с нашими)
	function FormAdminEtpCities( $p=array() ){

		$qrq		= new ClassQrq();

		$in = fieldIn($p, array('id'));

		if(!$in['id']){
			$row = array('id'=>'','cities_id'=>'','amo_cities_id'=>'');
		}else{
			$row = reqAmoCitiesCitiesId(array('id'=>$in['id']));
		}

		$content = '
		
				<div style="padding:10px 30px;">
				
					<h4>Связать города ЭТП</h4>
		
		
					<div>
						Города QRQ
					</div>
					<div class="form-group">
						'.$this->SelectCities(array('cities_id'=>$row['cities_id'])).'
					</div>
					
					<div>
						Города Qwep
					</div>
					<div class="form-group">
						'.$this->SelectAmoCities(array('amo_cities_id'=>$row['amo_cities_id'])).'
					</div>
					
					
					<div class="">
							'.$this->Input(	array(		'type'			=> 'hidden',
														'id'			=> 'id',
														'value'			=> $row['id']
													)
											).'
							'.$this->Input(	array(		'type'			=> 'submit',
														'class'			=> 'save btn-blue',
														'value'			=> 'Сохранить'
													)
											).'
					</div>
					
					
				</div>
									
						
					';



		return array('content'=>$content);
	}


	// Форма Email исключенный из отправки
	function FormAdminNosendEmail( $p=array() ){

		$qrq		= new ClassQrq();

		$in = fieldIn($p, array('id'));

		if(!$in['id']){
			$row = array('id'=>'','email'=>'');
		}else{
			$row = reqNosendEmail(array('id'=>$in['id']));
		}

		$content = '
		
				<div style="padding:10px 30px;">
				
					<h4>Email исключенный из отправки</h4>
		
		
					<div class="form-group">
						'.$this->Input(	array(	'type'			=> 'text',
												'id'			=> 'email',
												'class'			=> 'form-control',
												'value'			=> $row['email'],
												'placeholder'	=> 'Email'
											)
									).'
					</div>
					
					<div class="">
							'.$this->Input(	array(		'type'			=> 'hidden',
														'id'			=> 'id',
														'value'			=> $row['id']
													)
											).'
							'.$this->Input(	array(		'type'			=> 'submit',
														'class'			=> 'save btn-blue',
														'value'			=> 'Сохранить'
													)
											).'
					</div>
					
					
				</div>
									
						
					';



		return array('content'=>$content);
	}







}
?>