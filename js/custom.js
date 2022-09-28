$(function(){
	$("body").append('<div class="modal fade" id="modal_logo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>'+
		'<div class="modal fade" id="modal_amo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>'+
		'<div class="modal fade" id="vmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>'+
						'<div class="modal fade" id="vmodal_ar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>');//Блоки "модальное окно"
	var modal_logo = $('#modal_logo');
	var modal = $('#vmodal');
	var modal_ar = $('#vmodal_ar');
	var modal_amo = $('#modal_amo');
	
	
	
	//выход из админки
	$("body").on("click", ".exit", function(){
		var d = $(this).data();
		$.post('/exit', {}, function(){
			onReload('/');
		}
		);
	});

	//закрыть окошко ошибки
	$(".close-icon").click(function () {
		console.log('close');
		$('#php-error').remove();
	});
	
	$(".change-acc").click(function () {
		$(".nav-account").toggleClass("show-account");
		$(".nav-menu").toggleClass("nav-menu-change");
	});


	// Поиск
	$(".autocomplete_search_mainpage , .autocomplete_search_top").keydown(function( event ) {
		if( event.which == 13  ){
			var v = $(this).val();

			SearchBuySell( v , '' , true );
				/*
				if(v.length>2 && v.length<10 ){
					SearchBuySell( v );
				}else{
					webix.message({type:"error", text:'Введены некорректные данные'});
				}
				*/
			}
		});

	$(".search_infopart").keydown(function( event ) {
		if( event.which == 13  ){
			var v = $(this).val();

			SearchBuySell( v , '' , true , 'infopart' );

		}
	});


	$("body").on("click", ".PPP", function(){
		SearchBuySell( $(this).val(), '' , false );
	});
		///

	// модальное окно Регистрация
	$("body").on("click", ".modal_registration", function(){
		ModalRegistration();
	});
	// модальное окно Получить пароль
	$("body").on("click", ".modal_getpassword", function(){			
		ModalGetPassword();			
	});	
	
	//восстановление пароля
	$('#restore-form').bootstrapValidator({
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			email: {
				validators: {
					notEmpty: {
						message: 'Введите Email'
					},
					regexp: {
						regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
						message: 'Не верный email'
					}
				}
			}
		}
	}).on('success.form.bv', function(e) {
		e.preventDefault();
		var $form = $(e.target);
		var bv = $form.data('bootstrapValidator');
		$.post("/restore", $form.serialize(), 
			function(data){
				if (data.ok) {
									//$('.div_restore').html(data.code);
									webix.message({type:"success", text:data.code});
								}else {
									webix.message({type:"error", text:data.code});
								}
								if (bv.getInvalidFields().length > 0) {
									bv.disableSubmitButtons(false);
								}
							}
							);
	});



	// модальное окно изменить
	$("body").on("click", ".modal_change_pass", function(){
		var d = $(this).data();
		$.post("/modal_change_pass", {id:d.id}, 
			function(data){
				if(data.code){
					modal.html(data.code);
					modal.modal();
					modal.on('shown.bs.modal',
						function(e){
							$(".select2").select2({
								placeholder: function(){
									$(this).data('placeholder');
								}
							});
							ChangePass();
						}
						).on('hidden.bs.modal', function (e) {
								//onReload('/profile');
							});
					}
				}
				);
	});
	

	// отменить закрытие по пустому месту
	$('.modal').on('click', function (e) {
		if (e.target.classList.contains('modal')) e.stopImmediatePropagation();
	})




	// поиск по Enter
	function searchByEnter(e) {
		if (e.which == 13){
			var v = $(".autocomplete_search_modal").val();
			//if(v.length>2 && v.length<10 ){
				if(v.length<10 ){
					SearchBuySell( v , '' , true);
				}else{
					webix.message({type:"error", text:'Введены некорректные данные'});
				}
			}
		}


		$(".searchInMessages").on("keyup change blur", function() {
			let searchStr = $('.searchInMessages').val();

			if (searchStr.length > 2) {
				$.post('/searchOnMessages', {
						text: searchStr
					},
					function(data) {
						let reg = new RegExp(searchStr, 'gi')
						let content = []

						for (let i = 0; i < data.code.length; i++) {
							let curItem = data.code[i];
							
							if (reg.test(curItem)) {
								if (searchStr != curItem.match(reg)[0]) searchStr = curItem.match(reg)[0];
								content[i] = curItem.replace(reg, `<mark>${searchStr}</mark>`)
							} else {
								content[i] = "<h5>Ничего не найдено</h5>"
							}
						}

						$('.message-wrapper').html(
							"<h1>Пользователи</h1>" + content[0] +
							"<h1>Сообщения</h1>" + content[1] +
							"<h1>Темы</h1>" + content[2]);

					}
				);
			}
			if (searchStr.length == 0) {
				$.post('/searchOnMessages', {
						"flag": "chat",
						"start_limit": 0,
						"views": "messages",
						"value": ""
					},
					function(data) {

						$('.message-wrapper').html(data.code);
						// console.log(data.code);
					}
				);

			}
		})

	// модальное окно поиск
	$("body").on("click", ".modal_search", function(){
		var d = $(this).data();
		
		$.post("/modal_search", { mclass:d.mclass , where:window.location.pathname }, 
			function(data){
				if(data.code){
					modal.html(data.code);
					$('.autocomplete_search_modal').val($('.autocomplete_search_top').val());
					modal.modal();
					modal.on('shown.bs.modal',
						function(e){
							MainJs_Search();
							AutocompleteSearch('modal');
							AutocompleteCities('search');

							$('html').on('keyup', searchByEnter);

									// Поиск
									$(".autocomplete_search_modal").keydown(function( event ) {
										if(event.which == 13){
											var group	= $('#select_group_search_buy_sell').val();
											modal.modal('hide');
											SearchBuySell( $(this).val() , group , true);
										}
									});
									
									
									$('.param_search_buy_sell').click(function () {
										var dd = $(this).data();
										$('#nav-first #flag_buy_sell').val(dd.flag_buy_sell);
										SaveSearchFilterParamCompany('modal');
									});
									$('.search-main .search-after').click(function () {
										modal.modal('hide');
									});
									$('#get_span_cities').click(function () {
										$('.location-link').addClass('choosen');
										$('.nav-location').removeClass('active')
									});
									
									// нажатии кнопки мои интересы в поиске
									$('.button_serch_flag_interest').click(function () {
										var d = $(this).data();
										if(d.flag==1){
											$('#flag_serch_interest').val(1);
											flag 	= 2;
										}else if(d.flag==2){
											$('#flag_serch_interest').val(0);
											flag	= 1;
										}
										
										$(this).attr('data-flag',flag).data('flag',flag);
										
										$('.autocomplete_search_modal').focus();
										
										SaveSearchFilterParamCompany('modal');

									}); 
									
								}
								).on('hidden.bs.modal', function (e) {
									$('html').off('keyup', searchByEnter);
									modal.modal('dispose');
								});
							}
						}
						);
	});
	


	// модальное окно Добавить/Обновить мою компанию
	$("body").on("click", ".modal_my_company", function(){
		$('#vmodal').removeData();
		var d = $(this).data();
		console.log(d.id)
		$.post("/modal_my_company", {id:d.id}, 
			function(data){
				if(data.code){
					modal.html(data.code);
					modal.modal();
					modal.on('shown.bs.modal',
						function(e){
							$(".select2").select2({
								placeholder: function(){
									$(this).data('placeholder');
								}
							});
							SaveMyCompany();
						}
						).on('hidden.bs.modal', function (e) {
								//onReload('/profile');
							});
					}
				}
				);
	});


	//сменить профиль-компанию
	$("body").on("click", ".change_account_company", function(){
		var d = $(this).data();
		$.post('/change_account_company', {id:d.id}, function(data){
			if(data.ok){
				onReload('');
			}else{
				webix.message({type:"error", text:data.code});
			}
		}
		);
	});
	
	//сменить профиль-компанию
	$("body").on("click", ".img_avatar", function(){
		var d = $(this).data();
		$('#'+d.file_id+'').click();
	});
	/*
	// Аватар/Логотип
	$uploadCrop_profile = $('#upload_demo_profile').croppie({
		enableExif: true,
		viewport: {
			width: 200,
			height: 200,
			type: 'circle'
		},
		boundary: {
			width: 300,
			height: 300
		}
	});
	$uploadCrop_company = $('#upload_demo_company').croppie({
		enableExif: true,
		viewport: {
			width: 200,
			height: 200,
			type: 'circle'
		},
		boundary: {
			width: 300,
			height: 300
		}
	});	
	*/
	
	$('.upload_avatar').on('change', function () { 
		var trgt = $(this);
		var d = trgt.data();
		var reader = new FileReader();

		trgt.closest('.profile-img').find('.error').remove();
		
		reader.onload = function (e) {
			if ( !(reader.result.includes('data:image/jpeg') || 
				reader.result.includes('data:image/png')) ) {
				trgt.closest('.profile-img').append('<span class="error">Недопустимый формат файла</span>');
			reader.abort();
			return false
		}

		$uploadCrop = $('#'+d.div_id+'').croppie({
			enableExif: true,
			viewport: {
				width: 200,
				height: 200,
				type: 'circle'
			},
			boundary: {
				width: 300,
				height: 300
			}
		});

		$uploadCrop.croppie('bind', {
			url: e.target.result
		}).then(function(){
			$("#"+d.div_id+"").css('visibility', 'visible');
			$("#"+d.div_upload_id+"").fadeIn(0);
					// obj.fadeOut(0);
				});
	}
	reader.readAsDataURL(this.files[0]);
});
	$('.upload-result').on('click', function (ev) {
		var obj = $(this);
		var d = $(this).data();
		
		
		$uploadCrop.croppie('result', {
			type: 'canvas',
			size: 'viewport'
		}).then(function (resp) {
			html = '<img src="' + resp + '" />';
			$.post('/upload_avatar', {id:d.id , image:resp}, function(data){
				if(data.ok){
					webix.message({text:data.code});
					$("#"+d.div_id+"").css('visibility', 'hidden');
					obj.parent().fadeOut(0);
					$("#"+d.img_id+"").attr('src', data.src);
					$('#'+d.div_id+'').croppie('destroy');
				}else{
					webix.message({type:"error", text:data.code});
				}
			}
			);
		});
	});
	
	
	// Сохранить данные профиля
	$('#profile-form').bootstrapValidator({
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			email: {
				validators: {
					notEmpty: {
						message: 'Введите email'
					},
					regexp: {
						regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
						message: 'Не верный email'
					}
				}
			},
			name: {
				validators: {
					notEmpty: {
						message: 'Введите Имя'
					}
								/*,
								regexp: {
									regexp: '^[a-zA-Zа-яА-Я]+$',
									message: 'Введите существующее имя'
								}*/
							}
						},
						phone: {
							validators: {
								notEmpty: {
									message: 'Введите телефон'
								}							
							}
						},
						cities_id: {
							validators: {
								notEmpty: {
									message: 'Выберите город'
								}
							}
						}
					}
				}).on('success.form.bv', function(e) {
					e.preventDefault();
					var $form = $(e.target);
					var bv = $form.data('bootstrapValidator');
					var iti = $('#profile-form #country-listbox').attr('aria-activedescendant');
					var arr = iti.split('-');

		//alert(count_phone);	
		var phone = $('#profile-form #phone').val();
		var a = phone.replace(/[^+\d]/g, "");	
		var cur_length = a.length;
		
		if(count_phone==cur_length){
			$.post("/save_profile", $form.serialize()+'&value='+arr[2], 
				function(data){


					if (data.ok) {
								//onReload('profile');
								webix.message("Сохранено");
							}else {
								webix.message({type:"error", text:data.code});
							}
							//if (bv.getInvalidFields().length > 0) {
								bv.disableSubmitButtons(false);
							//}
						}
						);
		}else{
			webix.message({type:"error", text:'Не верный телефон'});
		}
	});

	// модальное окно Заявка/Объявление
	$("body").on("click", ".modal_buy_sell", function(){
		$('#vmodal').removeData();
		
		modal.modal('dispose');
		
		
		//$('#vmodal').modal('hide');
		
		var d = $(this).data();
		
		var id = d.id;
		
		var flag_offer_share = d.flag_offer_share;
		$.post("/modal_buy_sell", { id:d.id , flag_buy_sell:d.flag_buy_sell , share_url:d.share_url, status:d.status , flag:d.flag }, 
			function(data){
				if(data.code){
					modal.html(data.code);
					modal.modal();
					modal.on('shown.bs.modal',
						function(e){
									// main.js
									$('.app-changer span').click(function () {
										$('.app-cat-wrapper, .app-location-input').addClass('d-none');
										$('.app-changer span').removeClass('active');
										$(this).addClass('active');

										if ($(this).hasClass('part')) {
											$('.app-cat-wrapper').removeClass('d-none');
											$('.none-req').addClass('req');
										} else if ($(this).hasClass('location')) {
											$('.app-location-input').removeClass('d-none');
										}
									});
									///
									

									
									getOnlyNumber();
									
									getUploadFiles('');
									
									MainJs_Search();

									$(".select2").select2({
										placeholder: function(){
											$(this).data('placeholder');
										}
									});

									Select2UsersAttributeValue();
										//изменить категорию
										$(".change_categories_buy_sell").on("change", function() {
											var d = $(this).data();
											console.log(d.flag_buy_sell)
											$.post('/change_categories_buy_sell', {id:$(this).val() , flag_buy_sell:d.flag_buy_sell}, 
												function(data){
													$('#div_categories_buy_sell').html(data.code);
													$(".select2").select2({
														placeholder: function(){
															$(this).data('placeholder');
														}
													});
													Select2UsersAttributeValue();
													MaskInput();
												}
												);
										});
										$("#change_status_buy_sell").on("click", function() {
											var dd = $(this).data();
											
											var val_submit = $('#buy_sell-form #submit23').html();
											var ds = $('#buy_sell-form #submit23').data();
											var status_submit = ds.status;
											
											$('#buy_sell-form #submit23').html( $(this).html() );
											$('#buy_sell-form #submit23').attr('data-status',dd.status).data('status', dd.status);
											
											$('#buy_sell-form #change_status_buy_sell').html( val_submit );
											$('#change_status_buy_sell').attr('data-status',status_submit).data('status', status_submit);
											$('#buy_sell-form #submit23').attr('disabled',false);
											
										});
										
										$("#unit_id1").on("change", function() {// Выбрать единицу измерения, фасовка
											var d = $(this).data();	
											var unit_id = $(this).val();

											if(unit_id==1){
												$('#div_amount_unit2').fadeIn(0);
											}else{
												$('#div_amount_unit2').fadeOut(0);
											}

											$("[name='amount1']").data('unit_id', unit_id).attr('data-unit_id', unit_id);

											MaskUnit('#buy_sell-form');
										});
										
										MaskUnit('#buy_sell-form');
										MaskInput();
										
										AutocompleteSearch('buy_sell',d.flag_buy_sell);
										AutocompleteCities('buy_sell');
										AutocompleteCommentsCompany();
										AutocompleteResponsible('buy_sell');
										AutocompleteАssets('buy_sell');
										if(d.flag_buy_sell==5){
											AutocompleteFa('stock', d.flag_buy_sell);
										}else if(d.flag_buy_sell==2){
											AutocompleteFa('company_id3', d.flag_buy_sell);
										}
										CountStatusBuysellByNomenclature(d.nomenclature_id);
										SaveBuySell(modal,flag_offer_share);
										
									}
									).on('hidden.bs.modal', function (e) {
										modal.modal('dispose');
										$('.modal-backdrop').fadeOut(0);
									});
								}
							}
							);
	});

	// Модальное окно создания карточки товара
	$("body").on("click", ".modal-add-card", function(){
		$('#vmodal').removeData();
		
		modal.modal('dispose');
		
		//$('#vmodal').modal('hide');
		
		var d = $(this).data();
		var flag_offer_share = d.flag_offer_share;
		$.post("/modal_add_card", { id:d.id , flag_buy_sell:d.flag_buy_sell , share_url:d.share_url, status:d.status , flag:d.flag }, 
			function(data){
				if(data.code){
					modal.html(data.code);
					modal.modal();
					modal.on('shown.bs.modal',
						function(e){
									// main.js
									$('.app-changer span').click(function () {
										$('.app-cat-wrapper, .app-location-input').addClass('d-none');
										$('.app-changer span').removeClass('active');
										$(this).addClass('active');

										if ($(this).hasClass('part')) {
											$('.app-cat-wrapper').removeClass('d-none');
											$('.none-req').addClass('req');
										} else if ($(this).hasClass('location')) {
											$('.app-location-input').removeClass('d-none');
										}
									});
									///
									

									
									getOnlyNumber();
									
									getUploadFiles('');
									
									MainJs_Search();

									$(".select2").select2({
										placeholder: function(){
											$(this).data('placeholder');
										}
									});

									Select2UsersAttributeValue();
										//изменить категорию
										$(".change_categories_buy_sell").on("change", function() {
											var d = $(this).data();

											$.post('/change_categories_card', {id:$(this).val() , flag_buy_sell:d.flag_buy_sell}, 
												function(data){
													$('#div_categories_buy_sell').html(data.code);
													$(".select2").select2({
														placeholder: function(){
															$(this).data('placeholder');
														}
													});
													Select2UsersAttributeValue();
													MaskInput();
												}
												);
										});
										$("#change_status_buy_sell").on("click", function() {
											var dd = $(this).data();
											
											var val_submit = $('#buy_sell-form #submit23').html();
											var ds = $('#buy_sell-form #submit23').data();
											var status_submit = ds.status;
											
											$('#buy_sell-form #submit23').html( $(this).html() );
											$('#buy_sell-form #submit23').attr('data-status',dd.status).data('status', dd.status);
											
											$('#buy_sell-form #change_status_buy_sell').html( val_submit );
											$('#change_status_buy_sell').attr('data-status',status_submit).data('status', status_submit);
											$('#buy_sell-form #submit23').attr('disabled',false);
											
										});
										
										$("#unit_id1").on("change", function() {// Выбрать единицу измерения, фасовка
											var d = $(this).data();	
											var unit_id = $(this).val();

											if(unit_id==1){
												$('#div_amount_unit2').fadeIn(0);
											}else{
												$('#div_amount_unit2').fadeOut(0);
											}

											$("[name='amount1']").data('unit_id', unit_id).attr('data-unit_id', unit_id);

											MaskUnit('#buy_sell-form');
										});
										
										MaskUnit('#buy_sell-form');
										MaskInput();
										
										AutocompleteSearch('buy_sell',d.flag_buy_sell);
										AutocompleteCities('buy_sell');
										AutocompleteCommentsCompany();
										AutocompleteResponsible('buy_sell');
										AutocompleteАssets('buy_sell');
										if(d.flag_buy_sell==5){
											AutocompleteFa('stock', d.flag_buy_sell);
										}else if(d.fla