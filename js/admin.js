$(function(){
	var modal = $('#vmodal');

	
	// модальное окно Администрирование Категории
	$("body").on("click", ".modal_admin_categories", function(){
		var d =  $(this).data();
			$.post("/modal_admin_categories", {id:d.id,parent_id:d.parent_id,level:d.level}, 
				function(data){
					if(data.code){
						modal.html(data.code);
						modal.modal();
						modal.on('shown.bs.modal',
								function(e){
										//feather.replace();
										
										$(".select2").select2();
										$(".save_type_attribute").select2({
											dropdownParent: $('.modal-content'),
										});
										getCheckbox();
										Select2AttributeValue();
										
										$(".richtext").trumbowyg();
										
										$('#admin_categories-form').bootstrapValidator('destroy');
										$('#admin_categories-form').bootstrapValidator({
											feedbackIcons: {
												valid: 'glyphicon glyphicon-ok',
												invalid: 'glyphicon glyphicon-remove',
												validating: 'glyphicon glyphicon-refresh'
											},
											fields: {
												categories: {
													validators: {
														notEmpty: {
															message: 'Введите категорию'
														}
													}
												}
											}
										}).on('success.form.bv', function(e) {
											e.preventDefault();
											var $form = $(e.target);
											var bv = $form.data('bootstrapValidator');
												$.post("/save_admin_categories", $form.serialize(),
													function(data){
															if(data.ok){
																//onReload('');
																modal.modal('hide');
																webix.message('Сохранено');
															}else{
																webix.message({type:"error", text:data.code});
															}
															if (bv.getInvalidFields().length > 0) {
																bv.disableSubmitButtons(false);
															}
													}
												);
										});
										editFieldsSelect2OnQuantity();
								}
						).on('hidden.bs.modal', function (e) {
								modal.remove();
						});
					}
				}
			);
	});
	
	// модальное окно Администрирование Атрибуты
	$("body").on("click", ".modal_admin_attribute", function(){
		var d = $(this).data();
			$.post("/modal_admin_attribute", {id:d.id,parent_id:d.parent_id,level:d.level}, 
				function(data){
					if(data.code){
						modal.html(data.code);
						modal.modal();
						modal.on('shown.bs.modal',
								function(e){
										feather.replace();
										getCheckbox();
										$('#admin_attribute-form').bootstrapValidator('destroy');
										$('#admin_attribute-form').bootstrapValidator({
											feedbackIcons: {
												valid: 'glyphicon glyphicon-ok',
												invalid: 'glyphicon glyphicon-remove',
												validating: 'glyphicon glyphicon-refresh'
											},
											fields: {
												attribute: {
													validators: {
														notEmpty: {
															message: 'Введите атрибут'
														}
													}
												}
											}
										}).on('success.form.bv', function(e) {
											e.preventDefault();
											var $form = $(e.target);
											var bv = $form.data('bootstrapValidator');
												$.post("/save_slov_attribute", $form.serialize(),
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
								modal.remove();
						});
					}
				}
			);
	});
	
	// модальное окно Поисковый запрос
	$("body").on("click", ".modal_admin_change_level_categories", function(){
		var d = $(this).data();
			$.post("/modal_admin_change_level_categories", {id:d.id}, 
				function(data){
					if(data.code){
						modal.html(data.code);
						modal.modal();
						modal.on('shown.bs.modal',
								function(e){
										$(".select2").select2();
										$('#admin_change_level_categories-form').bootstrapValidator('destroy');
										$('#admin_change_level_categories-form').bootstrapValidator({
											feedbackIcons: {
												valid: 'glyphicon glyphicon-ok',
												invalid: 'glyphicon glyphicon-remove',
												validating: 'glyphicon glyphicon-refresh'
											},
											fields: {
												categories_id: {
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
											bv.disableSubmitButtons(false);
												$.post("/save_admin_change_level_categories", $form.serialize(),
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
								modal.remove();
						});
					}
				}
			);
	});
	
	// Администрирование - Связываем Категории и Атрибуты
	$("body").on("dblclick", ".td_attribute", function(){
		var obj = $(this);
		var d = obj.data();
		var obj2 = $('#sort'+d.categories_id+''+d.attribute_id+'');
		$.post('/save_categories_attribute', { categories_id:d.categories_id , attribute_id:d.attribute_id , active:d.active }, 	
							function(data){
								if(data.ok){
									webix.message(data.code);
									obj.removeClass(data.removeclass).addClass(data.addclass);
									obj.data('active', data.active).attr('data-active', data.active);
									obj2.data('id', data.id).attr('data-id', data.id);
									if(data.active==1){
										obj2.fadeIn(0);
									}else{
										obj2.fadeOut(0);
									}
								}else{
									webix.message({type:"error", text:data.code});
								}		
							}
		);
	});
	
	// Администрирование - Сортировка (Категории, Атрибуты и т.п.)
	$("body").on("blur", ".change_sort", function(){
		var obj = $(this);
		var d = obj.data();
		$.post('/save_change_sort', { table:d.table , id:d.id, value:$(this).val() }, 	
							function(data){
								if(data.ok){
									webix.message(data.code);
								}else{
									webix.message({type:"error", text:data.code});
								}		
							}
		);
	});
	
	// Администрирование - Сохранить тип атрибута
	$("body").on("change", ".save_type_attribute", function(){
		var obj = $(this);
		var d = obj.data();
		$.post('/save_type_attribute', { id:d.id , flag:d.flag , value:$(this).val() }, 	
							function(data){
								if(data.ok){
									webix.message(data.code);
								}else{
									webix.message({type:"error", text:data.code});
								}		
							}
		);
	});	
	
	// Администрирование - Атрибуты (обязательные поля для заполнения)
	$("body").on("blur", ".save_no_empty_categories_attribute", function(){
		var obj = $(this);
		var d = obj.data();
		$.post('/save_no_empty_categories_attribute', { flag:d.flag , id:d.id, value:$(this).val() }, 	
							function(data){
								if(data.ok){
									webix.message(data.code);
								}else{
									webix.message({type:"error", text:data.code});
								}		
							}
		);
	});
	
	// Администрирование - checkbox группировка
	$("body").on("click", ".checkbox_grouping_sell", function(){
		var obj = $(this);
		var d = obj.data();
		var value;
		if ($(this).prop('checked')){
			value = 1;
		}else{
			value = 0;
		}
		$.post('/save_grouping_sell', { id:d.id, value:value }, 	
							function(data){
								if(data.ok){
									webix.message(data.code);
								}else{
									webix.message({type:"error", text:data.code});
								}		
							}
		);
	});
	
	// Администрирование - checkbox активы
	$("body").on("click", ".checkbox_assets", function(){
		var obj = $(this);
		var d = obj.data();
		var value;
		if ($(this).prop('checked')){
			value = 1;
		}else{
			value = 0;
		}
		$.post('/save_assets', { id:d.id, value:value }, 	
							function(data){
								if(data.ok){
									webix.message(data.code);
								}else{
									webix.message({type:"error", text:data.code});
								}		
							}
		);
	});	
	
	// Администрирование - Добавить в модальном окне Атрибут-строку
	$("body").on("click", "#add_select_attribute", function(){
		var obj = $(this);
		var d = obj.data();
		$.post('/add_select_attribute', { categories_id:d.categories_id }, 	
							function(data){
								obj.closest('.buttons-row').before(data.code);
								Select2Attribute();
							}
		);
	});	
	
	
	// Администрирование - Значение Атрибута (редактирование)
	$("body").on("blur", ".update_slov_attribute_value", function(){
		var obj = $(this);
		var d = obj.data();
		$.post('/save_slov_attribute_value', { id:d.id, value:$(this).val() }, 	
							function(data){
								if(data.ok){
									webix.message(data.code);
								}else{
									webix.message({type:"error", text:data.code});
								}		
							}
		);
	});
	// Администрирование - Значение Атрибута (удаление)
	$("body").on("click", ".delete_slov_attribute_value", function(){
		var obj = $(this);
		var d = obj.data();
		webix.confirm({
			ok: "Удалить", cancel:"Отмена",
			text: "Удалить "+d.text+" ?",
			callback:function(result){
				if(result){
						$.post('/delete_slov_attribute_value', { id:d.id }, 	
											function(data){
												if(data.ok){
													$('#div_attribute_value'+d.id+'').remove();
												}else{
													webix.message({type:"error", text:data.code});
												}		
											}
						);
				}
			}
		});
	});	
	// Администрирование - Атрибут в Категории (удаление)
	$("body").on("click", ".delete_categories_attribute", function(){
		var obj = $(this);
		var d = obj.data();
		webix.confirm({
			ok: "Удалить", cancel:"Отмена",
			text: "Удалить "+d.text+" ?",
			callback:function(result){
				if(result){
						$.post('/delete_categories_attribute', { id:d.id }, 	
											function(data){
												if(data.ok){
													$('#div_categories_attribute'+d.id+'').remove();
												}else{
													webix.message({type:"error", text:data.code});
												}		
											}
						);
				}
			}
		});
	});
	
	// Администрирование - Создать поисковый запрос из имеющихся
	$("body").on("click", ".add_admin_search", function(){
		var obj = $(this);
		var d = obj.data();
		webix.confirm({
			ok: "Создать", cancel:"Отмена",
			text: "Создать "+d.text+" ?",
			callback:function(result){
				if(result){
						SaveAdminSearch(obj);
				}
			}
		});
	});
	// Администрирование - Удалить поисковый запрос
	$("body").on("click", ".delete_search_request", function(){
		var obj = $(this);
		var d = obj.data();
		webix.confirm({
			ok: "Удалить", cancel:"Отмена",
			text: "Удалить "+d.text+" ?",
			callback:function(result){
				if(result){
						$.post('/delete_search_request', { id:d.id }, 	
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
	
	// модальное окно "Поисковый запрос по Категории"
	$("body").on("click", ".modal_search_categories", function(){
		//$('#vmodal').removeData();
		var d = $(this).data();
			$.post("/modal_search_categories", { id:d.id }, 
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
									
										MainJs_Search();
									
										$(".select2").select2({
											    placeholder: function(){
													$(this).data('placeholder');
												}
										});
										
										Select2UsersAttributeValue();

										SaveSearchCategories();
										
								}
						).on('hidden.bs.modal', function (e) {
								modal.modal('dispose');
						});
					}
				}
			);
	});
	
	// удалить "Поисковый запрос по Категории"
	$("body").on("click", ".delete_search_categories", function(){
		var d = $(this).data();
		webix.confirm({
			ok: "Удалить", cancel:"Отмена",
			text: "Удалить "+d.name+" ?",
			callback:function(result){
				if(result){
						$.post( "/delete_search_categories", { id:d.id }, 
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
	
	// Подключить/Отключить Pro режим
	$("body").on("click", ".admin_pro_mode", function(){
		var obj = $(this);
		var d = obj.data();
		$.post('/admin_pro_mode', { id:d.id }, 	
					function(data){
						if(data.ok){
							onReload('');
						}else{
							webix.message({type:"error", text:data.code});
						}		
					}
		);
	});

	// модальное окно "Поставщики AMO"
	$("body").on("click", ".modal_admin_qrq", function(){
		//$('#vmodal').removeData();
		var d = $(this).data();
			$.post("/modal_admin_qrq", { id:d.id }, 
				function(data){
					if(data.code){
						modal.html(data.code);
						modal.modal();
						modal.on('shown.bs.modal',
								function(e){
										
										$('#admin_qrq-form').bootstrapValidator('destroy');
										$('#admin_qrq-form').bootstrapValidator({
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
												$.post("/save_admin_qrq", $form.serialize(),
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
	
	
	// модальное окно "ЭТП"
	$("body").on("click", ".modal_admin_etp", function(){
		//$('#vmodal').removeData();
		var d = $(this).data();
			$.post("/modal_admin_etp", { id:d.id }, 
				function(data){
					if(data.code){
						modal.html(data.code);
						modal.modal();
						modal.on('shown.bs.modal',
								function(e){
										
										get_intlTelInput("phone","ru");
										getCheckbox();
										
										$( "#admin_etp-form .select2" ).each(function( index ) {
												$(this).select2({
														placeholder: function(){
															$(this).data("placeholder");
														}
												});
										});
										
										$('#admin_etp-form').bootstrapValidator('destroy');
										$('#admin_etp-form').bootstrapValidator({
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
											var bv = $form.data('bootstrapValidator');
													var iti = $('#admin_etp-form #country-listbox').attr('aria-activedescendant');
													var arr = iti.split('-');
												$.post("/save_admin_etp", $form.serialize()+'&value='+arr[2],
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
	
	
	
	// модальное окно "ЭТП ошибки"
	$("body").on("click", ".modal_admin_etp_errors", function(){
		//$('#vmodal').removeData();
		var d = $(this).data();
			$.post("/modal_admin_etp_errors", { id:d.id }, 
				function(data){
					if(data.code){
						modal.html(data.code);
						modal.modal();
						modal.on('shown.bs.modal',
								function(e){
										
										getCheckbox();
										
										$('#admin_etp_errors-form').bootstrapValidator('destroy');
										$('#admin_etp_errors-form').bootstrapValidator({
											//
										}).on('success.form.bv', function(e) {
											e.preventDefault();
											var $form = $(e.target);
											var bv = $form.data('bootstrapValidator');
												$.post("/save_admin_etp_errors", $form.serialize(),
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
	
	
	// удалить "ЭТП ошибки"
	$("body").on("click", ".delete_admin_etp_errors", function(){
		var d = $(this).data();
		webix.confirm({
			ok: "Удалить", cancel:"Отмена",
			text: "Удалить "+d.name+" ?",
			callback:function(result){
				if(result){
						$.post( "/delete_admin_etp_errors", { id:d.id }, 
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
	
	
	
	
	// Сохранить vendorid для ЭТП
	$("body").on("click", ".save_admin_slov_qrq", function(){
		var obj = $(this);
		var d = obj.data();
		var promo;
		if ($('#promo'+d.id+'').prop('checked')){
			promo = 1;
		}else{
			promo = 0;
		}
		if ($('#flag_autorize'+d.id+'').prop('checked')){
			flag_autorize = 1;
		}else{
			flag_autorize = 0;
		}
		var vendorid 		= $('#vendorid'+d.id+'').val();
		var qrq 			= $('#qrq'+d.id+'').val();
		$.post('/save_admin_slov_qrq', { id:d.id , company_id:d.company_id , promo:promo , 
											flag:flag_autorize , vendorid:vendorid , name:qrq }, 	
					function(data){
						if(data.ok){
							webix.message(data.code);
							$('#div_etp_account'+d.company_id+'').html(data.tr);
						}else{
							webix.message({type:"error", text:data.code});
						}		
					}
		);
	});
	
	
	// Создать аккаутн для ЭТП (на qwep)
	$("body").on("click", ".connect_admin_slov_qrq", function(){
		var obj = $(this);
		var d = obj.data();
		$.post('/connect_admin_slov_qrq', { id:d.id , company_id:d.company_id , flag:d.flag },
					function(data){
						if(data.ok){
							webix.message(data.code,"info",10000);
							$('#div_etp_account'+d.company_id+'').html(data.tr);
						}else{
							webix.message({type:"error", text:data.code,expire:10000});
						}		
					}
		);
	});	
	
	
	
	// модальное окно "Компании"
	$("body").on("click", ".modal_admin_company", function(){
		//$('#vmodal').removeData();
		var d = $(this).data();
			$.post("/modal_admin_company", { id:d.id }, 
				function(data){
					if(data.code){
						modal.html(data.code);
						modal.modal();
						modal.on('shown.bs.modal',
								function(e){
										
										getCheckbox();
										
										$('#admin_company-form').bootstrapValidator('destroy');
										$('#admin_company-form').bootstrapValidator({
											//
										}).on('success.form.bv', function(e) {
											e.preventDefault();
											var $form = $(e.target);
											var bv = $form.data('bootstrapValidator');
												$.post("/save_admin_company", $form.serialize(),
													function(data){
															if(data.ok){
																onReload('');
															}else{
																webix.message({type:"error", text:data.code});
															}
															
															bv.disableSubmitButtons(false);
															
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
	
	// Подключить/Отключить Pro режим
	$("body").on("click", ".add_tr_admin_slov_qrq", function(){
		var obj = $(this);
		var d = obj.data();
		$.post('/add_tr_admin_slov_qrq', { company_id:d.company_id }, 	
					function(data){
						obj.before(data.code);
						obj.remove();
					}
		);
	});
	
	
	
	// модальное окно города Етп (связка с нашими)
	$("body").on("click", ".modal_admin_etp_cities", function(){
		//$('#vmodal').removeData();
		var d = $(this).data();
			$.post("/modal_admin_etp_cities", { id:d.id }, 
				function(data){
					if(data.code){
						modal.html(data.code);
						modal.modal();
						modal.on('shown.bs.modal',
								function(e){
									
										$(".select2").select2();
										
										$('#admin_etp_cities-form').bootstrapValidator('destroy');
										$('#admin_etp_cities-form').bootstrapValidator({
											//
										}).on('success.form.bv', function(e) {
											e.preventDefault();
											var $form = $(e.target);
											var bv = $form.data('bootstrapValidator');
												$.post("/save_admin_etp_cities", $form.serialize(),
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
	
	
	
	
	// удалить "accounts_id" страница admin_etp
	$("body").on("click", ".delete_admin_etp_accounts_id", function(){
		var d = $(this).data();
		webix.confirm({
			ok: "Удалить", cancel:"Отмена",
			text: "Удалить "+d.name+" ?",
			callback:function(result){
				if(result){
						$.post( "/delete_admin_etp_accounts_id", { id:d.id , accounts_id:d.accounts_id }, 
							function(data){
									if(data.ok){
										webix.message(data.code);
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
	
	
	
});//end $(function())

function editFieldsSelect2OnQuantity() {
    let itemsWrapHidden = '.save_attribute_value';
    let itemsWrap = '.select2-selection__rendered';
    let itemsQuan = 0;
    console.log($(itemsWrap))
    for (let i = 0; i < $(itemsWrapHidden).length; i++) {
        let curItem = itemsWrapHidden + `:eq(${i})`;
        let curItemSelect2 = curItem + ' + .select2 ';
        itemsQuan = $(curItem + ' option:selected').length;

        if ($(curItemSelect2 + '.select2-display-title').length) {
        	$(curItemSelect2 + '.select2-display-title').text('(' + itemsQuan + ')')
        } else {
	        $(curItemSelect2 + itemsWrap).prepend(`<span class="select2-display-title">(` + itemsQuan + `)</span>`);
        }
    }

	if ($('.select2-results__option').length > 1) {
		$('.select2-results__option').removeClass('select2-results__option--highlighted');
		$('.select2-results__option:eq(1)').addClass('select2-results__option--highlighted');
	}
    
}
$(document).ready(function() {
	$('body').on('input', '.select2-search__field', function() {
		editFieldsSelect2OnQuantity();
	})
})

// Выпадающий список с возможностью добавления значения атрибута
function Select2AttributeValue(){
		$(".save_attribute_value").select2({
			//placeholder: "-- Select --",
			//multiple: true,
			tags: true,
			// dropdownParent: $('[id*="div_categories_attribute"]'),
			dropdownParent: $('.modal-content '),
			//tokenSeparators: [",", " "],
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
				
				// append the new option element prenamently:
				$(this).find('[value="'+e.params.data.id+'"]').replaceWith('<option selected value="'+e.params.data.id+'">'+e.params.data.text+'</option>');
				$.post("/save_slov_attribute_value", {value:e.params.data.id , categories_id:dd.categories_id , attribute_id:dd.attribute_id},
					function(data){
						if(data.ok){
							webix.message(data.code);
							editFieldsSelect2OnQuantity();
						}else{
							webix.message({type:"error", text:data.code});
						}
					}
				);
			}else if(e.params.data.id){// выбор имеющегося значения
				$.post("/save_attribute_value", {flag:'insert' , id:e.params.data.id , categories_id:dd.categories_id , attribute_id:dd.attribute_id},
					function(data){
						if(data.ok){
							webix.message(data.code);
							editFieldsSelect2OnQuantity();
						}else{
							webix.message({type:"error", text:data.code});
						}
					}
				);
			}
		}).on("select2:unselect", function(e) {// отменить выброное значение
			var dd = $(this).data();
			$.post("/save_attribute_value", {flag:'delete' , id:e.params.data.id , categories_id:dd.categories_id , attribute_id:dd.attribute_id},
				function(data){
					if(data.ok){
						webix.message(data.code);
						editFieldsSelect2OnQuantity();
					}else{
						webix.message({type:"error", text:data.code});
					}
				}
				);
		});

	return false;
}

// Выпадающий список атрибута и возможностью добавление атрибута
function Select2Attribute(){
		$(".save_attribute").select2({
			//placeholder: "Выбрать/Добавить поле",
			//multiple: true,
			tags: true,
			dropdownParent: $('.modal-content '),
			//tokenSeparators: [",", " "],
			createTag: function (tag) {
				return {
					id: tag.term,
					text: tag.term,
					isNew : true
				};
			}
		}).on("select2:select", function(e) {
			var obj = $(this);
			var dd = obj.data();
			if(e.params.data.isNew){// создание новоги значения и его выбор
				
				// append the new option element prenamently:
				$(this).find('[value="'+e.params.data.id+'"]').replaceWith('<option selected value="'+e.params.data.id+'">'+e.params.data.text+'</option>');
				$.post("/save_slov_attribute", { active:1 , attribute:e.params.data.id , categories_id:dd.categories_id },
					function(data){
							if(data.ok){
								obj.parent().parent().remove();
								webix.message(data.code);
								$('#add_select_attribute').closest('.buttons-row').before(data.div);
								$(".save_type_attribute").select2({
									dropdownParent: $('.modal-content '),
								});
								Select2AttributeValue();
								editFieldsSelect2OnQuantity();
							}else{
								webix.message({type:"error", text:data.code});
							}
					}
				);
			}else if(e.params.data.id){// выбор имеющегося значения
				$.post("/save_categories_attribute", {active:2 , attribute_id:e.params.data.id , categories_id:dd.categories_id},
					function(data){
							if(data.ok){
								obj.parent().parent().remove();
								webix.message(data.code);
								$('#add_select_attribute').closest('.buttons-row').before(data.div);
								$(".save_type_attribute").select2({
									dropdownParent: $('.modal-content '),
								});
								Select2AttributeValue();
								editFieldsSelect2OnQuantity();
							}else{
								webix.message({type:"error", text:data.code});
							}
					}
				);
			}
		});

	return false;
}

// Сохранить поисковый запрос
function SaveAdminSearch(obj){
		var d = obj.data();
		$.post("/save_admin_search", {id:d.id , flag:d.flag , flag_search:d.flag_search , categories_id:d.categories_id, value:d.value},
				function(data){
						if(data.ok){
							onReload('');
						}else{
							webix.message({type:"error", text:data.code});
						}
				}
		);


	return false;
}


// Сохранить Поисковый запрос
function SaveSearchCategories(){
		$('#search_categories-form').bootstrapValidator('destroy');
		$('#search_categories-form').bootstrapValidator({
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
			bv.disableSubmitButtons(false);// УБРАТЬ
			var categories_id=$('#categories_id').val();
			if(categories_id>0){
				
				
				$.post("/save_search_categories", $form.serialize(),
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
				
			}else{
				webix.message({type:"error", text:"Выберите Категорию"});
			}
		});


	return false;
}
