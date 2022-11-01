<?php
	//$row 	= $member['mainpage']['row'];

	$form_autorize = (!COMPANY_ID)? '	
									<svg class="icon icon-signIn" viewBox="0 0 20 20">
                                        <use xlink:href="/infoparts_assets/icons/sprite.svg#signIn"></use>
                                    </svg>
                                    <div class="header__log-in-enter">
                                        <div class="header__log-in-text">Войти</div>
                                        <div class="header__log-in-btn">
                                            <form class="form-wrapper" id="login-form">
                                                <div class="form-group">
                                                    <input id="email" type="text" name="email" placeholder="Логин">
                                                </div>
                                                <div class="form-group">
                                                    <input id="pass" type="password" name="pass" placeholder="Пароль">
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-group__title"><a href="/restore">Забыли пароль?</a>
                                                    </div>
                                                    <button class="login-form-button login-in btn btn-blue" type="submit">Войти</button>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-group__title">Если у&nbsp;Вас нет аккаунта?</div>
                                                    <div class="login-form-button modal_registration btn btn-blue">Создать сейчас</div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>' : '';


	$code .= '
    <link rel="stylesheet" href="/infoparts_assets/css/app.css?v=1613147712566">
    <script>
        function canUseWebP(){var e=document.createElement("canvas");return!(!e.getContext||!e.getContext("2d"))&&0==e.toDataURL("image/webp").indexOf("data:image/webp")}var root=document.getElementsByTagName("html")[0];canUseWebP()?root.classList.add("ws"):root.classList.add("wn");
    </script>
    <main>
        <header class="header">
            <div class="header__wrap wrap">
                <div class="header__inner flex flex_vertical flex_justify">
                    <div class="header__left flex flex_vertical">
                        <a class="header__logo logo" href="/">
                            <img src="/infoparts_assets/img/logo.svg" alt="Логотип">
                        </a>
                    </div>
                    <div class="header__right flex flex_vertical">
                        <a class="header__phone flex flex_vertical" href="tel:8 (800) 250 26 10">
                            <svg class="icon icon-phone" viewBox="0 0 20 20">
                                <use xlink:href="/infoparts_assets/icons/sprite.svg#phone"></use>
                            </svg><span class="header__phone-text">8 (800) 250 26 10</span>
                        </a>
                        <div class="header__log-in flex flex_vertical">
                                                                                    '.$form_autorize.'

                        </div>
                    </div>
                </div>
            </div>
        </header>
        <section class="free-platform">
            <div class="free-platform__wrap wrap flex flex_center flex_vertical">
                <svg class="icon icon-freePlatform" viewBox="0 0 66 66">
                    <use xlink:href="/infoparts_assets/icons/sprite.svg#freePlatform"></use>
                </svg>
                <div class="free-platform__content">
                    <div class="free-platform__title">БЕСПЛАТНАЯ ПЛАТФОРМА</div>
                    <div class="free-platform__subtitle">для&nbsp;упрощения закупок и&nbsp;снижения цен на&nbsp; запчасти, масла, шины</div>
                </div>
            </div>
        </section>
        <section class="switch-role">
            <div class="switch-role__wrap wrap flex flex_center flex_vertical js-tabs">
                <div class="switch switch-role__switch js-tabs-nav">
                    <div class="switch__btn active">Для снабженца</div>
                    <div class="switch__btn">Для владельца</div>
                </div>
                <div class="js-tabs-body">
                    <div class="switch-role__advantages active">
                        <div class="switch-role__advantages-item list">
                            <svg class="icon icon-notepad" viewBox="0 0 48 48">
                                <use xlink:href="/infoparts_assets/icons/sprite.svg#notepad"></use>
                            </svg>
                            <div class="switch-role__title">Удобно иметь все заявки в&nbsp;одном месте</div>
                            <div class="switch-role__subtitle">
                                <ul>
                                    <li>Фиксируйте заявки с&nbsp;учётом срочности и&nbsp;других деталей.</li>
                                </ul>
                            </div>
                            <div class="switch-role__subtitle">
                                <ul>
                                    <li>Чтоб не забыть, фиксируйте на&nbsp;ходу черновые заявки, не публикуя их.</li>
                                </ul>
                            </div>
                            <div class="switch-role__subtitle">
                                <ul>
                                    <li>Меняйте статусы их выполнения и&nbsp;у Вас всегда будет актуальная информация - исполнена или&nbsp;не исполнена заявка.</li>
                                </ul>
                            </div>
                        </div>
                        <div class="switch-role__advantages-item list advantages-item-label">
                            <svg class="icon icon-mail" viewBox="0 0 48 48">
                                <use xlink:href="/infoparts_assets/icons/sprite.svg#mail"></use>
                            </svg>
                            <div class="switch-role__title">Выгодно получать максимум предложений</div>
                            <div class="switch-role__subtitle">
                                <ul>
                                    <li>Ваши поставщики будут получать оповещения и&nbsp;сами давать предложения.</li>
                                </ul>
                            </div>
                            <div class="switch-role__subtitle">
                                <ul>
                                    <li>Делитесь заявками по&nbsp;ссылке.</li>
                                </ul>
                            </div>
                            <div class="switch-role__subtitle">
                                <ul>
                                    <li>Фиксируйте предложения в&nbsp;ручную.</li>
                                </ul>
                            </div>
                            <div class="switch-role__subtitle">
                                <ul>
                                    <li>Находите новых поставщиков на платформе, чтобы получать ещё больше предложений.</li>
                                </ul>
                            </div>
                            <div class="switch-role__subtitle">
                                <ul>
                                    <li>Руководство оценит Вашу эффективную работу.</li>
                                </ul>
                            </div>
                        </div>
                        <div class="switch-role__advantages-item list">
                            <svg class="icon icon-clock" viewBox="0 0 48 48">
                                <use xlink:href="/infoparts_assets/icons/sprite.svg#clock"></use>
                            </svg>
                            <div class="switch-role__title">Меньше времени на&nbsp;закуп</div>
                            <div class="switch-role__subtitle">
                                <ul>
                                    <li>Предложения отсортированы для&nbsp;быстрого принятия решения.</li>
                                </ul>
                            </div>
                            <div class="switch-role__subtitle">
                                <ul>
                                    <li>На все события поставщикам отправляется оповещения, что позволяет меньше тратить времени на&nbsp;общение.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="switch-role__advantages">
                        <div class="switch-role__advantages-item">
                            <svg class="icon icon-bestPrice" viewBox="0 0 48 48">
                                <use xlink:href="/infoparts_assets/icons/sprite.svg#bestPrice"></use>
                            </svg>
                            <div class="switch-role__title">Лучшие цены</div>
                            <div class="switch-role__subtitle">Заявки всегда доступны Вашим поставщикам. Благодаря этому они дают большое количество предложений, среди которых Вы можете выбрать лучшее.</div>
                        </div>
                        <div class="switch-role__advantages-item">
                            <svg class="icon icon-noRollbacks" viewBox="0 0 48 48">
                                <use xlink:href="/infoparts_assets/icons/sprite.svg#noRollbacks"></use>
                            </svg>
                            <div class="switch-role__title">Нет Откатам</div>
                            <div class="switch-role__subtitle">Вы можете проверить была ли возможность купить выгоднее, т.к. все полученные предложения сохранены и&nbsp;всегда доступны.</div>
                        </div>
                        <div class="switch-role__advantages-item">
                            <svg class="icon icon-transparency" viewBox="0 0 48 48">
                                <use xlink:href="/infoparts_assets/icons/sprite.svg#transparency"></use>
                            </svg>
                            <div class="switch-role__title">Прозрачность</div>
                            <div class="switch-role__subtitle">Статус заявки постоянно доступен и&nbsp;понятно на&nbsp;какой стадии заявка.</div>
                        </div>
                        <div class="switch-role__advantages-item">
                            <svg class="icon icon-speed" viewBox="0 0 48 48">
                                <use xlink:href="/infoparts_assets/icons/sprite.svg#speed"></use>
                            </svg>
                            <div class="switch-role__title">Скорость</div>
                            <div class="switch-role__subtitle">Большое количество инструментов для&nbsp;снабженца, позволит сократить его трудозатраты до&nbsp;60%.</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="make-system-top">
            <div class="make-system-top__wrap wrap flex flex_center flex_vertical">
                <div class="make-system-top__img-wrap">
                    <picture>
                        <source type="image/webp" srcset="/infoparts_assets/img/computer.webp">
                            <img src="/infoparts_assets/img/computer.png" alt="" />
                    </picture>
                    <svg class="icon icon-computerArrow" viewBox="0 0 178 647">
                        <use xlink:href="/infoparts_assets/icons/sprite.svg#computerArrow"></use>
                    </svg>
                    <svg class="icon icon-computerArrowTablet" viewBox="0 0 236 716">
                        <use xlink:href="/infoparts_assets/icons/sprite.svg#computerArrowTablet"></use>
                    </svg>
                    <svg class="icon icon-computerArrowMobile" viewBox="0 0 86 591">
                        <use xlink:href="/infoparts_assets/icons/sprite.svg#computerArrowMobile"></use>
                    </svg>
                    <img class="icon-play" src="/infoparts_assets/img/play.svg" alt="" />
                </div>
            </div>
        </section>
        <section class="make-system-bottom">
            <div class="make-system-bottom__wrap wrap flex flex_center flex_column flex_vertical">
                <div class="make-system-bottom__sticker">
                    <svg class="icon icon-fire" viewBox="0 0 10 12">
                        <use xlink:href="/infoparts_assets/icons/sprite.svg#fire"></use>
                    </svg><span class="make-system-bottom__sticker-text">Бесплатно навсегда</span>
                </div>
                <div class="make-system-bottom__title">Сделать такую систему у&nbsp;себя</div>
                <form id="registration2-form" class="make-system-bottom__form form flex flex_justify" role="form">
                    <div class="form-group">
						<input type="text" id="name" name="name" placeholder="Имя" required>
					</div>
                    <div class="form-group">
						<input type="tel" id="phone2" name="phone2" placeholder="Телефон" inputmode="tel" required>
					</div>
                    <div class="form-group">
						<input type="text" id="email" name="email" placeholder="E-mail" required>
					</div>
                    <button class="btn btn-blue" type="submit">Зарегистрироваться</button>
                </form>
            </div>
        </section>
    </main>
<div class="modal fade modal-ifoparts-video" id="modalIfopartsVideo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-modal="true">
    <div class="modal-dialog ifoparts-video-dialog " role="document">
        <div class="modal-close-wrap">
            <div class="modal-close" data-dismiss="modal">×</div>
        </div>
        <div class="modal-content ifoparts-video">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/FGUp-8BzJU0?enablejsapi=1&" title="YouTube video player"
                frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
        </div>
    </div>
</div>
    <script src="/infoparts_assets/js/app.js?v=1613142712576"></script>
	
<script>

	get_intlTelInput("phone2","ru");
	
$(function(){
	
		$("#registration2-form").bootstrapValidator({
            feedbackIcons: {
                valid: "glyphicon glyphicon-ok",
                invalid: "glyphicon glyphicon-remove",
                validating: "glyphicon glyphicon-refresh"
            },
			fields: {
				email: {
					validators: {
						notEmpty: {
							message: "Введите email"
						},
						regexp: {							
							regexp:"[^@]+@[^@]+\.[a-zA-Z]{2,6}",
							message: "Неверный email"
						},						
					}
				},
				name: {
					validators: {
						notEmpty: {
							message: "Введите Имя"
						}
					}
				},
				phone2: {
					validators: {
						notEmpty: {
							message: "Введите телефон"
						}
					}
				}
			}
		}).on("success.form.bv", function(e) {
			e.preventDefault();
			var $form = $(e.target);
			var bv = $form.data("bootstrapValidator");
			
			ModalRegistration( $form.serialize() );
			
			bv.disableSubmitButtons(false);
		});
	
});
	
</script>		
			';


?>