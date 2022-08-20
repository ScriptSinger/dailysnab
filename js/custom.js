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
						console.log(data)
						for (let i = 0; i < data.code.length; i++) {
							console.log(data.code[i].search(/searchStr/g))
							console.log(data.code[i].search(searchStr))
						if (data.code[i].search(/searchStr/g))
							console.log(data.code[i].search(/searchStr/g))
						}
						let o1 = (data.code[0].length > 0) ? data.code[0] : "<h5>Ничего не найдено</h5>"
						let o2 = (data.code[1].length > 0) ? data.code[1] : "<h5>Ничего не найдено</h5>"
						let o3 = (data.code[2].length > 0) ? data.code[2] : "<h5>Ничего не найдено</h5>"
						$('.message-wrapper').html(
							"<h1>Пользователи</h1>" + o1 +
							"<h1>Сообщения</h1>" + o2 +
							"<h1>Темы</h1>" + o3);

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


	$("body").on("click", "#save_buy_sell_formnovalidate", function(){

		SaveBuySellAfter( modal , $('#buy_sell-form').serialize() , 1 , '' );

	});
	
	// форма - Предложение, Куплено, Исполнено, Возврат
	$("body").on("click", ".form_buy_sell", function(){
		var obj = $(this);
		var d = obj.data();
		
		$.post('/form_buy_sell', { id:d.id , categories_id:d.categories_id , status:d.status , value:d.value , share_url:d.share_url , flag:d.flag }, 
			function(data){
				if(data.ok){
					$('#tr_'+d.id+'').html(data.code).addClass('hidden-show');
					$('#div_form_buy_sell'+d.id+'').fadeOut(0);
					$('#div_form_buy_sell_hidden'+d.id+'').fadeIn(0);

					$.map($('#tr_' + d.id + ' .select2'), function (el) {
						if ($(`[id="${el.id}"]`).length > 1) {
							$(el).attr('id', $(el).attr('id') + d.id)
						}
					});

					$('#tr_' + d.id + ' .select2').select2({
						placeholder: function () {
							$(this).data('placeholder');
						}
					});

									$(".div_offer_dopol_attribute_visible").on("click", function () {// Предложение - показать дополнительные параметры
										var d = $(this).data();
										var d = $(this).data();
										$('#' + d.id_form + ' .div_offer_dopol_attribute').css('visibility', 'visible').css('height', '50px');
										// $(this).remove();
									});

									$('#tr_'+d.id+' .select2').select2({
										placeholder: function(){
											$(this).data('placeholder');
										}
									});
									
									$(".div_offer_dopol_attribute_visible").on("click", function() {// Предложение - показать дополнительные параметры
										var d = $(this).data();											
										$('#'+d.id_form+' .div_offer_dopol_attribute').css('visibility','visible').css('height','50px');
											// $(this).remove();
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
										MaskUnit('#offer_'+d.id+'-form');
									});								
									
									MaskUnit('#offer_'+d.id+'-form');
									
									AutocompleteFa(d.id,false);
									
									getUploadFiles(d.id);
									
									Select2UsersAttributeValue();
									
									getOnlyNumber();
									
									let curForm = $('#tr_'+d.id);
									if (curForm.find('.offer-form_sec-main').width() > 750) curForm.find('.offer-form_sec-more').addClass('active');

									let reqSel = '.select2-selection--single';
									for (let i = 0; i < $(reqSel).length; i++) {
										if ($(reqSel+`:eq(${i})`).closest('.form-group').find('.require-input').length) {
											$(reqSel+`:eq(${i})`).addClass('require-input');
										}
									}
								}else{
									webix.message({type:"error", text:data.code});
								}
							}
							);

		
	});
	
	// Скрыть форма - Предложение, Куплено, Исполнено, Возврат
	$("body").on("click", ".form_buy_sell_hidden", function(){
		var obj = $(this);
		var d = obj.data();
		$('#div_form_buy_sell'+d.id+'').fadeIn(0);
		$('#tr_'+d.id+'').html('').removeClass('hidden-show');
		$('#div_form_buy_sell_hidden'+d.id+'').fadeOut(0);
		
	});
	
	// форма купить количество
	$("body").on("click", ".get_form_buy_amount", function(){
		var obj = $(this);
		var d = $(this).data();
		$.post("/get_form_buy_amount", { id:d.id , where:d.where , amount:d.amount_recom }, 
			function(data){

				$(".div_after_form").each(function(indx, element){
					$(element).html('');
				});

				obj.parent().addClass('open');
				obj.parent().html(data.code);
				MaskUnit('#form_buy-form'+d.id+'');
			}
			);
	})	

	// модальное окно Предложения на Заявки
	$("body").on("click", ".modal_offer_buy", function(){
		$('#vmodal').removeData();
		var d = $(this).data();
		$.post("/modal_offer_buy", { id:d.id }, 
			function(data){
				if(data.code){
					modal.html(data.code);
					modal.modal();
					modal.on('shown.bs.modal',
						function(e){
							CountStatusBuysellByNomenclature(d.nomenclature_id);
						}
						).on('hidden.bs.modal', function (e) {
							modal.modal('dispose');
						});
					}
				}
				);
	});


	// действия над Заявка/Объявление
	$("body").on("click", ".action_buy_sell", function(){
		var d = $(this).data();
		var id = d.id;
		$.post("/action_buy_sell", { id:d.id , status:d.status }, 
			function(data){
				if (data.ok) {
					if(data.flag_reload){
						onReload('');
					}else{
						if(data.tr){
							$('#div_mybs'+id+'').html(data.tr);
							modal.modal('hide');
							webix.message("Сохранено");
						}
					}
				}else {
					webix.message({type:"error", text:data.code});
				}
			}
			);
	});	
	
	// удалить изображение
	$("body").on("click", ".delete_file_buy_sell", function(){
		var d = $(this).data();
		webix.confirm({
			ok: "Удалить", cancel:"Отмена",
			text: "Удалить "+d.name+" ?",
			callback:function(result){
				if(result){
					$.post( "/delete_file_buy_sell", { value:d.value }, 
						function(data){
							if(data.ok){
								$('#'+d.elem+'').fadeOut(0);
							}else{
								webix.message({type:"error", text:data.code});
							}
						}
						);
				}
			}
		});
	});
	
	// Показать телефон (объявление/предложение)
	$("body").on("click", ".view_phone", function(){
		var d = $(this).data();
		$.post("/view_phone", { id:d.id , amount:d.amount }, 
			function(data){
				if (data.ok) {
					$('#div_phone'+d.id+'').addClass('phone-show').html(data.phone);
					if(data.note){
						$('#div_note'+d.id+'').html(data.note);
					}
					if(data.buy_offer){
						$('#div_buy_offer').html(data.buy_offer);
						MaskUnit('#form_buy-form');
					}
				}else {
					webix.message({type:"error", text:data.code});
				}
			}
			);
	});
	
	// Показать телефон (объявление/предложение)
	$("body").on("click", "#click_buy", function(){
		$(this).remove();
		$('#form_buy-form').fadeIn(0);
		getOnlyNumber();
	});	
	
	
	// модальное окно История Заявка/Объявление
	$("body").on("click", ".modal_history_buy_sell", function(){
		$('#vmodal').removeData();
		var d = $(this).data();
		ModalHistoryBuySell(d.id);
	});
	
	// Подписаться/Отписаться
	$("body").on("click", ".action_subscriptions", function(){
		var obj = $(this);
		var d = obj.data();
		ActionSubscriptions(d.id,d.where);
	});
	
	// Подписаться не авторизованный
	$("body").on("click", ".action_subscriptions_no_autorize", function(){
		var obj = $(this);
		var d = obj.data();
		$.post("/action_subscriptions_no_autorize", { id:d.id }, 
			function(data){

				if (data.ok) {
					webix.message(data.code);
					obj.remove();
					$('body,html').animate({ scrollTop: 0 }, 1000);
					$('.enter-btn').click();
				}else{
					webix.message({type:"error", text:data.code});
				}

			}
			);
	});	
	
	
	
	// модальное окно Создать поставщика
	$("body").on("click", ".modal_add_fa3", function(){
		$('#vmodal_ar').removeData();
		var d = $(this).data();
		var flag_buy_sell = d.flag_buy_sell;
		var flag = d.flag;
		var id = d.id;
		
		$.post("/modal_add_fa3", {value:d.value}, 
			function(data){
				if(data.code){
					modal_ar.html(data.code);
					modal_ar.modal();
					modal_ar.on('shown.bs.modal',
						function(e){

							get_intlTelInput("phone","ru");

							$('#add_fa3-form').bootstrapValidator('destroy');
							$('#add_fa3-form').bootstrapValidator({
								feedbackIcons: {
									valid: 'glyphicon glyphicon-ok',
									invalid: 'glyphicon glyphicon-remove',
									validating: 'glyphicon glyphicon-refresh'
								},
								fields: {
									company: {
										validators: {
											notEmpty: {
												message: 'Введите наименование'
											}
										}
									}
								}
							}).on('success.form.bv', function(e) {
								e.preventDefault();
								var $form = $(e.target);
								var bv = $form.data('bootstrapValidator');
								var button=$(e.target).data('bootstrapValidator').getSubmitButton();
								var d = button.data();
								var iti = $('#add_fa3-form #country-listbox').attr('aria-activedescendant');
								var arr = iti.split('-');
												// проверка телефона на правильность ввода	
												var phone = $('#add_fa3-form #phone').val();
												var a = phone.replace(/[^+\d]/g, "");	
												var cur_length = a.length;
												
												if( ((cur_length>0)&&(count_phone==cur_length)) || (cur_length==0) ){

													$.post("/save_add_fa3", $form.serialize()+'&value='+arr[2],
														function(data){

																	var flag_ok = true;// по умолчанию
																	var entry = '';
																	var arr = data.flag.split(',');
																	arr.forEach(function(entry) {
																		if(entry=='email'){
																			var flag_ok = false;
																			bv.disableSubmitButtons(false);
																		}
																		if(entry=='phone'){
																			var flag_ok = false;
																			bv.disableSubmitButtons(false);
																		}
																	});

																	if( data.ok && flag_ok ){
																		webix.message(data.code);
																		modal_ar.modal('hide');
																		if(flag=='share'){
																			ModalShareBuySell(data.company_id,flag_buy_sell);
																		}else if(flag=='assets'){
																			$('#assets_sell-form #autocomplete_faassets').val(data.value);
																			$('#assets_sell-form #company_id').val(data.company_id);
																		}else if(flag=='stock'){
																			$('#buy_sell-form #autocomplete_fastock').val(data.value);
																			$('#buy_sell-form #company_id2').val(data.company_id);
																		}else if(flag=='stock_sell'){
																			$('#stock_sell-form #autocomplete_fastock_sell').val(data.value);
																			$('#stock_sell-form #company_id').val(data.company_id);
																		}else if(flag=='company_id3'){
																			$('#buy_sell-form #autocomplete_facompany_id3').val(data.value);
																			$('#buy_sell-form #company_id3').val(data.company_id);
																		}else{
																			$('#offer_'+flag+'-form #qwertyu').val(data.value);
																			$('#offer_'+flag+'-form #company_id').val(data.company_id);
																		}
																	}else{
																		webix.message({type:"error", text:data.code});
																	}
																	if (bv.getInvalidFields().length > 0) {
																		bv.disableSubmitButtons(false);
																	}
																}
																);
												}else{
													webix.message({type:"error", text:'Не верный телефон'});
													bv.disableSubmitButtons(false);
												}
											});		
						}
						).on('hidden.bs.modal', function (e) {
							modal_ar.modal('dispose');
							$('.modal-backdrop').fadeOut(0);
						});
					}
				}
				);
	});

	// модальное окно Создать Ответственного
	$("body").on("click", ".modal_add_responsible", function(){
		modal_ar.removeData();
		var d = $(this).data();
		var flag = d.flag;
		$.post("/modal_add_responsible", {value:d.value}, 
			function(data){
				if(data.code){
					modal_ar.html(data.code);
					modal_ar.modal();
					modal_ar.on('shown.bs.modal',
						function(e){
							$('#add_responsible-form').bootstrapValidator('destroy');
							$('#add_responsible-form').bootstrapValidator({
								feedbackIcons: {
									valid: 'glyphicon glyphicon-ok',
									invalid: 'glyphicon glyphicon-remove',
									validating: 'glyphicon glyphicon-refresh'
								},
								fields: {
									company: {
										validators: {
											notEmpty: {
												message: 'Введите ответственного'
											}
										}
									}
								}
							}).on('success.form.bv', function(e) {
								e.preventDefault();
								var $form = $(e.target);
								var bv = $form.data('bootstrapValidator');
								var button=$(e.target).data('bootstrapValidator').getSubmitButton();
								var d = button.data();
								$.post("/save_add_responsible", $form.serialize(),
									function(data){
										if(data.ok){
											webix.message(data.code);
											modal_ar.modal('hide');
											if(flag=='buy_sell'){
												$('#buy_sell-form #responsible').val(data.value);
												$('#buy_sell-form #responsible_id').val(data.company_id);
											}else if(flag=='assets_issue'){
												$('#assets_issue-form #responsible').val(data.value);
												$('#assets_issue-form #responsible_id').val(data.company_id);
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
						}
						).on('hidden.bs.modal', function (e) {
							modal.modal('dispose');
							$('.modal-backdrop').fadeOut(0);
						});
					}
				}
				);
	});
	

	// Оповещение - сохранение
	$("body").on("change", ".save_notification", function(){
		var d = $(this).data();
		$.post("/save_notification", { notification_id:d.notification_id , id:$(this).val() , flag:d.flag }, 
			function(data){
				if (data.ok) {
					webix.message(data.code);
				}else {
					webix.message({type:"error", text:data.code});
				}
			}
			);
	});


	// Интересы - добавить условие
	$("body").on("click", ".add_interests", function(){
		var obj = $(this);
		var d = obj.data();
		$.post("/add_interests", {login_id:d.login_id,flag:d.flag}, 
			function(data){
				obj.before(data.code);
				Select2InterestsCompanyParam();
				Select2InterestsCompanyParamCities();
			}
			);
	});
	

	// модальное окно - Расчеты формы оплаты 
	$("body").on("click", ".modal_company_form_payment", function(){
		$('#vmodal').removeData();
		var d = $(this).data();
		$.post("/modal_company_form_payment", {tax_system_id:$('#tax_system_id').val()}, 
			function(data){
				if(data.code){
					modal.html(data.code);
					modal.modal();
					modal.on('shown.bs.modal',
						function(e){

									//$('#company_form_payment-form').bootstrapValidator('destroy');
									
									
									$('#company_form_payment-form').bootstrapValidator({
											/*feedbackIcons: {
												valid: 'glyphicon glyphicon-ok',
												invalid: 'glyphicon glyphicon-remove',
												validating: 'glyphicon glyphicon-refresh'
											},
											fields: {
											}*/
										}).on('success.form.bv', function(e) {
											e.preventDefault();
											var $form = $(e.target);
											var bv = $form.data('bootstrapValidator');
											$.post("/save_company_form_payment", $form.serialize(),
												function(data){
													if(data.ok){
														webix.message(data.code);
														modal.modal('hide');
													}else{
														webix.message({type:"error", text:data.code});
													}
													bv.disableSubmitButtons(false);
												}
												);
										});
										
										MaskInput();
									}
									).on('hidden.bs.modal', function (e) {
										modal.modal('dispose');
									});
								}
							}
							);
	});
	
	function cancelClickForShare(e) {
		if (e.target.type != 'checkbox') {
			e.preventDefault();
			return false;
		}
	}
	$('.share_buy_sell[data-flag="2"], button').on('click', function() {
		$('body').off('click', cancelClickForShare);
	})
	// показать checkbox Поделиться
	$("body").on("click", ".share_buy_sell", function(){

		var d = $(this).data();

		if(d.flag==1){
			$('body').on('click', cancelClickForShare);
			$('.checkbox_share').fadeIn(0);
		} else if(d.flag==2){
			$('.checkbox_share').fadeOut(0);
		}
	});

	
	// выделить checkbox Поделиться
	$("body").on("click", ".checkbox_checking_buysell", function(){
		var el = $(this);
		var d = el.data();
		var checked;
		var flag;
		if(d.flag==1){
			checked = true;
			flag 	= 2;
		}else if(d.flag==2){
			checked = false;
			flag	= 1;
		}
		
		$("#request .checkbox_share").each(function(indx, element){
			$(element).prop({checked: checked});
		});

		$(this).attr('data-flag',flag).data('flag',flag);

		$('body').on('click', '.checkbox_share', function() {
			if (d.flag == 2 ) {
				el.attr('data-flag', '1');
				d.flag = 1;
				el.prop({checked: false});
			}
		});
	});	
	
	// снимать чекбокс "выбрать все" у Поделиться
	$('body').on('change', '.checkbox_share', function() {
		if ($('.checkbox_share:checked').length) {
			$('.modal_share_buy_sell').removeClass('inactive')
		} else {
			$('.modal_share_buy_sell').addClass('inactive')
		}
	});

	// не открываться модалку Поделиться, пока не выбран хотя бы 1 чекбокс
	$('body').on('click', '.request-btn.inactive', function(e) {
		e.stopImmediatePropagation();
	});
	
	
	// модальное окно - Поделиться
	$("body").on("click", ".modal_share_buy_sell", function(){
		var d = $(this).data();
		ModalShareBuySell('',d.flag_buy_sell);
	});
	
	// Поделиться отправка/копия
	$("body").on("click", ".send_copy_share", function(){
		var d = $(this).data();
		var st = '';
		$("#request .checkbox_share").each(function(indx, element){
			var dd = $(element).data();
			if ($(element).prop('checked')){
				st=st+dd.id+',';
			}
		});
		st = st.slice(0,-1);
		var email 		= $('#div_form_share #email').val();
		var name 		= $('#div_form_share #name').val();
		var company_id 	= $('#div_form_share #company_id').val();
		var comments 	= $('#div_form_share #comments').val();

		$.post("/send_copy_share", { value:st , flag:d.flag , flag_buy_sell:d.flag_buy_sell ,
			company_id:company_id , email:email , name:name , comments:comments }, 
			function(data){
				if(!data.error){
					$('#vmodal div.modal-body').html(data.code);
					if(d.flag==1){
									//
								}else if(d.flag==2){
									myCopyText(data.url);
								}
							}else{
								webix.message({type:"error", text:data.error});
							}
						}
						);
	});
	
	
	// Группировка "Предложения"
	$("body").on("click", ".view_grouping", function(){
		var obj = $(this);
		var d = obj.data();
		var flag_tr = d.flag_tr;
		$.post("/view_grouping", { value:d.value , flag:d.flag , parent_id:d.parent_id , 
			flag_limit:d.flag_limit , start_limit:d.start_limit }, 
			function(data){
				if(flag_tr==3){
					obj.parent().parent().append(data.code);
				}else if(flag_tr==2){
					obj.parent().parent().html(data.code);
				}else{
					$('#tr_'+d.id+'').html(data.code).slideDown(700);
					$('#view_grouping'+d.id+'').fadeOut(0);
					$('#close_view_grouping'+d.id+'').fadeIn(0);
				}
			}
			);
	});
	
	// Группировка - свернуть "Предложения"
	$("body").on("click", ".close_view_grouping", function(){
		var d = $(this).data();
		$('#view_grouping'+d.id+'').fadeIn(0);
		$('#close_view_grouping'+d.id+'').fadeOut(0);
		$('#tr_'+d.id+'').slideUp(700);
	});
	
	
	// Группировка "Мои заявки"
	$("body").on("click", ".view_group", function(){
		var obj = $(this);
		var d = obj.data();
		var flag_tr = d.flag_tr;
			var url = window.location; // or window.location.href for current url
			let searchParams = new URLSearchParams(url.search);
			var value = searchParams.get('value');
			$.post("/view_group_mybuysell", { 	group:d.group , group_id:d.group_id , flag_buy_sell:2 , 
				where:window.location.pathname , value:value }, 
				function(data){
					if(flag_tr==3){
						obj.parent().parent().append(data.code);
					}else if(flag_tr==2){
						obj.parent().parent().html(data.code);
					}else{
						$('#tr_'+d.id+'').html(data.code).slideDown(700);
						$('#view_group'+d.id+'').fadeOut(0);
						$('#close_group'+d.id+'').fadeIn(0);
					}
				}
				);
		});
	
	// Группировка - свернуть "Мои заявки"
	$("body").on("click", ".close_group", function(){
		var d = $(this).data();
		$('#view_group'+d.id+'').fadeIn(0);
		$('#close_group'+d.id+'').fadeOut(0);
		$('#tr_'+d.id+'').slideUp(700);
	});
	
	
	// Сортировка - "Мои заявки"
	$("body").on("click", ".sort_arrow", function(){
		var d = $(this).data();
		if(d.flag=='down'){
			$('#sort_arrow_up').fadeIn(0);
			$('#sort_arrow_down').fadeOut(0);
			$('#sort_12').val(1);
		}else if(d.flag=='up'){
			$('#sort_arrow_up').fadeOut(0);
			$('#sort_arrow_down').fadeIn(0);
			$('#sort_12').val(2);
		}
		SaveSearchFilterParamCompany('modal');
	});
	
	// Сортировка - "Мои заявки"
	$("body").on("change", "#select_sort_search_buy_sell", function(){
		SaveSearchFilterParamCompany('modal');
	});
	
	// Где поиск 
	$("body").on("change", "#select_flag_search_where_page", function(){
		SaveSearchFilterParamCompany('modal');
	});
	

	// модальное окно Пригласить сотрудника
	$("body").on("click", ".modal_invite_workers", function(){
		$('#vmodal').removeData();
		var d = $(this).data();
		$.post("/modal_invite_workers", {id:d.id , flag:d.flag}, 
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

							Select2InterestsCompanyParam();
							Select2InterestsCompanyParamCities();


							$('#invite_workers-form').bootstrapValidator('destroy');
							$('#invite_workers-form').bootstrapValidator({
								feedbackIcons: {
									valid: 'glyphicon glyphicon-ok',
									invalid: 'glyphicon glyphicon-remove',
									validating: 'glyphicon glyphicon-refresh'
								},
								fields: {
									name: {
										validators: {
											notEmpty: {
												message: 'Введите'
											}
										}
									},
									position: {
										validators: {
											notEmpty: {
												message: 'Введите'
											}
										}
									},
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
									prava_id: {
										validators: {
											notEmpty: {
												message: 'Выберите роль'
											}
										}
									}
								}
							}).on('success.form.bv', function(e) {
								e.preventDefault();
								var $form = $(e.target);
								var bv = $form.data('bootstrapValidator');
								$.post("/save_invite_workers", $form.serialize(),
									function(data){
										if(data.ok){
											webix.message(data.code_w);
											if(d.id){
												onReload('');
											}else{
												$('#button_miw').before(data.code);
												modal.modal('hide');
											}
										}else{
											webix.message({type:"error", text:data.code_w});
										}
										if (bv.getInvalidFields().length > 0) {
											bv.disableSubmitButtons(false);
										}
									}
									);
							});		
						}
						).on('hidden.bs.modal', function (e) {
							modal.modal('dispose');
						});
					}
				}
				);
	});
	
	// удалить сотрудника
	$("body").on("click", ".delete_invite_workers", function(){
		var d = $(this).data();
		webix.confirm({
			ok: d.question, cancel:"Отмена",
			text: d.question+" "+d.name+" ?",
			callback:function(result){
				if(result){
					$.post( "/delete_invite_workers", { id:d.id , flag:d.flag }, 
						function(data){
							if(data.ok){
								if(d.flag=='exit'){
									onReload('');
								}else{
									$('#div_workers'+d.id+'').remove();
								}
							}else{
								webix.message({type:"error", text:data.code});
							}
						}
						);
				}
			}
		});
	});
	
	
	// модальное окно Склад (добавить/редактировать)
	$("body").on("click", ".modal_stock", function(){
		$('#vmodal').removeData();
		var d = $(this).data();
		$.post("/modal_stock", {id:d.id}, 
			function(data){
				if(data.code){
					modal.html(data.code);
					modal.modal();
					modal.on('shown.bs.modal',
						function(e){


							$('#stock-form').bootstrapValidator('destroy');
							$('#stock-form').bootstrapValidator({
								feedbackIcons: {
									valid: 'glyphicon glyphicon-ok',
									invalid: 'glyphicon glyphicon-remove',
									validating: 'glyphicon glyphicon-refresh'
								},
								fields: {
									name: {
										validators: {
											notEmpty: {
												message: 'Введите'
											}
										}
									},
									address: {
										validators: {
											notEmpty: {
												message: 'Введите'
											}
										}
									}
								}
							}).on('success.form.bv', function(e) {
								e.preventDefault();
								var $form = $(e.target);
								var bv = $form.data('bootstrapValidator');
								$.post("/save_stock", $form.serialize(),
									function(data){
										if(data.ok){
											onReload('');
										}else{
											webix.message({type:"error", text:data.code_w});
										}
										if (bv.getInvalidFields().length > 0) {
											bv.disableSubmitButtons(false);
										}
									}
									);
							});		
						}
						).on('hidden.bs.modal', function (e) {
							modal.modal('dispose');
						});
					}
				}
				);
	});
	
	// модальное окно Продано (актив)
	$("body").on("click", ".modal_assets_sell", function(){
		var d = $(this).data();
		ModalAssetsSell(d.id,0);
	});
	
	// модальное окно Выдать (актив)
	$("body").on("click", ".modal_assets_issue", function(){
		var d = $(this).data();
		$.post("/modal_assets_issue", { id:d.id }, 
			function(data){

				if (data.code) {

					modal.html(data.code);

					modal.modal();
					modal.on('shown.bs.modal',
						function (e) {

							AutocompleteResponsible('assets_issue');
							AutocompleteCommentsCompany();

							$('#assets_issue-form').bootstrapValidator('destroy');
							$('#assets_issue-form').bootstrapValidator({
								feedbackIcons: {
									valid: 'glyphicon glyphicon-ok',
									invalid: 'glyphicon glyphicon-remove',
									validating: 'glyphicon glyphicon-refresh'
								},
								fields: {
									responsible: {
										validators: {
											notEmpty: {
												message: 'Введите'
											}
										}
									},
									cities: {
										validators: {
											notEmpty: {
												message: 'Введите'
											}
										}
									}
								}
							}).on('success.form.bv', function(e) {
								e.preventDefault();
								var $form = $(e.target);
								var bv = $form.data('bootstrapValidator');
								$.post("/save_assets_issue", $form.serialize(),
									function(data){
										if(data.ok){
											onReload('');
										}else{
											webix.message({type:"error", text:data.code});
										}
										if (bv.getInvalidFields().length > 0) {
											bv.disableSubmitButtons(false);
										}
									}
									);
							});

						}
						).on('hidden.bs.modal', function (e) {
							modal.modal('dispose');
						});
					}
					
				}
				);
	});
	
	
	// модальное окно Сдать (актив)
	$("body").on("click", ".modal_assets_handover", function(){
		var d = $(this).data();
		$.post("/modal_assets_handover", { id:d.id }, 
			function(data){

				if (data.code) {

					modal.html(data.code);

					modal.modal();
					modal.on('shown.bs.modal',
						function (e) {

							$(".select2").select2({
								placeholder: function(){
									$(this).data('placeholder');
								}
							});

							$('#assets_handover-form').bootstrapValidator('destroy');
							$('#assets_handover-form').bootstrapValidator({
								feedbackIcons: {
									valid: 'glyphicon glyphicon-ok',
									invalid: 'glyphicon glyphicon-remove',
									validating: 'glyphicon glyphicon-refresh'
								},
								fields: {
									stock_id: {
										validators: {
											notEmpty: {
												message: 'Выберите'
											}
										}
									}
								}
							}).on('success.form.bv', function(e) {
								e.preventDefault();
								var $form = $(e.target);
								var bv = $form.data('bootstrapValidator');
								$.post("/save_assets_handover", $form.serialize(),
									function(data){
										if(data.ok){
											onReload('');
										}else{
											webix.message({type:"error", text:data.code});
										}
										if (bv.getInvalidFields().length > 0) {
											bv.disableSubmitButtons(false);
										}
									}
									);
							});	

						}
						).on('hidden.bs.modal', function (e) {
							modal.modal('dispose');
						});
					}
					
				}
				);
	});
	
	
	// Переместить на склад (Склад)
	$("body").on("click", ".action_stock_move", function(){
		var d = $(this).data();
		webix.confirm({
			ok: "Переместить", cancel:"Отмена",
			text: "Переместить в "+d.categories_id+" ?",
			callback:function(result){
				if(result){
					$.post( "/save_stock_move", { buy_sell_id:d.id , stock_id:d.stock_id }, 
						function(data){
							if(data.ok){
								onReload('');
							}else{
								webix.message({type:"error", text:data.code});
							}
						}
						);
				}
			}
		});
	});
	
	// подгрузить Товары на складе закрепленные за номенклатурой
	$("body").on("click", ".action_stock_nomenclature", function(){
		var obj = $(this);
		var d = obj.data();
		$.post("/action_stock_nomenclature", { nomenclature_id:d.nomenclature_id }, 
			function(data){
				$('#tr_'+d.id+'').html(data.code).slideDown(700);
			}
			);
	});
	
	// модальное окно Продано (Склад)
	$("body").on("click", ".modal_stock_sell", function(){
		var d = $(this).data();
		ModalStockSell(d.id,0);
	});
	
	// модальное окно Резерв (Склад)
	$("body").on("click", ".modal_stock_reserve", function(){
		var d = $(this).data();
		$.post("/modal_stock_reserve", { id:d.id }, 
			function(data){

				if (data.code) {

					modal.html(data.code);

					modal.modal();
					modal.on('shown.bs.modal',
						function (e) {

							MaskInput();

							$('#stock_reserve-form').bootstrapValidator('destroy');
							$('#stock_reserve-form').bootstrapValidator({
								feedbackIcons: {
									valid: 'glyphicon glyphicon-ok',
									invalid: 'glyphicon glyphicon-remove',
									validating: 'glyphicon glyphicon-refresh'
								},
								fields: {
									amount: {
										validators: {
											notEmpty: {
												message: 'Введите'
											}
										}
									}
								}
							}).on('success.form.bv', function(e) {
								e.preventDefault();
								var $form = $(e.target);
								var bv = $form.data('bootstrapValidator');
								$.post("/save_stock_reserve", $form.serialize(),
									function(data){
										if(data.ok){
											onReload('');
										}else{
											webix.message({type:"error", text:data.code});
										}
										if (bv.getInvalidFields().length > 0) {
											bv.disableSubmitButtons(false);
										}
									}
									);
							});	

						}
						).on('hidden.bs.modal', function (e) {
							modal.modal('dispose');
						});
					}
					
				}
				);
	});
	
	
	// модальное окно Выдача (Склад)
	$("body").on("click", ".modal_stock_issue", function(){
		var d = $(this).data();
		$.post("/modal_stock_issue", { id:d.id }, 
			function(data){

				if (data.code) {

					modal.html(data.code);

					modal.modal();
					modal.on('shown.bs.modal',
						function (e) {

							AutocompleteResponsible('stock_issue');
							AutocompleteАssets('stock_issue');


							$('#stock_issue-form').bootstrapValidator('destroy');
							$('#stock_issue-form').bootstrapValidator({
								feedbackIcons: {
									valid: 'glyphicon glyphicon-ok',
									invalid: 'glyphicon glyphicon-remove',
									validating: 'glyphicon glyphicon-refresh'
								},
								fields: {
									amount: {
										validators: {
											notEmpty: {
												message: 'Введите'
											}
										}
									},
									responsible: {
										validators: {
											notEmpty: {
												message: 'Введите'
											}
										}
									},
									assets: {
										validators: {
											notEmpty: {
												message: 'Введите'
											}
										}
									}
								}
							}).on('success.form.bv', function(e) {
								e.preventDefault();
								var $form = $(e.target);
								var bv = $form.data('bootstrapValidator');
								$.post("/save_stock_issue", $form.serialize(),
									function(data){
										if(data.ok){
											onReload('');
										}else{
											webix.message({type:"error", text:data.code});
										}
										if (bv.getInvalidFields().length > 0) {
											bv.disableSubmitButtons(false);
										}
									}
									);
							});

						}
						).on('hidden.bs.modal', function (e) {
							modal.modal('dispose');
						});
					}
					
				}
				);
	});
	
	
	// Возврат товара (Склад отмена выдачи)
	$("body").on("click", ".save_stock_issue_cancel", function(){
		var d = $(this).data();
		$.post("/save_stock_issue_cancel", { buy_sell_id:d.id },
			function(data){
				if(data.ok){
					onReload('');
				}else{
					webix.message({type:"error", text:data.code});
				}
			}
			);
	});
	
	
	// Перемещение в активы (Склад)
	$("body").on("click", ".action_stock_move_assets", function(){
		var d = $(this).data();
		webix.confirm({
			ok: "Добавить", cancel:"Отмена",
			text: "Добавить в активы ?",
			callback:function(result){
				if(result){
					$.post( "/action_stock_move_assets", { buy_sell_id:d.id }, 
						function(data){
							if(data.ok){
								onReload('');
							}else{
								webix.message({type:"error", text:data.code});
							}
						}
						);
				}
			}
		});
	});
	
	
	
	/*
	// модальное окно QRQ по заявкам
	$("body").on("click", ".modal_qrq_buy_sell", function(){
				ModalQrqBuySell();
	});
	*/


	
	// модальное окно Номенклатура
	$("body").on("click", ".modal_nomenclature", function(){
		$('#vmodal').removeData();
		var d = $(this).data();
		var where = d.where;
		$.post("/modal_nomenclature", { id:d.id }, 
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
									
									Autocomplete1cnomenclature();
									
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
											$.post('/change_categories_buy_sell', {id:$(this).val() , flag_buy_sell:d.flag_buy_sell}, 
												function(data){
													$('#div_categories_buy_sell').html(data.code);
													$(".select2").select2({
														placeholder: function(){
															$(this).data('placeholder');
														}
													});
													Select2UsersAttributeValue();
												}
												);
										});
										
										$('#nomenclature-form').bootstrapValidator('destroy');
										$('#nomenclature-form').bootstrapValidator({
											feedbackIcons: {
												valid: 'glyphicon glyphicon-ok',
												invalid: 'glyphicon glyphicon-remove',
												validating: 'glyphicon glyphicon-refresh'
											},
											fields: {
												name: {
													validators: {
														notEmpty: {
															message: 'Введите'
														}
													}
												}
											}
										}).on('success.form.bv', function(e) {
											e.preventDefault();
											var $form = $(e.target);
											var bv = $form.data('bootstrapValidator');
											var button=$(e.target).data('bootstrapValidator').getSubmitButton();
											var d = button.data();
											bv.disableSubmitButtons(false);// УБРАТЬ
											var categories_id=$('#categories_id').val();
											if(categories_id>0){
												
												
												$.post("/save_nomenclature", $form.serialize(),
													function(data){
														if(data.ok){
															if(where=='logo_notification'){
																modal.modal('hide');
																if(data.flag_1c){
																	$('#div_no_1cnomenclature'+data.id+'').remove();
																}
															}else{
																onReload('');
															}
														}else{
															webix.message({type:"error", text:data.code});
														}
														if (bv.getInvalidFields().length > 0) {
															bv.disableSubmitButtons(false);
														}
													}
													);
												
											}else{
												webix.message({type:"error", text:"Выберите Категорию"});
											}
										});
									}
									).on('hidden.bs.modal', function (e) {
										modal.modal('dispose');
									});
								}
							}
							);
	});
	
	
	// удалить номенклаиуру
	$("body").on("click", ".delete_nomenclature", function(){
		var d = $(this).data();
		webix.confirm({
			ok: "Удалить", cancel:"Отмена",
			text: "Удалить "+d.name+" ?",
			callback:function(result){
				if(result){
					$.post( "/delete_nomenclature", { id:d.id }, 
						function(data){
							if(data.ok){
								$('#'+d.elem+'').remove();
							}else{
								webix.message({type:"error", text:data.code});
							}
						}
						);
				}
			}
		});
	});
	
	
	// обновить этп у заявки
	$("body").on("click", ".qrq_update_in_buy_sell", function(){
		var d = $(this).data();
		$.post( "/qrq_update_in_buy_sell", { id:d.id }, 
			function(data){
				if(data.ok){
					webix.message(data.code);
				}else{
					webix.message({type:"error", text:data.code});
				}
			}
			);
	});
	
	
	$("body").on("click", ".edit_buy_sell_note", function(){
		var d = $(this).data();
		if(d.flag==1){
			$('#div_note_view').fadeOut(0);
			$('#div_note_edit').fadeIn(0);
			$(this).attr('data-flag',2).data('flag',2);
		}else{
			$('#div_note_view').fadeIn(0);
			$('#div_note_edit').fadeOut(0);
			$(this).attr('data-flag',1).data('flag',1);
		}
		
	});
	
	
	// включить/отключить функции пакета Vip
	$("body").on("click", ".action_enter_cancel_vip", function(){
		var d = $(this).data();
		$.post( "/action_enter_cancel_vip", { id:d.id , active:d.active }, 
			function(data){
				if(data.ok){
					$('#div_action_enter_cancel_vip_'+d.id+'').html(data.code);
						if( d.id==1 && data.active==1 ){// исполнение 1С
							ModalServiceBind1C();
						}
					}else{
						webix.message({type:"error", text:data.code});
					}
				}
				);
	});
	
	// включить/отключить функции пакета Vip
	$("body").on("click", ".modal_service_bind1c", function(){
		var d = $(this).data();
		ModalServiceBind1C();
	});	
	
	
	
	// Привязать единицы измерения
	$("body").on("click", "#bind_unit_1c", function(){
		var d = $(this).data();
		$.post( "/bind_unit_1c", {  }, 
			function(data){
				if(data.ok){
					$('#div_bind_unit_1c').html(data.code);
				}else{
					webix.message({type:"error", text:data.code});
				}
			}
			);
	});
	
	// Привязать вид номенклатуры
	$("body").on("click", "#bind_1c_typenom", function(){
		var d = $(this).data();
		$.post( "/bind_1c_typenom", {  }, 
			function(data){
				if(data.ok){
					webix.message(data.code);
				}else{
					webix.message({type:"error", text:data.code});
				}
			}
			);
	});	
	
	// Вернуть форму Привязать вид номенклатуры
	$("body").on("click", ".get_form_bind_1c_typenom", function(){
		var d = $(this).data();
		$.post( "/get_form_bind_1c_typenom", { where:d.where }, 
			function(data){
				if(data.ok){
					$(".div_bind_1c_typenom").each(function(indx, element){
						$(element).html('');
					});
					$('#div_bind_1c_typenom'+d.id+'').html(data.code);
					$(".select2").select2({
						placeholder: function(){
							$(this).data('placeholder');
						}
					});
				}else{
					webix.message({type:"error", text:data.code});
				}
			}
			);
	});

	// сохранить - Привязать вид номенклатуры и Категории
	$("body").on("change", ".save_1c_typenom_categoies", function(){
		var d = $(this).data();
		var typenom_id = $('#select_1c_typenom_id'+d.id+'').val();
		var categories_id = $('#select_1c_typenom_categories_id'+d.id+'').val();
		$.post( "/save_1c_typenom_categoies", { id:d.id , value:typenom_id , categories_id:categories_id }, 
			function(data){
				if(data.ok){
					webix.message('Сохранено');
					$('#div_bind_1c_typenom').html(data.code);
					$(".select2").select2({
						placeholder: function(){
							$(this).data('placeholder');
						}
					});
				}else{
					webix.message({type:"error", text:data.code});
				}
			}
			);
	});
	
	// Привязать склады
	$("body").on("click", "#bind_1c_stock", function(){
		var d = $(this).data();
		$.post( "/bind_1c_stock", {  }, 
			function(data){
				if(data.ok){
					webix.message(data.code);
				}else{
					webix.message({type:"error", text:data.code});
				}
			}
			);
	});
	
	// Вернуть форму Привязать склады
	$("body").on("click", "#get_form_bind_1c_stock", function(){
		var d = $(this).data();
		$.post( "/get_form_bind_1c_stock", {  }, 
			function(data){
				if(data.ok){
					$('#div_bind_1c_stock').html(data.code);
					$(".select2").select2({
						placeholder: function(){
							$(this).data('placeholder');
						}
					});
				}else{
					webix.message({type:"error", text:data.code});
				}
			}
			);
	});

	// сохранить - Привязать вид номенклатуры и Категории
	$("body").on("change", ".save_1c_stock_stock", function(){
		var d = $(this).data();
		var stock = $('#select_1c_stock_id'+d.id+'').val();
		var stock_id = $('#select_1c_stock_id_stock'+d.id+'').val();
		$.post( "/save_1c_stock_stock", { id:d.id , value:stock , stock_id:stock_id }, 
			function(data){
				if(data.ok){
					webix.message('Сохранено');
					$('#div_bind_1c_stock').html(data.code);
					$(".select2").select2({
						placeholder: function(){
							$(this).data('placeholder');
						}
					});
				}else{
					webix.message({type:"error", text:data.code});
				}
			}
			);
	});
	
	
	// Привязать компании
	$("body").on("click", "#bind_1c_company", function(){
		var d = $(this).data();
		$.post( "/bind_1c_company", {  },
			function(data){
				if(data.ok){
					webix.message(data.code);
				}else{
					webix.message({type:"error", text:data.code});
				}
			}
			);
	});
	
	
	// Привязать компанию 1С к "нашей"
	$("body").on("change", "#company_company_id_1c", function(){
		var d = $(this).data();
		$.post( "/save_1c_company_company", { value:$(this).val() , company_id:d.company_id },
			function(data){
				if(data.ok){
					webix.message('Сохранено');
					$('#div_1c_company_company').html(data.code);
					$(".select2").select2({
						placeholder: function(){
							$(this).data('placeholder');
						}
					});
				}else{
					webix.message({type:"error", text:data.code});
				}
			}
			);
	});	
	
	
	// Привязать номенклатуру
	$("body").on("click", "#bind_1c_nomenclature", function(){
		var d = $(this).data();
		$.post( "/bind_1c_nomenclature", {  },
			function(data){
				if(data.ok){
					webix.message(data.code);
				}else{
					webix.message({type:"error", text:data.code});
				}
			}
			);
	});	
	
	
	// amo - Поставщики сторонних ресурсов (Получить список)
	$("body").on("click", ".modal_amo_vendors", function(){
		$('#vmodal').removeData();
		var d = $(this).data();
		$.post( "/modal_amo_vendors", {  },
			function(data){
				if(data.code){
					modal.html(data.code);
					modal.modal();
					modal.on('shown.bs.modal',
						function(e){
									// amo - Добавить аккаунт поставщика
									//.save_accountsadd
								}
								).on('hidden.bs.modal', function (e) {
									modal.modal('dispose');
								});
							}else{
								webix.message({type:"error", text:data.code});
							}
						}
						);
	});

	// amo - Добавить аккаунт поставщика
	$("body").on("click", ".save_accountsadd", function(){
		var d = $(this).data();
		var login = $('#login'+d.i+'').val();
		var pass = $('#pass'+d.i+'').val();
		SaveAccountsadd(login,pass,d.value,d.id,d.parent_id);
	});
	
	// amo - Удалить аккаунт поставщика
	$("body").on("click", ".delete_amo_accounts", function(){
		var d = $(this).data();
		
		webix.confirm({
			ok: "Удалить", cancel:"Отмена",
			text: "Удалить "+d.name+" ?",
			callback:function(result){
				if(result){
					$.post( "/delete_amo_accounts", { id:d.id , company_id:d.company_id },
						function(data){
							if(data.ok){
								$('#div_form_accountsadd'+d.id_v+'').remove();
							}
							if(data.ok2){
								webix.message(data.code);
							}else{
								webix.message({type:"error", text:data.code, expire:300000});
							}
						}
						);
				}
			}
		});
	});
	
	// amo - вернуть форму логин/пароль стороннего аккаунта
	$("body").on("click", ".view_form_accountsadd", function(){
		var d = $(this).data();
		$('#div_form_accountsadd'+d.id+'').fadeIn(0);
	});
	
	// поставить в крон на получение предложений от сторонних сервисов
	$("body").on("click", ".cron_amo_search", function(){
		var obj = $(this);
		var d = $(this).data();
		var values = {};
		$("#modal_logo .checkbox_qrq_article_id_"+d.buy_sell_id+"").each(function(indx, element){
			if ($(element).prop('checked')){
				var dd = $(element).data();
				var addmenu = { brand:dd.brand };
				values[indx] = addmenu;

			}
		});
			//alert(JSON.stringify(values));
			$.post("/cron_amo_search", { buy_sell_id:d.buy_sell_id , values:values , token:d.token , value:d.searchtext }, 
				function(data){
					if(data.code){
						webix.message(data.code);
						obj.remove();
						timeOutId2 = setTimeout(ajaxFn2, 5000);
					}
					else{
						webix.message({type:"error", text:data.code});
					}
				}
				);
		});
	
	// удалить вопрос от стороннего сервиса
	$("body").on("click", ".delete_amo_html_searchbrend", function(){
		var obj = $(this);
		var d = $(this).data();
		$.post("/delete_amo_html_searchbrend", { buy_sell_id:d.buy_sell_id }, 
			function(data){
				if(data.code){
					webix.message(data.code);
					obj.remove();
				}
				else{
					webix.message({type:"error", text:data.code});
				}
			}
			);
	});
	
	
// повторная отправка кода подтверждения
$("body").on("click", "#again_link", function(){		
	$('#again_link').addClass('hidden').removeClass('show');
	$('#again_link_text').addClass('show').removeClass('hidden');
	run_timer();
	$.post( "/resending_code", 
		function(data){					
			if(data.ok){						
				webix.message(data.code);
			}else{
				webix.message({type:"error", text:data.code});
			}
		}
		); 
});	

	// формирование счета pdf
	$("body").on("click", "#pdf", function(){		
		var f = $("form").serialize();
		//console.log(f);
		//invoice_pdf(); 
		
		$.post("/pdf_generation", f, 	
			function(data){					
				if(data.ok){
						//webix.message(data.code);
						webix.alert({
							text:data.code,
							callback:function(){
											//download_file('/'+data.file, data.file);
											download_file(data.file, data.file);
											//console.log(data.file);
											//window.open("data:application/pdf," + encodeURI(data.file)); 
											//onReload('/profile');
										} 
									});						
					}else{
						webix.message({type:"error", text:data.code});
					}
				}
				);   
	});	
	
	// модальное окно Подписка  
	$("body").on("click", ".podpiska", function(){
		//$('#vmodal').removeData();
		var d = $(this).data();
			//console.log(d.podpiska);
			if (d.podpiska == 1){	//если пописка есть		
				$.post("/modal_podpiska_out", {id:d.id, podpiska:d.podpiska}, 
					function(data){
						if(data.code){
							modal.html(data.code);
							modal.modal();							
							modal.on('shown.bs.modal',
								function(e){	

								}	
								).on('hidden.bs.modal', function (e) {									

								}); 
							}
						}
						);
			} else if (d.podpiska == 0) { //если пописки нет
				var type_skills = $(".skills_select").val();
				//totalpay = $(".skills_select").find("option:selected").data("totalpay");
					//balance = $('.podpiska').data("balance"),
					//total = totalpay-balance;			
					$.post("/modal_podpiska_in", {id:d.id, type_skills:type_skills}, 
						function(data){
							if(data.code){
								modal.html(data.code);
								modal.modal();
								modal.on('shown.bs.modal',
									function(e){
									//$(".pay_sum").text(total);
									if (d.podpiska){
										console.log('пописан_in');
									} else {
										console.log('не подписан_in');
										//$('.modal-body__content').html($('.pay_buttons').html());  //.parent()
									};
									
								}	
								).on('hidden.bs.modal', function (e) {
									//onReload('/pro');

								}); /**/
							}
						}
						);			

				}	



			});	
	
	$("body").on("click", ".action_podpiska", function(){
		var d = $(this).data();
		$.post("/user_pro_mode", { id:d.id, type_skills:d.type_skills }, 
			function(data){
				if(data.ok){
							//webix.message(data.code);
							webix.alert({
								text:data.code,
								callback:function(){	
									onReload('/pro');
								} 
							});						
						}else{
							webix.message({type:"error", text:data.code});
						}
					}
					);		
	});
	
	$(".skills_select").change(function (e){
		var val = $(e.target).val(),
			text = $(e.target).find("option:selected").text(); //only time the find is required
		//var name = $(e.target).attr('name');
		var type = $('.pay_selector').data("type"),
		href = $('.pay_selector').attr('href');
		var totalpay = $(e.target).find("option:selected").data("totalpay"),
		balance = $('.podpiska').data("balance");	
		$.post("/change_pro_mode", { total:totalpay, type_skills:val, balance:balance }, 
			function(data){
				if(data.ok){
							//webix.message(data.code);
							//$(".pay_sum").text(data.code);
/* 							webix.alert({
											text:data.code,
											callback:function(){	
												onReload('/pro');
											} 
										}); */						
									}else{
										webix.message({type:"error", text:data.code});
									}
								}
								);			


		//$(".skills_div").text(text);
		$('.pay_selector').each(function (index, value) { 
		  //console.log(' ' + index + ':' + $(this).data('type')); 
		  $(this).attr('href','/pro/'+$(this).data('type')+'/?type='+val);
		  $('#type_skills').val(val);		  
		});		
		
	});	

	// модальное окно Пополнение балланса 
	$("body").on("click", ".add_balance", function(){
		var d = $(this).data();

		$.post("/modal_add_balance", {id:d.id}, 
			function(data){
				if(data.code){
					modal.html(data.code);
					modal.modal();							
				}
			}
			);			
	});	
	
	// модальное окно Создать новое сообщение
	$("body").on("click", ".write_message", function(){
		//var d = $(this).data();
		$.post("/modal_write_message", {}, 
			function(data){
				if(data.code){
					modal.html(data.code);
					modal.modal();	
					$(".select2").select2({
						placeholder: function(){
							$(this).data('placeholder');
						}
					});						
				}
			}
			);			
	});		
	// Создать новое сообщение
	$("body").on("click", ".write-message", function(){
		var f = $("form").serialize();
		
				//console.log(f);
				//console.log(d);
				var company = $('.company').select2('data');
				potrb = $('.potrb').select2('data');
				var companies = [],potrbs = [];
				company.forEach(function(i) {					
					//console.log(i.id);
					companies.push(i.id);					
				});				

				potrb.forEach(function(i) {					
					potrbs.push(i.id);					
				});		 		

					//console.log(companies);
					//console.log(companies.join(","));
					
					co = companies.join(",");
					po = potrbs.join(",");
/* 					
				var flag_uploader = true;
				if($('#message-logo').attr('required')=='required'){
				
					var order = $$("upload_logo_message").files.data.order;
					var kol_file = order.length;
					if(kol_file==0){
						flag_uploader = false;
						console.log('Не выбран файл(фото)');
						//webix.message({type:"error", text:"Не выбран файл(фото)"});
						//bv.disableSubmitButtons(false);
					}
					
				}	 */				

				//console.log(f+"&companies="+co+"&potrbs="+po);		
				$.post("/create_new_message", f+"&companies="+co+"&potrbs="+po, 
					function(data){
						if(data.ok){
							console.log(data);							
							onReload('/chat/messages/'+data.folder);
						}else{
							console.log(data);
							webix.message({type:"error", text:data.code});
						}
						
					}
					);		
			});
	// Создать новое сообщение от потрбностей с предзаполнением
	$("body").on("click", ".write-message_potrb", function(){
		var f = $("form").serialize();		
				//console.log(f);
				//console.log(d);
				var company = $('.company').select2('data');
					//potrb = $('.potrb').select2('data');
					var companies = [],potrbs = [];
					company.forEach(function(i) {					
					//console.log(i.id);
					companies.push(i.id);					
				});				
					
					co = companies.join(",");

					$.post("/create_new_message_potrb", f+"&companies="+co, 
						function(data){
							if(data.ok){
								console.log(data);							
								onReload('/chat/messages/'+data.folder);
							}else{
								console.log(data);
								webix.message({type:"error", text:data.code});
							}

						}
						);		
				});	
	// ответное сообщение
	$("body").on("click", ".reply_message", function(){
		var im = $(".input-message").val(),
		d = $(this).data();
		if(d.status == 2){
			$.post("/open_theme", {id:d.mid},
			function(data){
				if(data.ok){
					console.log(data);
					webix.message(data.code);
					onReload('/chat/messages/');
				}else{
					console.log(data);
					//webix.message({type:"error", text:data.code});
				}

			}
			);
		}
		var imagesM = $(".img-item input[name='images[]']").map(function(){return $(this).val();}).get();			
				//console.log(im);
				//console.log(d.mid);

				$.post("/reply_message", { messagetext:im, mid:d.mid, media:imagesM.toString()},  
					function(data){
						if(data.ok){
							console.log(data);							
							onReload('/chat/messages/'+d.mid);
						}else{
							console.log(data);
							webix.message({type:"error", text:data.code});
						}
						
					}
					);	 
			});	
	// модальное окно Редактирование темы
	$("body").on("click", ".edit_theme", function(){
		var d = $(this).data();

		$.post("/modal_edit_theme", {id:d.id}, 
			function(data){
				if(data.code){
					modal.html(data.code);
					modal.modal();

					$(".company").select2({
						placeholder: function(){
							$(this).data('placeholder');
						},
									//multiple: true,									
									//data: [{id: 0, text: 'story'},{id: 1, text: 'bug'}]
								});		
							/* 							$(".need").select2({
									placeholder: function(){
										$(this).data('placeholder');
									}
								}); */
/* 							var f = $("form").serialize();
							var company = $('.company').select2("val")
							console.log(d);
							console.log(f);	
							console.log(company); */
							
						}
					}
					);			
	});		
	// Сохранить инфо темы
	$("body").on("click", ".edit-theme", function(){
		var f = $("form").serialize();
		
		console.log(f);
		var company = $('.company').select2('data');
					//potrb = $('.need').select2('data');
					var companies = [],potrbs = [];
					company.forEach(function(i) {					
						companies.push(i.id);					
					});				
				/* 				
				potrb.forEach(function(i) {					
					potrbs.push(i.id);					
				}); */				


				co = companies.join(",");
					//po = potrbs.join(",");

 				$.post("/update_theme_info", f+"&companies="+co,//f+"&companies="+co+"&potrbs="+po, 
 					function(data){
 						if(data.ok){
 							console.log(data);	
 							webix.message(data.code);
 							onReload('/chat/messages/');
 						}else{
 							console.log(data);
 							webix.message({type:"error", text:data.code});
 						}

 					}
 					);		
 			});
	// Выход из темы для не владельца чата
	$("body").on("click", ".out_of_theme", function(){
		var d = $(this).data();	

		$.post("/out_of_theme", {id:d.fid}, 
			function(data){
				if(data.ok){
					console.log(data);	
							//webix.message(data.code);
							onReload('/chat/messages/'+d.fid);
						}else{
							console.log(data);
							//webix.message({type:"error", text:data.code});
						}
						
					}
					); 			
	});	
	// Предложить закрыть тему
	$("body").on("click", ".close_theme_pr", function(){
		var d = $(this).data();	

		$.post("/close_theme_pr", {id:d.fid}, 
			function(data){
				if(data.ok){
					console.log(data);	
							//webix.message(data.code);
							onReload('/chat/messages/'+d.fid);
						}else{
							console.log(data);
							//webix.message({type:"error", text:data.code});
						}
						
					}
					); 		
	});
	// Закрыть тему
	$("body").on("click", ".close_theme", function(){
		var d = $(this).data();

		$.post("/close_theme", {id:d.fid},
			function(data){
				if(data.ok){
					console.log(data);
					webix.message(data.code);
					onReload('/chat/messages/');
				}else{
					console.log(data);
					//webix.message({type:"error", text:data.code});
				}

			}
			);
	});

	// Открыть тему
	$("body").on("click", ".open_theme", function(){
		var d = $(this).data();

		$.post("/open_theme", {id:d.fid},
			function(data){
				if(data.ok){
					console.log(data);
					webix.message(data.code);
					onReload('/chat/messages/');
				}else{
					console.log(data);
					//webix.message({type:"error", text:data.code});
				}

			}
			);
	});

	

	// модальное окно Создать новое сообщение из сущностей
	$("body").on("click", ".write_message_need", function(){
		var d = $(this).data();
		console.log(d);
		$.post("/modal_write_message_from_potrb", {id:d.id,url:d.url,potrbs:d.need,company:d.company}, 
			function(data){
				if(data.code){
					modal.html(data.code);
					modal.modal();
					$(".select2").select2({
						placeholder: function(){
							$(this).data('placeholder');
						}
					});							
				}
			}
			);			
	});		
	// Загурзка картинок для сообщений	
	$("#js-file").change(function(){
		let error = false;
		if (window.FormData === undefined) {
			alert('В вашем браузере загрузка файлов не поддерживается');
		} else {
			var formData = new FormData();
			$.each($("#js-file")[0].files, function(key, input){
				
				if(input.size > 25165824){
					
					webix.message({type:"error", text:'Максимальный размер файла 25 мб'});
					error = true
				}else{
					formData.append('file[]', input);
					error = false
				}
			});
			if(!error){
				$.ajax({
					type: 'POST',
					url: '/upload_files_message',
					cache: false,
					contentType: false,
					processData: false,
					data: formData,
					dataType : 'json',
					success: function(data){
						console.log(data.mfiles);
						$.each(data.mfiles, function(index, value){
						//console.log("INDEX: " + index + " VALUE: " + value);
						$('#js-file-list').append(value);
					});				

						$("#js-file").val('');				

					} 
				});
			}
		}
	});	

	// модальное окно Создать тикет
	$("body").on("click", ".write_ticket", function(){
		$.post("/modal_write_ticket", {}, 
			function(data){
				if(data.code){
					modal.html(data.code);
					modal.modal();	
					$(".select2").select2({
						placeholder: function(){
							$(this).data('placeholder');
						}
					});						
				}
			}
			);			
	});		
	// Создать новый тикет
	$("body").on("click", ".write-ticket", function(e){
		var f = $("#writeticket-form").serialize();
		var imagesM = $(".img-item input[name='images[]']").map(function(){return $(this).val();}).get();
			//d = $(".write-ticket a").data();
			var media = imagesM.toString();

				//console.log(f+"&media="+media);
				//console.log(d);
				//console.log(e.target.nodeName);

				$.post("/create_new_ticket", f+"&media="+imagesM.toString(), 
					function(data){
						if(data.ok){
							console.log(data);							
							onReload('/ticket/'+data.folder);
						}else{
							console.log(data);
							webix.message({type:"error", text:data.code});
						}
						
					}
					);		
			});
	// Смена статуса тикета
	$("body").on("click", ".change_ticket", function(){
		var d = $(this).data();
		var ticket_flag = $('.select_'+d.bid).val();
		console.log(d.bid);
		console.log(ticket_flag);
		$.post("/change_ticket", {id:d.bid,ticket_flag:ticket_flag}, 
			function(data){
				if(data.ok){
					console.log(data);							
					onReload('/ticket/'+data.folder);
				}else{
					console.log(data);
					webix.message({type:"error", text:data.code});
				}

			}
			); 	
	});	


	// Проверить доступность пользователя к не опубликованным заявкам
	$("body").on("click", ".get_url_buy_sell_one", function(){
		var d = $(this).data();
		$.post("/get_url_buy_sell_one", {id:d.id}, 
			function(data){
				if(data.ok){
					window.open(data.url, '_blank');
				}else{
					webix.message({type:"error", text:data.code});
				}

			}
			); 	
	});


	// модальное окно - Уведомление  (где логотип)
	$("body").on("click", ".modal_logo_notification", function(){
		$.post("/modal_logo_notification", {}, 
			function(data){
				if(data.code){
					modal_logo.html(data.code);
					modal_logo.modal();						
				}
			}
			);			
	});	

	
	// модальное окно - Уведомление  (где логотип)
	$("body").on("click", ".notification_logo_propustit", function(){
		var d = $(this).data();
		var flag = d.flag;
		var id = d.id;
		$.post("/notification_logo_propustit", {id:d.id , flag:d.flag}, 
			function(data){
				if(data.ok){
					if(flag==1){
						$('#div_no_1cnomenclature'+id+'').remove();
					}else if(flag==2){
						$('#div_no_1company'+id+'').remove();
					}else if(flag==3){
						$('#div_no_1ccategories'+id+'').remove();
					}
					webix.message(data.code);
				}else{
					webix.message({type:"error", text:data.code});
				}
			}
			);			
	});
	
	// обновить все из 1С
	$("body").on("click", ".refresh_1c_all", function(){
		$.post("/refresh_1c_all", {}, 
			function(data){
				if(data.ok){
					onReload('/skills?modal=1c');
				}else{
					webix.message({type:"error", text:data.code});
				}
			}
			);			
	});
	
	
	// создать запрос на добавление номенклатуры в 1С
	$("body").on("click", ".create_1c_nomenclature", function(){
		var d = $(this).data();
		var flag = d.flag;
		var id = d.id;
		$.post("/create_1c_nomenclature", {id:d.id}, 
			function(data){
				if(data.ok){
					$('#create_1c_nomenclature'+id+'').remove();
					webix.message(data.code);
				}else{
					webix.message({type:"error", text:data.code});
				}
			}
			);			
	});
	
	// сохранить данные ЭТП при подписке
	$("body").on("click", ".save_subscriptions_etp", function(){
		var d = $(this).data();
		var id = d.id;
		$.post("/save_subscriptions_etp", { company_id:d.id, login:d.login , pass:d.pass , flag:d.flag },
			function(data){
				if(data.ok){
					webix.message(data.code);
				}else{
					webix.message({type:"error", text:data.code});
				}
			}
			);			
	});	
	
	
	// Модаль Подписка пользователя на компанию ЭТП (Amo)
	$("body").on("click", ".modal_amo_accounts_etp", function(){
		$('#vmodal').removeData();
		var d = $(this).data();
		$.post("/modal_amo_accounts_etp", { company_id:d.id }, 
			function(data){
				if(data.code){
					$('#vmodal').html(data.code);
					$('#vmodal').modal();
					$('#vmodal').on('shown.bs.modal',
						function(e){

							$(".select2").select2({
								placeholder: function(){
									$(this).data('placeholder');
								}
							});

								// проверка кнопки "Без входа" при подписке Этп
								$("#qrq_id").on("change", function() {
									$.post("/proverka_button_etp_no_autorize", { id:$(this).val() }, 
										function(data){
											if (data.ok) {
												$('#button_etp_no_autorize').fadeIn(0);
											}else {
												$('#button_etp_no_autorize').fadeOut(0);
											}
										}
										);
								});


							}
							).on('hidden.bs.modal', function (e) {
								$('#vmodal').modal('dispose');
							});
						}
					}
					);
	});
	
	
	// сохранить данные ЭТП при подписке
	$("body").on("click", ".connect_users_etp", function(){
		var d = $(this).data();
		var company_id = d.company_id;
		var qrq_id = $('#connect_users_etp-form #qrq_id').val();
		var login = $('#connect_users_etp-form #login').val();
		var pass = $('#connect_users_etp-form #pass').val();
		
		$.post("/connect_users_etp", { flag:d.flag , company_id:d.company_id , qrq_id:qrq_id , login:login , pass:pass },
			function(data){
				if(data.ok){
					webix.message(data.code);
					modal.modal('hide');
					ActionSubscriptions(company_id,'');
				}else{
					webix.message({type:"error", text:data.code});
				}
			}
			);
	});
	
	

	
	
	// Поделиться профилем
	document.getElementById('get_href_company_profile1').addEventListener('click', function(){
		var d = $(this).data();
		var textarea = document.createElement('textarea');
		textarea.textContent = d.href;
		document.body.appendChild(textarea);

		var selection = document.getSelection();
		var range = document.createRange();
		
		range.selectNode(textarea);
		selection.removeAllRanges();
		selection.addRange(range);

		console.log('copy success', document.execCommand('copy'));
		selection.removeAllRanges();

		document.body.removeChild(textarea);
		webix.message("Все заявки и объявления "+d.company+" по ссылке");
	})
	// Поделиться компанией
	document.getElementById('get_href_company_profile2').addEventListener('click', function(){
		var d = $(this).data();
		var textarea = document.createElement('textarea');
		textarea.textContent = d.href;
		document.body.appendChild(textarea);

		var selection = document.getSelection();
		var range = document.createRange();
		
		range.selectNode(textarea);
		selection.removeAllRanges();
		selection.addRange(range);

		console.log('copy success', document.execCommand('copy'));
		selection.removeAllRanges();

		document.body.removeChild(textarea);
		webix.message("Все заявки и объявления "+d.company+" по ссылке");
	})
	/*
	// Поделиться профилем
	$("body").on("click", ".get_href_company_profile", function(){
			var d = $(this).data();
			$('#'+d.elem_id+'').val(d.href);
			
			var ta = document.getElementById("myCopyText");
			var range = document.createRange();
			range.selectNode(ta);
			window.getSelection().addRange(range); 
			try {
				document.execCommand("copy"); 
			} catch(err) { 
				console.log("Can`t copy"); 
			}
			window.getSelection().removeAllRanges();
			webix.message("Все заявки и объявления "+d.company+" по ссылке");
			
	});	
	*/

	
	
});//end $(function())

//checkbox
function getCheckbox(){
	$( "input[type='checkbox']" ).on('change', function() {
		if ($(this).prop('checked')){
			$(this).attr('value', 1);
		} else {
			$(this).attr('value', 0);
		}
	});
}



/***
  *  Вспомогательные функции  Begin
  ***/
  var count_phone;
  function get_intlTelInput(elem_id,iti_phone) {

	/*
	 * International Telephone Input v16.0.0
	 * https://github.com/jackocnr/intl-tel-input.git
	 * Licensed under the MIT license
	 */
	 var input = document.querySelectorAll("#"+elem_id+"");
	 var iti_el = $('.iti.iti--allow-dropdown.iti--separate-dial-code');
	 if(iti_el.length){
	 	iti.destroy();
		// Get the current number in the given format
	}
	for(var i = 0; i < input.length; i++){
		iti = intlTelInput(input[i], {
			initialCountry: ""+iti_phone+"",
			autoHideDialCode: false,
			autoPlaceholder: "aggressive" ,
                //initialCountry: "auto",
                separateDialCode: true,
                preferredCountries: ['ru'],
                customPlaceholder:function(selectedCountryPlaceholder,selectedCountryData){
                	return ''+selectedCountryPlaceholder.replace(/[0-9]/g,'X');
                },
                geoIpLookup: function(callback) {
                	$.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                		var countryCode = (resp && resp.country) ? resp.country : "";
                		callback(countryCode);
                	});
                },
                utilsScript: "/component/intlTelInput/js/utils.js" // just for 
            });



		$('#'+elem_id+'').on("focus click countrychange", function(e, countryData) {
			var pl = $(this).attr('placeholder') + '';
			var res = pl.replace( /X/g ,'9');
			var a = res.replace(/[^+\d]/g, "");
			count_phone = a.length;
			if(res != 'undefined'){
				$(this).inputmask(res, {placeholder: "X", clearMaskOnLostFocus: true});
			}
		});

		$('#'+elem_id+'').on("focusout", function(e, countryData) {
			var intlNumber = iti.getNumber();
		});

	}
	

	count_phone = $('#'+elem_id+'').val().length;

};

function createModalCompany(){
	$('#vmodal').removeData();
	var d = $(this).data();
	console.log(d)
	$.post("/modal_my_company", {id:d.id},
		function(data){
			if(data.code){
				$('#vmodal').html(data.code);
				$('#vmodal').modal();
				$('#vmodal').on('shown.bs.modal',
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
}

// модальное окно приветствие при регистрации
function getModalStart() {
	$.post("/modal_start", {}, 
		function(data){
			if(data.code){
				console.log(data)
				$('#vmodal').html(data.code);
				$('#vmodal').addClass('welcome-modal');
				$('#vmodal').modal();
				$('#vmodal').on('shown.bs.modal',
					function(e){
										//
									}
									).on('hidden.bs.modal', function (e) {
								//alert('qw');
							});
								}
							}
							);
	return false;
};

// модальное окно поиск со сторонних ресурсов
function getModalQrqSearch() {
	$.post("/modal_qrq_search", {}, 
		function(data){
			if(data.code){
				$('#vmodal').html(data.code);
				$('#vmodal').modal();
				$('#vmodal').on('shown.bs.modal',
					function(e){
										//
									}
									).on('hidden.bs.modal', function (e) {
								//alert('qw');
							});
								}
							}
							);
	return false;
};


function ModalRegistration( form_serilize=false ) {
	var f='';
	if(form_serilize){
		f = "&"+form_serilize;
	}
	
	$.post("/modal_registration", "who=1"+f,
		function(data){
			if(data.code){
				$('#vmodal').html(data.code);
				$('#vmodal').modal();
				$('#vmodal').on('shown.bs.modal',
					function(e){
						get_intlTelInput("phone","ru");

						$('#registration-form').bootstrapValidator('destroy');
						$('#registration-form').bootstrapValidator({
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
									}
								},
								phone: {
									validators: {
										notEmpty: {
											message: 'Введите телефон'
										}
									}
								}
							}
						}).on('success.form.bv', function(e) {
							e.preventDefault();
							var $form = $(e.target);
							var bv = $form.data('bootstrapValidator');
							var iti = $('#registration-form #country-listbox').attr('aria-activedescendant');
							var arr = iti.split('-');
							$.post("/registration", $form.serialize()+'&value='+arr[2],
								function(data){
									var entry = '';
									var arr = data.flag.split(',');
									arr.forEach(function(entry) {
										if(entry=='email'){
											$('[data-bv-icon-for="email"]').removeClass('glyphicon-ok').addClass('glyphicon-remove').fadeIn(0);
											$('[data-bv-validator="regexp"]').fadeIn(0).html('Email занят');
											$('[data-bv-icon-for="email"]').parent().removeClass('has-success').addClass('has-error');
											var flag_entry = true;
											grecaptcha.reset();
										}
										if(entry=='phone'){
											$('[data-bv-icon-for="phone"]').removeClass('glyphicon-ok').addClass('glyphicon-remove').fadeIn(0);
											$('[data-bv-for="phone"]').fadeIn(0).html('Телефон занят');
											$('[data-bv-icon-for="phone"]').parent().parent().removeClass('has-success').addClass('has-error');
											var flag_entry = true;
											grecaptcha.reset();
										}
									});
									if(data.recaptcha){
										if(data.ok){
											$('.register-dialog').addClass('register-welcome');
											$('#registration-form .modal-body').html(data.code);
											$('#registration-form input[type="submit"]').remove();
										}else{
											webix.message({type:"error", text:data.code});
										}
									}else{
										$('#recaptchaError').html(data.code);
										bv.disableSubmitButtons(false);
									}
									if (bv.getInvalidFields().length > 0) {
										bv.disableSubmitButtons(false);
									}
								}
								);
						});
					}
					);
			}
		}
		);
	
	return false;
};	



//получить пароль
function ModalGetPassword( form_serilize=false ) {
	var f='';
	if(form_serilize){
		f = "&"+form_serilize;
	}
	
	$.post("/modal_getpassword", //"who=1"+f,
		function(data){
			if(data.code){
				$('#vmodal').html(data.code);
				$('#vmodal').modal();
				$('#vmodal').on('shown.bs.modal',
					function(e){

						$('#getpassword-form').bootstrapValidator('destroy');
						$('#getpassword-form').bootstrapValidator({
							feedbackIcons: {
								valid: 'glyphicon glyphicon-ok',
								invalid: 'glyphicon glyphicon-remove',
								validating: 'glyphicon glyphicon-refresh'
							},
							fields: {
								phone_email: {
									validators: {
										notEmpty: {
											message: 'Введите email или телефон'
										}
									}
								}									
							}
						}).on('success.form.bv', function(e) {
							e.preventDefault();
							var $form = $(e.target);
							var bv = $form.data('bootstrapValidator');	
									//var iti = $('#registration-form #country-listbox').attr('aria-activedescendant');
									//var arr = iti.split('-');
									//$.post("/get_sms_email", $form.serialize()+'&value=ru',
									$.post("/get_sms_email", $form.serialize(), 										
										function(data){	
											var new_login = data.new_login;
											console.log(1);
											console.log(data);
											if (data.ok) {

												$('.getpassword-dialog').parent().html(data.code);
														$(".phone_email_code").on("keyup change blur",function(){  //проверка ввода кода 											
															if($('.phone_email_code').val().length == 4) {
															$.post('/check_code', {id:$(".login_id").val(),phone_email_code:$(".phone_email_code").val()}, function(data){
																console.log(2);
																console.log(data);
																if(data.ok){																			

																	var login_id = $(".login_id").val();
																	$.post("/modal_save_pass", {id:login_id}, 			
																		function(data){
																			if(data.code){																				
																				$('.getcode-dialog').parent().html(data.code);
																				ChangePass2(new_login);
																			}
																		}
																		);	


																}else{
																	if($('.phone_email_code').val().length == 4) {
																		webix.message({type:"error", text:data.code});
																	}
																}
															}
															);														  
															}
														});

													}
													else {
														console.log('error');
														console.log(data);
													
														if (bv.getInvalidFields().length > 0) {
															bv.disableSubmitButtons(false);
														}
													}

													
												}
												);
									

								});	

					}
					);

			}
		}
		);


	return false;
};	

//получить код подтверждения
function ModalGetCode( form_serilize=false ) {
	console.log('start get code');
	var f='';
	if(form_serilize){
		f = "&"+form_serilize;
	}
	
	$.post("/modal_getcode", //"who=1"+f,
		function(data){
			if(data.code){
				$('#vmodal').html(data.code);
				$('#vmodal').modal();
				$('#vmodal').on('shown.bs.modal',
					function(e){								

						$('#getcode-form').bootstrapValidator('destroy');
						$('#getcode-form').bootstrapValidator({
							feedbackIcons: {
								valid: 'glyphicon glyphicon-ok',
								invalid: 'glyphicon glyphicon-remove',
								validating: 'glyphicon glyphicon-refresh'
							},
							fields: {
								phone_email: {
									validators: {
										notEmpty: {
											message: 'Введите код подтверждения'
										}
									}
								},								

							}
						}).on('success.form.bv', function(e) {
							e.preventDefault();
							var $form = $(e.target);
							var bv = $form.data('bootstrapValidator');
							$.post("/set_code", $form.serialize(), 
								function(data){
									if (data.ok) {
										console.log(data);
														//onReload('');
													}else {
														webix.message({type:"error", text:data.code});
														if (bv.getInvalidFields().length > 0) {
															bv.disableSubmitButtons(false);
														}
													}
												}
												);
						});	

					}
					);
			}
		}
		);
	
	return false;
};


function SkipRegistCompany(){

	$.post("/skip_registration_company", {},
		
		);
	ModalSelectSkills();
	return false;
};

// модальное окно Подключение навыков
function ModalSelectSkills(){

	$.post("/modal_registration_pro", {},
		function(data){
			if(data.code){
				$('#vmodal').html(data.code);
				$('#vmodal').addClass('select-skills');
				$('#vmodal').modal();
				$('#vmodal').on('shown.bs.modal',
					function(e){
						//console.log('след окно выбора навыков');
					}
					).on('hidden.bs.modal', function (e) {
					//alert('qw');
				});
				}
			}
			);
	return false;
};




// изменение пароля 2
function ChangePass2(flag) {
	$('#newpass-form').bootstrapValidator('destroy');
	$('#newpass-form').bootstrapValidator({
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			new_pass: {
				validators: {
					notEmpty: {
						message: 'Введите пароль'
					}
				}
			},
			new_pass_again: {
				validators: {
					notEmpty: {
						message: 'Повторно пароль'
					},
					identical: {
						field: 'new_pass',
						message: 'Не совпадает пароль'
					},
					blank: {
						message: 'Не совпадает пароль'
					}
				}
			}

		}
	}).on('success.form.bv', function(e) {
		e.preventDefault();
		var $form = $(e.target);
		var	new_user = flag;

		var bv = $form.data('bootstrapValidator');
		$.post("/save_password", $form.serialize(), 
			function(data){
				if(data.ok){
					console.log(new_user);								
								if (new_user === 0){  //если не новый клиент, то просто переходим в профиль
									onReload('/profile/');
								} else {
									onReload('/profile/modal-welcome');
								}

							}else{								
								bv.updateStatus('new_pass_again', 'INVALID', 'blank').validateField('new_pass_again');
							}
							if (bv.getInvalidFields().length > 0) {
								bv.disableSubmitButtons(false);
							}
						}
						);
	});
	return false;
};

// Формирвоание счета
function invoice_pdf() {		
	$('form').bootstrapValidator('destroy');
	$('form').bootstrapValidator({
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			inn: {
				validators: {
					notEmpty: {
						message: 'Введите ИНН'
					}
				}
			},
			kpp: {
				validators: {
					notEmpty: {
						message: 'Введите КПП'
					}
				}
			},
			rschet: {
				validators: {
					notEmpty: {
						message: 'Введите номер расчетного счета'
					}
				}
			},
			bik: {
				validators: {
					notEmpty: {
						message: 'Введите БИК'
					}
				}
			},
			korr_schet: {
				validators: {
					notEmpty: {
						message: 'Введите корр. счет'
					}
				}
			},
			ur_adr: {
				validators: {
					notEmpty: {
						message: 'Введите юридический адрес'
					}
				}
			}

		}

	}).on('success.form.bv', function(e) {
		e.preventDefault();
			//console.log('ddd');
			var $form = $(e.target);
			var bv = $form.data('bootstrapValidator');
			$.post("/pdf_generation", $form.serialize(), 
				function(data){
					if(data.ok){
								//console.log(data);
								//webix.message({type:"success", text:data.code});
								//onReload('/profile/modal-welcome');

							}else{
								//console.log(data);
								//bv.updateStatus('new_pass_again', 'INVALID', 'blank').validateField('new_pass_again');
							}
							if (bv.getInvalidFields().length > 0) {
								bv.disableSubmitButtons(false);
							}
						}
						);
		});
	return false;
};





// сохранение компании
function SaveMyCompany() {
	$('#my_company-form').bootstrapValidator('destroy');

	$('#my_company-form').bootstrapValidator({
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			company: {
				validators: {
					notEmpty: {
						message: 'Введите наименование'
					}
				}
			},
			legal_entity_id: {
				validators: {
					notEmpty: {
						message: 'Выберите Правовую форму'
					}
				}
			},
			tax_system_id: {
				validators: {
					notEmpty: {
						message: 'Выберите Систему налогообложения'
					}
				}
			},
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
			cities_id: {
				validators: {
					notEmpty: {
						message: 'Выберите город'
					}
				}
			},
			who_company: {
				validators: {
					notEmpty: {
						message: 'Выберите значение для поля Покупатель/Продавец'
					}
				}
			}
		}
	}).on('success.form.bv', function(e) {
		e.preventDefault();
		var $form = $(e.target);
		var unindexed_array = $form.serializeArray();
		var indexed_array = {};

		$.map(unindexed_array, function(n, i){
			indexed_array[n['name']] = n['value'];
		});

				console.log(indexed_array)	
		var bv = $form.data('bootstrapValidator');
		$.post("/save_my_company", $form.serialize(),
			function(data){
				if(data.ok){
								//onReload('/profile');
								webix.message("Сохранено");
								if(typeof(indexed_array['companyIn']) != "undefined" && indexed_array['companyIn'] !== null) {
									$.post('/change_account_company', {id:data.id}, function(data){
										console.log('Супер')
										if(data.ok){
												//onReload('');
												ModalSelectSkills(); //след окно для выбора навыков
											}else{
												webix.message({type:"error", text:data.code});
											}
										}
										);
								}else{
									ModalSelectSkills(); //след окно для выбора навыков
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
	return false;
};

// сохранение id_1c компании
function SaveMyCompanyId1c() {
	$('#my_company_id_1c-form').bootstrapValidator('destroy');
	$('#my_company_id_1c-form').bootstrapValidator({
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			id_1c: {
				validators: {
					notEmpty: {
						message: 'Введите идентификатор 1С'
					}
				}
			}
		}
	}).on('success.form.bv', function(e) {
		e.preventDefault();
		var $form = $(e.target);
		var bv = $form.data('bootstrapValidator');
		$.post("/save_my_company_id_1c", $form.serialize(),
			function(data){
				if(data.ok){
								onReload('/skills?modal=1c');//надо обновить define параметры
								//webix.message("Сохранено");
							}else{
								webix.message({type:"error", text:data.code});
							}
							if (bv.getInvalidFields().length > 0) {
								bv.disableSubmitButtons(false);
							}
						}
						);
	});
	return false;
};


// 
function ChangePass() {
	$('#change-pass-form').bootstrapValidator('destroy');
	$('#change-pass-form').bootstrapValidator({
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			pass: {
				validators: {
					notEmpty: {
						message: 'Введите пароль'
					}
				}
			},
			pass_again: {
				validators: {
					notEmpty: {
						message: 'Повторно пароль'
					},
					identical: {
						field: 'pass',
						message: 'Не совпадает пароль'
					},
					blank: {
						message: 'Не совпадает пароль'
					}
				}
			}

		}
	}).on('success.form.bv', function(e) {
		e.preventDefault();
		var $form = $(e.target);
		var bv = $form.data('bootstrapValidator');
		$.post("/change_pass", $form.serialize(), 
			function(data){
				if(data.ok){
					webix.alert({
						text:data.code,
						callback:function(){
							onReload('/profile');
						}
					});
				}else{
					bv.updateStatus('pass_again', 'INVALID', 'blank').validateField('pass_again');
				}
				if (bv.getInvalidFields().length > 0) {
					bv.disableSubmitButtons(false);
				}
			}
			);
	});
	return false;
};

// сохранение Заявка/Объявление
function SaveBuySell(modal,flag_offer_share) {
	

		//$('#buy_sell-form').bootstrapValidator('destroy');
		$('#buy_sell-form').bootstrapValidator({

		}).on('error.form.bv', function(e) {
			/*
			e.preventDefault();
			var $form = $(e.target);
			var bv = $form.data('bootstrapValidator');
			var button=$(e.target).data('bootstrapValidator').getSubmitButton();
			var d = button.data();
			if(d.status==1){
					alert('qw');
			}
			*/
		}).on('success.form.bv', function(e) {
			e.preventDefault();
			var $form = $(e.target);
			var bv = $form.data('bootstrapValidator');
			var button=$(e.target).data('bootstrapValidator').getSubmitButton();
			var d = button.data();
			
			
			
			bv.disableSubmitButtons(true);

			
			/*
			var categories_id=$('#categories_id').val();
			
			var flag_categories = true;
			if( categories_id==0 ){
				flag_categories = false;
				webix.message({type:"error", text:"Выберите категорию"});
			}
			*/
			var flag_amount = true;
			$("#buy_sell-form [name='amount']").each(function(indx, element){
				if ( $(element).val()=='' || $(element).val()==0 ){
					flag_amount = false;
					webix.message({type:"error", text:"Введите количесвто"});
				}
			});
			
			var flag_amount1 = true;
			$("#buy_sell-form [name='amount1']").each(function(indx, element){
				if ( $(element).val()=='' || $(element).val()==0 ){
					flag_amount1 = false;
					webix.message({type:"error", text:"Введите количесвто"});
				}
			});
			
			var flag_amount2 = true;
			$("#buy_sell-form [name='amount2']").each(function(indx, element){
						// $(element).parent().attr('style') может скрыт display:none
						if ( ($(element).parent().attr('style')=='') && ($(element).val()=='' || $(element).val()==0) ){
					//alert($(element).parent().attr('style'));
					flag_amount2 = false;
					webix.message({type:"error", text:"Введите количесвто"});
				}
			});

			var flag_name = true;
			if($('#buy_sell-form #name').attr('required')=='required'){
				var val = $('#buy_sell-form #name').val();
				if(val.trim()==''){
					flag_name = false;
					webix.message({type:"error", text:"Введите наименование"});
				}
				
			}	

			var flag_uploader = true;
			if($('#buy_sell-form #cam').attr('required')=='required'){

				var order = $$("upload_files_buy_sell").files.data.order;
				var kol_file = order.length;
				
				var has_string = 0;
				$(".container_files_orders").each(function(indx, element){
					var texts = $(element).html();
					has_string = texts.indexOf("files/buy_sell");
				});
				
				if( kol_file==0 && has_string==0 ){
					flag_uploader = false;
					webix.message({type:"error", text:"Не выбран файл(фото)"});
					bv.disableSubmitButtons(false);
				}
				
			}			
			
			if( /*flag_categories &&*/ flag_amount && flag_amount1 && flag_amount2 && flag_name && flag_uploader ){
				
				var status_id = d.status;
				
				
				SaveBuySellAfter( modal , $form.serialize() , status_id , flag_offer_share );
				/* перенесено в отдельную
				webix.ajax().post( "/save_buy_sell", $form.serialize()+"&status="+status_id, 
									function(text, data, xhr){
										data = data.json();
										
										if(data.ok){
											
											//var tr = data.tr;
											var id = data.id;
											
											//$('#loading').show();
											$$("upload_files_buy_sell").files.data.each(function(obj){
														obj.formData = { id:data.id };
											});
											
											$$("upload_files_buy_sell").send(function(response){
													$$("upload_files_buy_sell").files.data.each(function(obj){
														
														var status = obj.status;
														var name = obj.name;
														if(status=="server"){
															webix.message("Файл: "+name+" загружен");
														}
														else{
															webix.message({type:"error", text:"Нельзя загрузить: "+name});
														}
													});
													
													
													
													
													var tr = '';
													webix.ajax().post( "/get_cache_buy_sell", { buy_sell_id:id , status:status_id , flag_buy_sell:data.flag_buy_sell }, 
																			function(text, data2, xhr){
																				
																				data2 = data2.json();
																				var tr = data2.tr;
																				
																				if(data.noautorize && !flag_offer_share ){
																					modal.modal('hide');
																					$('.enter-btn').click();
																				}else{
																					if(flag_offer_share){// изменить данное предложение
																						$("#button_form_buy_sell"+data.parent_id+"").click();
																						modal.modal('hide');
																					}else{
																							if(!data.flag_nomenclature && (data.flag_buy_sell==2) ){
																								// создание/обновление номенклатуры от заявки
																								webix.confirm({
																									ok: "Создать", cancel:"Обновить",
																									text: "Номенклатуру?",
																									callback:function(result){
																										if(result){
																												$.post( "/save_nomenclature", $form.serialize()+"&buy_sell_id="+data.id+"&flag=insert" , 
																													function(data){
																														//
																														if(data.ok){
																															if(data.flag_reload){
																																onReload('');
																															}else{
																																$('#div_mybs'+id+'').html(tr);
																																modal.modal('hide');
																																webix.message("Сохранено");
																															}
																														}else{
																															webix.message({type:"error", text:"Нельзя сохранить"});
																														}
																													}
																												);
																										}else{
																												$.post( "/save_nomenclature", $form.serialize()+"&buy_sell_id="+data.id+"&flag=update" , 
																													function(data){
																														//onReload('');
																														if(data.ok){
																															if(data.flag_reload){
																																onReload('');
																															}else{
																																$('#div_mybs'+id+'').html(tr);
																																modal.modal('hide');
																																webix.message("Сохранено");
																															}
																														}else{
																															webix.message({type:"error", text:"Нельзя сохранить"});
																														}
																													}
																												);
																										}
																									}
																								});
																							}else{
																									//onReload('');
																									if(data.ok){
																										if(data.flag_reload){
																											onReload('');
																										}else{
																											$('#div_mybs'+id+'').html(tr);
																											modal.modal('hide');
																											webix.message("Сохранено");
																										}
																									}else{
																										webix.message({type:"error", text:"Нельзя сохранить"});
																									}
																							}
																					}
																				}
																				
																				
																			}
													);
													
													//webix.message(tr);
													//webix.message("2");
													

											});
											
											
										}else{
											webix.message({type:"error", text:data.code});
											bv.disableSubmitButtons(false);
										}
										
										if (bv.getInvalidFields().length > 0) {
											bv.disableSubmitButtons(false);
										}
									}
								);
								*/
							}
						});

return false;
};


function SaveBuySellAfter(modal,form_serialize,status_id,flag_offer_share){

	webix.ajax().post( "/save_buy_sell", form_serialize+"&status="+status_id, 
		function(text, data, xhr){
			data = data.json();

			if(data.ok){

											//var tr = data.tr;
											var id = data.id;
											
											//$('#loading').show();
											$$("upload_files_buy_sell").files.data.each(function(obj){
												obj.formData = { id:data.id };
											});
											
											$$("upload_files_buy_sell").send(function(response){
												
												$$("upload_files_buy_sell").files.data.each(function(obj){

													var status = obj.status;
													var name = obj.name;
													if(status=="server"){
														webix.message("Файл: "+name+" загружен");
													}
													else{
														webix.message({type:"error", text:"Нельзя загрузить: "+name});
													}
												});




												var tr = '';
												webix.ajax().post( "/get_cache_buy_sell", { buy_sell_id:id , status:status_id , flag_buy_sell:data.flag_buy_sell }, 
													function(text, data2, xhr){

														data2 = data2.json();
														var tr = data2.tr;

														if(data.noautorize && !flag_offer_share ){
															modal.modal('hide');
															$('.enter-btn').click();
														}else{
																					if(flag_offer_share){// изменить данное предложение
																						$("#button_form_buy_sell"+data.parent_id+"").click();
																						modal.modal('hide');
																					}else{
																						if(!data.flag_nomenclature && (data.flag_buy_sell==2) ){
																								// создание/обновление номенклатуры от заявки
																								webix.confirm({
																									ok: "Создать", cancel:"Обновить",
																									text: "Номенклатуру?",
																									callback:function(result){
																										if(result){
																											$.post( "/save_nomenclature", form_serialize+"&buy_sell_id="+data.id+"&flag=insert" , 
																												function(data){
																														//
																														if(data.ok){
																															if(data.flag_reload){
																																onReload('');
																															}else{
																																$('#div_mybs'+id+'').html(tr);
																																modal.modal('hide');
																																webix.message("Сохранено");
																															}
																														}else{
																															webix.message({type:"error", text:"Нельзя сохранить"});
																														}
																													}
																													);
																										}else{
																											$.post( "/save_nomenclature", form_serialize+"&buy_sell_id="+data.id+"&flag=update" , 
																												function(data){
																														//onReload('');
																														if(data.ok){
																															if(data.flag_reload){
																																onReload('');
																															}else{
																																$('#div_mybs'+id+'').html(tr);
																																modal.modal('hide');
																																webix.message("Сохранено");
																															}
																														}else{
																															webix.message({type:"error", text:"Нельзя сохранить"});
																														}
																													}
																													);
																										}
																									}
																								});
																							}else{
																									//onReload('');
																									if(data.ok){
																										if(data.flag_reload){
																											onReload('');
																										}else{
																											$('#div_mybs'+id+'').html(tr);
																											modal.modal('hide');
																											webix.message("Сохранено");
																										}
																									}else{
																										webix.message({type:"error", text:"Нельзя сохранить"});
																									}
																								}
																							}
																						}


																					}
																					);

													//webix.message(tr);
													//webix.message("2");
													

												});


}else{
	webix.message({type:"error", text:data.code});
	bv.disableSubmitButtons(false);
}

if (bv.getInvalidFields().length > 0) {
	bv.disableSubmitButtons(false);
}
}
);

return false;
};


// модальное окно История Заявка/Объявлени
function ModalHistoryBuySell(id){
	$.post("/modal_history_buy_sell", {id:id}, 
		function(data){
			if(data.code){
				$('#vmodal').html(data.code);
				$('#vmodal').modal();
				$('#vmodal').on('shown.bs.modal',
					function(e){
									//
								}
								).on('hidden.bs.modal', function (e) {
									$('#vmodal').modal('dispose');
								});
							}
						}
						);
	return false;
};


// Выпадающий список с возможностью добавления значения
function Select2UsersAttributeValue(){
	$(".save_users_attribute_value").select2({
		tags: true,
		createTag: function (tag) {
			return {
				id: tag.term,
				text: tag.term,
				isNew : true
			};
		}
	}).on("select2:select", function(e) {
		var dd = $(this).data();
			if(e.params.data.isNew){// создание новоги значения и его выбор
				/*
				$(this).find('[value="'+e.params.data.id+'"]').replaceWith('<option selected value="'+e.params.data.id+'">'+e.params.data.text+'</option>');
				alert(e.params.data.id+'*'+dd.categories_id+'*'+dd.attribute_id);
				$.post("/save_users_slov_attribute_value", {value:e.params.data.id , categories_id:dd.categories_id , attribute_id:dd.attribute_id},
					function(data){
							if(data.ok){
								webix.message(data.code);
							}else{
								webix.message({type:"error", text:data.code});
							}
					}
				);
				*/
			}else if(e.params.data.id){// выбор имеющегося значения
				/*$.post("/save_attribute_value", {flag:'insert' , id:e.params.data.id , categories_id:dd.categories_id , attribute_id:dd.attribute_id},
					function(data){
							if(data.ok){
								webix.message(data.code);
							}else{
								webix.message({type:"error", text:data.code});
							}
					}
					);*/
				}
		}).on("select2:unselect", function(e) {// отменить выброное значение
			var dd = $(this).data();
				/*$.post("/save_attribute_value", {flag:'delete' , id:e.params.data.id , categories_id:dd.categories_id , attribute_id:dd.attribute_id},
					function(data){
							if(data.ok){
								webix.message(data.code);
							}else{
								webix.message({type:"error", text:data.code});
							}
					}
					);*/
				});

		return false;
	}

// Поиск,Заявка/Объявление
function AutocompleteSearch( flag , flag_buy_sell ){
	$(".autocomplete_search_"+flag+"").each(function(indx, element) {
		$(".autocomplete_search_"+flag+"").autocomplete({
			source: function( request, response ) {
				$.ajax({
					type: "POST",
					url: "/autocomplete_search",
					data: {
						value:			request.term,
						flag: 			flag,
						flag_buy_sell:	flag_buy_sell,
						where:			window.location.pathname
					},
					dataType: "json",
					success: function( data ) {
						response( $.map( data, function( item ) {
							return {
								label: 				item.name,
								categories_id: 		item.categories_id,
								value: 				item.value,
								id_attribute: 		item.id_attribute,
								flag: 				item.flag,
								nomenclature_id:	item.nomenclature_id
							}
						}));
					}
				});
			},
			minLength: 2,
			select: function( event, ui ) {

				if(flag=='buy_sell'){
							if(ui.item.flag==8){// выбрали Номенклатуру
								$('#buy_sell-form #nomenclature_id').val(ui.item.nomenclature_id);
								$(this).val(ui.item.value);
								CountStatusBuysellByNomenclature(ui.item.nomenclature_id);
							}
							if(ui.item.flag==21){// выбрали "Поисковый запрос"
								var search_categories_id = ui.item.nomenclature_id;
									//alert(ui.item.categories_id+'*'+flag_buy_sell+'*'+flag+'*'+search_categories_id);
									ChangeCategoriesBuySell(ui.item.categories_id,flag_buy_sell,flag,'',search_categories_id);
								}else if(ui.item.categories_id){
								//$(this).val(ui.item.value);
								$('p[data-categories_id="'+ui.item.categories_id+'"]').click();
								
							}
							//alert(flag+'*'+ui.item.categories_id+'*'+ui.item.id_attribute);
							if(ui.item.id_attribute){
								//$(this).val('');
								setTimeout(function(){
									$("[name='elem_23[]']").select2("val", [ui.item.id_attribute]);
								}, 1000);
							}
							
						} else if( flag=='mainpage' || flag=='top' || flag=='modal' ){
							$('div.search-main #flag').val(ui.item.flag);
							SaveSearchFilterParamCompany( flag , ui.item.categories_id , $(this).val() , ui.item.flag , true );
						}
						


						return false;
					}
				}).focus(function() {
					$(this).autocomplete('search', $(this).val())
				}).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
					return $( "<li></li>" ).data( "item.autocomplete", item ).append( "<div>"+ item.label + "</div>" ).appendTo( ul );
				};

			});
}


// Город / Местоположение
function AutocompleteCities( flag ){
	$(".autocomplete_cities").autocomplete({
		source: function( request, response ) {
			$.ajax({
				type: "POST",
				url: "/autocomplete_cities",
				data: {
					value:	request.term,
					flag: 	flag
				},
				dataType: "json",
				success: function( data ) {
					response( $.map( data, function( item ) {
						return {
							label: 			item.name2,
							id: 			item.id,
							value: 			item.value,
							cities_id: 		item.cities_id
						}
					}));
				}
			});
		},
		minLength: 2,
		select: function( event, ui ) {
			if(ui.item.id){
				$(this).val(ui.item.value);
				if(flag=='buy_sell'){
					$("#buy_sell-form #cities_id").val(ui.item.cities_id);
					$("#buy_sell-form #get_span_cities").html(ui.item.value);
				}else if(flag=='search'){
					$(".city-wrapper #cities_id").val(ui.item.cities_id);
					$("#get_span_cities").html(ui.item.value);
					SaveSearchFilterParamCompany('modal');
							}/*else if(flag=='assets_issue'){
								$("#assets_issue-form #cities_id").val(ui.item.cities_id);
							}*/
						}
						return false;
					},
				}).focus(function() {
					$(this).autocomplete('search', $(this).val())
				}).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
					return $( "<li></li>" ).data( "item.autocomplete", item ).append( "<div>"+ item.label + "</div>" ).appendTo( ul );
				};

			}



// Несуществующий поставщик
function AutocompleteFa( id , flag_buy_sell , tid ){
	$(".autocomplete_fa"+id+"").each(function(indx, element) {

		$(element).autocomplete({
			source: function( request, response ) {
				$.ajax({
					type: "POST",
					url: "/autocomplete_fa",
					data: {
						value:			request.term,
						flag:			id,
						flag_buy_sell: 	flag_buy_sell,
						id: 			tid
					},
					dataType: "json",
					success: function( data ) {
						response( $.map( data, function( item ) {
							return {
								label: 			item.name2,
								id: 			item.id,
								value: 			item.value,
								email: 			item.email
							}
						}));
					}
				});
			},
			minLength: 2,
			select: function( event, ui ) {
				if(ui.item.id){
					if(id=='share'){
						$(this).val(ui.item.value);
						$('#div_form_share #company_id').val(ui.item.id);
						$('#div_form_share #email').val(ui.item.email);
					}else if(id=='assets'){
						$(this).val(ui.item.value);
						$('#div_form_assets_sell #company_id').val(ui.item.id);
					}else if(id=='stock'){
						$(this).val(ui.item.value);
						$('#buy_sell-form #company_id2').val(ui.item.id);
					}else if(id=='company_id3'){
						$(this).val(ui.item.value);
						$('#buy_sell-form #company_id3').val(ui.item.id);
					}else if(id=='stock_sell'){
						$(this).val(ui.item.value);
						$('#stock_sell-form #company_id').val(ui.item.id);
					}else{
						$(this).val(ui.item.value);
						$('#offer_'+id+'-form #company_id').val(ui.item.id);
					}
				}
				return false;
			}
		}).focus(function() {
			$(this).autocomplete('search', $(this).val())
		}).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
			return $( "<li></li>" ).data( "item.autocomplete", item ).append( "<div>"+ item.label + "</div>" ).appendTo( ul );
		};
		
	});
}

// Имя заказа
function AutocompleteCommentsCompany(){
	$(".autocomplete_comments_company").each(function(indx, element) {
		var d 	= $(element).data();
		var flag_buy_sell = d.flag_buy_sell;
		$(".autocomplete_comments_company").autocomplete({
			source: function( request, response ) {
				$.ajax({
					type: "POST",
					url: "/autocomplete_comments_company",
					data: {
						value:			request.term,
						flag_buy_sell:	flag_buy_sell
					},
					dataType: "json",
					success: function( data ) {
						response( $.map( data, function( item ) {
							return {
								label: 			item.name,
								value: 			item.value,
							}
						}));
					}
				});
			},
			minLength: 2,
			select: function( event, ui ) {
				$(this).val(ui.item.value);

				return false;
			}
		}).focus(function() {
			$(this).autocomplete('search', $(this).val())
		}).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
			return $( "<li></li>" ).data( "item.autocomplete", item ).append( "<div>"+ item.label + "</div>" ).appendTo( ul );
		};
		
	});
}

// Ответственный
function AutocompleteResponsible(flag){
	$(".autocomplete_responsible").each(function(indx, element) {
		$(".autocomplete_responsible").autocomplete({
			source: function( request, response ) {
				$.ajax({
					type: "POST",
					url: "/autocomplete_responsible",
					data: {
						value:	request.term,
						flag:	flag
					},
					dataType: "json",
					success: function( data ) {
						response( $.map( data, function( item ) {
							return {
								label: 			item.name2,
								value: 			item.value,
								id: 			item.id
							}
						}));
					}
				});
			},
			minLength: 2,
			select: function( event, ui ) {
				if(ui.item.id){
					if(flag=='buy_sell'){
						$(this).val(ui.item.value);
						$('#buy_sell-form #responsible_id').val(ui.item.id);
					}else if(flag=='assets_issue'){
						$(this).val(ui.item.value);
						$('#assets_issue-form #responsible_id').val(ui.item.id);
					}else if(flag=='stock_issue'){
						$(this).val(ui.item.value);
						$('#stock_issue-form #responsible_id').val(ui.item.id);
					}
				}
				return false;
			}
		}).focus(function() {
			$(this).autocomplete('search', $(this).val())
		}).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
			return $( "<li></li>" ).data( "item.autocomplete", item ).append( "<div>"+ item.label + "</div>" ).appendTo( ul );
		};
		
	});
}

// Актив
function AutocompleteАssets(flag){
	$(".autocomplete_assets").each(function(indx, element) {
		$(".autocomplete_assets").autocomplete({
			source: function( request, response ) {
				$.ajax({
					type: "POST",
					url: "/autocomplete_assets",
					data: {
						value:	request.term,
						flag:	flag
					},
					dataType: "json",
					success: function( data ) {
						response( $.map( data, function( item ) {
							return {
								label: 			item.name2,
								value: 			item.value,
								id: 			item.id
							}
						}));
					}
				});
			},
			minLength: 2,
			select: function( event, ui ) {
				if(ui.item.id){
					if(flag=='stock_issue'){
						$(this).val(ui.item.value);
						$('#stock_issue-form #assets_id').val(ui.item.id);
					}else if(flag=='buy_sell'){
						$(this).val(ui.item.value);
						$('#buy_sell-form #assets_id').val(ui.item.id);
					}
				}
				return false;
			}
		}).focus(function() {
			$(this).autocomplete('search', $(this).val())
		}).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
			return $( "<li></li>" ).data( "item.autocomplete", item ).append( "<div>"+ item.label + "</div>" ).appendTo( ul );
		};
		
	});
}

// Сообщения
function AutocompleteMessages(){
	$(".autocomplete_messages").autocomplete({
		source: function( request, response ) {
			$.ajax({
				type: "POST",
				url: "/autocomplete_messages",
				data: {
					value:	request.term
				},
				dataType: "json",
				success: function( data ) {
					response( $.map( data, function( item ) {
						return {
							label: 			item.name2,
							id: 			item.id,
							value: 			item.value,
							messages_id: 	item.messages_id
						}
					}));
				}
			});
		},
		minLength: 2,
		select: function( event, ui ) {
			if(ui.item.id){
				$(this).val(ui.item.value);
			}
			return false;
		},
	}).focus(function() {
		$(this).autocomplete('search', $(this).val())
	}).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
		return $( "<li></li>" ).data( "item.autocomplete", item ).append( "<div>"+ item.label + "</div>" ).appendTo( ul );
	};

}


// Номенклатура из 1С
function Autocomplete1cnomenclature(flag){
	$(".autocomplete_1cnomenclature").each(function(indx, element) {
		$(".autocomplete_1cnomenclature").autocomplete({
			source: function( request, response ) {
				$.ajax({
					type: "POST",
					url: "/autocomplete_1cnomenclature",
					data: {
						value:	request.term,
						flag:	flag
					},
					dataType: "json",
					success: function( data ) {
						response( $.map( data, function( item ) {
							return {
								label: 			item.name2,
								value: 			item.value,
								id: 			item.id
							}
						}));
					}
				});
			},
			minLength: 2,
			select: function( event, ui ) {
				if(ui.item.id){
					$(this).val(ui.item.value);
					$('#nomenclature-form #1c_nomenclature_id').val(ui.item.id);
				}
				return false;
			}
		}).focus(function() {
			$(this).autocomplete('search', $(this).val())
		}).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
			return $( "<li></li>" ).data( "item.autocomplete", item ).append( "<div>"+ item.label + "</div>" ).appendTo( ul );
		};
		
	});
}


// Интересы - настройка пользователя
function Select2InterestsCompanyParam(){
	$(".save_interests_company_param").select2({
			//
		}).on("select2:select", function(e) {
			var dd = $(this).data();
			if(e.params.data.id){// выбор имеющегося значения
				$.post("/save_interests_company_param", {value:'insert' , id:e.params.data.id , 
					interests_param_id:dd.interests_param_id , interests_id:dd.interests_id, where:dd.where, flag:dd.flag, login_id:dd.login_id},
					function(data){
						if(data.ok){
							webix.message(data.code);
						}else{
							webix.message({type:"error", text:data.code});
						}
					}
					);
			}
		}).on("select2:unselect", function(e) {// отменить выброное значение
			var dd = $(this).data();
			$.post("/save_interests_company_param", {value:'delete' , id:e.params.data.id , 
				interests_param_id:dd.interests_param_id , interests_id:dd.interests_id, where:dd.where, flag:dd.flag, login_id:dd.login_id},
				function(data){
					if(data.ok){
						webix.message(data.code);
					}else{
						webix.message({type:"error", text:data.code});
					}
				}
				);
		});

		return false;
	}

// Интересы - настройка пользователя (местоположение)
function Select2InterestsCompanyParamCities(){

	$(".save_interests_company_param_cities").select2({
		ajax: {
			url: '/autocomplete_interest_cities',
			delay: 250,
			type: "POST",
			dataType: 'json',
			data: function (params) {
				var query = {
					value: params.term
				}
				return query;
			},
			processResults: function (data, params) {
				return {
					results: data.results
				};
			}
		}
	}).on("select2:select", function(e) {
		var dd = $(this).data();
			if(e.params.data.id){// выбор имеющегося значения
				$.post("/save_interests_company_param", {value:'insert' , id:e.params.data.id , 
					interests_param_id:dd.interests_param_id , interests_id:dd.interests_id, where:dd.where, flag:dd.flag, login_id:dd.login_id},
					function(data){
						if(data.ok){
							webix.message(data.code);
						}else{
							webix.message({type:"error", text:data.code});
						}
					}
					);
			}
		}).on("select2:unselect", function(e) {// отменить выброное значение
			var dd = $(this).data();
			$.post("/save_interests_company_param", {value:'delete' , id:e.params.data.id , 
				interests_param_id:dd.interests_param_id , interests_id:dd.interests_id, where:dd.where, flag:dd.flag, login_id:dd.login_id},
				function(data){
					if(data.ok){
						webix.message(data.code);
					}else{
						webix.message({type:"error", text:data.code});
					}
				}
				);
		});

		return false;
	}


// Загрузка файлов
function getUploadFiles( id ){
	
	webix.ready(function() {

		webix.ui({
			container:"container_upload_files"+id+"",
			rows:[
			{ 
				view: "uploader", id:"upload_files_buy_sell"+id+"",
				height:1,
				width:400,
				name:"files",
				link:"mylist",  upload: "/upload_files_buy_sell", autosend:false,
				on:{
					onBeforeFileAdd:function(item){
						var type = item.type.toLowerCase();
										// допустимые разрешения
										var arr = [ 'pdf','doc','docx','xls','xlsx','jpg','jpeg','gif','png','bmp','tiff' ];
										var rez = jQuery.inArray( type, arr );
										if(rez<0){
											webix.message({type:"error", text:item.name+" недопустимый тип файлов"});
											return false;
										}
									},
									onUploadComplete:function(response){
										$$("upload_files_buy_sell"+id+"").files.data.clearAll();
									}
								}/*,
								formData:{
									//flag : $('#flag_upload').val(),
									//id: $('#id_upload').val()
								}*/
							},
							{
								view:"list", scroll:false, id:"mylist", type:"uploader",
								autoheight:true, borderless:true	
							}
							]
						});

	});
}


// сохранение параметров поиска
function SaveSearchFilterParamCompany( where , categories_id , search_value , flag , flag_reload ){

	var flag_reload2 = false;

	var flag_search 	= $('#select_flag_search_where_page').val();

	if(categories_id>0){
			// оставляем переданную категорию
			flag_reload2 = true;// выбрана категория в autocomplete_search - перезагружаем страницу с текущими параматрами
		}else{
			$("#nav-category #categories_id").each(function(indx, element){
				if($(element).val()>0){
					categories_id 	= $(element).val();
				}
			});
		}
		var cities_id 		= $('#nav-location #cities_id').val();
		var interests_id 	= $('#flag_serch_interest').val();
		
		var sort_12 		= $('#sort_12').val();
		
		var sort_who 		= $('#select_sort_search_buy_sell').val();
		
		
		$.post("/save_search_filter_param_company", {	where:			where,
			flag_search:	flag_search,
			categories_id:	categories_id,
			cities_id:		cities_id,
			interests_id:	interests_id,
			flag:			flag,
			sort_12:		sort_12,
			sort_who:		sort_who
		}, 
		function(data){
				//
				if(flag_reload2||flag_reload){
					SearchBuySell( search_value , '' , false );
				}
			}
			);
		

		return false;
	};

// поздгрузить статистику по номенклатуре в заявке,предложениях
function CountStatusBuysellByNomenclature( nomenclature_id ){

	$.post("/countstatusbuysellbynomenclature", {nomenclature_id:nomenclature_id},
		function(data){
			if(data.code){
				$('#div_count_status_buysell').html(data.code);
			}
		}
		);


	return false;
};


// поиска
function SearchBuySell( value , group , enter13 , flag ){
		//alert(enter13);
		if(enter13&&value){// проверяем выводить вопросы для Этп (бренды), только по нажатию клавиши enter
			
			$.post("/search_brend_etp", { value:value , where:window.location.pathname , group:group , flag:flag  }, 
				function(data){
					if(data.code){

						$('#vmodal').removeData();

						$('#vmodal').html(data.code);
						$('#vmodal').modal();
						$('#vmodal').on('shown.bs.modal',
							function(e){

								$(".search_brend_etp").on("click", function() {
									var dd = $(this).data();

									$(this).remove();

									var values = {};
									$(".checkbox_qrq_article_id_").each(function(indx, element){
										if ($(element).prop('checked')){
											var dd = $(element).data();
											var addmenu = { brand:dd.brand };
											values[indx] = addmenu;

										}
									});

									$.post("/get_sell_by_amo_accountsetp", { values:values , value:value , categories_id:dd.categories_id },
										function(data){
											if(data.ok){
												SearchBuySell( value , group , false, 'etp_sell' );
											}
											else{
												webix.message({type:"error", text:data.code});
											}
										}
										);

								});


								$(".no_search_brend_etp").on("click", function() {
									SearchBuySell( value , group , false );
								});


							}
							).on('hidden.bs.modal', function (e) {

							});
						}else{
							SearchBuySell( value , group , false );
						}
					}
					);				
			
		}else{

			$.post("/search_buy_sell", { 	value:value, 
				where:window.location.pathname, 
				group:group, 
				enter13:enter13,
				flag:flag  }, 
				function(data){
					onReload(data.url);
				}
				);

		}

		return false;
	};


// Отправка потребностей
function ModalShareBuySell( company_id , flag_buy_sell ){
	$('#vmodal').removeData();
	var i=0;
	$("#request .checkbox_share").each(function(indx, element){
		if ($(element).prop('checked')){
			i=i+1;
		}
	});

	$.post("/modal_share_buy_sell", {company_id:company_id , flag_buy_sell:flag_buy_sell , value:i}, 
		function(data){
			if (data.code) {
				$('#vmodal').html(data.code);

				function openFinishedModal() {
					$('#vmodal').modal();
					$('#vmodal').on('shown.bs.modal',
						function (e) {
							AutocompleteFa('share', flag_buy_sell);
						}
						).on('hidden.bs.modal', function (e) {
							$('#vmodal').modal('dispose');
							$('.modal-backdrop').fadeOut(0);
						}); 
					}

					if (company_id) {
						setTimeout(() => {
							openFinishedModal()
						}, 400);
					} else {
						openFinishedModal()
					}
				}
			}
			);

	return false;
};


// Модальное окно Продано (Актив)
function ModalAssetsSell( id, company_id ){
	$('#vmodal').removeData();
	$.post("/modal_assets_sell", { id:id , company_id:company_id }, 
		function(data){

			if (data.code) {
				$('#vmodal').html(data.code);

				function openFinishedModal() {
					$('#vmodal').modal();
					$('#vmodal').on('shown.bs.modal',
						function (e) {

							AutocompleteFa('assets', 4 , id);

							$('#assets_sell-form').bootstrapValidator('destroy');
							$('#assets_sell-form').bootstrapValidator({
								feedbackIcons: {
									valid: 'glyphicon glyphicon-ok',
									invalid: 'glyphicon glyphicon-remove',
									validating: 'glyphicon glyphicon-refresh'
								},
								fields: {
									company: {
										validators: {
											notEmpty: {
												message: 'Введите'
											}
										}
									},
									cost: {
										validators: {
											notEmpty: {
												message: 'Введите'
											}
										}
									}
								}
							}).on('success.form.bv', function(e) {
								e.preventDefault();
								var $form = $(e.target);
								var bv = $form.data('bootstrapValidator');
								$.post("/save_assets_sell", $form.serialize(),
									function(data){
										if(data.ok){
											onReload('');
										}else{
											webix.message({type:"error", text:data.code});
										}
										if (bv.getInvalidFields().length > 0) {
											bv.disableSubmitButtons(false);
										}
									}
									);
							});	

						}
						).on('hidden.bs.modal', function (e) {
							$('#vmodal').modal('dispose');
						}); 
					}

					if (company_id) {
						setTimeout(() => {
							openFinishedModal()
						}, 400);
					} else {
						openFinishedModal()
					}
				}

			}
			);

	return false;
};

// Модальное окно Продано (Склад)
function ModalStockSell( id, company_id ){
	$('#vmodal').removeData();
	$.post("/modal_stock_sell", { id:id , company_id:company_id }, 
		function(data){

			if (data.code) {
				$('#vmodal').html(data.code);

				function openFinishedModal() {
					$('#vmodal').modal();
					$('#vmodal').on('shown.bs.modal',
						function (e) {

							AutocompleteFa('stock_sell', 5 , id);

							$('#stock_sell-form').bootstrapValidator('destroy');
							$('#stock_sell-form').bootstrapValidator({
								feedbackIcons: {
									valid: 'glyphicon glyphicon-ok',
									invalid: 'glyphicon glyphicon-remove',
									validating: 'glyphicon glyphicon-refresh'
								},
								fields: {
									company: {
										validators: {
											notEmpty: {
												message: 'Введите'
											}
										}
									},
									cost: {
										validators: {
											notEmpty: {
												message: 'Введите'
											}
										}
									},
									amount: {
										validators: {
											notEmpty: {
												message: 'Введите'
											}
										}
									}
								}
							}).on('success.form.bv', function(e) {
								e.preventDefault();
								var $form = $(e.target);
								var bv = $form.data('bootstrapValidator');
								$.post("/save_stock_sell", $form.serialize(),
									function(data){
										if(data.ok){
											onReload('');
										}else{
											webix.message({type:"error", text:data.code});
										}
										if (bv.getInvalidFields().length > 0) {
											bv.disableSubmitButtons(false);
										}
									}
									);
							});	

						}
						).on('hidden.bs.modal', function (e) {
							$('#vmodal').modal('dispose');
						}); 
					}

					if (company_id) {
						setTimeout(() => {
							openFinishedModal()
						}, 400);
					} else {
						openFinishedModal()
					}
				}

			}
			);

	return false;
};

// Обработка покупки со стороннего сервиса
function SaveAccountsadd(login,pass,value,id,parent_id){
	
	var rez = false;
	
	$.post( "/save_accountsadd", { login:login , pass:pass , value:value , id:id , parent_id:parent_id },
		function(data){
			if(data.ok){
				rez = true;
				webix.message(data.code);
				$('#button_'+value+'').remove();
			}else{
				webix.message({type:"error", text:data.code});
			}
		}
		);

	return rez;
};


// Обработка покупки со стороннего сервиса
function AmoBasket( json , amount , buy_sell_id , where , accounts_id , param , flag_next_qrq ){
	
	var modal_amo = $('#modal_amo');

	$.post("/amo_basket", { json:json , amount:amount , buy_sell_id:buy_sell_id , 
		where:where , accounts_id:accounts_id , value:param , flag:flag_next_qrq }, 
		function(data){
			//alert(data.flag_clear_parent+'*'+data.parent_id+'*'+buy_sell_id);
			if(data.ok){
				
				if(data.modal_errors_message){// выводим модаль с сообщением об ошибки
					modal_amo.html(data.modal_errors_message);
					modal_amo.modal();
					modal_amo.on('shown.bs.modal',
						function (e) {

							$('.next_etp_next_amo_basket').click(function () {
								modal_amo.modal('hide');
								AmoBasket( json , amount , buy_sell_id , where , accounts_id , '' , true )
							});

							$('.next_etp_stop_amo_basket').click(function () {
								modal_amo.modal('hide');
							});

						}
						).on('hidden.bs.modal', function (e) {
							$('#modal_amo').modal('dispose');
						}); 
					}else{
						if(where=="modal_offer11"){																									
							$("#div_offer"+buy_sell_id+"").html(data.code);
							if(data.flag_clear_parent){
								$("#div_mybs"+data.parent_id+"").remove();
							}
						}else if(where=="page_sell"){
							onReload("");
						}
					}

				}else{
					webix.message({type:"error", text:data.code});
				}

			}
			);

	return false;
};


// модаль настройки интеграции с 1С
function ModalServiceBind1C(){

	var d = $(this).data();
	$.post("/modal_service_bind1c", { }, 
		function(data){
			if(data.code){
				$('#vmodal').html(data.code);
				$('#vmodal').modal();
				$('#vmodal').on('shown.bs.modal',
					function(e){
						SaveMyCompanyId1c();
					}
					).on('hidden.bs.modal', function (e) {
								//onReload('/profile');
							});
				}
			}
			);

	return false;
};


// Подписаться/Отписаться 
function ActionSubscriptions(id,where){
	
	$.post("/action_subscriptions", { id:id , where:where }, 
		function(data){
			if(where=='company_profile'){
				if (data.ok) {
					webix.message(data.code);
					$('#div_subscriptions').html(data.button);
				}else{
					webix.message({type:"error", text:data.code});
				}
			}else if(where=='share'){
				if (data.ok) {
					webix.message(data.code);
					obj.remove();
				}else{
					webix.message({type:"error", text:data.code});
				}
			}else{
				if (data.ok) {
					webix.message(data.code);
							//obj.parent().html(data.button);
							$('#count_subscriptions').html(data.count);
						}else{
							webix.message({type:"error", text:data.code, expire:300000});
						}
					}
				}
				);

}


/***
  *  Вспомогательные функции  End
  ***/






/***
  *		Инициализация библиотек Begin
  ***/
//
function getOnlyNumber(){
	$('.onlynumber').bind("change keyup input click", function() {
		if (this.value.match(/[^0-9,.]/g)) {
			this.value = this.value.replace(/[^0-9,.]/g, '');
		}
	});
}

// маска input ед.изм.
function MaskInput(){

	$(".vmask_coefficient").each(function(indx, element){
		$(element).mask('99999999999.9');
	});


	$(".vmask1").mask("Z0999999.00", {

		translation: {
			'0': {pattern: /\d/},
			'9': {pattern: /\d/, optional: true},
			'Z': {pattern: /[\-\+]/, optional: true}
		}

	});
		/*
		$(".vmask1").each(function(indx, element){
				$(element).mask('99999999999');
				
				$(element).bind("keyup", function() {
					this.value = this.value.replace(/^0/g, '');
				});
				
		});
		*/
	}

// маска input ед.изм.
function MaskUnit(id_form){

	$(""+id_form+" .vmask").each(function(indx, element){

				$(element).unbind( "keyup" );// отменяем 
				
				var id_elem = 'div_krat_'+$(element).attr('name')+'';
				
				var d = $(this).data();
				
				if(d.unit_id==1){
					$(element).mask('99999999999');
					//$('#'+id_elem+'').fadeOut(0);
					$(element).bind("keyup", function() {
						//$('#'+id_elem+'').fadeOut(0);
						this.value = this.value.replace(/^0/g, '');
					});
				}else{
					//this.value = this.value.replace(/,/g, '.');
					$(element).mask('99999999999.99');
					$(element).bind("keyup", function() {
							//if (this.value.indexOf(".")>0) {
							//	$('#'+id_elem+'').fadeIn(0);
							//}else{
							//	$('#'+id_elem+'').fadeOut(0);
							//}
							this.value = this.value.replace(/^00/g, '0');
						});
				}

				//alert($(element).attr('name')+'***'+d.unit_id);
			});
}

//инициализация maskedinput
function getDatePicker(){
	// Дата Накладной
	$( "#__" ).each(function( index ) {
		var date = new Date(); 
		var year = date.getFullYear();
		$(this).datepicker({
			dayNamesMin: ["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
			dayNames: ["Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"],
			monthNames: ["Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь"],
			monthNamesShort: ["Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь"],
			firstDay: 1,
			dateFormat: "dd.mm.yy",
			onSelect: function (date, inst) {
				$("#invoice-form").bootstrapValidator("revalidateField", "curdata");
			}
		});
		$(this).mask("99.99.9999");	
	});
	

	
	$.fn.modal.Constructor.prototype.enforceFocus = function() {};// changeMonth - bag in modal
}
/***
  *		Инициализация библиотек end
  ***/


// поиск из main.js
function MainJs_Search(){
	
	var i_click = 1;
	
	$('.nav-link span, .nav-link .cancel-choose').click(function () {
		$('.hidden-wrapper .tab-pane').removeClass('active');
		$('.search-top').removeClass('cat-tab-active')
		if ($(this).parent().attr('aria-controls') == 'category') $(this).closest('.search-top').addClass('cat-tab-active');
	});
	$('#flag_serch_interest').on('change', function(){
		SaveSearchFilterParamCompany('modal');
	});
	$('.app-wrapper button').click(function () {
		$('.app-wrapper button').removeClass('active');
		$(this).addClass('active');
		$('.first-link span').text($(this).text())
		$('.first-link').addClass('choosen');
		$('.nav-first').removeClass('active');
		$('.first-link img').attr('src', $(this).data('src'));
	});
	$('.first-link .cancel-choose').click(function () {
		$('.first-link').removeClass('choosen');
		$('.nav-first').addClass('active');
	});
	$('.location-link .cancel-choose').click(function () {
		$('.location-link span').text('Город');
		$('.location-link').removeClass('choosen');
		$('.nav-location').addClass('active');
		$('.autocomplete_cities ').val('');

		var d = $(this).data();

		if(d.flag=='clear_location_search'){
			$('#nav-location #cities_id').val(0);
			SaveSearchFilterParamCompany('modal');
		}
	});
	$('.first-link').click(function () {
		$('.nav-first').addClass('active');
	});
	$('.category-link').click(function () {
		$('.nav-category').addClass('active');
	})

	$('.cat-changer p, .category-link .cancel-choose').click(function (event) {
		
		var d = $(this).data();
		if(d.flag=='search'){
			$('#nav-category #categories_id').val(d.categories_id);
			SaveSearchFilterParamCompany('modal');
			$('.category-link span').text($(this).text());
		}else{
			$('.category-link span').text('Категория');
		}
		
		
		$('.category-link').removeClass('choosen');
		$('.nav-category').addClass('active');

		$('.cat-changer p').removeClass('active');
		$('.element-1 p').removeClass('active');
		$('.element-2 p').removeClass('active');
		$('.element-3 p').removeClass('active');
		$('.element-4 p').removeClass('active');
		$(this).addClass('active');
		var listOne = $(this).data('block');
		// $('.list-element div').animate({width: 0}, 200)
		setTimeout(function () {
			$('.list-element:not(.element-3) div').css('display', 'none');
			$('.list-element div p').removeClass('active');
			$('.element-1 .' + listOne).css('display', 'block');
		//   $('.element-1 .' + listOne).animate({width: 193}, 200);
	}, 150);
		
		var d = $(this).data();
		if(d.flag=='clear_category_search'){
			$('#nav-category #categories_id').val(0);
			SaveSearchFilterParamCompany('modal');
		}
	});
	$('.element-1 p').click(function (event) {
		
		var d = $(this).data();
		if(d.flag=='search'){
			$('#nav-category #categories_id').val(d.categories_id);
			SaveSearchFilterParamCompany('modal');
			$('.category-link span').text($(this).text());
		}
		
		$('.element-1 p').removeClass('active');
		$('.element-2 p').removeClass('active');
		$('.element-3 p').removeClass('active');
		$(this).addClass('active');
		var listOne = $(this).data('block');
		// $('.element-2 div').animate({width: 0}, 200);
		// $('.element-3 div').animate({width: 0}, 200);
		setTimeout(function () {
			$('.element-2 div').css('display', 'none');
			$('.element-3 div').removeClass('active');
			$('.element-2 .' + listOne).css('display', 'block');
		//   $('.element-2 .' + listOne).animate({width: 200}, 200);
	}, 150);
	});
	$('.element-2 p').click(function (event) {
		
		var d = $(this).data();
		if(d.flag=='search'){
			$('#nav-category #categories_id').val(d.categories_id);
			SaveSearchFilterParamCompany('modal');
			$('.category-link span').text($(this).text());
		}		
		
		$('.element-2 p').removeClass('active');
		$('.element-3 p').removeClass('active');
		$(this).addClass('active');
		let listOne = $(this).data('block');
		let activeEL = $('.element-3 .' + listOne);
		// $('.element-3 div').animate({width: 0}, 200);
		setTimeout(function () {
			$('.element-3 div').removeClass('active');
			$('.list-wrapper').removeClass('el-3_wild');
			
			// $('.element-3 div').css('display', 'none');
			// $('.element-3 .' + listOne).css('display', 'flex');
			activeEL.addClass('active');
			if (activeEL.height() > 650) {
				activeEL.addClass('wild')
				$('.list-wrapper').addClass('el-3_wild')
			}
			if (activeEL.hasClass('wild')) $('.list-wrapper').addClass('el-3_wild');
		//   $('.element-3 .' + listOne).animate({width: 390}, 200);
	}, 150);
	});
	$('.element-3 p').click(function (event) {
		
		var d = $(this).data();
		if(d.flag=='buy_sell'||d.flag=='nomenclature'){
			$('#'+d.flag+'-form #categories_id').val(d.categories_id);
			var nomenclature_id = $('#'+d.flag+'-form #nomenclature_id').val();
			ChangeCategoriesBuySell(d.categories_id,d.flag_buy_sell,d.flag,nomenclature_id,'');
		}else if(d.flag=='search'){
			$('#nav-category #categories_id').val(d.categories_id);
			SaveSearchFilterParamCompany('modal');
		}else if(d.flag=='search_categories'){
			$('#search_categories-form #categories_id').val(d.categories_id);
			$.post('/change_categories_buy_sell', { id:d.categories_id , flag:'nomenclature' }, 
				function(data){

										$('#search_categories-form').bootstrapValidator('destroy');// важно до изменения формы
										
										$('#div_categories_buy_sell').html(data.code);
										
										$(".select2").select2({
											placeholder: function(){
												$(this).data('placeholder');
											}
										});
										
										Select2UsersAttributeValue();
										
										SaveSearchCategories();
									}
									);
		}
		
		$('.element-3 p').removeClass('active');
		$(this).addClass('active');
		$('.category-link span').text($(this).text());
		$('.category-link').addClass('choosen');
		$('.nav-category').removeClass('active');
		if ($('.location-link').hasClass('choosen') && $('.category-link').hasClass('choosen')) {
			$('.search-after').addClass('search-after-colored');
		} else {
			$('.search-after').removeClass('search-after-colored')
		}
	});
	$('.app-cat-wrapper .element-3 p').click(function () {
		$('.element-3 p').removeClass('active');
		$(this).addClass('active');
		$('.app-changer .part .naming').text($(this).text());
		$('.part').addClass('choosen');
		$('.app-cat-wrapper').addClass('d-none');
		$('.first-row, .second-row').removeClass('d-none');
	})
	$('.app-wrapper p').click(function (event) {
		$('.app-wrapper p').removeClass('active');
		$(this).addClass('active');
	});
}


function ChangeCategoriesBuySell(categories_id,flag_buy_sell,flag,nomenclature_id,search_categories_id) {

	$.post('/change_categories_buy_sell', { id:					categories_id,
		flag_buy_sell:		flag_buy_sell,
		flag:				flag,
		nomenclature_id:	nomenclature_id,
		search_categories_id:	search_categories_id }, 
		function(data){

										$('#buy_sell-form').bootstrapValidator('destroy');// важно до изменения формы
										
										$('#div_categories_buy_sell').html(data.code);
										
										if(data.required_name){
											$('#buy_sell-form #name').prop('required',true).attr('required','required');
										}else{
											$('#buy_sell-form #name').removeAttr('required');
										}
										
										if(data.required_file){
											$('#buy_sell-form #cam').prop('required',true).attr('required','required');
										}else{
											$('#buy_sell-form #cam').removeAttr('required');
										}
										
										
										$(".select2").select2({
											placeholder: function(){
												$(this).data('placeholder');
											}
										});


										$("#unit_id1").on("change", function() {// Выбрать единицу измерения, фасовка
											var d = $(this).data();	
											var unit_id = $(this).val();

											if(unit_id==1){
												$('#buy_sell-form #div_amount_unit2').fadeIn(0);

											}else{
												$('#buy_sell-form #div_amount_unit2').fadeOut(0);
											}

											$("#buy_sell-form [name='amount1']").data('unit_id', unit_id).attr('data-unit_id', unit_id);

											MaskUnit('#buy_sell-form');
										});
										
										MaskUnit('#buy_sell-form');
										
										MaskInput();

										SaveBuySell($('#vmodal',false));
										
										Select2UsersAttributeValue();
										
										$('#span_select_categories .naming').html(data.categories);
									}
									);

}



// Скопировать в буфер
function myCopyText(value) {

	//$("body").append('<input type="text" value="'+value+'" id="myCopyText">');
	$('#myCopyText').html(value);
	setTimeout(function() {	
		var copyText = document.getElementById("myCopyText");
		copyText.select();
		document.execCommand("copy");
		document.getElementById("myCopyText").remove();
		webix.message('Выполнено');
	}, 1500);

}  

$(document).ready(()=>{
	$('body').on('click', 'form[id^="offer_"] .request-btn', function (e) {
		e.preventDefault();
		let form = $(this).closest('form');
		form.submit();
		form.find('.has-success .require-input').attr('style', 'border:solid 1px #c0c0c0 !important');
		form.find('.has-error .require-input').attr('style', '');

		let errorEl = form.find('.offer-form_sec .has-error').last();

		if (errorEl.length && errorEl.offset().top != errorEl.closest('.offer-form_sec').offset().top ) {
			let btnMore = form.find('.request-hidden-more');
			btnMore.addClass('active');
			btnMore.closest('.offer-form_sec').find('.offer-form_sec-main').addClass('active');
			btnMore.find('.request-hidden-more__text').text('Свернуть');
		}
	})
})