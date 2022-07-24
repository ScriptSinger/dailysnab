<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1">
    <title>Мои заявки</title>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;700&amp;family=Open+Sans:wght@300;400;500;600;700;800&amp;display=fallback" rel="stylesheet">
    <link rel="stylesheet" href="/app/css/app.css?v=1657458532784">
    <script>
        function canUseWebP(){var e=document.createElement("canvas");return!(!e.getContext||!e.getContext("2d"))&&0==e.toDataURL("image/webp").indexOf("data:image/webp")}var root=document.getElementsByTagName("html")[0];canUseWebP()?root.classList.add("ws"):root.classList.add("wn");
    </script>
</head>

<body>
    <main>
        <header class="header">
            <div class="header__wrap wrap">
                <a class="logo" href="/">
                    <svg class="icon icon-logo " viewBox="0 0 153 54">
                        <use xlink:href="/app/icons/sprite.svg#logo"></use>
                    </svg>
                    <div class="badge-notify"><span>24</span>
                    </div>
                </a>
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
                        <div class="what-search__more">
                            <div class="what-search__close">
                                <svg class="icon icon-cross " viewBox="0 0 24 24">
                                    <use xlink:href="/app/icons/sprite.svg#cross"></use>
                                </svg>
                            </div>
                            <ul class="what-search__more-list">
                                <li class="what-search__more-item what-search__more-item_applications" data-ws-tab-id="1"><span class="what-search__more-icon"><svg class="icon icon-requests " viewBox="0 0 20 20"><use xlink:href="/app/icons/sprite.svg#requests"></use></svg></span>
                                    <div class="what-search__more-select-group">
                                        <select class="what-search__more-select">
                                            <option>Заявки</option>
                                            <option>Объявления</option>
                                        </select>
                                        <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                                            <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                                        </svg>
                                    </div>
                                </li>
                                <li class="what-search__more-item" data-ws-tab-id="2"><span class="what-search__more-icon"><svg class="icon icon-nineSquares " viewBox="0 0 20 20"><use xlink:href="/app/icons/sprite.svg#nineSquares"></use></svg></span><span class="what-search__more-text">Категория</span>
                                    <div
                                    class="what-search__more-item-close">
                                        <svg class="icon icon-cross " viewBox="0 0 24 24">
                                            <use xlink:href="/app/icons/sprite.svg#cross"></use>
                                        </svg>
                        </div>
                        </li>
                        <li class="what-search__more-item" data-ws-tab-id="3"><span class="what-search__more-icon"><svg class="icon icon-location " viewBox="0 0 20 20"><use xlink:href="/app/icons/sprite.svg#location"></use></svg></span><span class="what-search__more-text">Место</span>
                            <div class="what-search__more-item-close">
                                <svg class="icon icon-cross " viewBox="0 0 24 24">
                                    <use xlink:href="/app/icons/sprite.svg#cross"></use>
                                </svg>
                            </div>
                        </li>
                        <li class="what-search__more-item"><span class="what-search__more-icon"><svg class="icon icon-sort " viewBox="0 0 20 20"><use xlink:href="/app/icons/sprite.svg#sort"></use></svg></span><span class="what-search__more-text">По дате</span>
                            <svg class="icon icon-dropdown "
                            viewBox="0 0 12 12">
                                <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                            </svg>
                        </li>
                        <li class="what-search__more-item"><span class="what-search__more-icon"><svg class="icon icon-divisionByThree " viewBox="0 0 20 20"><use xlink:href="/app/icons/sprite.svg#divisionByThree"></use></svg></span><span class="what-search__more-text">По активу</span>
                            <svg
                            class="icon icon-dropdown " viewBox="0 0 12 12">
                                <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                                </svg>
                        </li>
                        </ul>
                        <div class="what-search__location what-search__more-section" data-ws-content-id="3">
                            <form class="location-form ac-group">
                                <input class="location-form__input ac-group__input" type="text" id="what-search-location" name="what-search-location" placeholder="Введите город" />
                                <svg class="icon icon-dropdown ac-group__icon-dropdown search-all-form__icon-dropdown" viewBox="0 0 12 12">
                                    <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                                </svg>
                            </form>
                        </div>
                        <div class="what-search__category what-search__more-section" data-ws-content-id="2">
                            <div class="what-search__category-wrap">
                                <div class="what-search__category-list what-search__category-list what-search__category-list_1">
                                    <div class="what-search__category-headline"></div>
                                    <div class="what-search__category-content">
                                        <div class="what-search__category-item">
                                            <div class="what-search__category-logo">
                                                <svg class="icon icon-bricks " viewBox="0 0 20 20">
                                                    <use xlink:href="/app/icons/sprite.svg#bricks"></use>
                                                </svg>
                                            </div>
                                            <div class="what-search__category-name">Строительство и&nbsp;ремонт</div>
                                        </div>
                                        <div class="what-search__category-item">
                                            <div class="what-search__category-logo">
                                                <svg class="icon icon-technic " viewBox="0 0 20 20">
                                                    <use xlink:href="/app/icons/sprite.svg#technic"></use>
                                                </svg>
                                            </div>
                                            <div class="what-search__category-name">Транспорт</div>
                                        </div>
                                        <div class="what-search__category-item">
                                            <div class="what-search__category-logo">
                                                <svg class="icon icon-equipment " viewBox="0 0 20 20">
                                                    <use xlink:href="/app/icons/sprite.svg#equipment"></use>
                                                </svg>
                                            </div>
                                            <div class="what-search__category-name">Оборудование</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="what-search__category-list what-search__category-list what-search__category-list_2 hidden">
                                    <div class="what-search__category-headline"></div>
                                    <div class="what-search__category-content">
                                        <div class="what-search__category-item" selected>
                                            <div class="what-search__category-name">Стройматериалы</div>
                                        </div>
                                        <div class="what-search__category-item" selected>
                                            <div class="what-search__category-name">Металл</div>
                                        </div>
                                        <div class="what-search__category-item" selected>
                                            <div class="what-search__category-name">ЖБИ</div>
                                        </div>
                                        <div class="what-search__category-item" selected>
                                            <div class="what-search__category-name">Дерево</div>
                                        </div>
                                        <div class="what-search__category-item" selected>
                                            <div class="what-search__category-name">Отделка</div>
                                        </div>
                                        <div class="what-search__category-item" selected>
                                            <div class="what-search__category-name">Мебель</div>
                                        </div>
                                        <div class="what-search__category-item" selected>
                                            <div class="what-search__category-name">Сад</div>
                                        </div>
                                        <div class="what-search__category-item" selected>
                                            <div class="what-search__category-name">Аодоснабжение</div>
                                        </div>
                                        <div class="what-search__category-item" selected>
                                            <div class="what-search__category-name">Электротовары</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="what-search__category-list what-search__category-list what-search__category-list_3 hidden">
                                    <div class="what-search__category-headline"></div>
                                    <div class="what-search__category-content">
                                        <div class="what-search__category-item" selected>
                                            <div class="what-search__category-name">Инструменты</div>
                                        </div>
                                        <div class="what-search__category-item" selected>
                                            <div class="what-search__category-name">Конструкции и&nbsp;детали</div>
                                        </div>
                                        <div class="what-search__category-item" selected>
                                            <div class="what-search__category-name">Фундаменты стаканного типа и&nbsp; башмаки</div>
                                        </div>
                                        <div class="what-search__category-item" selected>
                                            <div class="what-search__category-name">Плиты фундаментов</div>
                                        </div>
                                        <div class="what-search__category-item" selected>
                                            <div class="what-search__category-name">Детали росверков</div>
                                        </div>
                                        <div class="what-search__category-item" selected>
                                            <div class="what-search__category-name">Сваи</div>
                                        </div>
                                        <div class="what-search__category-item" selected>
                                            <div class="what-search__category-name">Ригели и&nbsp;прогоны</div>
                                        </div>
                                        <div class="what-search__category-item" selected>
                                            <div class="what-search__category-name">Фермы</div>
                                        </div>
                                        <div class="what-search__category-item" selected>
                                            <div class="what-search__category-name">Элементы рам</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="what-search__category-list what-search__category-list what-search__category-list_4 hidden">
                                    <div class="what-search__category-headline"></div>
                                    <div class="what-search__category-content">
                                        <div class="what-search__category-item" selected>
                                            <div class="what-search__category-name">Перемычки</div>
                                        </div>
                                        <div class="what-search__category-item" selected>
                                            <div class="what-search__category-name">Панели стеновые наружные</div>
                                        </div>
                                        <div class="what-search__category-item" selected>
                                            <div class="what-search__category-name">Фундаменты стаканного типа и&nbsp;башмаки</div>
                                        </div>
                                        <div class="what-search__category-item" selected>
                                            <div class="what-search__category-name">Перегородки</div>
                                        </div>
                                        <div class="what-search__category-item" selected>
                                            <div class="what-search__category-name">Длоки стеновые</div>
                                        </div>
                                        <div class="what-search__category-item" selected>
                                            <div class="what-search__category-name">Плиты перекрытий</div>
                                        </div>
                                        <div class="what-search__category-item" selected>
                                            <div class="what-search__category-name">Плиты дорожные</div>
                                        </div>
                                        <div class="what-search__category-item" selected>
                                            <div class="what-search__category-name">Трубы наопрные</div>
                                        </div>
                                        <div class="what-search__category-item" selected>
                                            <div class="what-search__category-name">Трубы безнапорные</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="place-need">
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
            <a class="main-phone header__phone" href="tel:8 (800) 250 26 10">
                <svg class="icon icon-phone " viewBox="0 0 24 24">
                    <use xlink:href="/app/icons/sprite.svg#phone"></use>
                </svg><span class="main-phone__num">8 (800) 250 26 10</span>
            </a>
            </div>
        </header>
        <div class="share-need">
            <div class="share-need__wrap wrap">
                <div class="share-need__inner header-submenu__inner">
                    <label class="checkbox share-need__checkbox">
                        <input class="checkbox__input j-cb-share-need-all" type="checkbox" name="share-need-all" /><span class="checkbox__control"><span class="checkbox__icon"><svg class="icon icon-check " viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#check"></use></svg></span></span>
                    </label>
                    <div class="share-need__btn-cancel btn btn_blue-light btn_m j-cancel-need-recipient">Отменить</div>
                    <div class="share-need__btn-select btn btn_blue btn_m j-select-need-recipient">Выбрать получателя</div>
                </div>
            </div>
        </div>
        <aside class="sidebar">
            <div class="sidebar__header">
                <div class="ham">
                    <svg class="icon icon-hamburger " viewBox="0 0 32 32">
                        <use xlink:href="/app/icons/sprite.svg#hamburger"></use>
                    </svg>
                </div>
                <div class="sidebar__content">
                    <input class="sidebar__input-add-menu" type="checkbox" id="sidebarAddMenuCheckbox" />
                    <label class="sidebar__toggle-add-menu" for="sidebarAddMenuCheckbox">
                        <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                            <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                        </svg>
                    </label>
                    <div class="sidebar__content-data">
                        <div class="sidebar__username">ООО БашАльянсСтрой</div>
                        <ul class="sidebar__add-menu">
                            <li class="sidebar__add-menu-item"><a class="sidebar__add-menu-link" href="#"><span class="sidebar__add-menu-icon"><svg class="icon icon-turn " viewBox="0 0 17 17"><use xlink:href="/app/icons/sprite.svg#turn"></use></svg></span><span class="sidebar__add-menu-name">Смена аккаунта</span></a>
                            </li>
                            <li class="sidebar__add-menu-item"><a class="sidebar__add-menu-link" href="#"><span class="sidebar__add-menu-icon"><svg class="icon icon-pencil " viewBox="0 0 15 15"><use xlink:href="/app/icons/sprite.svg#pencil"></use></svg></span><span class="sidebar__add-menu-name">Профиль</span></a>
                            </li>
                            <li class="sidebar__add-menu-item"><a class="sidebar__add-menu-link" href="#"><span class="sidebar__add-menu-icon"><svg class="icon icon-power " viewBox="0 0 15 15"><use xlink:href="/app/icons/sprite.svg#power"></use></svg></span><span class="sidebar__add-menu-name">Выйти</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <nav class="nav-sidebar">
                <ul class="nav-sidebar__list">
                    <li class="nav-sidebar__item is-active"><a class="nav-sidebar__link" href="#"><span class="nav-sidebar__icon"><svg class="icon icon-requests " viewBox="0 0 36 36"><use xlink:href="/app/icons/sprite.svg#requests"></use></svg><div class="badge-notify"><span>2</span></div></span><div class="nav-sidebar__name-wrapper"><div class="nav-sidebar__name"> <span class="nav-sidebar__name-full">Мои&nbsp;</span><span>Заявки</span></div></div></a>
                    </li>
                    <li class="nav-sidebar__item"><a class="nav-sidebar__link" href="#"><span class="nav-sidebar__icon"><svg class="icon icon-announcement " viewBox="0 0 36 36"><use xlink:href="/app/icons/sprite.svg#announcement"></use></svg><div class="badge-notify"><span>2</span></div></span><div class="nav-sidebar__name-wrapper"><div class="nav-sidebar__name"> <span class="nav-sidebar__name-full">Мои&nbsp;</span><span>Объявления</span></div></div></a>
                    </li>
                    <li class="nav-sidebar__item"><a class="nav-sidebar__link" href="#"><span class="nav-sidebar__icon"><svg class="icon icon-subscriptions " viewBox="0 0 36 36"><use xlink:href="/app/icons/sprite.svg#subscriptions"></use></svg></span><div class="nav-sidebar__name-wrapper"><div class="nav-sidebar__name"> <span>Подписки</span></div></div></a>
                    </li>
                    <li class="nav-sidebar__item"><a class="nav-sidebar__link" href="#"><span class="nav-sidebar__icon"><svg class="icon icon-skills " viewBox="0 0 36 36"><use xlink:href="/app/icons/sprite.svg#skills"></use></svg></span><div class="nav-sidebar__name-wrapper"><div class="nav-sidebar__name"> <span>Навыки</span></div></div></a>
                    </li>
                    <li class="nav-sidebar__item"><a class="nav-sidebar__link" href="#"><span class="nav-sidebar__icon"><svg class="icon icon-help " viewBox="0 0 36 36"><use xlink:href="/app/icons/sprite.svg#help"></use></svg></span><div class="nav-sidebar__name-wrapper"><div class="nav-sidebar__name"> <span>Помощь</span></div></div></a>
                    </li>
                    <li class="nav-sidebar__item"><a class="nav-sidebar__link" href="#"><span class="nav-sidebar__icon"><svg class="icon icon-sheetWithCheckMark " viewBox="0 0 36 36"><use xlink:href="/app/icons/sprite.svg#sheetWithCheckMark"></use></svg></span><div class="nav-sidebar__name-wrapper"><div class="nav-sidebar__name"> <span>Номенклатура</span></div></div></a>
                    </li>
                </ul>
            </nav>
        </aside>
        <div class="submenu header-submenu">
            <div class="submenu__wrap wrap">
                <div class="submenu__inner header-submenu__inner">
                    <div class="submenu-nav">
                        <div class="submenu-nav__inner">
                            <ul class="submenu-nav__list">
                                <li class="submenu-nav__item is-active"><a class="submenu-nav__link" href="#"><span class="submenu-nav__name">Мои заявки&nbsp;</span><span class="submenu-nav__quantity">1</span><span class="submenu-nav__dropdown"><svg class="icon icon-dropdown " viewBox="0 0 12 12"><use xlink:href="/app/icons/sprite.svg#dropdown"></use></svg></span></a>
                                </li>
                                <li class="submenu-nav__item"><a class="submenu-nav__link" href="#"><span class="submenu-nav__name">Не опубликованные&nbsp;</span><span class="submenu-nav__quantity">1</span><div class="badge-notify"><span>1</span></div></a>
                                </li>
                                <li class="submenu-nav__item"><a class="submenu-nav__link" href="#"><span class="submenu-nav__name">Опубликованные&nbsp;</span><span class="submenu-nav__quantity">1</span></a>
                                </li>
                                <li class="submenu-nav__item"><a class="submenu-nav__link" href="#"><span class="submenu-nav__name">Активные&nbsp;</span><span class="submenu-nav__quantity">1</span><div class="badge-notify"><span>1</span></div></a>
                                </li>
                                <li class="submenu-nav__item"><a class="submenu-nav__link" href="#"><span class="submenu-nav__name">Куплено&nbsp;</span><span class="submenu-nav__quantity">1</span></a>
                                </li>
                                <li class="submenu-nav__item"><a class="submenu-nav__link" href="#"><span class="submenu-nav__name">Исполнено&nbsp;</span><span class="submenu-nav__quantity">1</span></a>
                                </li>
                                <li class="submenu-nav__item"><a class="submenu-nav__link" href="#"><span class="submenu-nav__name">Возврат&nbsp;</span><span class="submenu-nav__quantity">1</span></a>
                                </li>
                                <li class="submenu-nav__item"><a class="submenu-nav__link" href="#"><span class="submenu-nav__name">Возвращено&nbsp;</span><span class="submenu-nav__quantity">1</span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="submenu__select-requests j-open-share-need-menu">
                        <svg class="icon icon-newspaper " viewBox="0 0 24 25">
                            <use xlink:href="/app/icons/sprite.svg#newspaper"></use>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="section">
            <div class="wrap">
                <div class="cards">
                    <div class="cards__item">
                        <div class="cards__content">
                            <div class="cards-gallery">
                                <div class="cards-gallery__inner"><a class="cards-gallery__item" href="/app/img/car.jpg" data-fancybox="card-imgs"><span class="cards-gallery__img-wrapper"><img class="cards-gallery__img" src="/img/car.jpg" alt="" role="presentation"/></span><span class="cards-gallery__line"></span></a>
                                    <a
                                    class="cards-gallery__item" href="/app/img/car2.jpg" data-fancybox="card-imgs"><span class="cards-gallery__img-wrapper"><img class="cards-gallery__img" src="/img/car2.jpg" alt="" role="presentation"/></span><span class="cards-gallery__line"></span>
                                        </a><a class="cards-gallery__item" href="/app/img/car3.jpg" data-fancybox="card-imgs"><span class="cards-gallery__img-wrapper"><img class="cards-gallery__img" src="/img/car3.jpg" alt="" role="presentation"/></span><span class="cards-gallery__line"></span></a>
                                        <a
                                        class="cards-gallery__item" href="/app/img/car.jpg" data-fancybox="card-imgs">
                                            <div class="cards-gallery__img-wrapper">
                                                <img class="cards-gallery__img" src="/img/car.jpg" alt="" role="presentation" />
                                                <div class="cards-gallery__more">
                                                    <div class="cards-gallery__more-icon">
                                                        <svg class="icon icon-camera cards-gallery__more-icon" viewBox="0 0 54 46">
                                                            <use xlink:href="/app/icons/sprite.svg#camera"></use>
                                                        </svg>
                                                    </div>
                                                    <div class="cards-gallery__more-text">Еще 7 фото</div>
                                                </div>
                                            </div>
                                            <div class="cards-gallery__line"></div>
                                            </a>
                                </div>
                            </div>
                            <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><label class="checkbox cards-top__checkbox"><input class="checkbox__input j-cb-share-need" type="checkbox" name="share-need"/><span class="checkbox__control"><span class="checkbox__icon"><svg class="icon icon-check " viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#check"></use></svg></span></span>
                                </label><a class="cards-top__item-name-text" href="#http://link1/">Прокладка впускного коллектора (1374340) SCANIA D/DS2</a>
                                </span>
                                </span>
                                <div class="cards-top__quantity">
                                    <div class="cards-top__quantity-left">20 шт</div>
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
                                <div class="cards-bottom__urgency cards-bottom__urgency cards-bottom__urgency_not-urgently">Не срочно</div>
                                <div class="cards-bottom__city">Уфа</div>
                                <div class="cards-bottom__right">
                                    <div class="cards-bottom__badge">Лично для&nbsp;ВП</div>
                                    <div class="cards-bottom__user"><span class="cards-bottom__user-name user-online">Тимур</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#noAvatar"></use></svg></span>
                                    </div>
                                    <a class="cards-bottom__share" href="#">
                                        <svg class="icon icon-clip cards-bottom__share-icon" viewBox="0 0 16 16">
                                            <use xlink:href="/app/icons/sprite.svg#clip"></use>
                                        </svg>
                                    </a>
                                    <div class="cards-bottom__category">
                                        <div class="cards-bottom__category-text">Запчасти</div>
                                    </div>
                                </div>
                            </div>
                            <div class="cards-info">
                                <div class="cards-info__nums">
                                    <div class="cards-info__nums-inner">
                                        <div class="cards-info__nums-days"> <span class="cards-info__nums-days-text"> <span class="j-cards-nums-days">19</span>&nbsp;дней</span>
                                            <div class="cards-info__nums-days-scale"><span class="cards-info__nums-days-scale-thumb"></span>
                                            </div>
                                        </div>
                                        <div class="cards-info__nums-views">
                                            <div class="cards-info__nums-views-img">
                                                <svg class="icon icon-eye cards-info__nums-views-icon" viewBox="0 0 16 16">
                                                    <use xlink:href="/app/icons/sprite.svg#eye"></use>
                                                </svg>
                                            </div><span class="cards-info__nums-views-text">21</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="cards-info__action">
                                    <div class="cards-info__action-btn btn btn_blue btn btn_dropdown" data-btn=""><span>Активировать</span>
                                        <svg class="icon icon-dropdown cards-info__action-btn-icon" viewBox="0 0 12 12">
                                            <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="cards-info__status">
                                    <div class="cards-info__status-name"><span class="cards-info__status-name-text">Не опубликовано</span>
                                        <div class="badge-notify"><span>1</span>
                                        </div>
                                    </div>
                                    <div class="cards-info__status-published"><span class="cards-info__status-published-text">20 минут назад</span>
                                    </div>
                                </div>
                                <div class="cards-info__manage">
                                    <div class="cards-info__manage-inner">
                                        <div class="cards-info__manage-item cards-info__manage-edit">
                                            <svg class="icon icon-pencil cards-info__manage-item-icon" viewBox="0 0 15 15">
                                                <use xlink:href="/app/icons/sprite.svg#pencil"></use>
                                            </svg>
                                        </div>
                                        <div class="cards-info__manage-item cards-info__manage-open j-open-offers">
                                            <svg class="icon icon-pencilWrite cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                <use xlink:href="/app/icons/sprite.svg#pencilWrite"></use>
                                            </svg>
                                        </div>
                                        <div class="cards-info__manage-item cards-info__manage-message">
                                            <svg class="icon icon-mail cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                <use xlink:href="/app/icons/sprite.svg#mail"></use>
                                            </svg>
                                        </div>
                                        <div class="cards-info__manage-item cards-info__manage-refresh">
                                            <svg class="icon icon-rotateArrow cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                <use xlink:href="/app/icons/sprite.svg#rotateArrow"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="cards-info__menu">
                                    <svg class="icon icon-threeDot cards-info__menu-icon" viewBox="0 0 32 32">
                                        <use xlink:href="/app/icons/sprite.svg#threeDot"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cards__item">
                        <div class="cards__content">
                            <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><label class="checkbox cards-top__checkbox"><input class="checkbox__input j-cb-share-need" type="checkbox" name="share-need"/><span class="checkbox__control"><span class="checkbox__icon"><svg class="icon icon-check " viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#check"></use></svg></span></span>
                                </label><a class="cards-top__item-name-text" href="#http://link2/">Прокладка впускного коллектора (1374340) SCANIA D/DS2</a>
                                </span>
                                </span>
                                <div class="cards-top__quantity">
                                    <div class="cards-top__quantity-left">20 шт<span class="cards-top__quantity-purchased">&nbsp;(1)</span>
                                    </div>
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
                                    <div class="cards-bottom__user"><span class="cards-bottom__user-name user-online">Тимур</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#noAvatar"></use></svg></span>
                                    </div>
                                    <div class="cards-bottom__category">
                                        <div class="cards-bottom__category-text">Запчасти</div>
                                    </div>
                                </div>
                            </div>
                            <div class="cards-info">
                                <div class="cards-info__nums">
                                    <div class="cards-info__nums-inner">
                                        <div class="cards-info__nums-days"> <span class="cards-info__nums-days-text"> <span class="j-cards-nums-days">25</span>&nbsp;дней</span>
                                            <div class="cards-info__nums-days-scale"><span class="cards-info__nums-days-scale-thumb"></span>
                                            </div>
                                        </div>
                                        <div class="cards-info__nums-views">
                                            <div class="cards-info__nums-views-img">
                                                <svg class="icon icon-eye cards-info__nums-views-icon" viewBox="0 0 16 16">
                                                    <use xlink:href="/app/icons/sprite.svg#eye"></use>
                                                </svg>
                                            </div><span class="cards-info__nums-views-text">27</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="cards-info__action">
                                    <div class="cards-info__action-btn btn btn_blue btn btn_dropdown" data-btn=""><span>в&nbsp;Неопубликованные</span>
                                        <svg class="icon icon-dropdown cards-info__action-btn-icon" viewBox="0 0 12 12">
                                            <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                                        </svg>
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
                                        <div class="cards-info__manage-item cards-info__manage-edit">
                                            <svg class="icon icon-pencil cards-info__manage-item-icon" viewBox="0 0 15 15">
                                                <use xlink:href="/app/icons/sprite.svg#pencil"></use>
                                            </svg>
                                        </div>
                                        <div class="cards-info__manage-item cards-info__manage-open j-open-offers">
                                            <svg class="icon icon-pencilWrite cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                <use xlink:href="/app/icons/sprite.svg#pencilWrite"></use>
                                            </svg>
                                        </div>
                                        <div class="cards-info__manage-item cards-info__manage-message">
                                            <svg class="icon icon-mail cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                <use xlink:href="/app/icons/sprite.svg#mail"></use>
                                            </svg>
                                        </div>
                                        <div class="cards-info__manage-item cards-info__manage-refresh">
                                            <svg class="icon icon-rotateArrow cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                <use xlink:href="/app/icons/sprite.svg#rotateArrow"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="cards-info__menu">
                                    <svg class="icon icon-threeDot cards-info__menu-icon" viewBox="0 0 32 32">
                                        <use xlink:href="/app/icons/sprite.svg#threeDot"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cards__item offers-on">
                        <div class="cards__content">
                            <div class="cards-gallery">
                                <div class="cards-gallery__inner"><a class="cards-gallery__item" href="/app/img/car.jpg"><span class="cards-gallery__img-wrapper"><img class="cards-gallery__img" src="/img/car.jpg" alt="" role="presentation"/></span><span class="cards-gallery__line"></span></a>
                                </div>
                            </div>
                            <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><label class="checkbox cards-top__checkbox"><input class="checkbox__input j-cb-share-need" type="checkbox" name="share-need"/><span class="checkbox__control"><span class="checkbox__icon"><svg class="icon icon-check " viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#check"></use></svg></span></span>
                                </label><a class="cards-top__item-name-text" href="#http://link3/">Прокладка впускного коллектора (1374340) SCANIA D/DS2</a>
                                </span>
                                </span>
                                <div class="cards-top__quantity">
                                    <div class="cards-top__quantity-left">20 шт</div>
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
                                <div class="cards-bottom__urgency cards-bottom__urgency cards-bottom__urgency_two-week">2 недели</div>
                                <div class="cards-bottom__city">Уфа</div>
                                <div class="cards-bottom__right">
                                    <div class="cards-bottom__badge">Лично для&nbsp;ВП</div>
                                    <div class="cards-bottom__user"><span class="cards-bottom__user-name">Фаниль</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#noAvatar"></use></svg></span>
                                    </div>
                                    <div class="cards-bottom__category">
                                        <div class="cards-bottom__category-text">Запчасти</div>
                                    </div>
                                </div>
                            </div>
                            <div class="cards-info">
                                <div class="cards-info__nums">
                                    <div class="cards-info__nums-inner">
                                        <div class="cards-info__nums-days"> <span class="cards-info__nums-days-text"> <span class="j-cards-nums-days">1</span>&nbsp;дней</span>
                                            <div class="cards-info__nums-days-scale"><span class="cards-info__nums-days-scale-thumb"></span>
                                            </div>
                                        </div>
                                        <div class="cards-info__nums-views">
                                            <div class="cards-info__nums-views-img">
                                                <svg class="icon icon-eye cards-info__nums-views-icon" viewBox="0 0 16 16">
                                                    <use xlink:href="/app/icons/sprite.svg#eye"></use>
                                                </svg>
                                            </div><span class="cards-info__nums-views-text">27</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="cards-info__action">
                                    <div class="cards-info__action-btn btn btn_blue j-modal-offers-open" data-btn=""><span>от&nbsp;160,40 (72)</span>
                                    </div>
                                </div>
                                <div class="cards-info__status">
                                    <div class="cards-info__status-name"><span class="cards-info__status-name-text">Активна</span>
                                    </div>
                                    <div class="cards-info__status-published"><span class="cards-info__status-published-text">20 минут назад</span>
                                    </div>
                                </div>
                                <div class="cards-info__manage">
                                    <div class="cards-info__manage-inner">
                                        <div class="cards-info__manage-item cards-info__manage-edit">
                                            <svg class="icon icon-pencil cards-info__manage-item-icon" viewBox="0 0 15 15">
                                                <use xlink:href="/app/icons/sprite.svg#pencil"></use>
                                            </svg>
                                        </div>
                                        <div class="cards-info__manage-item cards-info__manage-open j-open-offers is-active">
                                            <svg class="icon icon-pencilWrite cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                <use xlink:href="/app/icons/sprite.svg#pencilWrite"></use>
                                            </svg>
                                        </div>
                                        <div class="cards-info__manage-item cards-info__manage-message">
                                            <svg class="icon icon-mail cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                <use xlink:href="/app/icons/sprite.svg#mail"></use>
                                            </svg>
                                        </div>
                                        <div class="cards-info__manage-item cards-info__manage-refresh">
                                            <svg class="icon icon-rotateArrow cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                <use xlink:href="/app/icons/sprite.svg#rotateArrow"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="cards-info__menu">
                                    <svg class="icon icon-threeDot cards-info__menu-icon" viewBox="0 0 32 32">
                                        <use xlink:href="/app/icons/sprite.svg#threeDot"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <form class="cards-write-offers j-show-more-dd">
                            <div class="form-group">
                                <input class="input require" type="text" placeholder="Поставщик">
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" placeholder="Город">
                            </div>
                            <div class="form-group">
                                <input class="input require" type="text" placeholder="Наличие">
                            </div>
                            <div class="form-group">
                                <div class="input-select-box">
                                    <input type="text" placeholder="Цена">
                                    <div class="select-box">
                                        <select>
                                            <option>₽</option>
                                            <option>$</option>
                                        </select>
                                        <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                                            <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="select-box">
                                    <select>
                                        <option>с&nbsp;НДС</option>
                                        <option>без&nbsp;НДС</option>
                                    </select>
                                    <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                                        <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-select-box">
                                    <input type="text" placeholder="Название поля">
                                    <div class="select-box">
                                        <select>
                                            <option>шт</option>
                                            <option>л</option>
                                            <option>гр</option>
                                        </select>
                                        <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                                            <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-select-box">
                                    <input type="text" placeholder="Название поля">
                                    <div class="select-box">
                                        <select>
                                            <option>л</option>
                                            <option>шт</option>
                                            <option>гр</option>
                                        </select>
                                        <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                                            <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="select-box">
                                    <select>
                                        <option>Тип</option>
                                        <option>Бренд</option>
                                        <option>Вариант 1</option>
                                        <option>Вариант 2</option>
                                        <option>Вариант 3</option>
                                        <option>Вариант 4</option>
                                        <option>Вариант 5</option>
                                    </select>
                                    <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                                        <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="select-box">
                                    <select>
                                        <option>Назначение</option>
                                        <option>Бренд</option>
                                        <option>Вариант 1</option>
                                        <option>Вариант 2</option>
                                        <option>Вариант 3</option>
                                        <option>Вариант 4</option>
                                        <option>Вариант 5</option>
                                    </select>
                                    <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                                        <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="select-box">
                                    <select>
                                        <option>Тип применения</option>
                                        <option>Бренд</option>
                                        <option>Вариант 1</option>
                                        <option>Вариант 2</option>
                                        <option>Вариант 3</option>
                                        <option>Вариант 4</option>
                                        <option>Вариант 5</option>
                                    </select>
                                    <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                                        <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="select-box">
                                    <select>
                                        <option>Поверхность</option>
                                        <option>Бренд</option>
                                        <option>Вариант 1</option>
                                        <option>Вариант 2</option>
                                        <option>Вариант 3</option>
                                        <option>Вариант 4</option>
                                        <option>Вариант 5</option>
                                    </select>
                                    <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                                        <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" placeholder="Комментарий">
                            </div>
                            <div class="form-group cards-write-offers__more">
                                <input class="input" type="text" placeholder="Поставщик">
                            </div>
                            <div class="form-group cards-write-offers__more">
                                <input class="input" type="text" placeholder="Город">
                            </div>
                            <div class="form-group cards-write-offers__more">
                                <input class="input" type="text" placeholder="Наличие">
                            </div>
                            <div class="form-group cards-write-offers__more">
                                <div class="input-select-box">
                                    <input type="text" placeholder="Цена">
                                    <div class="select-box">
                                        <select>
                                            <option>₽</option>
                                            <option>$</option>
                                        </select>
                                        <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                                            <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group cards-write-offers__more">
                                <div class="select-box">
                                    <select>
                                        <option>с&nbsp;НДС</option>
                                        <option>без&nbsp;НДС</option>
                                    </select>
                                    <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                                        <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="form-group cards-write-offers__more">
                                <div class="input-select-box">
                                    <input type="text" placeholder="Название поля">
                                    <div class="select-box">
                                        <select>
                                            <option>шт</option>
                                            <option>л</option>
                                            <option>гр</option>
                                        </select>
                                        <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                                            <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="cards-write-offers__manage">
                                <div class="cards-write-offers__photos">
                                    <svg class="icon icon-cameraSharp cards-write-offers__photos-icon" viewBox="0 0 17 17">
                                        <use xlink:href="/app/icons/sprite.svg#cameraSharp"></use>
                                    </svg>
                                </div><span class="cards-write-offers__show-more j-show-more-dd-btn"> <span class="cards-write-offers__show-more-text">Еще</span>
                                <svg class="icon icon-dropdown show-more-dropdown__icon" viewBox="0 0 12 12">
                                    <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                                </svg>
                                </span><span class="cards-write-offers__list"><svg class="icon icon-list cards-write-offers__list-icon" viewBox="0 0 14 10"><use xlink:href="/app/icons/sprite.svg#list"></use></svg></span>
                                <div class="cards-write-offers__write btn btn btn_blue">Записать</div>
                            </div>
                        </form>
                        <div class="cards-offers cards__content">
                            <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><a class="cards-top__item-name-text" href="#">Прокладка впускного коллектора (1374340) SCANIA D/DS2</a></span></span>
                                <div class="cards-top__quantity">
                                    <div class="cards-top__quantity-left">20 шт<span class="cards-top__quantity-purchased">&nbsp;(1)</span>
                                    </div>
                                    <div class="cards-top__min-lot"> <span class="cards-top__min-lot-left">2</span><span class="cards-top__min-lot-separator">/</span><span class="cards-top__min-lot-multiplicity">2</span>
                                    </div>
                                </div>
                            </div>
                            <div class="cards-cost">
                                <div class="cards-cost__main"><span class="cards-cost__price">до&nbsp;2 375,6<span class="cards-cost__symbol">&nbsp;₽</span></span><span class="cards-cost__payment">НДС</span>
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
                                <div class="cards-bottom__city">Уфа</div>
                                <div class="cards-bottom__days">9 дней</div>
                                <div class="cards-bottom__right">
                                    <div class="cards-bottom__user"><span class="cards-bottom__user-name user-online">Тимур</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#noAvatar"></use></svg></span>
                                    </div>
                                    <div class="cards-bottom__category">
                                        <div class="cards-bottom__category-text">Запчасти</div>
                                    </div>
                                </div>
                            </div>
                            <div class="cards-info">
                                <div class="cards-info__status">
                                    <div class="cards-info__status-name"><span class="cards-info__status-name-text">Предложение</span>
                                    </div>
                                    <div class="cards-info__status-published"><span class="cards-info__status-published-text">20 минут назад</span>
                                    </div>
                                </div>
                                <div class="cards-info__manage">
                                    <div class="cards-info__manage-inner">
                                        <div class="cards-info__manage-item cards-info__manage-edit">
                                            <svg class="icon icon-pencil cards-info__manage-item-icon" viewBox="0 0 15 15">
                                                <use xlink:href="/app/icons/sprite.svg#pencil"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="cards-info__menu">
                                    <svg class="icon icon-threeDot cards-info__menu-icon" viewBox="0 0 32 32">
                                        <use xlink:href="/app/icons/sprite.svg#threeDot"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cards__item">
                        <div class="cards__content">
                            <div class="cards-gallery">
                                <div class="cards-gallery__inner"><a class="cards-gallery__item" href="/app/img/car.jpg"><span class="cards-gallery__img-wrapper"><img class="cards-gallery__img" src="/img/car.jpg" alt="" role="presentation"/></span><span class="cards-gallery__line"></span></a>
                                </div>
                            </div>
                            <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><a class="cards-top__item-name-text" href="#">Прокладка впускного коллектора (1374340) SCANIA D/DS2</a></span></span>
                                <div class="cards-top__quantity">
                                    <div class="cards-top__quantity-left">20 шт</div>
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
                                <div class="cards-bottom__urgency cards-bottom__urgency cards-bottom__urgency_two-week">2 недели</div>
                                <div class="cards-bottom__city">Уфа</div>
                                <div class="cards-bottom__right">
                                    <div class="cards-bottom__badge">Лично для&nbsp;ВП</div>
                                    <div class="cards-bottom__user"><span class="cards-bottom__user-name">Фаниль</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#noAvatar"></use></svg></span>
                                    </div>
                                    <div class="cards-bottom__category">
                                        <div class="cards-bottom__category-text">Запчасти</div>
                                    </div>
                                </div>
                            </div>
                            <div class="cards-info">
                                <div class="cards-info__nums">
                                    <div class="cards-info__nums-inner">
                                        <div class="cards-info__nums-days"> <span class="cards-info__nums-days-text"> <span class="j-cards-nums-days">1</span>&nbsp;дней</span>
                                            <div class="cards-info__nums-days-scale"><span class="cards-info__nums-days-scale-thumb"></span>
                                            </div>
                                        </div>
                                        <div class="cards-info__nums-views">
                                            <div class="cards-info__nums-views-img">
                                                <svg class="icon icon-eye cards-info__nums-views-icon" viewBox="0 0 16 16">
                                                    <use xlink:href="/app/icons/sprite.svg#eye"></use>
                                                </svg>
                                            </div><span class="cards-info__nums-views-text">27</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="cards-info__action">
                                    <div class="cards-info__action-btn btn btn_blue j-modal-offers-open" data-btn=""><span>от&nbsp;160,40 (72)</span>
                                    </div>
                                    <div class="badge-notify"><span>1</span>
                                    </div>
                                </div>
                                <div class="cards-info__status">
                                    <div class="cards-info__status-name"><span class="cards-info__status-name-text">Активна</span>
                                    </div>
                                    <div class="cards-info__status-published"><span class="cards-info__status-published-text">20 минут назад</span>
                                    </div>
                                </div>
                                <div class="cards-info__manage">
                                    <div class="cards-info__manage-inner">
                                        <div class="cards-info__manage-item cards-info__manage-edit">
                                            <svg class="icon icon-pencil cards-info__manage-item-icon" viewBox="0 0 15 15">
                                                <use xlink:href="/app/icons/sprite.svg#pencil"></use>
                                            </svg>
                                        </div>
                                        <div class="cards-info__manage-item cards-info__manage-open j-open-offers">
                                            <svg class="icon icon-pencilWrite cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                <use xlink:href="/app/icons/sprite.svg#pencilWrite"></use>
                                            </svg>
                                        </div>
                                        <div class="cards-info__manage-item cards-info__manage-message">
                                            <svg class="icon icon-mail cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                <use xlink:href="/app/icons/sprite.svg#mail"></use>
                                            </svg>
                                        </div>
                                        <div class="cards-info__manage-item cards-info__manage-refresh">
                                            <svg class="icon icon-rotateArrow cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                <use xlink:href="/app/icons/sprite.svg#rotateArrow"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="cards-info__menu">
                                    <svg class="icon icon-threeDot cards-info__menu-icon" viewBox="0 0 32 32">
                                        <use xlink:href="/app/icons/sprite.svg#threeDot"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cards__item">
                        <div class="cards__content">
                            <div class="cards-gallery">
                                <div class="cards-gallery__inner"><a class="cards-gallery__item" href="/app/img/car.jpg"><span class="cards-gallery__img-wrapper"><img class="cards-gallery__img" src="/img/car.jpg" alt="" role="presentation"/></span><span class="cards-gallery__line"></span></a>
                                </div>
                            </div>
                            <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><a class="cards-top__item-name-text" href="#">Прокладка впускного коллектора (1374340) SCANIA D/DS2</a></span></span>
                                <div class="cards-top__quantity">
                                    <div class="cards-top__quantity-left">20 шт</div>
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
                                <div class="cards-bottom__city">Уфа</div>
                                <div class="cards-bottom__days">9 дней</div>
                                <div class="cards-bottom__right">
                                    <div class="cards-bottom__badge">Лично для&nbsp;ВП</div>
                                    <div class="cards-bottom__user"><span class="cards-bottom__user-name">Фаниль</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#noAvatar"></use></svg></span>
                                    </div>
                                    <div class="cards-bottom__category">
                                        <div class="cards-bottom__category-text">Запчасти</div>
                                    </div>
                                </div>
                            </div>
                            <div class="cards-info">
                                <div class="cards-info__action">
                                    <div class="cards-info__action-btn btn btn_blue" data-btn=""><span>Отменить</span>
                                    </div>
                                </div>
                                <div class="cards-info__status">
                                    <div class="cards-info__status-name"><span class="cards-info__status-name-text">Куплено</span>
                                    </div>
                                    <div class="cards-info__status-published"><span class="cards-info__status-published-text">20 минут назад</span>
                                    </div>
                                </div>
                                <div class="cards-info__manage">
                                    <div class="cards-info__manage-inner">
                                        <div class="cards-info__manage-item cards-info__manage-edit">
                                            <svg class="icon icon-pencil cards-info__manage-item-icon" viewBox="0 0 15 15">
                                                <use xlink:href="/app/icons/sprite.svg#pencil"></use>
                                            </svg>
                                        </div>
                                        <div class="cards-info__manage-item cards-info__manage-open j-open-offers">
                                            <svg class="icon icon-pencilWrite cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                <use xlink:href="/app/icons/sprite.svg#pencilWrite"></use>
                                            </svg>
                                        </div>
                                        <div class="cards-info__manage-item cards-info__manage-message">
                                            <svg class="icon icon-mail cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                <use xlink:href="/app/icons/sprite.svg#mail"></use>
                                            </svg>
                                        </div>
                                        <div class="cards-info__manage-item cards-info__manage-refresh">
                                            <svg class="icon icon-rotateArrow cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                <use xlink:href="/app/icons/sprite.svg#rotateArrow"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="cards-info__menu">
                                    <svg class="icon icon-threeDot cards-info__menu-icon" viewBox="0 0 32 32">
                                        <use xlink:href="/app/icons/sprite.svg#threeDot"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cards__item cards__item_view-1">
                        <div class="cards__content">
                            <div class="cards__content-list">
                                <div class="cards__content-item">
                                    <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><a class="cards-top__item-name-text" href="#">Карданный вал L=715mm 1796593-01</a></span></span>
                                        <div class="cards-top__quantity">
                                            <div class="cards-top__quantity-left">5 г</div>
                                        </div>
                                    </div>
                                    <div class="cards-cost">
                                        <div class="cards-cost__main"><span class="cards-cost__price">4 490 000<span class="cards-cost__symbol">&nbsp;₽</span></span><span class="cards-cost__payment"> <svg class="icon icon-money " viewBox="0 0 20 20"><use xlink:href="/app/icons/sprite.svg#money"></use></svg></span>
                                        </div>
                                    </div>
                                    <div class="cards-bottom">
                                        <div class="cards-bottom__comment"><span class="cards-bottom__comment-text">оплата до&nbsp;20 ноября</span>
                                        </div>
                                        <div class="cards-bottom__city">Уфа</div>
                                        <div class="cards-bottom__right">
                                            <div class="cards-bottom__user"><span class="cards-bottom__user-name">КамДорСнаб</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#noAvatar"></use></svg></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="cards__content-item">
                                    <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><a class="cards-top__item-name-text" href="#">Карданный вал L=715mm 1796593-01</a></span></span>
                                        <div class="cards-top__quantity">
                                            <div class="cards-top__quantity-left">30 г</div>
                                        </div>
                                    </div>
                                    <div class="cards-bottom">
                                        <div class="cards-bottom__comment"><span class="cards-bottom__comment-text">Цену только указывайте с&nbsp;доставкой</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cards-bottom">
                                <div class="cards-bottom__urgency cards-bottom__urgency cards-bottom__urgency_week">Неделя</div>
                                <div class="cards-bottom__city">Уфа</div>
                                <div class="cards-bottom__right">
                                    <div class="cards-bottom__badge">Лично для&nbsp;ВП</div>
                                    <div class="cards-bottom__user"><span class="cards-bottom__user-name user-online">Виталий</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#noAvatar"></use></svg></span>
                                    </div>
                                    <div class="cards-bottom__category">
                                        <div class="cards-bottom__category-text">Запчасти</div>
                                    </div>
                                </div>
                            </div>
                            <div class="cards-info">
                                <div class="cards-info__action">
                                    <div class="cards-info__action-btn btn btn_blue btn btn_dropdown 1" data-btn=""><span>от&nbsp;79 000 (103)</span>
                                        <svg class="icon icon-dropdown cards-info__action-btn-icon" viewBox="0 0 12 12">
                                            <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="cards-info__status">
                                    <div class="cards-info__status-name"><span class="cards-info__status-name-text">Куплено</span>
                                    </div>
                                    <div class="cards-info__status-published"><span class="cards-info__status-published-text">20 минут назад</span>
                                    </div>
                                </div>
                                <div class="cards-info__manage">
                                    <div class="cards-info__manage-inner">
                                        <div class="cards-info__manage-item cards-info__manage-message">
                                            <svg class="icon icon-mail cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                <use xlink:href="/app/icons/sprite.svg#mail"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="cards-info__menu">
                                    <svg class="icon icon-threeDot cards-info__menu-icon" viewBox="0 0 32 32">
                                        <use xlink:href="/app/icons/sprite.svg#threeDot"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cards__item cards__item_view-1">
                        <div class="cards__content">
                            <div class="cards__content-list">
                                <div class="cards__content-item">
                                    <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><a class="cards-top__item-name-text" href="#">Карданный вал L=715mm 1796593-01</a></span></span>
                                        <div class="cards-top__quantity">
                                            <div class="cards-top__quantity-left">20 шт</div>
                                        </div>
                                    </div>
                                    <div class="cards-cost">
                                        <div class="cards-cost__main"><span class="cards-cost__price cards-cost__price cards-cost__price_red">2 375,6<span class="cards-cost__symbol">&nbsp;₽</span></span><span class="cards-cost__payment">Без НДС</span>
                                        </div>
                                    </div>
                                    <div class="cards-properties">
                                        <div class="cards-properties__properties-item">2360-2910210</div>
                                        <div class="cards-properties__properties-item">Scania</div>
                                        <div class="cards-properties__properties-item">Сталь 20</div>
                                        <div class="cards-properties__properties-item">5 брендов</div>
                                    </div>
                                    <div class="cards-bottom">
                                        <div class="cards-bottom__city">Уфа</div>
                                        <div class="cards-bottom__right">
                                            <div class="cards-bottom__user"><span class="cards-bottom__user-name">Тимур</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#noAvatar"></use></svg></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="cards__content-item">
                                    <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><a class="cards-top__item-name-text" href="#">Карданный вал L=715mm 1796593-01</a></span></span>
                                        <div class="cards-top__quantity">
                                            <div class="cards-top__quantity-left">20 шт</div>
                                            <div class="cards-top__photos">
                                                <svg class="icon icon-cameraSharp cards-top__photos-icon" viewBox="0 0 17 17">
                                                    <use xlink:href="/app/icons/sprite.svg#cameraSharp"></use>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cards-cost">
                                        <div class="cards-cost__main"><span class="cards-cost__price">2 375,6<span class="cards-cost__symbol">&nbsp;₽</span></span><span class="cards-cost__payment">Без НДС</span>
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
                                        <div class="cards-bottom__city">Уфа</div>
                                        <div class="cards-bottom__days">9 дней</div>
                                        <div class="cards-bottom__right">
                                            <div class="cards-bottom__user"><span class="cards-bottom__user-name user-online">Тимур</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#noAvatar"></use></svg></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="cards__content-item">
                                    <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><a class="cards-top__item-name-text" href="#">Карданный вал L=715mm 1796593-01</a></span></span>
                                        <div class="cards-top__quantity">
                                            <div class="cards-top__quantity-left">20 шт</div>
                                            <div class="cards-top__photos">
                                                <svg class="icon icon-cameraSharp cards-top__photos-icon" viewBox="0 0 17 17">
                                                    <use xlink:href="/app/icons/sprite.svg#cameraSharp"></use>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cards-cost">
                                        <div class="cards-cost__main"><span class="cards-cost__price">2 375,6<span class="cards-cost__symbol">&nbsp;₽</span></span><span class="cards-cost__payment">Без НДС</span>
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
                                        <div class="cards-bottom__city">Уфа</div>
                                        <div class="cards-bottom__days">9 дней</div>
                                        <div class="cards-bottom__right">
                                            <div class="cards-bottom__user"><span class="cards-bottom__user-name user-online">Тимур</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#noAvatar"></use></svg></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="cards__content-item">
                                    <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><a class="cards-top__item-name-text" href="#">Карданный вал L=715mm 1796593-01</a></span></span>
                                        <div class="cards-top__quantity">
                                            <div class="cards-top__quantity-left">20 шт</div>
                                            <div class="cards-top__photos">
                                                <svg class="icon icon-cameraSharp cards-top__photos-icon" viewBox="0 0 17 17">
                                                    <use xlink:href="/app/icons/sprite.svg#cameraSharp"></use>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cards-cost">
                                        <div class="cards-cost__main"><span class="cards-cost__price">2 375,6<span class="cards-cost__symbol">&nbsp;₽</span></span><span class="cards-cost__payment">Без НДС</span>
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
                                    </div>
                                </div>
                            </div>
                            <div class="cards-bottom">
                                <div class="cards-bottom__urgency cards-bottom__urgency cards-bottom__urgency_urgent">Срочно</div>
                                <div class="cards-bottom__city">Уфа</div>
                                <div class="cards-bottom__right">
                                    <div class="cards-bottom__badge">Лично для&nbsp;ВП</div>
                                    <div class="cards-bottom__user"><span class="cards-bottom__user-name user-online">Тимур</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#noAvatar"></use></svg></span>
                                    </div>
                                </div>
                            </div>
                            <div class="cards-info">
                                <div class="cards-info__action">
                                    <div class="cards-info__action-btn btn btn_blue 1" data-btn=""><span>от&nbsp;2 200 (13)</span>
                                    </div>
                                </div>
                                <div class="cards-info__status">
                                    <div class="cards-info__status-name"><span class="cards-info__status-name-text">Исполнено</span>
                                    </div>
                                    <div class="cards-info__status-published"><span class="cards-info__status-published-text">5 дней назад</span>
                                    </div>
                                </div>
                                <div class="cards-info__manage">
                                    <div class="cards-info__manage-inner">
                                        <div class="cards-info__manage-item cards-info__manage-message">
                                            <svg class="icon icon-mail cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                <use xlink:href="/app/icons/sprite.svg#mail"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="cards-info__menu">
                                    <svg class="icon icon-threeDot cards-info__menu-icon" viewBox="0 0 32 32">
                                        <use xlink:href="/app/icons/sprite.svg#threeDot"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cards__item cards__item_view-1">
                        <div class="cards__content">
                            <div class="cards__content-list">
                                <div class="cards__content-item">
                                    <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><a class="cards-top__item-name-text" href="#">Карданный вал L=715mm 1796593-01</a></span></span>
                                        <div class="cards-top__quantity">
                                            <div class="cards-top__quantity-left">20 шт</div>
                                        </div>
                                    </div>
                                    <div class="cards-cost">
                                        <div class="cards-cost__main"><span class="cards-cost__price">2 375,6<span class="cards-cost__symbol">&nbsp;₽</span></span><span class="cards-cost__payment">Без НДС</span>
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
                                        <div class="cards-bottom__city">Уфа</div>
                                        <div class="cards-bottom__right">
                                            <div class="cards-bottom__user"><span class="cards-bottom__user-name">Тимур</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#noAvatar"></use></svg></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="cards__content-item">
                                    <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><a class="cards-top__item-name-text" href="#">Карданный вал L=715mm 1796593-01</a></span></span>
                                        <div class="cards-top__quantity">
                                            <div class="cards-top__quantity-left">20 шт</div>
                                            <div class="cards-top__photos">
                                                <svg class="icon icon-cameraSharp cards-top__photos-icon" viewBox="0 0 17 17">
                                                    <use xlink:href="/app/icons/sprite.svg#cameraSharp"></use>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cards-cost">
                                        <div class="cards-cost__main"><span class="cards-cost__price">2 375,6<span class="cards-cost__symbol">&nbsp;₽</span></span><span class="cards-cost__payment">Без НДС</span><span class="cards-cost__truck"> <svg class="icon icon-truck cards-cost__truck-icon" viewBox="0 0 30 18"><use xlink:href="/app/icons/sprite.svg#truck"></use></svg></span>
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
                                        <div class="cards-bottom__city">Уфа</div>
                                        <div class="cards-bottom__days">9 дней</div>
                                        <div class="cards-bottom__right">
                                            <div class="cards-bottom__user"><span class="cards-bottom__user-name">Цена - Качество</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#noAvatar"></use></svg></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="cards__content-item">
                                    <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><a class="cards-top__item-name-text" href="#">Карданный вал L=715mm 1796593-01</a></span></span>
                                        <div class="cards-top__quantity">
                                            <div class="cards-top__quantity-left">20 шт</div>
                                            <div class="cards-top__photos">
                                                <svg class="icon icon-cameraSharp cards-top__photos-icon" viewBox="0 0 17 17">
                                                    <use xlink:href="/app/icons/sprite.svg#cameraSharp"></use>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cards-cost">
                                        <div class="cards-cost__main"><span class="cards-cost__price">2 375,6<span class="cards-cost__symbol">&nbsp;₽</span></span><span class="cards-cost__payment">Без НДС</span>
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
                                    </div>
                                </div>
                            </div>
                            <div class="cards-bottom">
                                <div class="cards-bottom__urgency cards-bottom__urgency cards-bottom__urgency_urgent">Срочно</div>
                                <div class="cards-bottom__city">Уфа</div>
                                <div class="cards-bottom__right">
                                    <div class="cards-bottom__badge">Лично для&nbsp;ВП</div>
                                    <div class="cards-bottom__user"><span class="cards-bottom__user-name user-online">Тимур</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#noAvatar"></use></svg></span>
                                    </div>
                                </div>
                            </div>
                            <div class="cards-info">
                                <div class="cards-info__action">
                                    <div class="cards-info__action-btn btn btn_blue" data-btn=""><span>Отменить</span>
                                    </div>
                                </div>
                                <div class="cards-info__status">
                                    <div class="cards-info__status-name"><span class="cards-info__status-name-text">Возврат</span>
                                    </div>
                                    <div class="cards-info__status-published"><span class="cards-info__status-published-text">20 минут назад</span>
                                    </div>
                                </div>
                                <div class="cards-info__manage">
                                    <div class="cards-info__manage-inner">
                                        <div class="cards-info__manage-item cards-info__manage-message">
                                            <svg class="icon icon-mail cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                <use xlink:href="/app/icons/sprite.svg#mail"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="cards-info__menu">
                                    <svg class="icon icon-threeDot cards-info__menu-icon" viewBox="0 0 32 32">
                                        <use xlink:href="/app/icons/sprite.svg#threeDot"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cards__item cards__item_view-1">
                        <div class="cards__content">
                            <div class="cards__content-list">
                                <div class="cards__content-item">
                                    <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><a class="cards-top__item-name-text" href="#">Карданный вал L=715mm 1796593-01</a></span></span>
                                        <div class="cards-top__quantity">
                                            <div class="cards-top__quantity-left">20 шт</div>
                                        </div>
                                    </div>
                                    <div class="cards-cost">
                                        <div class="cards-cost__main"><span class="cards-cost__price">2 375,6<span class="cards-cost__symbol">&nbsp;₽</span></span><span class="cards-cost__payment">НДС</span>
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
                                        <div class="cards-bottom__city">Уфа</div>
                                        <div class="cards-bottom__right">
                                            <div class="cards-bottom__user"><span class="cards-bottom__user-name">Тимур</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#noAvatar"></use></svg></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="cards__content-item">
                                    <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><a class="cards-top__item-name-text" href="#">Карданный вал L=715mm 1796593-01</a></span></span>
                                        <div class="cards-top__quantity">
                                            <div class="cards-top__quantity-left">20 шт</div>
                                            <div class="cards-top__photos">
                                                <svg class="icon icon-cameraSharp cards-top__photos-icon" viewBox="0 0 17 17">
                                                    <use xlink:href="/app/icons/sprite.svg#cameraSharp"></use>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cards-cost">
                                        <div class="cards-cost__main"><span class="cards-cost__price">2 375,6<span class="cards-cost__symbol">&nbsp;₽</span></span><span class="cards-cost__payment">Без НДС</span>
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
                                        <div class="cards-bottom__city">Уфа</div>
                                        <div class="cards-bottom__days">9 дней</div>
                                        <div class="cards-bottom__right">
                                            <div class="cards-bottom__user"><span class="cards-bottom__user-name">Цена - Качество</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#noAvatar"></use></svg></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="cards__content-item">
                                    <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><a class="cards-top__item-name-text" href="#">Карданный вал L=715mm 1796593-01</a></span></span>
                                        <div class="cards-top__quantity">
                                            <div class="cards-top__quantity-left">20 шт</div>
                                            <div class="cards-top__photos">
                                                <svg class="icon icon-cameraSharp cards-top__photos-icon" viewBox="0 0 17 17">
                                                    <use xlink:href="/app/icons/sprite.svg#cameraSharp"></use>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cards-cost">
                                        <div class="cards-cost__main"><span class="cards-cost__price">2 375,6<span class="cards-cost__symbol">&nbsp;₽</span></span><span class="cards-cost__payment">Без НДС</span>
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
                                    </div>
                                </div>
                            </div>
                            <div class="cards-bottom">
                                <div class="cards-bottom__urgency cards-bottom__urgency cards-bottom__urgency_urgent">Срочно</div>
                                <div class="cards-bottom__city">Уфа</div>
                                <div class="cards-bottom__right">
                                    <div class="cards-bottom__badge">Лично для&nbsp;ВП</div>
                                    <div class="cards-bottom__user"><span class="cards-bottom__user-name user-online">Тимур</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#noAvatar"></use></svg></span>
                                    </div>
                                </div>
                            </div>
                            <div class="cards-info">
                                <div class="cards-info__status">
                                    <div class="cards-info__status-name"><span class="cards-info__status-name-text">Возвращено</span>
                                    </div>
                                    <div class="cards-info__status-published"><span class="cards-info__status-published-text">20 минут назад</span>
                                    </div>
                                </div>
                                <div class="cards-info__manage">
                                    <div class="cards-info__manage-inner">
                                        <div class="cards-info__manage-item cards-info__manage-message">
                                            <svg class="icon icon-mail cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                <use xlink:href="/app/icons/sprite.svg#mail"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="cards-info__menu">
                                    <svg class="icon icon-threeDot cards-info__menu-icon" viewBox="0 0 32 32">
                                        <use xlink:href="/app/icons/sprite.svg#threeDot"></use>
                                    </svg>
                                </div>
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
                                <use xlink:href="/app/icons/sprite.svg#cross"></use>
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
                                <input class="input" type="text" placeholder="E-mail">
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" placeholder="Примечание">
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
    <div class="modal modal_edit-card create-supplier-modal">
        <div class="modal__container">
            <div class="modal__inner">
                <div class="modal__content">
                    <div class="modal__head">
                        <div class="modal__close" data-close="close">
                            <svg class="icon icon-cross " viewBox="0 0 24 24">
                                <use xlink:href="/app/icons/sprite.svg#cross"></use>
                            </svg>
                        </div>
                        <div class="modal__head-text">Создание поставщика</div>
                    </div>
                    <div class="modal__body">
                        <form class="form create-supplier-form">
                            <div class="form__logo">
                                <input class="input" type="file" id="logo" disabled>
                                <label class="form__logo-wrap" for="logo"> <span class="form__logo-text">Лого</span>
                                </label>
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
                                                <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
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
                                                <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input class="input require" type="text" placeholder="Наименование">
                                </div>
                                <div class="form-group">
                                    <input class="input" type="text" placeholder="Адрес">
                                </div>
                                <div class="form-group">
                                    <div class="select-box">
                                        <select>
                                            <option>Продавец</option>
                                            <option>Вариант 1</option>
                                            <option>Вариант 2</option>
                                        </select>
                                        <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                                            <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
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
                                            <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="form__bottom">
                                <div class="form-group">
                                    <input class="input" type="text" placeholder="Комментарий">
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
                                <use xlink:href="/app/icons/sprite.svg#cross"></use>
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
                                <use xlink:href="/app/icons/sprite.svg#cross"></use>
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
                                <use xlink:href="/app/icons/sprite.svg#cross"></use>
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
                                <use xlink:href="/app/icons/sprite.svg#cross"></use>
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
                        <div class="cards cards_solid">
                            <div class="cards__item">
                                <div class="cards__content">
                                    <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><label class="checkbox cards-top__checkbox"><input class="checkbox__input j-cb-share-need" type="checkbox" name="share-need"/><span class="checkbox__control"><span class="checkbox__icon"><svg class="icon icon-check " viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#check"></use></svg></span></span>
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
                                            <div class="cards-bottom__user"><span class="cards-bottom__user-name user-online">Тимур</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#noAvatar"></use></svg></span>
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
                                                        <use xlink:href="/app/icons/sprite.svg#mail"></use>
                                                    </svg>
                                                </div>
                                                <div class="cards-info__manage-item cards-info__manage-warning">
                                                    <svg class="icon icon-warning cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                        <use xlink:href="/app/icons/sprite.svg#warning"></use>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cards-info__menu">
                                            <svg class="icon icon-threeDot cards-info__menu-icon" viewBox="0 0 32 32">
                                                <use xlink:href="/app/icons/sprite.svg#threeDot"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cards__item">
                                <div class="cards__content">
                                    <div class="cards-gallery">
                                        <div class="cards-gallery__inner"><a class="cards-gallery__item" href="/app/img/car.jpg"><span class="cards-gallery__img-wrapper"><img class="cards-gallery__img" src="/img/car.jpg" alt="" role="presentation"/></span><span class="cards-gallery__line"></span></a>
                                        </div>
                                    </div>
                                    <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><label class="checkbox cards-top__checkbox"><input class="checkbox__input j-cb-share-need" type="checkbox" name="share-need"/><span class="checkbox__control"><span class="checkbox__icon"><svg class="icon icon-check " viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#check"></use></svg></span></span>
                                        </label><a class="cards-top__item-name-text" href="#http://link2/">Прокладка впускного коллектора (1374340) SCANIA D/DS2</a>
                                        </span>
                                        </span>
                                        <div class="cards-top__quantity">
                                            <div class="cards-top__quantity-left">20 шт<span class="cards-top__quantity-purchased">&nbsp;(1)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cards-cost">
                                        <div class="cards-cost__main"><span class="cards-cost__price">2 900 000<span class="cards-cost__symbol">&nbsp;₽</span></span><span class="cards-cost__payment"> <svg class="icon icon-money " viewBox="0 0 20 20"><use xlink:href="/app/icons/sprite.svg#money"></use></svg></span>
                                            <span
                                            class="cards-cost__truck">
                                                <svg class="icon icon-truck cards-cost__truck-icon" viewBox="0 0 30 18">
                                                    <use xlink:href="/app/icons/sprite.svg#truck"></use>
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
                                            <div class="cards-bottom__user"><span class="cards-bottom__user-name user-online">Тимур</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#noAvatar"></use></svg></span>
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
                                                        <use xlink:href="/app/icons/sprite.svg#mail"></use>
                                                    </svg>
                                                </div>
                                                <div class="cards-info__manage-item cards-info__manage-warning">
                                                    <svg class="icon icon-warning cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                        <use xlink:href="/app/icons/sprite.svg#warning"></use>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cards-info__menu">
                                            <svg class="icon icon-threeDot cards-info__menu-icon" viewBox="0 0 32 32">
                                                <use xlink:href="/app/icons/sprite.svg#threeDot"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cards__item">
                                <div class="cards__content">
                                    <div class="cards-gallery">
                                        <div class="cards-gallery__inner"><a class="cards-gallery__item" href="/app/img/car.jpg" data-fancybox="card-imgs"><span class="cards-gallery__img-wrapper"><img class="cards-gallery__img" src="/img/car.jpg" alt="" role="presentation"/></span><span class="cards-gallery__line"></span></a>
                                            <a
                                            class="cards-gallery__item" href="/app/img/car2.jpg" data-fancybox="card-imgs"><span class="cards-gallery__img-wrapper"><img class="cards-gallery__img" src="/img/car2.jpg" alt="" role="presentation"/></span><span class="cards-gallery__line"></span>
                                                </a><a class="cards-gallery__item" href="/app/img/car3.jpg" data-fancybox="card-imgs"><span class="cards-gallery__img-wrapper"><img class="cards-gallery__img" src="/img/car3.jpg" alt="" role="presentation"/></span><span class="cards-gallery__line"></span></a>
                                                <a
                                                class="cards-gallery__item" href="/app/img/car.jpg" data-fancybox="card-imgs">
                                                    <div class="cards-gallery__img-wrapper">
                                                        <img class="cards-gallery__img" src="/img/car.jpg" alt="" role="presentation" />
                                                        <div class="cards-gallery__more">
                                                            <div class="cards-gallery__more-icon">
                                                                <svg class="icon icon-camera cards-gallery__more-icon" viewBox="0 0 54 46">
                                                                    <use xlink:href="/app/icons/sprite.svg#camera"></use>
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
                                                    <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
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
                                                        <use xlink:href="/app/icons/sprite.svg#mail"></use>
                                                    </svg>
                                                </div>
                                                <div class="cards-info__manage-item cards-info__manage-warning">
                                                    <svg class="icon icon-warning cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                        <use xlink:href="/app/icons/sprite.svg#warning"></use>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cards-info__menu">
                                            <svg class="icon icon-threeDot cards-info__menu-icon" viewBox="0 0 32 32">
                                                <use xlink:href="/app/icons/sprite.svg#threeDot"></use>
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
                                            <div class="cards-bottom__user"><span class="cards-bottom__user-name user-online">Арт-Мосторс</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#noAvatar"></use></svg></span>
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
                                                        <use xlink:href="/app/icons/sprite.svg#mail"></use>
                                                    </svg>
                                                </div>
                                                <div class="cards-info__manage-item cards-info__manage-warning">
                                                    <svg class="icon icon-warning cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                        <use xlink:href="/app/icons/sprite.svg#warning"></use>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cards-info__menu">
                                            <svg class="icon icon-threeDot cards-info__menu-icon" viewBox="0 0 32 32">
                                                <use xlink:href="/app/icons/sprite.svg#threeDot"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="cards-offers cards__content">
                                    <div class="cards-gallery">
                                        <div class="cards-gallery__inner"><a class="cards-gallery__item" href="/app/img/car.jpg"><span class="cards-gallery__img-wrapper"><img class="cards-gallery__img" src="/img/car.jpg" alt="" role="presentation"/></span><span class="cards-gallery__line"></span></a>
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
                                            <div class="cards-bottom__user"><span class="cards-bottom__user-name user-online">Арт-Мосторс</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#noAvatar"></use></svg></span>
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
                                                <use xlink:href="/app/icons/sprite.svg#threeDot"></use>
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
                                        <div class="cards-gallery__inner"><a class="cards-gallery__item" href="/app/img/car.jpg"><span class="cards-gallery__img-wrapper"><img class="cards-gallery__img" src="/img/car.jpg" alt="" role="presentation"/></span><span class="cards-gallery__line"></span></a>
                                        </div>
                                    </div>
                                    <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><label class="checkbox cards-top__checkbox"><input class="checkbox__input j-cb-share-need" type="checkbox" name="share-need"/><span class="checkbox__control"><span class="checkbox__icon"><svg class="icon icon-check " viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#check"></use></svg></span></span>
                                        </label><a class="cards-top__item-name-text" href="#http://link2/">Прокладка впускного коллектора (1374340) SCANIA D/DS2</a>
                                        </span>
                                        </span>
                                        <div class="cards-top__quantity">
                                            <div class="cards-top__quantity-left">20 шт<span class="cards-top__quantity-purchased">&nbsp;(1)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cards-cost">
                                        <div class="cards-cost__main"><span class="cards-cost__price">2 900 000<span class="cards-cost__symbol">&nbsp;₽</span></span><span class="cards-cost__payment"> <svg class="icon icon-money " viewBox="0 0 20 20"><use xlink:href="/app/icons/sprite.svg#money"></use></svg></span>
                                            <span
                                            class="cards-cost__truck">
                                                <svg class="icon icon-truck cards-cost__truck-icon" viewBox="0 0 30 18">
                                                    <use xlink:href="/app/icons/sprite.svg#truck"></use>
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
                                            <div class="cards-bottom__user"><span class="cards-bottom__user-name user-online">Тимур</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#noAvatar"></use></svg></span>
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
                                                        <use xlink:href="/app/icons/sprite.svg#mail"></use>
                                                    </svg>
                                                </div>
                                                <div class="cards-info__manage-item cards-info__manage-warning">
                                                    <svg class="icon icon-warning cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                        <use xlink:href="/app/icons/sprite.svg#warning"></use>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cards-info__menu">
                                            <svg class="icon icon-threeDot cards-info__menu-icon" viewBox="0 0 32 32">
                                                <use xlink:href="/app/icons/sprite.svg#threeDot"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cards__item">
                                <div class="cards__content">
                                    <div class="cards-gallery">
                                        <div class="cards-gallery__inner"><a class="cards-gallery__item" href="/app/img/car.jpg"><span class="cards-gallery__img-wrapper"><img class="cards-gallery__img" src="/img/car.jpg" alt="" role="presentation"/></span><span class="cards-gallery__line"></span></a>
                                        </div>
                                    </div>
                                    <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><label class="checkbox cards-top__checkbox"><input class="checkbox__input j-cb-share-need" type="checkbox" name="share-need"/><span class="checkbox__control"><span class="checkbox__icon"><svg class="icon icon-check " viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#check"></use></svg></span></span>
                                        </label><a class="cards-top__item-name-text" href="#http://link2/">Прокладка впускного коллектора (1374340) SCANIA D/DS2</a>
                                        </span>
                                        </span>
                                        <div class="cards-top__quantity">
                                            <div class="cards-top__quantity-left">20 шт<span class="cards-top__quantity-purchased">&nbsp;(1)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cards-cost">
                                        <div class="cards-cost__main"><span class="cards-cost__price">2 900 000<span class="cards-cost__symbol">&nbsp;₽</span></span><span class="cards-cost__payment"> <svg class="icon icon-money " viewBox="0 0 20 20"><use xlink:href="/app/icons/sprite.svg#money"></use></svg></span>
                                            <span
                                            class="cards-cost__truck">
                                                <svg class="icon icon-truck cards-cost__truck-icon" viewBox="0 0 30 18">
                                                    <use xlink:href="/app/icons/sprite.svg#truck"></use>
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
                                            <div class="cards-bottom__user"><span class="cards-bottom__user-name user-online">Тимур</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#noAvatar"></use></svg></span>
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
                                                        <use xlink:href="/app/icons/sprite.svg#mail"></use>
                                                    </svg>
                                                </div>
                                                <div class="cards-info__manage-item cards-info__manage-warning">
                                                    <svg class="icon icon-warning cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                        <use xlink:href="/app/icons/sprite.svg#warning"></use>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cards-info__menu">
                                            <svg class="icon icon-threeDot cards-info__menu-icon" viewBox="0 0 32 32">
                                                <use xlink:href="/app/icons/sprite.svg#threeDot"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cards__item">
                                <div class="cards__content">
                                    <div class="cards-gallery">
                                        <div class="cards-gallery__inner"><a class="cards-gallery__item" href="/app/img/car.jpg"><span class="cards-gallery__img-wrapper"><img class="cards-gallery__img" src="/img/car.jpg" alt="" role="presentation"/></span><span class="cards-gallery__line"></span></a>
                                        </div>
                                    </div>
                                    <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><label class="checkbox cards-top__checkbox"><input class="checkbox__input j-cb-share-need" type="checkbox" name="share-need"/><span class="checkbox__control"><span class="checkbox__icon"><svg class="icon icon-check " viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#check"></use></svg></span></span>
                                        </label><a class="cards-top__item-name-text" href="#http://link2/">Прокладка впускного коллектора (1374340) SCANIA D/DS2</a>
                                        </span>
                                        </span>
                                        <div class="cards-top__quantity">
                                            <div class="cards-top__quantity-left">20 шт<span class="cards-top__quantity-purchased">&nbsp;(1)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cards-cost">
                                        <div class="cards-cost__main"><span class="cards-cost__price">2 900 000<span class="cards-cost__symbol">&nbsp;₽</span></span><span class="cards-cost__payment"> <svg class="icon icon-money " viewBox="0 0 20 20"><use xlink:href="/app/icons/sprite.svg#money"></use></svg></span>
                                            <span
                                            class="cards-cost__truck">
                                                <svg class="icon icon-truck cards-cost__truck-icon" viewBox="0 0 30 18">
                                                    <use xlink:href="/app/icons/sprite.svg#truck"></use>
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
                                            <div class="cards-bottom__user"><span class="cards-bottom__user-name user-online">Тимур</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#noAvatar"></use></svg></span>
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
                                                        <use xlink:href="/app/icons/sprite.svg#mail"></use>
                                                    </svg>
                                                </div>
                                                <div class="cards-info__manage-item cards-info__manage-warning">
                                                    <svg class="icon icon-warning cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                        <use xlink:href="/app/icons/sprite.svg#warning"></use>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cards-info__menu">
                                            <svg class="icon icon-threeDot cards-info__menu-icon" viewBox="0 0 32 32">
                                                <use xlink:href="/app/icons/sprite.svg#threeDot"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cards__item">
                                <div class="cards__content">
                                    <div class="cards-gallery">
                                        <div class="cards-gallery__inner"><a class="cards-gallery__item" href="/app/img/car.jpg"><span class="cards-gallery__img-wrapper"><img class="cards-gallery__img" src="/img/car.jpg" alt="" role="presentation"/></span><span class="cards-gallery__line"></span></a>
                                        </div>
                                    </div>
                                    <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><label class="checkbox cards-top__checkbox"><input class="checkbox__input j-cb-share-need" type="checkbox" name="share-need"/><span class="checkbox__control"><span class="checkbox__icon"><svg class="icon icon-check " viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#check"></use></svg></span></span>
                                        </label><a class="cards-top__item-name-text" href="#http://link2/">Прокладка впускного коллектора (1374340) SCANIA D/DS2</a>
                                        </span>
                                        </span>
                                        <div class="cards-top__quantity">
                                            <div class="cards-top__quantity-left">20 шт<span class="cards-top__quantity-purchased">&nbsp;(1)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cards-cost">
                                        <div class="cards-cost__main"><span class="cards-cost__price">2 900 000<span class="cards-cost__symbol">&nbsp;₽</span></span><span class="cards-cost__payment"> <svg class="icon icon-money " viewBox="0 0 20 20"><use xlink:href="/app/icons/sprite.svg#money"></use></svg></span>
                                            <span
                                            class="cards-cost__truck">
                                                <svg class="icon icon-truck cards-cost__truck-icon" viewBox="0 0 30 18">
                                                    <use xlink:href="/app/icons/sprite.svg#truck"></use>
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
                                            <div class="cards-bottom__user"><span class="cards-bottom__user-name user-online">Тимур</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#noAvatar"></use></svg></span>
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
                                                        <use xlink:href="/app/icons/sprite.svg#mail"></use>
                                                    </svg>
                                                </div>
                                                <div class="cards-info__manage-item cards-info__manage-warning">
                                                    <svg class="icon icon-warning cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                        <use xlink:href="/app/icons/sprite.svg#warning"></use>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cards-info__menu">
                                            <svg class="icon icon-threeDot cards-info__menu-icon" viewBox="0 0 32 32">
                                                <use xlink:href="/app/icons/sprite.svg#threeDot"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cards__item">
                                <div class="cards__content">
                                    <div class="cards-gallery">
                                        <div class="cards-gallery__inner"><a class="cards-gallery__item" href="/app/img/car.jpg"><span class="cards-gallery__img-wrapper"><img class="cards-gallery__img" src="/img/car.jpg" alt="" role="presentation"/></span><span class="cards-gallery__line"></span></a>
                                        </div>
                                    </div>
                                    <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><label class="checkbox cards-top__checkbox"><input class="checkbox__input j-cb-share-need" type="checkbox" name="share-need"/><span class="checkbox__control"><span class="checkbox__icon"><svg class="icon icon-check " viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#check"></use></svg></span></span>
                                        </label><a class="cards-top__item-name-text" href="#http://link2/">Прокладка впускного коллектора (1374340) SCANIA D/DS2</a>
                                        </span>
                                        </span>
                                        <div class="cards-top__quantity">
                                            <div class="cards-top__quantity-left">20 шт<span class="cards-top__quantity-purchased">&nbsp;(1)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cards-cost">
                                        <div class="cards-cost__main"><span class="cards-cost__price">2 900 000<span class="cards-cost__symbol">&nbsp;₽</span></span><span class="cards-cost__payment"> <svg class="icon icon-money " viewBox="0 0 20 20"><use xlink:href="/app/icons/sprite.svg#money"></use></svg></span>
                                            <span
                                            class="cards-cost__truck">
                                                <svg class="icon icon-truck cards-cost__truck-icon" viewBox="0 0 30 18">
                                                    <use xlink:href="/app/icons/sprite.svg#truck"></use>
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
                                            <div class="cards-bottom__user"><span class="cards-bottom__user-name user-online">Тимур</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#noAvatar"></use></svg></span>
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
                                                        <use xlink:href="/app/icons/sprite.svg#mail"></use>
                                                    </svg>
                                                </div>
                                                <div class="cards-info__manage-item cards-info__manage-warning">
                                                    <svg class="icon icon-warning cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                        <use xlink:href="/app/icons/sprite.svg#warning"></use>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cards-info__menu">
                                            <svg class="icon icon-threeDot cards-info__menu-icon" viewBox="0 0 32 32">
                                                <use xlink:href="/app/icons/sprite.svg#threeDot"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cards__item">
                                <div class="cards__content">
                                    <div class="cards-gallery">
                                        <div class="cards-gallery__inner"><a class="cards-gallery__item" href="/app/img/car.jpg"><span class="cards-gallery__img-wrapper"><img class="cards-gallery__img" src="/img/car.jpg" alt="" role="presentation"/></span><span class="cards-gallery__line"></span></a>
                                        </div>
                                    </div>
                                    <div class="cards-top"><span class="cards-top__item-name"> <span class="cards-top__item-name-inner"><label class="checkbox cards-top__checkbox"><input class="checkbox__input j-cb-share-need" type="checkbox" name="share-need"/><span class="checkbox__control"><span class="checkbox__icon"><svg class="icon icon-check " viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#check"></use></svg></span></span>
                                        </label><a class="cards-top__item-name-text" href="#http://link2/">Прокладка впускного коллектора (1374340) SCANIA D/DS2</a>
                                        </span>
                                        </span>
                                        <div class="cards-top__quantity">
                                            <div class="cards-top__quantity-left">20 шт<span class="cards-top__quantity-purchased">&nbsp;(1)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cards-cost">
                                        <div class="cards-cost__main"><span class="cards-cost__price">2 900 000<span class="cards-cost__symbol">&nbsp;₽</span></span><span class="cards-cost__payment"> <svg class="icon icon-money " viewBox="0 0 20 20"><use xlink:href="/app/icons/sprite.svg#money"></use></svg></span>
                                            <span
                                            class="cards-cost__truck">
                                                <svg class="icon icon-truck cards-cost__truck-icon" viewBox="0 0 30 18">
                                                    <use xlink:href="/app/icons/sprite.svg#truck"></use>
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
                                            <div class="cards-bottom__user"><span class="cards-bottom__user-name user-online">Тимур</span><span class="cards-bottom__user-avatar"><svg class="icon icon-noAvatar cards-bottom__user-avatar-icon" viewBox="0 0 16 16"><use xlink:href="/app/icons/sprite.svg#noAvatar"></use></svg></span>
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
                                                        <use xlink:href="/app/icons/sprite.svg#mail"></use>
                                                    </svg>
                                                </div>
                                                <div class="cards-info__manage-item cards-info__manage-warning">
                                                    <svg class="icon icon-warning cards-info__manage-item-icon" viewBox="0 0 16 16">
                                                        <use xlink:href="/app/icons/sprite.svg#warning"></use>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cards-info__menu">
                                            <svg class="icon icon-threeDot cards-info__menu-icon" viewBox="0 0 32 32">
                                                <use xlink:href="/app/icons/sprite.svg#threeDot"></use>
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
    <div class="subscription-emex-modal modal modal_m">
        <div class="modal__container">
            <div class="modal__inner">
                <div class="modal__content">
                    <div class="modal__head">
                        <div class="modal__close" data-close="close">
                            <svg class="icon icon-cross " viewBox="0 0 24 24">
                                <use xlink:href="/app/icons/sprite.svg#cross"></use>
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
                                            <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="subscription-emex-modal__info">
                                <div class="subscription-emex-modal__info-inner">
                                    <div class="subscription-emex-modal__info-btn">
                                        <svg class="icon icon-infoSign " viewBox="0 0 30 30">
                                            <use xlink:href="/app/icons/sprite.svg#infoSign"></use>
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
    <div class="modal modal_edit-card edit-subs-user-modal">
        <div class="modal__container">
            <div class="modal__inner">
                <div class="modal__content">
                    <div class="modal__head">
                        <div class="modal__close" data-close="close">
                            <svg class="icon icon-cross " viewBox="0 0 24 24">
                                <use xlink:href="/app/icons/sprite.svg#cross"></use>
                            </svg>
                        </div>
                        <div class="modal__head-text">Редактирование аккаунта</div>
                    </div>
                    <div class="modal__body">
                        <form class="form edit-subs-user-form">
                            <div class="form__logo">
                                <input class="input" type="file" id="logo" disabled>
                                <label class="form__logo-wrap" for="logo"> <span class="form__logo-img"><img src="/img/car.jpg"></span>
                                </label>
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
                                                <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
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
                                                <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input class="input" type="text" placeholder="Наименование">
                                </div>
                                <div class="form-group">
                                    <input class="input" type="text" placeholder="Адрес">
                                </div>
                                <div class="form-group">
                                    <div class="select-box">
                                        <select>
                                            <option>Продавец</option>
                                            <option>Вариант 1</option>
                                            <option>Вариант 2</option>
                                        </select>
                                        <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                                            <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input class="input" type="text" placeholder="Электронная почта">
                                </div>
                                <div class="form-group">
                                    <input class="input" type="text" placeholder="Телефон">
                                </div>
                                <div class="form-group">
                                    <div class="select-box">
                                        <select>
                                            <option>Интересы</option>
                                            <option>Вариант 1</option>
                                            <option>Вариант 2</option>
                                        </select>
                                        <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                                            <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="form__bottom">
                                <div class="form-group">
                                    <input class="input" type="text" placeholder="Комментарий">
                                </div>
                                <div class="form__btn btn btn_blue btn_m">Сохранить</div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="brand-groups-modal modal modal_m">
        <div class="modal__container">
            <div class="modal__inner">
                <div class="modal__content">
                    <div class="modal__head">
                        <div class="modal__close" data-close="close">
                            <svg class="icon icon-cross " viewBox="0 0 24 24">
                                <use xlink:href="/app/icons/sprite.svg#cross"></use>
                            </svg>
                        </div>
                        <div class="modal__head-text">Группы брендов</div>
                    </div>
                    <div class="modal__body">
                        <form class="brand-groups-modal__form form brand-groups-form">
                            <div class="brand-groups-modal__form-group-row form-group-row">
                                <div class="brand-groups-modal__form-group form-group">
                                    <input class="input" type="text" placeholder="Название" name="login">
                                </div>
                                <div class="brand-groups-modal__form-group form-group">
                                    <div class="select-box">
                                        <select>
                                            <option>Бренды</option>
                                            <option>Вариант 1Вариант 1Вариант 1</option>
                                            <option>Вариант 2</option>
                                        </select>
                                        <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                                            <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="brand-groups-modal__remove">Удалить</div>
                            </div>
                            <div class="brand-groups-modal__form-group-row form-group-row">
                                <div class="brand-groups-modal__form-group form-group">
                                    <input class="input" type="text" placeholder="Название" name="login">
                                </div>
                                <div class="brand-groups-modal__form-group form-group">
                                    <div class="select-box">
                                        <select>
                                            <option>Бренды</option>
                                            <option>Вариант 1</option>
                                            <option>Вариант 2</option>
                                        </select>
                                        <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                                            <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="brand-groups-modal__remove">Удалить</div>
                            </div>
                            <div class="brand-groups-modal__add btn btn_gray-bd btn_m" data-close="close">Добавить</div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/just-validate@3.8.1/dist/just-validate.production.min.js"></script>
    <script src="/app/js/app.js?v=1657458532846"></script>
</body>

</html>