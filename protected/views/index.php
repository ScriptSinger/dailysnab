<?php
$member = application();
$content = array();
$_title = $_menu_top = $_login = $_menu_left = $_modal_start = '';
//echo '<pre>';
//vecho($member);
//die; 
if (!empty($member['buy'])){ $cid_buy = $member['buy']['cat_id']; }
if (!empty($member['sell'])){ $cid_sell = $member['sell']['cat_id']; }

foreach($member as $key => $v){
	$code = '';
	$path = VIEWS.$key.'.php';


	if( file_exists($path) ) require $path;

	
	if($key == 'title')					$_title 			= $v;
	//elseif($key == 'login')			$_login 			= $code;
	elseif($key == 'menu_top')			$_menu_top 			= $code;	
	elseif($key == 'menu_left')			$_menu_left 		= $code;
	elseif($key == 'modal_start')		$_modal_start 		= $code;// всплывающее окно при загрузке страницы 

	else								$content[] 			= $code;
}

 	$title = $description_buy = $keywords_buy = $description_sell = $keywords_sell = '';
	
	if (!empty($cid_buy)){
		$rc = reqSlovCategories(array('id'=>$cat_id));

		$title 			= !empty($rc["categories"])?$rc["categories"]:'';
		$description_buy 	= !empty($rc["description_buy"])?$rc["description_buy"]:''; 
		$keywords_buy 	= !empty($rc["keywords_buy"])?$rc["keywords_buy"]:'';   
	} 
	
	if (!empty($cid_sell)){
		$rc = reqSlovCategories(array('id'=>$cat_id));
		
		$title 			= !empty($rc["categories"])?$rc["categories"]:'';
		$description_sell	= !empty($rc["description_sell"])?$rc["description_sell"]:'';  
		$keywords_sell 	= !empty($rc["keywords_sell"])?$rc["keywords_sell"]:'';    
	} 	


	$page_content	= implode('', $content);
	
?><!DOCTYPE html>
<html lang="ru">
  <head>
  
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="google" value="notranslate">
	<meta name="description" content="<? echo $description_buy.$description_sell; ?>">
	<meta name="keywords" content="<? echo $keywords_buy.$keywords_sell; ?>">
	<meta name="author" content=""/>
	<meta name="robots" content="index,follow">
	<? if ($GLOBALS['args']['0'] == 'infoparts') {?>
		<meta name="viewport" content="width=device-width,initial-scale=1">
	<? } ?>
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
	<title><? 
		echo $title.' | '.$_title.( ($GLOBALS['args']['0']=='mainpage')? '' : ' на' )
		?> 
		"qrq.ru"</title>

	<link rel="stylesheet" href="/component/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
			<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
	<!--
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
	integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	-->
	
	<script src="/js/jquery-3.4.1.min.js"></script>
		<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
			<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
	<!--
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"
				integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	-->
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
				integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
			
	<script src="/component/bootstrap/js/bootstrap.min.js"></script>
	<!--	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
			integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	-->

	<script src="/js/jquery.validate.min.js"></script>
	<script src="/js/ui.js?<?=time()?>"></script>
	<script src="/js/custom.js?<?=time()?>"></script>
	
	<!--bootstrap-->
	<script src="/component/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!--<link rel="stylesheet" href="/component/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="/component/bootstrap/css/font-glyphicons.css">-->
	<!--bootstrapValidator-->
	<script src="/component/bootstrapvalidator/js/bootstrapValidator.min.js"></script>
	<link rel="stylesheet" href="/component/bootstrapvalidator/css/bootstrapValidator.min.css">	
	<!--bootstrapCheckbox-switch-->
	<link rel="stylesheet" href="/css/checkbox_switch.css">	
	<!--bootstrapCheckbox-chiller_cb-->
	<link rel="stylesheet" href="/css/checkbox_chiller_cb.css">	
	<!--intlTelInput-->
	<link rel="stylesheet" href="/component/intlTelInput/css/intlTelInput.css">
	<script src="/component/intlTelInput/js/intlTelInput.min.js"></script>
	<!--select2-->
	<script type="text/javascript" src="/component/select2/js/select2.full.js"></script>
	<link rel="stylesheet" href="/component/select2/css/select2.css" type="text/css"/>	
	<!--croppie-->
	<script type="text/javascript" src="/component/croppie/croppie.js"></script>
	<link rel="stylesheet" href="/component/croppie/croppie.css" type="text/css"/>	
	<!--maskedinput-->
	<script src="/component/maskedinput/jquery.inputmask.bundle.min.js"></script>
	<!--jquery-ui-->
	<link rel="stylesheet" href="/component/jquery-ui/jquery-ui.min.css">
	<script src="/component/jquery-ui/jquery-ui.min.js"></script>	

	<!--webix-->
	<link rel="stylesheet" href="http://cdn.webix.com/edge/webix.css" type="text/css">
    <script src="http://cdn.webix.com/edge/webix.js" type="text/javascript"></script> 
	<!-- <script src="/component/webix4014/webix.js"  type="text/javascript" charset="utf-8"></script> -->

	<link rel="stylesheet" href="/css/styles.css?<?=date('dmy')?>">
	<link rel="stylesheet" href="/css/main.css?1">
	<!-- fancyBox -->
  	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
  	<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>


	<!-- richtext -->
	<link rel="stylesheet" href="/js/trumbowyg/ui/trumbowyg.min.css">
	<script src="/js/trumbowyg/trumbowyg.min.js"></script>
	<script src="/js/trumbowyg/langs/langs/ru.min.js"></script>
	
	<script src="/js/refresh_notice.js"></script>

	
<?
if(LOGIN_ID){
	if(PRAVA_1){
		echo '<script src="/js/admin.js?'.date('dmy').'"></script>';
	}
}
?>

</head>

<body class="zooming<?=( (LOGIN_ID==1)? ' adminpanel' : '' )?>">


<?
	

if($page_content){
	if ($GLOBALS['args']['0'] == 'infoparts' || $GLOBALS['args']['0'] == 'infopart') {
		echo  '
			'.$page_content;
	} 	
	else {
		echo  '
			'.$_menu_left.'
			'.$_menu_top.'
			'.$page_content;
	}
	
	
		
		
/*
if($page_content){
	echo  '
<div class="container-fluid">
  <div class="row">

		'.$_menu_left.'
		
		<main role="main" class="'.$cl_main.'">
			<div id="page" class="contain '.$cl_page.'">
					
							'.$page_content.'<!--//content-->
				
			</div><!--container-->
		</main>
		
		
	</div>
</div>
			';
*/
}
?>

<?
if((!LOGIN_ID) && ($GLOBALS['args']['0'] != 'infoparts' && $GLOBALS['args']['0'] != 'infopro' && $GLOBALS['args']['0'] != 'infovip' && $GLOBALS['args']['0'] != 'infopart')){
//if((!LOGIN_ID) && ($GLOBALS['args']['0'] != 'infoparts')){	
?>
<footer class="footer" id="footer">
    <div class="container">
		<div class="footer-wrap">
			<a href="/about" class="footer-item">
				О QRQ
			</a>
			<a href="/rules" class="footer-item">
				Условия использования
			</a>
			<a href="/faq" class="footer-item">
				Помощь
			</a>
			<!--
			<a href="/buy" class="footer-item">
				Заявки
			</a>
			<a href="/sell" class="footer-item">
				Объявления
			</a>
			-->
		</div>
    </div>
</footer>
<?
}
?>
	<script type="text/javascript" src="/js/jquery.mask.min.js"></script>
	<script src="/js/main.js"></script>
	<script src="/js/slider.js"></script>
	
	
<?=$_modal_start?>

<?
if(!LOGIN_ID){
?>
<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(85847373, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
   });
</script>
<?
}
?>
<noscript><div><img src="https://mc.yandex.ru/watch/85847373" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
	
</body>
</html>