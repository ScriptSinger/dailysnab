$(function(){
	//Блоки "кнопка вверх"
	$("body").append("<div id='loading'><img src='/image/loading.gif'/></div> <a href='#top' id='back_top' class='hidden_' title='вверх'><img src='/image/back-top.png'/></a>");


	//форма авторизации
	$('#_login-form').bootstrapValidator({
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
                        }
                    }
                },
                pass: {
                    validators: {
                        notEmpty: {
                            message: 'Введите пароль'
                        }
                    }
                }
            }
        }).on('success.form.bv', function(e) {
            e.preventDefault();
            var $form = $(e.target);
            var bv = $form.data('bootstrapValidator');
			$.post("/authorization", $form.serialize(), 
						function(data){
								if (data.ok) {
									onReload('');
								}else {
									webix.message({type:"error", text:data.code});
									if (bv.getInvalidFields().length > 0) {
										bv.disableSubmitButtons(false);
									}
								}
						}
					);
        });

	//форма авторизации смс
	$('#login-form').bootstrapValidator({
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
                        }
                    }
                },
                pass: {
                    validators: {
                        notEmpty: {
                            message: 'Введите пароль'
                        }
                    }
                }
            }
        }).on('success.form.bv', function(e) {
            e.preventDefault();
            var $form = $(e.target);
            var bv = $form.data('bootstrapValidator');
			$.post("/authorization_sms", $form.serialize(), 
						function(data){
								if (data.ok) {
									onReload('');
								}else {
									webix.message({type:"error", text:data.code});
									if (bv.getInvalidFields().length > 0) {
										bv.disableSubmitButtons(false);
									}
								}
						}
					);
        });
	/**
	 * показываем элемент / скрываем индикатор при работе ajax
	 */
	var loading = $('#loading');
	$(document).on("ajaxSend", function(e, xhr, settings){
				var arr = [ '/qrq_html' ];// не показывать ajax индикатор
				var rez = jQuery.inArray( settings.url, arr );
				// console.log('rez')
				// console.log(rez)
					if(rez<0){
						loading.show();
					}
				})
				.bind("ajaxComplete", function(){
					loading.hide();
				});

	/**
	 * Кнопка Вверх
	 */
	var backTop = $('#back_top');
	$(window).scroll(function(){
			if($(this).scrollTop() > 150) backTop.fadeIn();
			else backTop.fadeOut();
	});
	backTop.hide().click(function(e){
		$('body,html').animate({ scrollTop: 0 }, 500);
		return false;
	});


	/**
	 * закрыть окно ошибок
	 */
	$("body").on("dblclick", ".php-error", function(){
		$(this).fadeOut();
	});	
	
});


function onReload(response)
{
	if(response!=''){
		window.location = ""+response+"";
	}else{
		location.reload();
	}
}

//очистить элемент
function clearHtmlSetTimeout(selector,time){
	var t=setTimeout("$('"+selector+"').html('')",time);
}

//number_format как в PHP
function number_format(number, decimals, dec_point, thousands_sep) {
  number = (number + '')
    .replace(/[^0-9+\-Ee.]/g, '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + (Math.round(n * k) / k)
        .toFixed(prec);
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
    .split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '')
    .length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1)
      .join('0');
  }
  return s.join(dec);
}
//формат используемый в проекте
function nf(value) {
	return number_format(value, 2, ',', ' ');
}

$.ajaxSetup({
    type: "post",
    dataType: 'json',
    error: function(error){
        autoUpdateflag = false;// отключение автообновления
		$("body").prepend('<div id="php-error" class="php-error"></div>');
        if(error.status == 0) var i;//alert("Соединение прервано. Обновите страницу или попробуйте подключиться позднее.");
        else if(error.status != 200) var i;//alert("Ошибка соединения. Код состояния HTTP: " + error.status + ".");
        else {//alert('sd');
				$("#php-error").append(parseAjaxError(error.responseText));
		}
    }
});


function parseAjaxError(error){
var str=error.replace(/<\\/ig, "<")
			.replace(/>/ig, "&gt;")
			.replace(/</ig, "&lt;")
			.replace(/&lt;br&gt;/ig, "\n")
			.replace(/\\"/ig, "&quot;")
			.replace(/\\r\\n/ig, "<br>\n")
			.replace(/\n/ig, "<br>\n")
			.replace(/\)\s\s\s\s/ig, ")<br>\n    ")
			.replace(/\(\s\s\s\s/ig, "(<br>\n    ")
			.replace(/\s\s\s\s\[/ig, "(<br>\n    [")
			.replace(/\s\s\s\s\]/ig, "(<br>\n    ]")
			.replace(/\s\s\s\s/ig, "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;")
			.replace(/\s\s\s\s/ig, "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;")
			.replace(/\\t/ig, "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;")
			.replace(/&gt;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/ig, "<br>\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n");

	str=str.slice( 0, str.indexOf('{"') );
		 
return str;
}