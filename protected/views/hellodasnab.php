<?php
	//$row 	= $member['mainpage']['row'];

	$code .= '
                <div class="hello-page">
                    <div class="wrapper">
                        <div class="index-title">Привет</div>
                        <div class="index-subtitle">здесь все то же самое, <br> только лучше</div>
                        <div class="content-block">
                            <div class="content-list">
                                <div class="content-list-title">Остались прежними:</div>
                                <ul>
                                    <li>- Логин и пароль </li>
                                    <li>- Заявки и заказы</li>
                                    <li>- Интересы</li>
                                </ul>
                            </div>
                            <div class="index-button-block">
                                <a class="link link-green" href="/">Начать ></a>
                            </div>
                        </div>
                        <div class="logo-block">
                            <img src="/image/logotype.svg" alt="логотип">
                        </div>
                    </div>
                </div>
                <script>
                    $("body").addClass("hello-page-body");
                </script>
			';


?>