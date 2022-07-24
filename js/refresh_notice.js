$(function(){
/*
	$("body").append('<div class="modal fade" id="vmodal_refresh" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>');//Блоки "модальное окно"
	var modal_refresh = $('#vmodal_refresh');
*/



});
/*
// выводить окно модаль брендов при их появлении (переделано в modal_logo_notification)
var timeOutId = 0;
var ajaxFn = function () {
		var d = $(this).data();
		$.post('/qrq_html', {}, 
					function(data){
								if(data.ok){
									clearTimeout(timeOutId);
									ModalQrqBuySell();
								}else{
									timeOutId = setTimeout(ajaxFn, 3000);
								}
					}
		);
}
//ajaxFn();
timeOutId = setTimeout(ajaxFn, 5000);
*/

// флаг, чтобы обновилось предложения не перегружая страницу
var timeOutId2 = 0;
var ajaxFn2 = function () {
		var d = $(this).data();
		$.post('/button_buy_sell_html', {}, 
					function(data){
								if(data.button){
									clearTimeout(timeOutId2);
									webix.message(data.code);
									$("#div_form_buy_sell"+data.buy_sell_id+"").html(data.button);
								}else{
									timeOutId2 = setTimeout(ajaxFn2, 5000);
								}
					}
		);
}



