<?php
    echo '
    <!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1">
    <title>Инфо</title>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;700&amp;family=Open+Sans:wght@300;400;500;600;700;800&amp;display=fallback" rel="stylesheet">
    <link rel="stylesheet" href="/infopart/css/app.css?v=1654684234572">
    <script>
        function canUseWebP(){var e=document.createElement("canvas");return!(!e.getContext||!e.getContext("2d"))&&0==e.toDataURL("image/webp").indexOf("data:image/webp")}var root=document.getElementsByTagName("html")[0];canUseWebP()?root.classList.add("ws"):root.classList.add("wn");
    </script>
</head>

<body class="infopart-body">
    <main>
        <header class="header header_not-login">
            <div class="header__wrap wrap">
                <a class="logo" href="/">
                    <svg class="icon icon-logo " viewBox="0 0 153 54">
                        <use xlink:href="/infopart/icons/sprite.svg#logo"></use>
                    </svg>
                </a>
                <a class="main-phone header__phone" href="tel:8 (800) 250 26 10">
                    <svg class="icon icon-phone " viewBox="0 0 24 24">
                        <use xlink:href="/infopart/icons/sprite.svg#phone"></use>
                    </svg><span class="main-phone__num">8 (800) 250 26 10</span>
                </a>
                <div class="header__enter j-login">
                    <svg class="icon icon-enterSolid " viewBox="0 0 26 24">
                        <use xlink:href="/infopart/icons/sprite.svg#enterSolid"></use>
                    </svg>
                    <div class="header__enter-text">Войти</div>
                </div>
            </div>
        </header>
        <div class="infopart">
            <div class="infopart__bg-imgs">
                <div class="infopart__bg-imgs-item infopart__bg-imgs-item_wheel">
                    <picture>
                        <source type="image/webp" srcset="/infopart/img/wheel.webp">
                            <img src="/infopart/img/wheel.png" />
                    </picture>
                </div>
                <div class="infopart__bg-imgs-item infopart__bg-imgs-item_oil">
                    <picture>
                        <source type="image/webp" srcset="/infopart/img/oil.webp">
                            <img src="/infopart/img/oil.png" />
                    </picture>
                </div>
                <div class="infopart__bg-imgs-item infopart__bg-imgs-item_engine">
                    <picture>
                        <source type="image/webp" srcset="/infopart/img/engine.webp">
                            <img src="/infopart/img/engine.png" />
                    </picture>
                </div>
                <div class="infopart__bg-imgs-item infopart__bg-imgs-item_engine1">
                    <picture>
                        <source type="image/webp" srcset="/infopart/img/engine1.webp">
                            <img src="/infopart/img/engine1.png" />
                    </picture>
                </div>
            </div>
            <div class="infopart__wrap">
                <div class="infopart__inner">
                    <div class="infopart__top">
                        <div class="infopart__title"> <span class="infopart__title-l">Cэкономьте тысячи рублей и&nbsp;десятки часов </span>
                            <br>на&nbsp;закупке запчастей, масел и&nbsp;шин</div>
                        <div class="what-search infopart__what-search">
                            <div class="what-search__inner">
                                <form class="search-all-form ac-group">
                                    <label class="search-all-form__magnifier" for="what-search">
                                        <svg class="icon icon-magnifier " viewBox="0 0 20 20">
                                            <use xlink:href="/infopart/icons/sprite.svg#magnifier"></use>
                                        </svg>
                                    </label>
                                    <input class="search-all-form__input ac-group__input" type="text" id="what-search" name="what-search" placeholder="Введите артикул" />
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="infopart__advantages">
                        <div class="infopart__advantages-item">
                            <div class="infopart__advantages-head">
                                <div class="infopart__advantages-img-wrap">
                                    <picture>
                                        <source type="image/webp" srcset="/infopart/img/warehouse.webp">
                                            <img src="/infopart/img/warehouse.png" class="infopart__advantages-img" alt="" role="presentation" />
                                    </picture>
                                </div>
                                <div class="infopart__advantages-title">Более 500
                                    <br>поставщиков:</div>
                            </div>
                            <ul class="infopart__advantages-ul">
                                <li class="infopart__advantages-li">Exist</li>
                                <li class="infopart__advantages-li">Автодок</li>
                                <li class="infopart__advantages-li">Армтек</li>
                                <li class="infopart__advantages-li">Автопитер</li>
                                <li class="infopart__advantages-li">Омега</li>
                                <li class="infopart__advantages-li">Корона-Авто</li>
                                <li class="infopart__advantages-li">Тракмоторс</li>
                                <li class="infopart__advantages-li">и&nbsp;др.</li>
                            </ul>
                        </div>
                        <div class="infopart__advantages-item">
                            <div class="infopart__advantages-head">
                                <div class="infopart__advantages-img-wrap">
                                    <picture>
                                        <source type="image/webp" srcset="/infopart/img/listSheet.webp">
                                            <img src="/infopart/img/listSheet.png" class="infopart__advantages-img" alt="" role="presentation" />
                                    </picture>
                                </div>
                                <div class="infopart__advantages-title">Более 5000
                                    <br>заявок в&nbsp;месяц</div>
                            </div>
                            <ul class="infopart__advantages-ul">
                                <li class="infopart__advantages-li">Легковые</li>
                                <li class="infopart__advantages-li">Грузовые</li>
                                <li class="infopart__advantages-li">Спецтехника</li>
                                <li class="infopart__advantages-li">и&nbsp;др.</li>
                            </ul>
                        </div>
                        <div class="infopart__advantages-item">
                            <div class="infopart__advantages-head">
                                <div class="infopart__advantages-img-wrap">
                                    <picture>
                                        <source type="image/webp" srcset="/infopart/img/binoculars.webp">
                                            <img src="/infopart/img/binoculars.png" class="infopart__advantages-img" alt="" role="presentation" />
                                    </picture>
                                </div>
                                <div class="infopart__advantages-title">О платформе
                                    <br>за&nbsp;1 минуту</div>
                            </div>
                            <div class="infopart__advantages-more">
                                <div class="infopart__advantages-video">
                                    <picture>
                                        <source type="image/webp" srcset="/infopart/img/platform-video.webp">
                                            <img src="/infopart/img/platform-video.png" />
                                    </picture>
                                    <svg class="icon icon-play " viewBox="0 0 33 32">
                                        <use xlink:href="/infopart/icons/sprite.svg#play"></use>
                                    </svg>
                                </div>
                                <div class="infopart__advantages-arrow">
                                    <div class="infopart__advantages-arrow-info">
                                        <div class="infopart__advantages-arrow-text">Сделать также</div>
                                        <div class="infopart__advantages-arrow-btn btn btn_m">
                                            <svg class="icon icon-fire " viewBox="0 0 10 12">
                                                <use xlink:href="/infopart/icons/sprite.svg#fire"></use>
                                            </svg><span>Бесплатно навсегда</span>
                                        </div>
                                    </div>
                                    <div class="header__enter j-login">
                                        <svg class="icon icon-enterSolid " viewBox="0 0 26 24">
                                            <use xlink:href="/infopart/icons/sprite.svg#enterSolid"></use>
                                        </svg>
                                        <div class="header__enter-text">Войти</div>
                                    </div>
                                    <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                                        <use xlink:href="/infopart/icons/sprite.svg#dropdown"></use>
                                    </svg>
                                </div>
                                <div class="j-v-play"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div class="modal sending-needs-modal">
        <div class="modal__container">
            <div class="modal__inner">
                <div class="modal__content">
                    <div class="modal__head">
                        <div class="modal__close" data-close="close">
                            <svg class="icon icon-cross " viewBox="0 0 24 24">
                                <use xlink:href="/infopart/icons/sprite.svg#cross"></use>
                            </svg>
                        </div>
                        <div class="modal__head-text">Отправка потребностей</div>
                    </div>
                    <div class="modal__body">
                        <form class="form sending-needs-form">
                            <div class="form-group">
                                <input class="input j-needs-name" type="text" placeholder="Название">
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" placeholder="E-mail" />
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" placeholder="Примечание" />
                            </div>
                        </form>
                        <div class="modal__footer">
                            <div class="modal__btn btn btn_blue j-send-need-mail">Отправить e-mail</div>
                            <div class="modal__btn btn btn_gray j-copy-need-link">Копировать ссылку</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal create-supplier-modal">
        <div class="modal__container">
            <div class="modal__inner">
                <div class="modal__content">
                    <div class="modal__head">
                        <div class="modal__close" data-close="close">
                            <svg class="icon icon-cross " viewBox="0 0 24 24">
                                <use xlink:href="/infopart/icons/sprite.svg#cross"></use>
                            </svg>
                        </div>
                        <div class="modal__head-text">Создание поставщика</div>
                    </div>
                    <div class="modal__body">
                        <form class="form create-supplier-form">
                            <div class="form__logo">
                                <input class="input" type="file" id="logo" disabled>
                                <label class="form__logo-img" for="logo">Лого</label>
                            </div>
                            <div class="form__groups">
                                <div class="form__groups-top">
                                    <div class="form__legal-form form-group">
                                        <div class="select-box">
                                            <select>
                                                <option disabled selected>Правовая форма</option>
                                                <option value="fl">Физ лицо</option>
                                                <option>OOO</option>
                                            </select>
                                            <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                                                <use xlink:href="/infopart/icons/sprite.svg#dropdown"></use>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="form__calculations form-group">
                                        <div class="select-box">
                                            <select>
                                                <option>Расчеты</option>
                                                <option>Вариант 1</option>
                                                <option>Вариант 2</option>
                                            </select>
                                            <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                                                <use xlink:href="/infopart/icons/sprite.svg#dropdown"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input class="input require" type="text" placeholder="Наименование">
                                </div>
                                <div class="form-group">
                                    <input class="input" type="text" placeholder="Адрес" />
                                </div>
                                <div class="form-group">
                                    <div class="select-box">
                                        <select>
                                            <option>Продавец</option>
                                            <option>Вариант 1</option>
                                            <option>Вариант 2</option>
                                        </select>
                                        <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                                            <use xlink:href="/infopart/icons/sprite.svg#dropdown"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input class="input require" type="text" placeholder="Электронная почта">
                                </div>
                                <div class="form-group">
                                    <input class="input require" type="text" placeholder="Телефон">
                                </div>
                                <div class="form-group">
                                    <div class="select-box">
                                        <select>
                                            <option>Интересы</option>
                                            <option>Вариант 1</option>
                                            <option>Вариант 2</option>
                                        </select>
                                        <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                                            <use xlink:href="/infopart/icons/sprite.svg#dropdown"></use>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="form__bottom">
                                <div class="form-group">
                                    <input class="input" type="text" placeholder="Комментарий" />
                                </div>
                                <div class="form__btn btn btn_blue btn_m">Создать</div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal need-sent-modal">
        <div class="modal__container">
            <div class="modal__inner modal__inner_s">
                <div class="modal__content">
                    <div class="modal__head">
                        <div class="modal__close" data-close="close">
                            <svg class="icon icon-cross " viewBox="0 0 24 24">
                                <use xlink:href="/infopart/icons/sprite.svg#cross"></use>
                            </svg>
                        </div>
                        <div class="modal__head-text">Потребность отправлена</div>
                    </div>
                    <div class="modal__body">
                        <p>Пользователь получил ссылку, при&nbsp;открытии которой, он увидит вашу потребность
                            <br>После того, как он даст предложение, вы увидете его у&nbsp;себя в&nbsp;предложениях</p>
                        <div class="modal__footer modal__footer_ok">
                            <div class="modal__btn btn btn_blue btn_m" data-close="close">Понятно</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal link-copied-modal">
        <div class="modal__container">
            <div class="modal__inner modal__inner_s">
                <div class="modal__content">
                    <div class="modal__head">
                        <div class="modal__close" data-close="close">
                            <svg class="icon icon-cross " viewBox="0 0 24 24">
                                <use xlink:href="/infopart/icons/sprite.svg#cross"></use>
                            </svg>
                        </div>
                        <div class="modal__head-text">Ссылка скопирована</div>
                    </div>
                    <div class="modal__body">
                        <p>Ссылка скопирована в&nbsp;буфер обмена
                            <br>Отправте ее и, когда пользователь даст преложение, Вы увидите его у&nbsp;себя в&nbsp;предложениях</p>
                        <div class="modal__footer modal__footer_ok">
                            <div class="modal__btn btn btn_blue btn_m" data-close="close">Понятно</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal need-history-modal">
        <div class="modal__container">
            <div class="modal__inner modal__inner_s">
                <div class="modal__content">
                    <div class="modal__head">
                        <div class="modal__close" data-close="close">
                            <svg class="icon icon-cross " viewBox="0 0 24 24">
                                <use xlink:href="/infopart/icons/sprite.svg#cross"></use>
                            </svg>
                        </div>
                        <div class="modal__head-text">История потребности</div>
                    </div>
                    <div class="modal__body">
                        <div class="history-list">
                            <div class="history-list__item">
                                <div class="history-list__info">
                                    <div class="history-list__info-top">
                                        <div class="history-list__info-name">Денис</div>
                                        <div class="history-list__info-time">12:51</div>
                                    </div>
                                    <div class="history-list__info-company">Цена - Качество</div>
                                </div>
                                <div class="history-list__descr">
                                    <p class="history-list__descr-text">28 января: Покупатель разместил не опубликованную заявку Категория - Запчасти, Наименование - Дистанционный элемент, Назначение</p>
                                </div>
                            </div>
                            <div class="history-list__item">
                                <div class="history-list__info">
                                    <div class="history-list__info-top">
                                        <div class="history-list__info-name">Денис</div>
                                        <div class="history-list__info-time">12:51</div>
                                    </div>
                                    <div class="history-list__info-company">Цена - Качество</div>
                                </div>
                                <div class="history-list__descr">
                                    <p class="history-list__descr-text">28 января: Покупатель разместил не опубликованную заявку Категория - Запчасти, Наименование - Дистанционный элемент, Назначение</p>
                                </div>
                            </div>
                            <div class="history-list__item">
                                <div class="history-list__info">
                                    <div class="history-list__info-top">
                                        <div class="history-list__info-name">Денис</div>
                                        <div class="history-list__info-time">12:51</div>
                                    </div>
                                    <div class="history-list__info-company">Цена - Качество</div>
                                </div>
                                <div class="history-list__descr">
                                    <p class="history-list__descr-text">28 января: Покупатель разместил не опубликованную заявку Категория - Запчасти, Наименование - Дистанционный элемент, Назначение</p>
                                </div>
                            </div>
                            <div class="history-list__item">
                                <div class="history-list__info">
                                    <div class="history-list__info-top">
                                        <div class="history-list__info-name">Денис</div>
                                        <div class="history-list__info-time">12:51</div>
                                    </div>
                                    <div class="history-list__info-company">Цена - Качество</div>
                                </div>
                                <div class="history-list__descr">
                                    <p class="history-list__descr-text">28 января: Покупатель разместил не опубликованную заявку Категория - Запчасти, Наименование - Дистанционный элемент, Назначение</p>
                                </div>
                            </div>
                            <div class="history-list__item">
                                <div class="history-list__info">
                                    <div class="history-list__info-top">
                                        <div class="history-list__info-name">Денис</div>
                                        <div class="history-list__info-time">12:51</div>
                                    </div>
                                    <div class="history-list__info-company">Цена - Качество</div>
                                </div>
                                <div class="history-list__descr">
                                    <p class="history-list__descr-text">28 января: Покупатель разместил не опубликованную заявку Категория - Запчасти, Наименование - Дистанционный элемент, Назначение</p>
                                </div>
                            </div>
                            <div class="history-list__item">
                                <div class="history-list__info">
                                    <div class="history-list__info-top">
                                        <div class="history-list__info-name">Денис</div>
                                        <div class="history-list__info-time">12:51</div>
                                    </div>
                                    <div class="history-list__info-company">Цена - Качество</div>
                                </div>
                                <div class="history-list__descr">
                                    <p class="history-list__descr-text">28 января: Покупатель разместил не опубликованную заявку Категория - Запчасти, Наименование - Дистанционный элемент, Назначение</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal offers-modal">
        <div class="modal__container">
            <div class="modal__inner">
                <div class="modal__content">
                    <div class="modal__head">
                        <div class="modal__close" data-close="close">
                            <svg class="icon icon-cross " viewBox="0 0 24 24">
                                <use xlink:href="/infopart/icons/sprite.svg#cross"></use>
                            </svg>
                        </div>
                        <div class="modal__head-left"><span class="modal__head-text">Mercedes Benz E-Classe</span><span>, от&nbsp;2015г., Кабриолет,  от&nbsp;80 000 до&nbsp;100 000,  Белый</span>
                        </div>
                        <div class="modal__head-right">
                            <ul class="modal__head-list">
                                <li class="modal__head-list-item"><span class="modal__head-list-item-name">Опубликовано</span><span class="modal__head-list-item-separator">&nbsp;-&nbsp; </span><span class="modal__head-list-item-num">5</span>
                                </li>
                                <li class="modal__head-list-item"><span class="modal__head-list-item-name">Активно</span><span class="modal__head-list-item-separator">&nbsp;-&nbsp; </span><span class="modal__head-list-item-num">8</span>
                                </li>
                                <li class="modal__head-list-item"><span class="modal__head-list-item-name">Заказано</span><span class="modal__head-list-item-separator">&nbsp;-&nbsp; </span><span class="modal__head-list-item-num">5</span>
                                </li>
                                <li class="modal__head-list-item"><span class="modal__head-list-item-name">Исполнено</span><span class="modal__head-list-item-separator">&nbsp;-&nbsp; </span><span class="modal__head-list-item-num">8</span>
                                </li>
                                <li class="modal__head-list-item"><span class="modal__head-list-item-name">На возврат</span><span class="modal__head-list-item-separator">&nbsp;-&nbsp; </span><span class="modal__head-list-item-num modal__head-list-item-num modal__head-list-item-num_red">8</span>
                                </li>
                                <li class="modal__head-list-item"><span class="modal__head-list-item-name">Возвращено</span><span class="modal__head-list-item-separator">&nbsp;-&nbsp; </span><span class="modal__head-list-item-num modal__head-list-item-num modal__head-list-item-num_red">8</span>
                                </li>
                                <li class="modal__head-list-item"><span class="modal__head-list-item-name">На складе</span><span class="modal__head-list-item-separator">&nbsp;-&nbsp; </span><span class="modal__head-list-item-num">8</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal__body">
                        <div class="cards">
                            <div class="cards__item">
                                <div class="cards__content">
                                    <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><label class="checkbox cards-top__checkbox"><input class="checkbox__input j-cb-share-need" type="checkbox" name="share-need"/><span class="checkbox__control"><span class="checkbox__icon"><svg class="icon icon-check " viewBox="0 0 16 16"><use xlink:href="/infopart/icons/sprite.svg#check"></use></svg></span></span>
                                        </label><a class="cards-top__item-name-text" href="#http://link1/">Ловушка фаркопа</a>
                                        </span>
                                        </span>
                                        <div class="cards-top__quantity">
                                            <div class="cards-top__quantity-left">20 шт<span class="cards-top__quantity-purchased">&nbsp;(1)</span>
                                            </div>
                                            <div class="cards-top__min-lot"> <span class="cards-top__min-lot-left">2</span><span class="cards-top__min-lot-separator">/</span><span class="cards-top__min-lot-multiplicity">2</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cards-cost">
                                        <div class="cards-cost__main"><span class="cards-cost__price">3 600<span class="cards-cost__symbol">&nbsp;₽</span></span><span class="cards-cost__payment">НДС</span>
                                        </div>
                                        <div class="cards-cost__old"><span class="cards-cost__price cards-cost__price_cross-out">3 500<span class="cards-cost__symbol">&nbsp;₽</span></span><span class="cards-cost__payment">НДС</span>
                                        </div>
                                    </div>
                                    <div class="cards-properties">
                                        <div class="cards-properties__properties-item">2360-2910210</div>
                                        <div class="cards-properties__properties-item">Scania</div>
                                        <div class="cards-properties__properties-item">Сталь 20</div>
                                        <div class="cards-properties__properties-item">5 брендов</div>
                                        <div class="cards-properties__properties-item">4 листа</div>
                                    </div>
                                    <div class="cards-bottom">
                                        <div class="cards-bottom__comment"><span class="cards-bottom__comment-text">оплата до&nbsp;20 ноября</span>
                                        </div>
                                        <div class="cards-bottom__urgency cards-bottom__urgency cards-bottom__urgency_urgent">Срочно</div>
                                        <div class="cards-bottom__city">Уфа</div>
                                        <div class="cards-bottom__right">
                                            <div class="cards-bottom__user"><span class="cards-bottom__user-name user-online">Тимур</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/infopart/icons/sprite.svg#noAvatar"></use></svg></span>
                                            </div>
                                            <div class="cards-bottom__category">
                                                <div class="cards-bottom__category-text">Запчасти</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cards-info">
                                        <div class="cards-info__action">
                                            <div class="cards-info__action-btn btn btn_blue" data-btn=""><span>Купить</span>
                                            </div>
                                        </div>
                                        <div class="cards-info__status">
                                            <div class="cards-info__status-name"></div>
                                            <div class="cards-info__status-published"><span class="cards-info__status-published-text">20 минут назад</span>
                                            </div>
                                        </div>
                                        <div class="cards-info__manage">
                                            <div class="cards-info__manage-inner">
                                                <div class="cards-info__manage-item cards-info__manage-message">
                                                    <svg class="icon icon-mail cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                        <use xlink:href="/infopart/icons/sprite.svg#mail"></use>
                                                    </svg>
                                                </div>
                                                <div class="cards-info__manage-item cards-info__manage-warning">
                                                    <svg class="icon icon-warning cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                        <use xlink:href="/infopart/icons/sprite.svg#warning"></use>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cards-info__menu">
                                            <svg class="icon icon-threeDot cards-info__menu-icon" viewBox="0 0 32 32">
                                                <use xlink:href="/infopart/icons/sprite.svg#threeDot"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cards__item">
                                <div class="cards__content">
                                    <div class="cards-gallery">
                                        <div class="cards-gallery__inner"><a class="cards-gallery__item" href="/infopart/img/car.jpg"><span class="cards-gallery__img-wrapper"><picture>
		                            <source type="image/webp" srcset="/infopart/img/car.webp">
		                            <img src="/infopart/img/car.jpg" class="cards-gallery__img" alt="" role="presentation" />
		                        </picture></span><span class="cards-gallery__line"></span></a>
                                        </div>
                                    </div>
                                    <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><label class="checkbox cards-top__checkbox"><input class="checkbox__input j-cb-share-need" type="checkbox" name="share-need"/><span class="checkbox__control"><span class="checkbox__icon"><svg class="icon icon-check " viewBox="0 0 16 16"><use xlink:href="/infopart/icons/sprite.svg#check"></use></svg></span></span>
                                        </label><a class="cards-top__item-name-text" href="#http://link2/">Прокладка впускного коллектора (1374340) SCANIA D/DS2</a>
                                        </span>
                                        </span>
                                        <div class="cards-top__quantity">
                                            <div class="cards-top__quantity-left">20 шт<span class="cards-top__quantity-purchased">&nbsp;(1)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cards-cost">
                                        <div class="cards-cost__main"><span class="cards-cost__price">2 900 000<span class="cards-cost__symbol">&nbsp;₽</span></span><span class="cards-cost__payment"> <svg class="icon icon-money " viewBox="0 0 20 20"><use xlink:href="/infopart/icons/sprite.svg#money"></use></svg></span>
                                            <span
                                            class="cards-cost__truck">
                                                <svg class="icon icon-truck cards-cost__truck-icon" viewBox="0 0 30 18">
                                                    <use xlink:href="/infopart/icons/sprite.svg#truck"></use>
                                                </svg>
                                                </span>
                                        </div>
                                    </div>
                                    <div class="cards-properties">
                                        <div class="cards-properties__properties-item">2360-2910210</div>
                                        <div class="cards-properties__properties-item">Scania</div>
                                        <div class="cards-properties__properties-item">Сталь 20</div>
                                        <div class="cards-properties__properties-item">5 брендов</div>
                                        <div class="cards-properties__properties-item">4 листа</div>
                                    </div>
                                    <div class="cards-bottom">
                                        <div class="cards-bottom__comment"><span class="cards-bottom__comment-text">Цену только указывайте с&nbsp;доставкой</span>
                                        </div>
                                        <div class="cards-bottom__urgency cards-bottom__urgency cards-bottom__urgency_month">Месяц</div>
                                        <div class="cards-bottom__city">Уфа</div>
                                        <div class="cards-bottom__right">
                                            <div class="cards-bottom__badge">Лично для&nbsp;ВП</div>
                                            <div class="cards-bottom__user"><span class="cards-bottom__user-name user-online">Тимур</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/infopart/icons/sprite.svg#noAvatar"></use></svg></span>
                                            </div>
                                            <div class="cards-bottom__category">
                                                <div class="cards-bottom__category-text">Запчасти</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cards-info">
                                        <div class="cards-info__action">
                                            <div class="cards-info__action-btn btn btn_blue" data-btn=""><span>Купить</span>
                                            </div>
                                        </div>
                                        <div class="cards-info__status">
                                            <div class="cards-info__status-name"></div>
                                            <div class="cards-info__status-published"><span class="cards-info__status-published-text">20 минут назад</span>
                                            </div>
                                        </div>
                                        <div class="cards-info__manage">
                                            <div class="cards-info__manage-inner">
                                                <div class="cards-info__manage-item cards-info__manage-message">
                                                    <svg class="icon icon-mail cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                        <use xlink:href="/infopart/icons/sprite.svg#mail"></use>
                                                    </svg>
                                                </div>
                                                <div class="cards-info__manage-item cards-info__manage-warning">
                                                    <svg class="icon icon-warning cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                        <use xlink:href="/infopart/icons/sprite.svg#warning"></use>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cards-info__menu">
                                            <svg class="icon icon-threeDot cards-info__menu-icon" viewBox="0 0 32 32">
                                                <use xlink:href="/infopart/icons/sprite.svg#threeDot"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cards__item">
                                <div class="cards__content">
                                    <div class="cards-gallery">
                                        <div class="cards-gallery__inner"><a class="cards-gallery__item" href="/infopart/img/car.jpg" data-fancybox="card-imgs"><span class="cards-gallery__img-wrapper"><picture>
		                            <source type="image/webp" srcset="/infopart/img/car.webp">
		                            <img src="/infopart/img/car.jpg" class="cards-gallery__img" alt="" role="presentation" />
		                        </picture></span><span class="cards-gallery__line"></span></a><a class="cards-gallery__item" href="/infopart/img/car2.jpg" data-fancybox="card-imgs"><span class="cards-gallery__img-wrapper"><picture>
		                            <source type="image/webp" srcset="/infopart/img/car2.webp">
		                            <img src="/infopart/img/car2.jpg" class="cards-gallery__img" alt="" role="presentation" />
		                        </picture></span><span class="cards-gallery__line"></span></a><a class="cards-gallery__item" href="/infopart/img/car3.jpg" data-fancybox="card-imgs"><span class="cards-gallery__img-wrapper"><picture>
		                            <source type="image/webp" srcset="/infopart/img/car3.webp">
		                            <img src="/infopart/img/car3.jpg" class="cards-gallery__img" alt="" role="presentation" />
		                        </picture></span><span class="cards-gallery__line"></span></a>
                                            <a class="cards-gallery__item" href="/infopart/img/car.jpg" data-fancybox="card-imgs">
                                                <div class="cards-gallery__img-wrapper">
                                                    <picture>
                                                        <source type="image/webp" srcset="/infopart/img/car.webp">
                                                            <img src="/infopart/img/car.jpg" class="cards-gallery__img" alt="" role="presentation" />
                                                    </picture>
                                                    <div class="cards-gallery__more">
                                                        <div class="cards-gallery__more-icon">
                                                            <svg class="icon icon-camera cards-gallery__more-icon" viewBox="0 0 54 46">
                                                                <use xlink:href="/infopart/icons/sprite.svg#camera"></use>
                                                            </svg>
                                                        </div>
                                                        <div class="cards-gallery__more-text">Еще 7 фото</div>
                                                    </div>
                                                </div>
                                                <div class="cards-gallery__line"></div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><a class="cards-top__item-name-text" href="#">Toyota Corolla</a></span></span>
                                    </div>
                                    <div class="cards-properties">
                                        <div class="cards-properties__properties-item">2360-2910210</div>
                                        <div class="cards-properties__properties-item">Scania</div>
                                    </div>
                                    <div class="cards-info">
                                        <div class="cards-info__action">
                                            <div class="cards-info__action-btn btn btn_blue btn btn_dropdown j-open-offers" data-btn=""><span>от&nbsp;1553 553 руб (28)</span>
                                                <svg class="icon icon-dropdown cards-info__action-btn-icon" viewBox="0 0 12 12">
                                                    <use xlink:href="/infopart/icons/sprite.svg#dropdown"></use>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="cards-info__status">
                                            <div class="cards-info__status-name"></div>
                                            <div class="cards-info__status-published"><span class="cards-info__status-published-text">20 минут назад</span>
                                            </div>
                                        </div>
                                        <div class="cards-info__manage">
                                            <div class="cards-info__manage-inner">
                                                <div class="cards-info__manage-item cards-info__manage-message">
                                                    <svg class="icon icon-mail cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                        <use xlink:href="/infopart/icons/sprite.svg#mail"></use>
                                                    </svg>
                                                </div>
                                                <div class="cards-info__manage-item cards-info__manage-warning">
                                                    <svg class="icon icon-warning cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                        <use xlink:href="/infopart/icons/sprite.svg#warning"></use>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cards-info__menu">
                                            <svg class="icon icon-threeDot cards-info__menu-icon" viewBox="0 0 32 32">
                                                <use xlink:href="/infopart/icons/sprite.svg#threeDot"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="cards-offers cards__content">
                                    <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><a class="cards-top__item-name-text" href="#">Toyota Corolla</a></span></span>
                                    </div>
                                    <div class="cards-cost">
                                        <div class="cards-cost__main"><span class="cards-cost__price">2 890 500<span class="cards-cost__symbol">&nbsp;₽</span></span><span class="cards-cost__payment">НДС</span>
                                        </div>
                                    </div>
                                    <div class="cards-properties">
                                        <div class="cards-properties__properties-item">2360-2910210</div>
                                        <div class="cards-properties__properties-item">Scania</div>
                                        <div class="cards-properties__properties-item">Сталь 20</div>
                                        <div class="cards-properties__properties-item">5 брендов</div>
                                        <div class="cards-properties__properties-item">4 листа</div>
                                    </div>
                                    <div class="cards-bottom">
                                        <div class="cards-bottom__comment"><span class="cards-bottom__comment-text">Цену только указывайте с&nbsp;доставкой</span>
                                        </div>
                                        <div class="cards-bottom__city">Севастополь</div>
                                        <div class="cards-bottom__right">
                                            <div class="cards-bottom__user"><span class="cards-bottom__user-name user-online">Арт-Мосторс</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/infopart/icons/sprite.svg#noAvatar"></use></svg></span>
                                            </div>
                                            <div class="cards-bottom__category">
                                                <div class="cards-bottom__category-text">Запчасти</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cards-info">
                                        <div class="cards-info__action"></div>
                                        <div class="cards-info__status">
                                            <div class="cards-info__status-name">
                                                <div class="badge-notify"><span>1</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cards-info__manage">
                                            <div class="cards-info__manage-inner">
                                                <div class="cards-info__manage-item cards-info__manage-message">
                                                    <svg class="icon icon-mail cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                        <use xlink:href="/infopart/icons/sprite.svg#mail"></use>
                                                    </svg>
                                                </div>
                                                <div class="cards-info__manage-item cards-info__manage-warning">
                                                    <svg class="icon icon-warning cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                        <use xlink:href="/infopart/icons/sprite.svg#warning"></use>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cards-info__menu">
                                            <svg class="icon icon-threeDot cards-info__menu-icon" viewBox="0 0 32 32">
                                                <use xlink:href="/infopart/icons/sprite.svg#threeDot"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="cards-offers cards__content">
                                    <div class="cards-gallery">
                                        <div class="cards-gallery__inner"><a class="cards-gallery__item" href="/infopart/img/car.jpg"><span class="cards-gallery__img-wrapper"><picture>
		                            <source type="image/webp" srcset="/infopart/img/car.webp">
		                            <img src="/infopart/img/car.jpg" class="cards-gallery__img" alt="" role="presentation" />
		                        </picture></span><span class="cards-gallery__line"></span></a>
                                        </div>
                                    </div>
                                    <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><a class="cards-top__item-name-text" href="#">Toyota Corolla</a></span></span>
                                    </div>
                                    <div class="cards-cost">
                                        <div class="cards-cost__main"><span class="cards-cost__price">2 890 500<span class="cards-cost__symbol">&nbsp;₽</span></span><span class="cards-cost__payment">НДС</span>
                                        </div>
                                    </div>
                                    <div class="cards-properties">
                                        <div class="cards-properties__properties-item">2360-2910210</div>
                                        <div class="cards-properties__properties-item">Scania</div>
                                        <div class="cards-properties__properties-item">Сталь 20</div>
                                        <div class="cards-properties__properties-item">5 брендов</div>
                                        <div class="cards-properties__properties-item">4 листа</div>
                                    </div>
                                    <div class="cards-bottom">
                                        <div class="cards-bottom__comment"><span class="cards-bottom__comment-text">Цену только указывайте с&nbsp;доставкой</span>
                                        </div>
                                        <div class="cards-bottom__city">Севастополь</div>
                                        <div class="cards-bottom__right">
                                            <div class="cards-bottom__user"><span class="cards-bottom__user-name user-online">Арт-Мосторс</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/infopart/icons/sprite.svg#noAvatar"></use></svg></span>
                                            </div>
                                            <div class="cards-bottom__category">
                                                <div class="cards-bottom__category-text">Запчасти</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cards-info">
                                        <div class="cards-info__action"></div>
                                        <div class="cards-info__status">
                                            <div class="cards-info__status-name"></div>
                                        </div>
                                        <div class="cards-info__menu">
                                            <svg class="icon icon-threeDot cards-info__menu-icon" viewBox="0 0 32 32">
                                                <use xlink:href="/infopart/icons/sprite.svg#threeDot"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="cards-offers cards-offers_more"><span class="j-show-part-offers">показать еще 1 предложение из&nbsp;6 от&nbsp;485,53&nbsp;₽</span> или&nbsp;<span class="j-show-all-offers">Показать&nbsp;все&nbsp;предложения</span>
                                </div>
                            </div>
                            <div class="cards__item">
                                <div class="cards__content">
                                    <div class="cards-gallery">
                                        <div class="cards-gallery__inner"><a class="cards-gallery__item" href="/infopart/img/car.jpg"><span class="cards-gallery__img-wrapper"><picture>
		                            <source type="image/webp" srcset="/infopart/img/car.webp">
		                            <img src="/infopart/img/car.jpg" class="cards-gallery__img" alt="" role="presentation" />
		                        </picture></span><span class="cards-gallery__line"></span></a>
                                        </div>
                                    </div>
                                    <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><label class="checkbox cards-top__checkbox"><input class="checkbox__input j-cb-share-need" type="checkbox" name="share-need"/><span class="checkbox__control"><span class="checkbox__icon"><svg class="icon icon-check " viewBox="0 0 16 16"><use xlink:href="/infopart/icons/sprite.svg#check"></use></svg></span></span>
                                        </label><a class="cards-top__item-name-text" href="#http://link2/">Прокладка впускного коллектора (1374340) SCANIA D/DS2</a>
                                        </span>
                                        </span>
                                        <div class="cards-top__quantity">
                                            <div class="cards-top__quantity-left">20 шт<span class="cards-top__quantity-purchased">&nbsp;(1)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cards-cost">
                                        <div class="cards-cost__main"><span class="cards-cost__price">2 900 000<span class="cards-cost__symbol">&nbsp;₽</span></span><span class="cards-cost__payment"> <svg class="icon icon-money " viewBox="0 0 20 20"><use xlink:href="/infopart/icons/sprite.svg#money"></use></svg></span>
                                            <span
                                            class="cards-cost__truck">
                                                <svg class="icon icon-truck cards-cost__truck-icon" viewBox="0 0 30 18">
                                                    <use xlink:href="/infopart/icons/sprite.svg#truck"></use>
                                                </svg>
                                                </span>
                                        </div>
                                    </div>
                                    <div class="cards-properties">
                                        <div class="cards-properties__properties-item">2360-2910210</div>
                                        <div class="cards-properties__properties-item">Scania</div>
                                        <div class="cards-properties__properties-item">Сталь 20</div>
                                        <div class="cards-properties__properties-item">5 брендов</div>
                                        <div class="cards-properties__properties-item">4 листа</div>
                                    </div>
                                    <div class="cards-bottom">
                                        <div class="cards-bottom__comment"><span class="cards-bottom__comment-text">Цену только указывайте с&nbsp;доставкой</span>
                                        </div>
                                        <div class="cards-bottom__urgency cards-bottom__urgency cards-bottom__urgency_month">Месяц</div>
                                        <div class="cards-bottom__city">Уфа</div>
                                        <div class="cards-bottom__right">
                                            <div class="cards-bottom__badge">Лично для&nbsp;ВП</div>
                                            <div class="cards-bottom__user"><span class="cards-bottom__user-name user-online">Тимур</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/infopart/icons/sprite.svg#noAvatar"></use></svg></span>
                                            </div>
                                            <div class="cards-bottom__category">
                                                <div class="cards-bottom__category-text">Запчасти</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cards-info">
                                        <div class="cards-info__action">
                                            <div class="cards-info__action-btn btn btn_blue" data-btn=""><span>Купить</span>
                                            </div>
                                        </div>
                                        <div class="cards-info__status">
                                            <div class="cards-info__status-name"><span class="cards-info__status-name-text">Опубликованна</span>
                                            </div>
                                            <div class="cards-info__status-published"><span class="cards-info__status-published-text">20 минут назад</span>
                                            </div>
                                        </div>
                                        <div class="cards-info__manage">
                                            <div class="cards-info__manage-inner">
                                                <div class="cards-info__manage-item cards-info__manage-message">
                                                    <svg class="icon icon-mail cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                        <use xlink:href="/infopart/icons/sprite.svg#mail"></use>
                                                    </svg>
                                                </div>
                                                <div class="cards-info__manage-item cards-info__manage-warning">
                                                    <svg class="icon icon-warning cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                        <use xlink:href="/infopart/icons/sprite.svg#warning"></use>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cards-info__menu">
                                            <svg class="icon icon-threeDot cards-info__menu-icon" viewBox="0 0 32 32">
                                                <use xlink:href="/infopart/icons/sprite.svg#threeDot"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cards__item">
                                <div class="cards__content">
                                    <div class="cards-gallery">
                                        <div class="cards-gallery__inner"><a class="cards-gallery__item" href="/infopart/img/car.jpg"><span class="cards-gallery__img-wrapper"><picture>
		                            <source type="image/webp" srcset="/infopart/img/car.webp">
		                            <img src="/infopart/img/car.jpg" class="cards-gallery__img" alt="" role="presentation" />
		                        </picture></span><span class="cards-gallery__line"></span></a>
                                        </div>
                                    </div>
                                    <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><label class="checkbox cards-top__checkbox"><input class="checkbox__input j-cb-share-need" type="checkbox" name="share-need"/><span class="checkbox__control"><span class="checkbox__icon"><svg class="icon icon-check " viewBox="0 0 16 16"><use xlink:href="/infopart/icons/sprite.svg#check"></use></svg></span></span>
                                        </label><a class="cards-top__item-name-text" href="#http://link2/">Прокладка впускного коллектора (1374340) SCANIA D/DS2</a>
                                        </span>
                                        </span>
                                        <div class="cards-top__quantity">
                                            <div class="cards-top__quantity-left">20 шт<span class="cards-top__quantity-purchased">&nbsp;(1)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cards-cost">
                                        <div class="cards-cost__main"><span class="cards-cost__price">2 900 000<span class="cards-cost__symbol">&nbsp;₽</span></span><span class="cards-cost__payment"> <svg class="icon icon-money " viewBox="0 0 20 20"><use xlink:href="/infopart/icons/sprite.svg#money"></use></svg></span>
                                            <span
                                            class="cards-cost__truck">
                                                <svg class="icon icon-truck cards-cost__truck-icon" viewBox="0 0 30 18">
                                                    <use xlink:href="/infopart/icons/sprite.svg#truck"></use>
                                                </svg>
                                                </span>
                                        </div>
                                    </div>
                                    <div class="cards-properties">
                                        <div class="cards-properties__properties-item">2360-2910210</div>
                                        <div class="cards-properties__properties-item">Scania</div>
                                        <div class="cards-properties__properties-item">Сталь 20</div>
                                        <div class="cards-properties__properties-item">5 брендов</div>
                                        <div class="cards-properties__properties-item">4 листа</div>
                                    </div>
                                    <div class="cards-bottom">
                                        <div class="cards-bottom__comment"><span class="cards-bottom__comment-text">Цену только указывайте с&nbsp;доставкой</span>
                                        </div>
                                        <div class="cards-bottom__urgency cards-bottom__urgency cards-bottom__urgency_month">Месяц</div>
                                        <div class="cards-bottom__city">Уфа</div>
                                        <div class="cards-bottom__right">
                                            <div class="cards-bottom__badge">Лично для&nbsp;ВП</div>
                                            <div class="cards-bottom__user"><span class="cards-bottom__user-name user-online">Тимур</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/infopart/icons/sprite.svg#noAvatar"></use></svg></span>
                                            </div>
                                            <div class="cards-bottom__category">
                                                <div class="cards-bottom__category-text">Запчасти</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cards-info">
                                        <div class="cards-info__action">
                                            <div class="cards-info__action-btn btn btn_blue" data-btn=""><span>Купить</span>
                                            </div>
                                        </div>
                                        <div class="cards-info__status">
                                            <div class="cards-info__status-name"><span class="cards-info__status-name-text">Опубликованна</span>
                                            </div>
                                            <div class="cards-info__status-published"><span class="cards-info__status-published-text">20 минут назад</span>
                                            </div>
                                        </div>
                                        <div class="cards-info__manage">
                                            <div class="cards-info__manage-inner">
                                                <div class="cards-info__manage-item cards-info__manage-message">
                                                    <svg class="icon icon-mail cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                        <use xlink:href="/infopart/icons/sprite.svg#mail"></use>
                                                    </svg>
                                                </div>
                                                <div class="cards-info__manage-item cards-info__manage-warning">
                                                    <svg class="icon icon-warning cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                        <use xlink:href="/infopart/icons/sprite.svg#warning"></use>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cards-info__menu">
                                            <svg class="icon icon-threeDot cards-info__menu-icon" viewBox="0 0 32 32">
                                                <use xlink:href="/infopart/icons/sprite.svg#threeDot"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cards__item">
                                <div class="cards__content">
                                    <div class="cards-gallery">
                                        <div class="cards-gallery__inner"><a class="cards-gallery__item" href="/infopart/img/car.jpg"><span class="cards-gallery__img-wrapper"><picture>
		                            <source type="image/webp" srcset="/infopart/img/car.webp">
		                            <img src="/infopart/img/car.jpg" class="cards-gallery__img" alt="" role="presentation" />
		                        </picture></span><span class="cards-gallery__line"></span></a>
                                        </div>
                                    </div>
                                    <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><label class="checkbox cards-top__checkbox"><input class="checkbox__input j-cb-share-need" type="checkbox" name="share-need"/><span class="checkbox__control"><span class="checkbox__icon"><svg class="icon icon-check " viewBox="0 0 16 16"><use xlink:href="/infopart/icons/sprite.svg#check"></use></svg></span></span>
                                        </label><a class="cards-top__item-name-text" href="#http://link2/">Прокладка впускного коллектора (1374340) SCANIA D/DS2</a>
                                        </span>
                                        </span>
                                        <div class="cards-top__quantity">
                                            <div class="cards-top__quantity-left">20 шт<span class="cards-top__quantity-purchased">&nbsp;(1)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cards-cost">
                                        <div class="cards-cost__main"><span class="cards-cost__price">2 900 000<span class="cards-cost__symbol">&nbsp;₽</span></span><span class="cards-cost__payment"> <svg class="icon icon-money " viewBox="0 0 20 20"><use xlink:href="/infopart/icons/sprite.svg#money"></use></svg></span>
                                            <span
                                            class="cards-cost__truck">
                                                <svg class="icon icon-truck cards-cost__truck-icon" viewBox="0 0 30 18">
                                                    <use xlink:href="/infopart/icons/sprite.svg#truck"></use>
                                                </svg>
                                                </span>
                                        </div>
                                    </div>
                                    <div class="cards-properties">
                                        <div class="cards-properties__properties-item">2360-2910210</div>
                                        <div class="cards-properties__properties-item">Scania</div>
                                        <div class="cards-properties__properties-item">Сталь 20</div>
                                        <div class="cards-properties__properties-item">5 брендов</div>
                                        <div class="cards-properties__properties-item">4 листа</div>
                                    </div>
                                    <div class="cards-bottom">
                                        <div class="cards-bottom__comment"><span class="cards-bottom__comment-text">Цену только указывайте с&nbsp;доставкой</span>
                                        </div>
                                        <div class="cards-bottom__urgency cards-bottom__urgency cards-bottom__urgency_month">Месяц</div>
                                        <div class="cards-bottom__city">Уфа</div>
                                        <div class="cards-bottom__right">
                                            <div class="cards-bottom__badge">Лично для&nbsp;ВП</div>
                                            <div class="cards-bottom__user"><span class="cards-bottom__user-name user-online">Тимур</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/infopart/icons/sprite.svg#noAvatar"></use></svg></span>
                                            </div>
                                            <div class="cards-bottom__category">
                                                <div class="cards-bottom__category-text">Запчасти</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cards-info">
                                        <div class="cards-info__action">
                                            <div class="cards-info__action-btn btn btn_blue" data-btn=""><span>Купить</span>
                                            </div>
                                        </div>
                                        <div class="cards-info__status">
                                            <div class="cards-info__status-name"><span class="cards-info__status-name-text">Опубликованна</span>
                                            </div>
                                            <div class="cards-info__status-published"><span class="cards-info__status-published-text">20 минут назад</span>
                                            </div>
                                        </div>
                                        <div class="cards-info__manage">
                                            <div class="cards-info__manage-inner">
                                                <div class="cards-info__manage-item cards-info__manage-message">
                                                    <svg class="icon icon-mail cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                        <use xlink:href="/infopart/icons/sprite.svg#mail"></use>
                                                    </svg>
                                                </div>
                                                <div class="cards-info__manage-item cards-info__manage-warning">
                                                    <svg class="icon icon-warning cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                        <use xlink:href="/infopart/icons/sprite.svg#warning"></use>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cards-info__menu">
                                            <svg class="icon icon-threeDot cards-info__menu-icon" viewBox="0 0 32 32">
                                                <use xlink:href="/infopart/icons/sprite.svg#threeDot"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cards__item">
                                <div class="cards__content">
                                    <div class="cards-gallery">
                                        <div class="cards-gallery__inner"><a class="cards-gallery__item" href="/infopart/img/car.jpg"><span class="cards-gallery__img-wrapper"><picture>
		                            <source type="image/webp" srcset="/infopart/img/car.webp">
		                            <img src="/infopart/img/car.jpg" class="cards-gallery__img" alt="" role="presentation" />
		                        </picture></span><span class="cards-gallery__line"></span></a>
                                        </div>
                                    </div>
                                    <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><label class="checkbox cards-top__checkbox"><input class="checkbox__input j-cb-share-need" type="checkbox" name="share-need"/><span class="checkbox__control"><span class="checkbox__icon"><svg class="icon icon-check " viewBox="0 0 16 16"><use xlink:href="/infopart/icons/sprite.svg#check"></use></svg></span></span>
                                        </label><a class="cards-top__item-name-text" href="#http://link2/">Прокладка впускного коллектора (1374340) SCANIA D/DS2</a>
                                        </span>
                                        </span>
                                        <div class="cards-top__quantity">
                                            <div class="cards-top__quantity-left">20 шт<span class="cards-top__quantity-purchased">&nbsp;(1)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cards-cost">
                                        <div class="cards-cost__main"><span class="cards-cost__price">2 900 000<span class="cards-cost__symbol">&nbsp;₽</span></span><span class="cards-cost__payment"> <svg class="icon icon-money " viewBox="0 0 20 20"><use xlink:href="/infopart/icons/sprite.svg#money"></use></svg></span>
                                            <span
                                            class="cards-cost__truck">
                                                <svg class="icon icon-truck cards-cost__truck-icon" viewBox="0 0 30 18">
                                                    <use xlink:href="/infopart/icons/sprite.svg#truck"></use>
                                                </svg>
                                                </span>
                                        </div>
                                    </div>
                                    <div class="cards-properties">
                                        <div class="cards-properties__properties-item">2360-2910210</div>
                                        <div class="cards-properties__properties-item">Scania</div>
                                        <div class="cards-properties__properties-item">Сталь 20</div>
                                        <div class="cards-properties__properties-item">5 брендов</div>
                                        <div class="cards-properties__properties-item">4 листа</div>
                                    </div>
                                    <div class="cards-bottom">
                                        <div class="cards-bottom__comment"><span class="cards-bottom__comment-text">Цену только указывайте с&nbsp;доставкой</span>
                                        </div>
                                        <div class="cards-bottom__urgency cards-bottom__urgency cards-bottom__urgency_month">Месяц</div>
                                        <div class="cards-bottom__city">Уфа</div>
                                        <div class="cards-bottom__right">
                                            <div class="cards-bottom__badge">Лично для&nbsp;ВП</div>
                                            <div class="cards-bottom__user"><span class="cards-bottom__user-name user-online">Тимур</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/infopart/icons/sprite.svg#noAvatar"></use></svg></span>
                                            </div>
                                            <div class="cards-bottom__category">
                                                <div class="cards-bottom__category-text">Запчасти</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cards-info">
                                        <div class="cards-info__action">
                                            <div class="cards-info__action-btn btn btn_blue" data-btn=""><span>Купить</span>
                                            </div>
                                        </div>
                                        <div class="cards-info__status">
                                            <div class="cards-info__status-name"><span class="cards-info__status-name-text">Опубликованна</span>
                                            </div>
                                            <div class="cards-info__status-published"><span class="cards-info__status-published-text">20 минут назад</span>
                                            </div>
                                        </div>
                                        <div class="cards-info__manage">
                                            <div class="cards-info__manage-inner">
                                                <div class="cards-info__manage-item cards-info__manage-message">
                                                    <svg class="icon icon-mail cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                        <use xlink:href="/infopart/icons/sprite.svg#mail"></use>
                                                    </svg>
                                                </div>
                                                <div class="cards-info__manage-item cards-info__manage-warning">
                                                    <svg class="icon icon-warning cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                        <use xlink:href="/infopart/icons/sprite.svg#warning"></use>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cards-info__menu">
                                            <svg class="icon icon-threeDot cards-info__menu-icon" viewBox="0 0 32 32">
                                                <use xlink:href="/infopart/icons/sprite.svg#threeDot"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cards__item">
                                <div class="cards__content">
                                    <div class="cards-gallery">
                                        <div class="cards-gallery__inner"><a class="cards-gallery__item" href="/infopart/img/car.jpg"><span class="cards-gallery__img-wrapper"><picture>
		                            <source type="image/webp" srcset="/infopart/img/car.webp">
		                            <img src="/infopart/img/car.jpg" class="cards-gallery__img" alt="" role="presentation" />
		                        </picture></span><span class="cards-gallery__line"></span></a>
                                        </div>
                                    </div>
                                    <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><label class="checkbox cards-top__checkbox"><input class="checkbox__input j-cb-share-need" type="checkbox" name="share-need"/><span class="checkbox__control"><span class="checkbox__icon"><svg class="icon icon-check " viewBox="0 0 16 16"><use xlink:href="/infopart/icons/sprite.svg#check"></use></svg></span></span>
                                        </label><a class="cards-top__item-name-text" href="#http://link2/">Прокладка впускного коллектора (1374340) SCANIA D/DS2</a>
                                        </span>
                                        </span>
                                        <div class="cards-top__quantity">
                                            <div class="cards-top__quantity-left">20 шт<span class="cards-top__quantity-purchased">&nbsp;(1)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cards-cost">
                                        <div class="cards-cost__main"><span class="cards-cost__price">2 900 000<span class="cards-cost__symbol">&nbsp;₽</span></span><span class="cards-cost__payment"> <svg class="icon icon-money " viewBox="0 0 20 20"><use xlink:href="/infopart/icons/sprite.svg#money"></use></svg></span>
                                            <span
                                            class="cards-cost__truck">
                                                <svg class="icon icon-truck cards-cost__truck-icon" viewBox="0 0 30 18">
                                                    <use xlink:href="/infopart/icons/sprite.svg#truck"></use>
                                                </svg>
                                                </span>
                                        </div>
                                    </div>
                                    <div class="cards-properties">
                                        <div class="cards-properties__properties-item">2360-2910210</div>
                                        <div class="cards-properties__properties-item">Scania</div>
                                        <div class="cards-properties__properties-item">Сталь 20</div>
                                        <div class="cards-properties__properties-item">5 брендов</div>
                                        <div class="cards-properties__properties-item">4 листа</div>
                                    </div>
                                    <div class="cards-bottom">
                                        <div class="cards-bottom__comment"><span class="cards-bottom__comment-text">Цену только указывайте с&nbsp;доставкой</span>
                                        </div>
                                        <div class="cards-bottom__urgency cards-bottom__urgency cards-bottom__urgency_month">Месяц</div>
                                        <div class="cards-bottom__city">Уфа</div>
                                        <div class="cards-bottom__right">
                                            <div class="cards-bottom__badge">Лично для&nbsp;ВП</div>
                                            <div class="cards-bottom__user"><span class="cards-bottom__user-name user-online">Тимур</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/infopart/icons/sprite.svg#noAvatar"></use></svg></span>
                                            </div>
                                            <div class="cards-bottom__category">
                                                <div class="cards-bottom__category-text">Запчасти</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cards-info">
                                        <div class="cards-info__action">
                                            <div class="cards-info__action-btn btn btn_blue" data-btn=""><span>Купить</span>
                                            </div>
                                        </div>
                                        <div class="cards-info__status">
                                            <div class="cards-info__status-name"><span class="cards-info__status-name-text">Опубликованна</span>
                                            </div>
                                            <div class="cards-info__status-published"><span class="cards-info__status-published-text">20 минут назад</span>
                                            </div>
                                        </div>
                                        <div class="cards-info__manage">
                                            <div class="cards-info__manage-inner">
                                                <div class="cards-info__manage-item cards-info__manage-message">
                                                    <svg class="icon icon-mail cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                        <use xlink:href="/infopart/icons/sprite.svg#mail"></use>
                                                    </svg>
                                                </div>
                                                <div class="cards-info__manage-item cards-info__manage-warning">
                                                    <svg class="icon icon-warning cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                        <use xlink:href="/infopart/icons/sprite.svg#warning"></use>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cards-info__menu">
                                            <svg class="icon icon-threeDot cards-info__menu-icon" viewBox="0 0 32 32">
                                                <use xlink:href="/infopart/icons/sprite.svg#threeDot"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cards__item">
                                <div class="cards__content">
                                    <div class="cards-gallery">
                                        <div class="cards-gallery__inner"><a class="cards-gallery__item" href="/infopart/img/car.jpg"><span class="cards-gallery__img-wrapper"><picture>
		                            <source type="image/webp" srcset="/infopart/img/car.webp">
		                            <img src="/infopart/img/car.jpg" class="cards-gallery__img" alt="" role="presentation" />
		                        </picture></span><span class="cards-gallery__line"></span></a>
                                        </div>
                                    </div>
                                    <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><label class="checkbox cards-top__checkbox"><input class="checkbox__input j-cb-share-need" type="checkbox" name="share-need"/><span class="checkbox__control"><span class="checkbox__icon"><svg class="icon icon-check " viewBox="0 0 16 16"><use xlink:href="/infopart/icons/sprite.svg#check"></use></svg></span></span>
                                        </label><a class="cards-top__item-name-text" href="#http://link2/">Прокладка впускного коллектора (1374340) SCANIA D/DS2</a>
                                        </span>
                                        </span>
                                        <div class="cards-top__quantity">
                                            <div class="cards-top__quantity-left">20 шт<span class="cards-top__quantity-purchased">&nbsp;(1)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cards-cost">
                                        <div class="cards-cost__main"><span class="cards-cost__price">2 900 000<span class="cards-cost__symbol">&nbsp;₽</span></span><span class="cards-cost__payment"> <svg class="icon icon-money " viewBox="0 0 20 20"><use xlink:href="/infopart/icons/sprite.svg#money"></use></svg></span>
                                            <span
                                            class="cards-cost__truck">
                                                <svg class="icon icon-truck cards-cost__truck-icon" viewBox="0 0 30 18">
                                                    <use xlink:href="/infopart/icons/sprite.svg#truck"></use>
                                                </svg>
                                                </span>
                                        </div>
                                    </div>
                                    <div class="cards-properties">
                                        <div class="cards-properties__properties-item">2360-2910210</div>
                                        <div class="cards-properties__properties-item">Scania</div>
                                        <div class="cards-properties__properties-item">Сталь 20</div>
                                        <div class="cards-properties__properties-item">5 брендов</div>
                                        <div class="cards-properties__properties-item">4 листа</div>
                                    </div>
                                    <div class="cards-bottom">
                                        <div class="cards-bottom__comment"><span class="cards-bottom__comment-text">Цену только указывайте с&nbsp;доставкой</span>
                                        </div>
                                        <div class="cards-bottom__urgency cards-bottom__urgency cards-bottom__urgency_month">Месяц</div>
                                        <div class="cards-bottom__city">Уфа</div>
                                        <div class="cards-bottom__right">
                                            <div class="cards-bottom__badge">Лично для&nbsp;ВП</div>
                                            <div class="cards-bottom__user"><span class="cards-bottom__user-name user-online">Тимур</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/infopart/icons/sprite.svg#noAvatar"></use></svg></span>
                                            </div>
                                            <div class="cards-bottom__category">
                                                <div class="cards-bottom__category-text">Запчасти</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cards-info">
                                        <div class="cards-info__action">
                                            <div class="cards-info__action-btn btn btn_blue" data-btn=""><span>Купить</span>
                                            </div>
                                        </div>
                                        <div class="cards-info__status">
                                            <div class="cards-info__status-name"><span class="cards-info__status-name-text">Опубликованна</span>
                                            </div>
                                            <div class="cards-info__status-published"><span class="cards-info__status-published-text">20 минут назад</span>
                                            </div>
                                        </div>
                                        <div class="cards-info__manage">
                                            <div class="cards-info__manage-inner">
                                                <div class="cards-info__manage-item cards-info__manage-message">
                                                    <svg class="icon icon-mail cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                        <use xlink:href="/infopart/icons/sprite.svg#mail"></use>
                                                    </svg>
                                                </div>
                                                <div class="cards-info__manage-item cards-info__manage-warning">
                                                    <svg class="icon icon-warning cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                        <use xlink:href="/infopart/icons/sprite.svg#warning"></use>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cards-info__menu">
                                            <svg class="icon icon-threeDot cards-info__menu-icon" viewBox="0 0 32 32">
                                                <use xlink:href="/infopart/icons/sprite.svg#threeDot"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                            <use xlink:href="/infopart/icons/sprite.svg#cross"></use>
                        </svg>
                    </div>
                    <div class="modal__body">
                        <div class="needs-modal__header">
                            <div class="needs-modal__photos">
                                <svg class="icon icon-cameraSharp " viewBox="0 0 17 17">
                                    <use xlink:href="/infopart/icons/sprite.svg#cameraSharp"></use>
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
                                    <use xlink:href="/infopart/icons/sprite.svg#floppyDisk"></use>
                                </svg>
                            </div>
                            <div class="needs-modal__next btn btn_blue btn_m" data-next="1">Продолжить</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="subscription-emex-modal modal modal_m">
        <div class="modal__container">
            <div class="modal__inner">
                <div class="modal__content">
                    <div class="modal__head">
                        <div class="modal__close" data-close="close">
                            <svg class="icon icon-cross " viewBox="0 0 24 24">
                                <use xlink:href="/infopart/icons/sprite.svg#cross"></use>
                            </svg>
                        </div>
                        <div class="modal__head-text">Подписка на&nbsp;Emex</div>
                    </div>
                    <div class="modal__body">
                        <form class="subscription-emex-modal__form form subscription-emex-form">
                            <div class="subscription-emex-modal__groups">
                                <div class="subscription-emex-modal__form-group form-group">
                                    <input class="input require" type="text" placeholder="Логин" name="login">
                                </div>
                                <div class="subscription-emex-modal__form-group form-group">
                                    <input class="input require" type="password" placeholder="Пароль" name="pass">
                                </div>
                                <div class="subscription-emex-modal__form-group form-group">
                                    <div class="select-box require">
                                        <select>
                                            <option>Выберите</option>
                                            <option>Вариант 1</option>
                                            <option>Вариант 2</option>
                                        </select>
                                        <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                                            <use xlink:href="/infopart/icons/sprite.svg#dropdown"></use>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="subscription-emex-modal__info">
                                <div class="subscription-emex-modal__info-inner">
                                    <div class="subscription-emex-modal__info-btn">
                                        <svg class="icon icon-infoSign " viewBox="0 0 30 30">
                                            <use xlink:href="/infopart/icons/sprite.svg#infoSign"></use>
                                        </svg>
                                    </div>
                                    <div class="subscription-emex-modal__info-tip">Свяжитесь с&nbsp;поставщиком и&nbsp;запросите Логин и&nbsp;Пароль
                                        <br>
                                        <br>Телефон:
                                        <br>+7 968 851-38-45 +7 916 845-99-65</div>
                                </div>
                            </div>
                            <div class="subscription-emex-modal__bottom">
                                <div class="subscription-emex-modal__btn btn btn_gray-bd btn_m" data-close="close">Без авторизации</div>
                                <div class="subscription-emex-modal__btn btn btn_blue btn_m" data-close="close">Добавить</div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/just-validate@3.8.1/dist/just-validate.production.min.js"></script>
    <script src="/infopart/js/app.js?v=1654684234594"></script>
	
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
<noscript><div><img src="https://mc.yandex.ru/watch/85847373" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
	
	
</body>

</html>
    ';
	//$row 	= $member['mainpage']['row'];

	// $form_autorize = (!COMPANY_ID)? '	
	// 								<svg class="icon icon-signIn" viewBox="0 0 20 20">
    //                                     <use xlink:href="/infoparts_assets/icons/sprite.svg#signIn"></use>
    //                                 </svg>
    //                                 <div class="header__log-in-enter">
    //                                     <div class="header__log-in-text">Войти</div>
    //                                     <div class="header__log-in-btn">
    //                                         <form class="form-wrapper" id="login-form">
    //                                             <div class="form-group">
    //                                                 <input id="email" type="text" name="email" placeholder="Логин">
    //                                             </div>
    //                                             <div class="form-group">
    //                                                 <input id="pass" type="password" name="pass" placeholder="Пароль">
    //                                             </div>
    //                                             <div class="form-group">
    //                                                 <div class="form-group__title"><a href="/restore">Забыли пароль?</a>
    //                                                 </div>
    //                                                 <button class="login-form-button login-in btn btn-blue" type="submit">Войти</button>
    //                                             </div>
    //                                             <div class="form-group">
    //                                                 <div class="form-group__title">Если у&nbsp;Вас нет аккаунта?</div>
    //                                                 <div class="login-form-button modal_registration btn btn-blue">Создать сейчас</div>
    //                                             </div>
    //                                         </form>
    //                                     </div>
    //                                 </div>' : '';


	// $code .= '
		// Для Кирилла 
		// <br/>
		// link rel="stylesheet" href="/infoparts_assets/css/app.css?v=1613147712566"
		// <br/>
		// (если подключить эту css исчезает checkbox во всплывающей модали после ввода артикула детали)
	
		// <section class="search" id="search">
		// 	<div class="container">
		// 		<div class="search-wrapper">
		// 			<div class="for-search">
		// 				<div class="btn search-main">
		// 					<input type="text" placeholder="Что ищете?" class="search-input search_infopart" autocomplete="off">
		// 				</div>
		// 			</div>
		// 		</div>
		// 	</div>
		// </section>
	
		// 	';


$_SESSION['tmp_login'] = false;

disConnect();
    exit;
?>