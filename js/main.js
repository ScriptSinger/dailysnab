$(document).ready(function ($) {
    (function removeAutocomplete() {
        $('body').on('focus', '#name', function () {
            $(this).attr('name', Date.now())
        });
        $('body').on('blur', '#name', function () {
            $(this).attr('name', 'name')
        });
    })();

    // var stt= null;


    var tagObject = {
        '.request-data-params>span': '',
        '.rAmount': 'Количество',
        '.rMeasure': 'Единица измерения',
        '.status-when': 'Дата и время присвоение статуса',
        '.data-time-type': 'Имя заказа: ',
        '.whenOff': 'Через сколько закончится публикация',
        // 'p.comments': '',
        '.request-views': 'Просмотры',
        '.convert': 'Нажмите, чтобы отправить сообщение',
        '.status-condition': 'Статус потребности',
        '.request-availability': 'Наличие',
        // '.request-data-name > p > a':'',
        '.urgency': 'Срочность',
        '.resppn': 'Ответственный',
        '.userImgCnt': '(Показывается наименование того кто совершил действие)',
        '.data-city': 'Куда / Откуда',
        '.rpCurrency': 'Валюта',
        '.rpCost': 'Цена',
        '.request-nds': 'Способ оплаты - ',
        '.request-money': 'Способ оплаты - Наличные'
    }
    Object.entries(tagObject).forEach(([k, v]) => {
        if ($(k).find('.bttip').length > 0) return;

        if (k == '.request-data-params>span') {
            $(k).each(function () {
                $(this).append("<span class='bttip'>" + $(this).data('name') + ": " + $(this).text() + "</span>")
            })
        } else if (k == '.data-time-type') {

            var stext = $(k).find('>span').eq(0).text();

            $(k).append("<span class='bttip'>" + v + stext + "</span>")

        } 
        // else if (k == 'p.comments') {

        //     $(k).each(function () {
        //         $(this).parent().before("<span class='bttip cments'>" + $(this).text() + "</span>");

        //     })

        // } 
        else {
            $(k).append("<span class='bttip'>" + v + "</span>")
        }
    }); 

    let bttipClass = '.bttip-wrap, .request-for-price, .buy-item-main-left__left-city, .buy-item-main-center_prop span, .buy-item-main-left__left-name a, .request-quantity, .data-month, .user-name, .item-list-6 .status-bar button, .modal-status__left-item,.modal-status__right-item,.rAmount,.rMeasure,.status-when,.data-time-type,.request-data-params>span,.whenOff,p.comments,.request-views,.convert,.status-category,.status-condition,.request-availability,.request-data-name > p > a,.urgency,.resppn,.userImgCnt,.data-city,.rpCurrency,.rpCost,.request-nds,.request-money';

    $(document).on('mouseover', bttipClass, function () {
        var btt = $(this).find(">.bttip");
        
        // if ($(this).hasClass("comments")) {
        //     btt = $(this).parent(".request-for-price").prev(".bttip.cments");
        // }
        if (btt.length) {
            stt = setTimeout(function () {

                btt.show()

            }, 900)
        }
    });
    $(document).on('mouseout', bttipClass, function () {
        var btt = $(this).find(">.bttip");

        clearTimeout(stt);
        btt.hide();
    });
    // , function () {
    //     console.log(2)
    //     var btt
    //     btt = $(this).find(">.bttip");
    //     if ($(this).hasClass("comments")) {
    //         btt = $(this).parent(".request-for-price").prev(".bttip.cments");
    //     }
    //     clearTimeout(stt)
    //     btt.hide()
    // }
    // $(".request-price").each(function () {
    //     var w = $(this).width()
    //     if (w > 150) {
    //         $(this).addClass('tooWide').css('left', '-' + (w - 131) + 'px')
    //     }
    // })

    $(".user-online:before").hover(function (e) {

    }
    );
    $(".ndsText").each(function () {

        $(this).next('.bttip').text($(this).next('.bttip').text() + $(this).text())


    });


    //toggle Post
    $(document).click(function (event) {
        if (!$(event.target).closest(".search-main, btn-wrap button, .after, .enter-btn, .register, .btn-option, .modal-body").length) {
            $('.search-post').removeClass('wid-auto');
            $('.post-btn p').removeClass('d-none');
        }
    });

    $(document).click(function (event) {
        if (!$(event.target).closest(".search-main, .search-post, .after, .enter-btn, .register, .btn-option, .modal-body").length) {
            $('.enter-btn').removeClass('wid-auto');
            $('.for-search').removeClass('wid-long');
        }
    });

    function postClose() {
        $('.search-post').addClass('wid-auto');
        $('.search-wrapper .post-btn p').addClass('d-none');
    }

    $('.search-main').click(function () {
        postClose();
        $('.enter-btn').addClass('wid-auto');
        $('.for-search').addClass('wid-long');
    });

    $('.search-after').click(function () {
        $('.enter-btn').addClass('wid-auto');
    })



    //toggle Search

    $(document).click(function (event) {
        if (!$(event.target).closest(".search-post, .after, .enter-btn, .register, .btn-option").length) {
            $('.for-search').removeClass('wid-auto');
            $('.search-input').removeClass('d-none')
            $('.search-after').removeClass('d-none');
						//$('.post-wrap').addClass('d-none');
            $('.search-post').removeClass('for-search-post');
            $('.post-btn').removeClass('d-none');
            //$('.enter-btn').removeClass('wid-auto');
        }
    });
    function searchClose() {
        $('.for-search').addClass('wid-auto');
					//$('.search-input').addClass('d-none')
        $('.search-after').addClass('d-none');
    }

    $('.search-post').click(function () {
        $('.post-wrap').removeClass('d-none');
        $('.search-post').addClass('for-search-post');
        //$('.post-btn').addClass('d-none');
        $('.for-search').removeClass('wid-long');
        searchClose();
    });

    $('.search-post, .post-btn, .btn-wrap button').click(function () {
        $('.enter-btn').addClass('wid-auto');
    })


    // toggle form


    $('.enter-btn, .header__log-in').click(function (e) {
        $('.enter-btn').removeClass('wid-auto');
				//$('.post-wrap').addClass('d-none');
        $('.search-post').removeClass('for-search-post');
        postClose();
        searchClose();
        $('.enter-btn').addClass('for-enter-btn');
        $('.form-wrapper').removeClass('d-none');
        if (!$(e.target).hasClass('modal_registration')) {
            setTimeout(function () {
                $('.enter-btn').addClass('for-enter');
            }, 300);
        }
    })


    $(document).click(function (event) {
        if (!$(event.target).closest(".header__log-in, .enter-btn, .register, .btn-option, .search-hidden").length) {
            $('.enter-btn').removeClass('for-enter-btn for-enter');
            $('.form-wrapper').addClass('d-none');
            $('#login-form').show();			
            $('.restore-form-block').hide();

        } else if ($(event.target).closest('.modal_registration').length) {
            $('.enter-btn').removeClass('for-enter-btn for-enter');
            $('.form-wrapper').addClass('d-none');
            $('.enter-btn').addClass('wid-auto');
        }
    });


    $('.ui-autocomplete-input').keydown(function () {
        if ($('.ui-autocomplete-input').val().length > 0) {
            $('.ui-autocomplete-input').addClass('focus-input');
        } else {
            $('.ui-autocomplete-input').removeClass('focus-input');
        }
    });

    $('.restore-btn').click((e)=> {
        console.log(1)
        $('#login-form').hide();
        $('.restore-form-block').show();
        e.preventDefault();
    });

    // Меню 
    $('.nav-burg-icon').click(function () {
        if ($('.nav-account').hasClass('show-account')) {
            $('.nav-account').removeClass('show-account');
            $('.nav-menu').toggleClass('nav-menu-change');
        } else {
            $('.nav-hidden-wrapper').toggleClass('open-hidden-wrapper');
            $('.nav-menu').toggleClass('nav-menu-change');
        }
    });

    $(document).click(function (event) {
        if (!$(event.target).closest(".menu-wrapper").length) {
            changeAccClose()
            $('.nav-hidden-wrapper').removeClass('open-hidden-wrapper');
            $('.nav-menu').removeClass('nav-menu-change');
            $('.submenu-wrapper').removeClass('submenu-show');
            $('.nav-arrow').removeClass('nav-active');
        }
    });

    $('.nav-arrow').click(function () {
        $('.submenu-wrapper').toggleClass('submenu-show');
        $('.nav-arrow').toggleClass('nav-active');
        changeAccClose()
    })

    function changeAccClose() {
        $('.nav-account').removeClass('show-account');
        $('.nav-menu').addClass('nav-menu-change');
    }

    $('.nav-account-item').click(function (e) {
        $('.nav-account-item').removeClass('account-choosen');
        $(e.target).closest('div').addClass('account-choosen');
    });

    $(".request-hidden input[placeholder]").each(function () {
        $(this).css('width', ($(this).attr('placeholder').length - 1) * 6 + 26 + 'px');
    });

    $('.for-hidden-request').click(function () {

        let currentItem = $(this).closest('.request-item-wrapper').find('.request-hidden');

        if (currentItem.hasClass('hidden-show')) {
            currentItem.removeClass('hidden-show')
        } else {
            $('.request-hidden').removeClass('hidden-show');
            currentItem.addClass('hidden-show');
        }

    });

    $('body').on('click', '.request-hidden-more',function() {
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            $(this).closest('.offer-form_sec').find('.offer-form_sec-main').removeClass('active');
            $(this).find('.request-hidden-more__text').text('Дополнительные параметры');
        } else {
            $(this).addClass('active');
            $(this).closest('.offer-form_sec').find('.offer-form_sec-main').addClass('active');
            $(this).find('.request-hidden-more__text').text('Свернуть');
        }
    });

    // Ховер на превью картинку
    $('.product-img-prev img').hover(function () {
        $('.img-prev img').parent().removeClass('active');
        $(this).parent().addClass('active');
        var src = $(this).attr('src');
        $('.product-big-img img').attr('src', src);
    }, function () {

    });

    $('.request-head-btn').click(function () {
        $(this).css('opacity', '0');
        $('.request-heading').css('margin-right', '0px');
        $('.request-menu').css('margin-left', '-100%');
        $('.request-checking').css('margin-left', '9px');
    });


    // jQuery.each($('.request-menu-item'), function () {
    //     if ($(this).find('span').text() == '0') {
    //         $(this).addClass('d-none');
    //     }
    // })

    $(document).click(function (event) {
        if (!$(event.target).closest(".choose-client, .request-head-btn, .request-stage input[type=checkbox], .request-checking input, .share-buy-sell, .ui-menu-item").length) {
            $('.request-head-btn').css('opacity', '1');
            $('.request-heading').css('margin-right', '-390px');
            $('.request-menu').css('margin-left', '0%');
            $('.request-checking').css('margin-left', '-15px');
            $('.request-stage').css('margin-left', '0px');
            $('.checkbox_share').css('display', 'none');
        }
    });

    $('.product-phone').click(function () {
        $(this).addClass('phone-show');
        $('.product-form').addClass('product-show');
    });

    $('.product-submit').click(function () {
        $('.product-quant').css('max-height', '70px')
    });

    $('.subs-btn').click(function () {
        if ($(this).hasClass('change-btn')) {
            $(this).removeClass('change-btn');
            $(this).text('Подписаться');

        } else {
            $(this).addClass('change-btn');
            $(this).text('Отписаться');
        }
    });

    $(document).on('click', '.show-all-categories', function (e) {
        e.preventDefault();
        $.getJSON('/admin_categories_table', function (data) {
            $('#table-admin_categories').html($('<div>' + data.code + '</div>').find('#table-admin_categories').html());
        })
        $(this).parent().remove();
    })
    $(function () {
        jQuery.each($('.request-item'), function () {

            if ($(this).find('> .request-slider-wrapper').hasClass('d-none')) {
                $(this).addClass('noPhoto');
                $(this).find('.request-data').insertBefore($(this).find('.request-data').prev('.request-pricing'))

            }
        });
    });

    // $(document).click(function (event) {
    //   if (!$(event.target).closest(".product-phone").length) {
    //     $('.product-phone').removeClass('phone-show');
    //   }
    // });

    $('body').on('click', '.search-top, .ui-autocomplete', function(e) {
        let tgt = e.target.classList;
        let category = $('.category-link');
        let location = $('.location-link');
        let interests = $('.interests-btn');

        if (!tgt.contains('cancel-choose')) {
            if (tgt.contains('interests-btn')) {
                if (e.target.dataset.flag == 2) {
                    if (category.hasClass('active') || category.hasClass('choosen')) {
                        category.find('.cancel-choose').click();
                        category.removeClass('active');
                    } 
                    if (location.hasClass('active') || location.hasClass('choosen'))  {
                        location.find('.cancel-choose').click();
                        location.removeClass('active');
                    }
                    
                    setTimeout(function() {
                        // $('.first-link span').click();
                        $('.hidden-wrapper .tab-pane').removeClass('active');
                    }, 150);

                }
            }

            resetBtnInterests();
        }
    });
    $('body').on('change', '.autocomplete_cities', function() {
        console.log($(this).val())
        resetBtnInterests(true);
    });
    $('body').on('change', '.autocomplete_messages', function() {
		AutocompleteMessages();               
    });		

    function resetBtnInterests(reset) {
        let category = $('.category-link');
        let location = $('.location-link');
        let interests = $('.interests-btn');

        let condition1 = interests.data('flag') == 2;
        let condition2 = category.hasClass('choosen');
        let condition3 = location.hasClass('choosen');

        if ((condition1 && (condition2 || condition3)) || reset) {
            interests.attr('data-flag', 1);
            interests.data('flag', 1);
            $('#flag_serch_interest').val(0);
            $('#flag_serch_interest').trigger('change');
        }
    }

    $(".dropdown-toggle").dropdown();

    // page share
    if (location.search.includes('share')) {
        $('.subscribe-requests').addClass('active');
    }

    // page not found for buy, sell 
    if ((location.href.includes('sell?') || location.href.includes('buy?')) && location.search.includes('value')) {
        let value = $('.header-nav-search-input').val();

        $('.buy-sell__search-text').text(value);
    }
    
    $("body").on('click', '.save_attribute_value + .select2', function() {
        let items = 0;
        $.each($('.select2-results__option[aria-selected="true"]'), function() {
            $('.select2-results__options').prepend($(this))
            items += 1;
        });
    })

    if (location.pathname == '/' && $('#login-form').length) {
        $("body").on('click', '#submit23', function() {
            //$('.modal').modal('hide');
			//  $('.enter-btn').click();
        })
    }

	$("body").on('click', '.pay_selector, #card_pay, #invoice_pay', function() {		//после клика на переход сформирования счета модалку закрываем
		$('#vmodal').modal('toggle');
		
    });
	
	// $("body").on('click', '.card-pro, .card-vip, .invoice-pay', function() {		//после клика модалку закрываем и редирект через 2 сек в профиль
	// 	console.log('закрытие окна');
	// 	$('#vmodal').modal('toggle');    
	// 	window.setTimeout(function(){			
	// 		window.location.href = "/profile/";
	// 	}, 2000);		
	// 	//$(window).attr('location','/profile/')
		
 //    });		
	
	$('#rschet, #kpp, #bik, #korr_schet').on('keydown', function(e){  //эти реквизиты - только цифры
	  if(e.key.length == 1 && e.key.match(/[^0-9'".]/)){
		return false;
	  };
	})	
	
	//$('.phone_email').val($(this).val().toLowerCase()); //преобразуем все вводимые значения в нижний регистр
	
	
	//запрет на запуск формы из модалки клавишой Enter	
/* 	$('#vmodal').submit(function() {
	  return false;
	}); */
	
/**/	
	$('#vmodal').on('keyup keypress', function(e) {
	  var keyCode = e.keyCode || e.which;
	  if (keyCode === 13) { 
		e.preventDefault();
		return false;
	  }	 															
    });

});

/*обратный отчет времени*/
function timer(time,update,complete) {
    var start = new Date().getTime();
    var interval = setInterval(function() {
        var now = time-(new Date().getTime()-start);
        if( now <= 0) {
            clearInterval(interval);
            complete();
        }
        else update(Math.floor(now/1000));
		$('#vmodal').on('hidden.bs.modal', function () { //останавливаем время, если закрыто модальное окно
			//console.log('close');
			clearInterval(interval);
			complete();
		});		
    },100); // the smaller this number, the more accurate the timer will be
}
function run_timer(){
	var alt = document.getElementById("again_link_text");
		al = document.getElementById("again_link");	
		timer(
			120000, // milliseconds
			function(timeleft) { // called every step to update the visible countdown
				document.getElementById('timer').innerHTML = timeleft+" секунд";
			},
			function() { // what to do after
				//console.log("Timer complete!");
				al.classList.remove("hidden");				
				al.classList ? al.classList.add('show') : al.className += ' show';
				alt.classList ? alt.classList.add('hidden') : alt.className += ' hidden';
			}
		);
	}

/* download file js */
function download_file(fileURL, fileName) {
// for non-IE
if (!window.ActiveXObject) {
    var save = document.createElement('a');
    save.href = fileURL;
    save.target = '_blank';
    var filename = fileURL.substring(fileURL.lastIndexOf('/')+1);
    save.download = fileName || filename;
       if ( navigator.userAgent.toLowerCase().match(/(ipad|iphone|safari)/) && navigator.userAgent.search("Chrome") < 0) {
            document.location = save.href; 
// window event not working here
        }else{
            var evt = new MouseEvent('click', {
                'view': window,
                'bubbles': true,
                'cancelable': false
            });
            save.dispatchEvent(evt);
            (window.URL || window.webkitURL).revokeObjectURL(save.href);
        }   
}

	// for IE < 11
	else if ( !! window.ActiveXObject && document.execCommand)     {
		var _window = window.open(fileURL, '_blank');
		_window.document.close();
		_window.document.execCommand('SaveAs', true, fileName || fileURL)
		_window.close();
	}
}

	/* Удаление загруженной картинки */
function remove_img(target){
		$(target).parent().remove();
}