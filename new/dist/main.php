<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1">
    <title>Главная</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&amp;display=fallback" rel="stylesheet">
    <link rel="stylesheet" href="/app/css/app.css?v=1657458531664">
    <script>
        function canUseWebP(){var e=document.createElement("canvas");return!(!e.getContext||!e.getContext("2d"))&&0==e.toDataURL("image/webp").indexOf("data:image/webp")}var root=document.getElementsByTagName("html")[0];canUseWebP()?root.classList.add("ws"):root.classList.add("wn");
    </script>
</head>

<body class="home-page-body">
    <main>
        <div class="home-page">
            <div class="home-page__header">
                <a class="home-page__logo logo" href="/">
                    <svg class="icon icon-logo " viewBox="0 0 153 54">
                        <use xlink:href="/app/icons/sprite.svg#logo"></use>
                    </svg>
                </a>
                <div class="home-page__enter-wrap">
                    <div class="home-page__enter btn btn_m j-login">
                        <svg class="icon icon-enter " viewBox="0 0 16 16">
                            <use xlink:href="/app/icons/sprite.svg#enter"></use>
                        </svg>
                        <div class="home-page__enter-text">Войти</div>
                    </div>
                </div>
            </div>
            <div class="home-page__content">
                <div class="home-page__content-inner">
                    <div class="what-search">
                        <div class="what-search__inner">
                            <form class="search-all-form ac-group">
                                <label class="search-all-form__magnifier" for="what-search">
                                    <svg class="icon icon-magnifier " viewBox="0 0 20 20">
                                        <use xlink:href="/app/icons/sprite.svg#magnifier"></use>
                                    </svg>
                                </label>
                                <input class="search-all-form__input ac-group__input" type="text" id="what-search" name="what-search" placeholder="Что ищете?" />
                                <svg class="icon icon-dropdown ac-group__icon-dropdown search-all-form__icon-dropdown" viewBox="0 0 12 12">
                                    <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                                </svg>
                            </form>
                        </div>
                    </div>
                    <div class="place-need place-need place-need_static">
                        <div class="place-need__main">
                            <svg class="icon icon-plus " viewBox="0 0 14 14">
                                <use xlink:href="/app/icons/sprite.svg#plus"></use>
                            </svg><span class="place-need__text">Разместить потребность</span>
                        </div>
                        <div class="btn-double btn-double_white-blue place-need__double">
                            <div class="btn-double__item cards-info__action-btn-buy place-need__double-item"><span class="btn-double__text place-need__double-text">Заявки</span>
                            </div>
                            <div class="btn-double__item cards-info__action-btn-sell place-need__double-item"><span class="btn-double__text place-need__double-text">Объявления</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="home-page__footer">
                <div class="home-page__footer-inner">
                    <div class="manage-block">
                        <div class="manage-block__inner">
                            <div class="manage-block__item manage-block__item_chat">
                                <svg class="icon icon-chat " viewBox="0 0 21 17">
                                    <use xlink:href="/app/icons/sprite.svg#chat"></use>
                                </svg>
                            </div>
                            <div class="manage-block__item manage-block__item_warning">
                                <svg class="icon icon-warning " viewBox="0 0 16 16">
                                    <use xlink:href="/app/icons/sprite.svg#warning"></use>
                                </svg>
                            </div>
                            <div class="manage-block__item manage-block__item_lamp">
                                <svg class="icon icon-lamp " viewBox="0 0 22 23">
                                    <use xlink:href="/app/icons/sprite.svg#lamp"></use>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <ul class="home-page__footer-list">
                        <li class="home-page__footer-item">
                            <a class="main-phone home-page__footer-link" href="tel:8 (800) 250 26 10">
                                <svg class="icon icon-phone " viewBox="0 0 24 24">
                                    <use xlink:href="/app/icons/sprite.svg#phone"></use>
                                </svg><span class="main-phone__num">8 (800) 250 26 10</span>
                            </a>
                        </li>
                        <li class="home-page__footer-item"><a class="home-page__footer-link" href="#">О&nbsp;Quest Request</a>
                        </li>
                        <li class="home-page__footer-item"><a class="home-page__footer-link" href="#">Условия использования</a>
                        </li>
                        <li class="home-page__footer-item"><a class="home-page__footer-link" href="#">Помощь</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </main>
    <div class="modal registration-modal registration-modal_simple registration-modal_success">
        <div class="modal__container">
            <div class="modal__inner"></div>
        </div>
    </div>
    <div class="needs-modal modal">
        <div class="modal__container">
            <div class="modal__inner">
                <div class="modal__content">
                    <div class="modal__close" data-close="close">
                        <svg class="icon icon-cross " viewBox="0 0 24 24">
                            <use xlink:href="/app/icons/sprite.svg#cross"></use>
                        </svg>
                    </div>
                    <div class="modal__body">
                        <div class="needs-modal__header">
                            <div class="needs-modal__photos">
                                <svg class="icon icon-cameraSharp " viewBox="0 0 17 17">
                                    <use xlink:href="/app/icons/sprite.svg#cameraSharp"></use>
                                </svg>
                            </div>
                            <div class="needs-modal__need-name-input form-group">
                                <input class="input require" type="text" placeholder="Название">
                            </div>
                        </div>
                        <div class="needs-modal__needs"></div>
                        <div class="needs-modal__bottom">
                            <div class="needs-modal__save">
                                <svg class="icon icon-floppyDisk " viewBox="0 0 24 24">
                                    <use xlink:href="/app/icons/sprite.svg#floppyDisk"></use>
                                </svg>
                            </div>
                            <div class="needs-modal__next btn btn_blue btn_m" data-next="1">Продолжить</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script src="/app/js/app.js?v=1657458531669"></script>
</body>

</html>