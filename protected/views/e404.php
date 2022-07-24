<?php
header("HTTP/1.0 404 Not Found"); //страница не найдена
$code = '
<style>
	.header,
	.menu-wrapper {
		display: none;
	}
</style>
		<div class="page-404">
			<div class="page-404__main">
				<h1>404</h1>
				<p>Кто-то ошибся адресом. Кликай по рабочим адресам</p>
				<p>Если это наша вина, то нам хотелось об этом знать</p>
				<a href="/" class="logo-wrap"><img src="/image/logotype.svg" alt="logotype" class="logo header-nav-logo"></a>
				<p>Пишите - <a href="mailto:support@qrq.ru" class="page-404__mail">support@qrq.ru</a></p>
			</div>
			<nav class="page-404__nav">
				<ul>
					<li>
						<a href="/" class="page-404__nav-link">Главная страница</a>
					</li>
					<li>
						<a href="/about" class="page-404__nav-link">О Quest Request</a>
					</li>
					<li>
						<a href="/rules" class="page-404__nav-link">Помощь</a>
					</li>
				</ul>
			</nav>
		</div>
		';
?>
<div class="page-404__mail"></div>