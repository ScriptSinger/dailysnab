import { config } from "../config";

var needsSettings = {
    state: {
        tab: 0,
        need: 0, // 1 - заявки, 2 - объявления
        category: 0,
        categorySection: 0,
        location: 0,
    },
    block: '.what-search',
    tabItem: '.what-search__more-item',
    closeBtn: '.what-search__close',
    categoryItem: '.what-search__category-item',
    tabCloseBtn: '.what-search__more-item-close',
    needNodes: [
        {
            id: 1,
            name: 'Заявки',
            icon: 'requests',
        },
        {
            id: 2,
            name: 'Объявления',
            icon: 'announcement',
        }
    ],
    nodesTabs: { // (data-ws-tab-id="1")
        needs: {
            id: 1,
            name: 'Заявки',
        },
        category: {
            id: 2,
            name: 'Категория',
        },
        location: {
            id: 3,
            name: 'Место',
        },
    },
    needsHTMLcontent: `
    <div class="what-search__more">
    <div class="what-search__close">
        <svg class="icon icon-cross " viewBox="0 0 24 24">
            <use xlink:href="/app/icons/sprite.svg#cross"></use>
        </svg>
    </div>
    <ul class="what-search__more-list">
        <li class="what-search__more-item what-search__more-item_applications" data-ws-tab-id="1"><span
                class="what-search__more-icon"><svg class="icon icon-requests " viewBox="0 0 20 20">
                    <use xlink:href="/app/icons/sprite.svg#requests"></use>
                </svg></span>
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
        <li class="what-search__more-item" data-ws-tab-id="2"><span class="what-search__more-icon"><svg
                    class="icon icon-nineSquares " viewBox="0 0 20 20">
                    <use xlink:href="/app/icons/sprite.svg#nineSquares"></use>
                </svg></span><span class="what-search__more-text">Категория</span>
            <div class="what-search__more-item-close">
                <svg class="icon icon-cross " viewBox="0 0 24 24">
                    <use xlink:href="/app/icons/sprite.svg#cross"></use>
                </svg>
            </div>
        </li>
        <li class="what-search__more-item" data-ws-tab-id="3"><span class="what-search__more-icon"><svg
                    class="icon icon-location " viewBox="0 0 20 20">
                    <use xlink:href="/app/icons/sprite.svg#location"></use>
                </svg></span><span class="what-search__more-text">Место</span>
            <div class="what-search__more-item-close">
                <svg class="icon icon-cross " viewBox="0 0 24 24">
                    <use xlink:href="/app/icons/sprite.svg#cross"></use>
                </svg>
            </div>
        </li>
    </ul>
    <div class="what-search__location what-search__more-section" data-ws-content-id="3" style="display: none;">
        <form class="location-form ac-group">
            <input class="location-form__input ac-group__input ui-autocomplete-input" type="text"
                id="what-search-location" name="what-search-location" placeholder="Введите город" autocomplete="off">
            <svg class="icon icon-dropdown ac-group__icon-dropdown search-all-form__icon-dropdown" viewBox="0 0 12 12">
                <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
            </svg>
        </form>
    </div>
    <div class="what-search__category what-search__more-section" data-ws-content-id="2">
        <div class="what-search__category-wrap">
            <div class="what-search__category-list what-search__category-list what-search__category-list_1"
                data-ws-cat-section="1">
                <div class="what-search__category-headline">
                    <div class="what-search__category-headline-inner">Выберите категорию</div>
                    <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                        <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                    </svg>
                </div>
                <div class="what-search__category-content">
                    <div class="what-search__category-item" data-ws-cat="Строительство и&nbsp;ремонт">
                        <div class="what-search__category-logo">
                            <svg class="icon icon-bricks " viewBox="0 0 20 20">
                                <use xlink:href="/app/icons/sprite.svg#bricks"></use>
                            </svg>
                        </div>
                        <div class="what-search__category-name">Строительство и&nbsp;ремонт</div>
                    </div>
                    <div class="what-search__category-item" data-ws-cat="Транспорт">
                        <div class="what-search__category-logo">
                            <svg class="icon icon-technic " viewBox="0 0 20 20">
                                <use xlink:href="/app/icons/sprite.svg#technic"></use>
                            </svg>
                        </div>
                        <div class="what-search__category-name">Транспорт</div>
                    </div>
                    <div class="what-search__category-item" data-ws-cat="Оборудование">
                        <div class="what-search__category-logo">
                            <svg class="icon icon-equipment " viewBox="0 0 20 20">
                                <use xlink:href="/app/icons/sprite.svg#equipment"></use>
                            </svg>
                        </div>
                        <div class="what-search__category-name">Оборудование</div>
                    </div>
                </div>
            </div>
            <div class="what-search__category-list what-search__category-list what-search__category-list_2 hidden"
                data-ws-cat-section="2">
                <div class="what-search__category-headline">
                    <div class="what-search__category-headline-inner">Выберите категорию</div>
                    <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                        <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                    </svg>
                </div>
                <div class="what-search__category-content">
                    <div class="what-search__category-item" selected="selected" data-ws-cat="Стройматериалы">
                        <div class="what-search__category-name">Стройматериалы</div>
                    </div>
                    <div class="what-search__category-item" selected="selected" data-ws-cat="Металл">
                        <div class="what-search__category-name">Металл</div>
                    </div>
                    <div class="what-search__category-item" selected="selected" data-ws-cat="ЖБИ">
                        <div class="what-search__category-name">ЖБИ</div>
                    </div>
                    <div class="what-search__category-item" selected="selected" data-ws-cat="Дерево">
                        <div class="what-search__category-name">Дерево</div>
                    </div>
                    <div class="what-search__category-item" selected="selected" data-ws-cat="Отделка">
                        <div class="what-search__category-name">Отделка</div>
                    </div>
                    <div class="what-search__category-item" selected="selected" data-ws-cat="Мебель">
                        <div class="what-search__category-name">Мебель</div>
                    </div>
                    <div class="what-search__category-item" selected="selected" data-ws-cat="Сад">
                        <div class="what-search__category-name">Сад</div>
                    </div>
                    <div class="what-search__category-item" selected="selected" data-ws-cat="Аодоснабжение">
                        <div class="what-search__category-name">Аодоснабжение</div>
                    </div>
                    <div class="what-search__category-item" selected="selected" data-ws-cat="Электротовары">
                        <div class="what-search__category-name">Электротовары</div>
                    </div>
                </div>
            </div>
            <div class="what-search__category-list what-search__category-list what-search__category-list_3 hidden"
                data-ws-cat-section="3">
                <div class="what-search__category-headline">
                    <div class="what-search__category-headline-inner">Выберите категорию</div>
                    <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                        <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                    </svg>
                </div>
                <div class="what-search__category-content">
                    <div class="what-search__category-item" selected="selected" data-ws-cat="Инструменты">
                        <div class="what-search__category-name">Инструменты</div>
                    </div>
                    <div class="what-search__category-item" selected="selected" data-ws-cat="Конструкции и&nbsp;детали">
                        <div class="what-search__category-name">Конструкции и&nbsp;детали</div>
                    </div>
                    <div class="what-search__category-item" selected="selected"
                        data-ws-cat="Фундаменты стаканного типа и&nbsp; башмаки">
                        <div class="what-search__category-name">Фундаменты стаканного типа и&nbsp; башмаки</div>
                    </div>
                    <div class="what-search__category-item" selected="selected" data-ws-cat="Плиты фундаментов">
                        <div class="what-search__category-name">Плиты фундаментов</div>
                    </div>
                    <div class="what-search__category-item" selected="selected" data-ws-cat="Детали росверков">
                        <div class="what-search__category-name">Детали росверков</div>
                    </div>
                    <div class="what-search__category-item" selected="selected" data-ws-cat="Сваи">
                        <div class="what-search__category-name">Сваи</div>
                    </div>
                    <div class="what-search__category-item" selected="selected" data-ws-cat="Ригели и&nbsp;прогоны">
                        <div class="what-search__category-name">Ригели и&nbsp;прогоны</div>
                    </div>
                    <div class="what-search__category-item" selected="selected" data-ws-cat="Фермы">
                        <div class="what-search__category-name">Фермы</div>
                    </div>
                    <div class="what-search__category-item" selected="selected" data-ws-cat="Элементы рам">
                        <div class="what-search__category-name">Элементы рам</div>
                    </div>
                </div>
            </div>
            <div class="what-search__category-list what-search__category-list what-search__category-list_4 hidden"
                data-ws-cat-section="4">
                <div class="what-search__category-headline">
                    <div class="what-search__category-headline-inner">Выберите категорию</div>
                    <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                        <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                    </svg>
                </div>
                <div class="what-search__category-content">
                    <div class="what-search__category-item" selected="selected" data-ws-cat="Перемычки">
                        <div class="what-search__category-name">Перемычки</div>
                    </div>
                    <div class="what-search__category-item" selected="selected" data-ws-cat="Панели стеновые наружные">
                        <div class="what-search__category-name">Панели стеновые наружные</div>
                    </div>
                    <div class="what-search__category-item" selected="selected"
                        data-ws-cat="Фундаменты стаканного типа и&nbsp;башмаки">
                        <div class="what-search__category-name">Фундаменты стаканного типа и&nbsp;башмаки</div>
                    </div>
                    <div class="what-search__category-item" selected="selected" data-ws-cat="Перегородки">
                        <div class="what-search__category-name">Перегородки</div>
                    </div>
                    <div class="what-search__category-item" selected="selected" data-ws-cat="Длоки стеновые">
                        <div class="what-search__category-name">Длоки стеновые</div>
                    </div>
                    <div class="what-search__category-item" selected="selected" data-ws-cat="Плиты перекрытий">
                        <div class="what-search__category-name">Плиты перекрытий</div>
                    </div>
                    <div class="what-search__category-item" selected="selected" data-ws-cat="Плиты дорожные">
                        <div class="what-search__category-name">Плиты дорожные</div>
                    </div>
                    <div class="what-search__category-item" selected="selected" data-ws-cat="Трубы наопрные">
                        <div class="what-search__category-name">Трубы наопрные</div>
                    </div>
                    <div class="what-search__category-item" selected="selected" data-ws-cat="Трубы безнапорные">
                        <div class="what-search__category-name">Трубы безнапорные</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="what-search__suggested what-search__more-section" data-ws-content-id="4">
        <div class="what-search__suggested-item relevant"><span class="what-search__suggested-inner"><span
                    class="what-search__suggested-name">Штукатурка</span><span
                    class="what-search__suggested-sec">Категория</span><span
                    class="what-search__suggested-sec">Стройматериалы</span></span>
        </div>
        <div class="what-search__suggested-item"><span class="what-search__suggested-inner"><span
                    class="what-search__suggested-name">Гипсовая штукатурка</span><span
                    class="what-search__suggested-sec">Тип</span><span
                    class="what-search__suggested-sec">Штукатурка</span>
                <span class="what-search__suggested-sec">Стройматериалы</span>
            </span>
        </div>
        <div class="what-search__suggested-item"><span class="what-search__suggested-inner"><span
                    class="what-search__suggested-name">Декоративная штукатурка</span><span
                    class="what-search__suggested-sec">Тип</span><span
                    class="what-search__suggested-sec">Штукатурка</span>
                <span class="what-search__suggested-sec">Стройматериалы</span>
            </span>
        </div>
        <div class="what-search__suggested-item"><span class="what-search__suggested-inner"><span
                    class="what-search__suggested-name">Сетки для&nbsp;штукатурки</span><span
                    class="what-search__suggested-sec">Тип</span><span class="what-search__suggested-sec">Кладочные
                    и&nbsp;штукатурные сетки</span>
                <span class="what-search__suggested-sec">Стройматериалы</span>
            </span>
        </div>
        <div class="what-search__suggested-item"><span class="what-search__suggested-inner"><span
                    class="what-search__suggested-name">Штукатурный фасад</span><span
                    class="what-search__suggested-sec">Тип</span><span
                    class="what-search__suggested-sec">Теплоизоляция</span>
                <span class="what-search__suggested-sec">Стройматериалы</span>
            </span>
        </div>
        <div class="what-search__suggested-item"><span class="what-search__suggested-inner"><span
                    class="what-search__suggested-name">Терки для&nbsp;штукатурки</span><span
                    class="what-search__suggested-sec">Категория</span><span
                    class="what-search__suggested-sec">Инструменты</span></span>
        </div>
        <div class="what-search__suggested-item"><span
                class="what-search__suggested-inner j-open-category-section"><span
                    class="what-search__suggested-name">Другая категория</span></span>
        </div>
    </div>
    <div class="what-search__features what-search__more-section" data-ws-content-id="5">
        <form class="what-search__features-form">
            <div class="what-search__features-all">
                <div class="form-group">
                    <div class="input-select-box">
                        <input type="text" placeholder="Количество">
                        <div class="select-box">
                            <select>
                                <option>шт</option>
                                <option>кг</option>
                            </select>
                            <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                                <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-select-box">
                        <input type="text" placeholder="Вес">
                        <div class="select-box">
                            <select>
                                <option>кг</option>
                                <option>шт</option>
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
                            <option>Бренд</option>
                            <option>var1</option>
                            <option>var2</option>
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
                            <option>var1</option>
                            <option>var2</option>
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
                            <option>var1</option>
                            <option>var2</option>
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
                            <option>var1</option>
                            <option>var2</option>
                        </select>
                        <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                            <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                        </svg>
                    </div>
                </div>
                <div class="form-group">
                    <div class="select-box">
                        <select>
                            <option>Основной</option>
                            <option>var1</option>
                            <option>var2</option>
                        </select>
                        <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                            <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                        </svg>
                    </div>
                </div>
                <div class="form-group">
                    <div class="select-box">
                        <select>
                            <option>Размер до</option>
                            <option>var1</option>
                            <option>var2</option>
                        </select>
                        <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                            <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                        </svg>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-fromto-box"><span class="input-fromto-box__name">Диаметр</span>
                        <input class="input-fromto-box__from" type="text" placeholder="от">
                        <input class="input-fromto-box__to" type="text" placeholder="до"><span class="input-fromto-box__scale">см</span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-fromto-box input-fromto-box_select"><span class="input-fromto-box__name">Диаметр</span>
                        <input class="input-fromto-box__from" type="text" placeholder="от">
                        <input class="input-fromto-box__to" type="text" placeholder="до">
                        <div class="input-fromto-box__scale select-box">
                            <select>
                                <option>см</option>
                                <option>мм</option>
                            </select>
                            <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                                <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-fromto-box"><span class="input-fromto-box__name">Давление</span>
                        <input class="input-fromto-box__from" type="text" placeholder="от">
                        <input class="input-fromto-box__to" type="text" placeholder="до"><span class="input-fromto-box__scale">бар</span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-fromto-box"><span class="input-fromto-box__name">Температура</span>
                        <input class="input-fromto-box__from" type="text" placeholder="от">
                        <input class="input-fromto-box__to" type="text" placeholder="до"><span class="input-fromto-box__scale">℃</span>
                    </div>
                </div>
            </div>
            <div class="what-search__features-main">
                <div class="form-group">
                    <div class="select-box require">
                        <select>
                            <option>Назначение</option>
                            <option>var1</option>
                            <option>var2</option>
                        </select>
                        <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                            <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                        </svg>
                    </div>
                </div>
                <div class="what-search__features-main-l">
                    <div class="form-group">
                        <input class="input" type="text" placeholder="Комментарий">
                    </div>
                </div>
                <div class="form-group">
                    <input class="input" type="text" placeholder="Имя заказа">
                </div>
                <div class="what-search__features-main-l">
                    <div class="form-group">
                        <input class="input" type="text" placeholder="Ответственный">
                    </div>
                    <div class="what-search__features-clear-form">Очистить все</div>
                </div>
            </div>
        </form>
    </div>
</div>
    `,
    // tabItemActiveToggle: function (e) {
    //     $(this).toggleClass('is-active')
    // },

    setCategoryInAccordionTab() {
        if (window.innerWidth >= 768) return;

        let cat = this.state.category,
            catSection = this.state.categorySection,
            carContent = '.what-search__category-content',
            catSectionsQuantity = 4;

        $('[data-ws-cat-section]').removeClass('expanded').removeClass('last-active').find(carContent).slideUp();

        for (let i = 1; i <= catSectionsQuantity; i++) {
            let catName,
                currentCatSectionNode = $('[data-ws-cat-section="' + i + '"]');

            console.log(catSection)
            if (i == catSection) {
                catName = $('[data-ws-cat="' + cat + '"]').html()
            } else if (i > catSection) {
                catName = 'Выберите категорию';

                if ((i == catSection + 1) && (catSection != 0)) {
                    currentCatSectionNode.addClass('expanded').find(carContent).slideDown();
                    needsSettings.switchLastActiveClass();
                }
            }

            currentCatSectionNode.find(' .what-search__category-headline-inner').html(catName);
        }
    },
    setCategoryInTab() {
        console.log(this.state.tab)
        switch (this.state.tab) {
            case 2:
                console.log('case 2')
                if (needsSettings.state.categorySection != 4) return;

                let catNode = $('[data-ws-tab-id="2"]');

                catNode.find('.what-search__more-text').text(needsSettings.state.category)
                catNode.find('.what-search__more-item-close').show();
                break;
            case 3:
                $('[data-ws-tab-id="3"]').find('.what-search__more-text').text(needsSettings.state.location)
                $('[data-ws-tab-id="3"]').find('.what-search__more-item-close').show();
                break;
        }
    },
    setCategoryIDForItem() {
        $.each($('.what-search__category-item'), function (i, el) {
            let name = $(el).find('.what-search__category-name').text();
            $(el).attr('data-ws-cat', name);
        });
    },
    adjustLastCategorySection() {
    },
    adjustCategory() {
        let cat = this.state.category,
            catSection = this.state.categorySection,
            catSectionsQuantity = 4,
            catSectionNode = $('[data-ws-cat-section]');

        catSectionNode.removeClass('hidden');

        for (let i = 1; i <= catSectionsQuantity; i++) {
            let currentCatSectionNode = $('[data-ws-cat-section="' + i + '"]');

            if (catSection == 0) {
                catSectionNode.not(':first-child').addClass('hidden');
                catSectionNode.find('.selected').removeClass('selected');
                break;
            }

            if (i >= catSection)
                currentCatSectionNode.find('.selected').removeClass('selected');

            if (i > catSection + 1)
                currentCatSectionNode.addClass('hidden');
        }

        $('[data-ws-cat="' + cat + '"]').addClass('selected');

        if (window.innerWidth >= 768) {
            let section = $('[data-ws-cat-section="4"] .what-search__category-content');
            let sectionHeight = config.getElementHeight(section, { 'width': 141, 'font-size': 10 });

            sectionHeight > 330 && catSection >= 3 ?
                $('[data-ws-content-id="2"]').addClass('extended') :
                $('[data-ws-content-id="2"]').removeClass('extended');
        }

        this.setCategoryInTab();
        this.setCategoryInAccordionTab();
    },
    categoryAccordion() {
        config.accordion($(this));
        needsSettings.switchLastActiveClass();
    },
    switchLastActiveClass() {
        $('[data-ws-cat-section]').siblings().removeClass('last-active')
        if ($('.expanded').last().next().hasClass('hidden') || $('.expanded').last().next().length == 0) {
            $('.expanded').last().addClass('last-active')
        }
    },
    initCategory() {
        let category = $(this).data('ws-cat');
        let categorySection = $(this).closest('.what-search__category-list');
        let categorySectionID = categorySection.data('ws-cat-section');

        needsSettings.state.categorySection = categorySectionID;
        needsSettings.state.category = category;

        needsSettings.adjustCategory();
    },
    setTabId(tabId) {
        console.log('setTabId')
        needsSettings.state.tab = tabId;
        needsSettings.adjustNodesTabs();
    },
    adjustNodesTabs(e) {
        console.log('adjustNodesTabs')
        console.log(needsSettings.state.tab)
        $('[data-ws-tab-id]').removeClass('selected');
        $('[data-ws-content-id]').hide();
        $('[data-ws-tab-id="' + this.state.tab + '"]').addClass('selected');
        $('[data-ws-content-id="' + this.state.tab + '"]').show();
        if (this.state.category) $('[data-ws-tab-id="' + 2 + '"]').addClass('selected');
        if (this.state.location) $('[data-ws-tab-id="' + 3 + '"]').addClass('selected');
    },
    adjustNeeds(e) {
        let icon = '';

        needsSettings.needNodes.forEach(el => {
            if (el.id == needsSettings.state.need)
                icon = el.icon;
        });

        $('.what-search__more-item_applications .what-search__more-icon use').attr('xlink:href', '/app/icons/sprite.svg#' + icon)
    },
    setSelect2ForNeeds(e) {
        console.log('setSelect2ForNeeds')
        $(".what-search__more-item_applications").click(() => $('.what-search__more-select').select2('open'));

        $('.what-search__more-select').select2({
            dropdownParent: $(".what-search__more-item_applications"),
            dropdownAutoWidth: true,
            minimumResultsForSearch: Infinity,
            templateResult: function formatState(state) {
                if (!state.id) return state.text;

                let icon = '';

                needsSettings.needNodes.forEach(el => {
                    if (el.name == state.text)
                        icon = el.icon;
                });

                var $state = $(
                    '<span><svg class="icon icon-' + icon + '" viewBox="0 0 20 20"><use xlink:href="/app/icons/sprite.svg#' + icon + '"></use></svg> ' + state.text + '</span>'
                );
                return $state;
            }
        }).data('select2').$dropdown.addClass('what-search-dd-applications');

        $('.what-search__more-select').on('change', function (e) {
            let currentNeed = $(this).val();

            needsSettings.needNodes.forEach(el => {
                if (el.name == currentNeed) needsSettings.state.need = el.id;
            });

            needsSettings.adjustNeeds()
        })
    },
    resetTab(e) {
        let thisTabId = $(this).parent().data('ws-tab-id');

        for (let i in needsSettings.nodesTabs) {
            let el = needsSettings.nodesTabs[i],
                id = el.id;

            if (thisTabId == id)
                $(this).siblings('.what-search__more-text').text(el.name)
        }

        $(this).hide();

        if (thisTabId == needsSettings.nodesTabs.category.id) {
            needsSettings.state.categorySection = 0;
            needsSettings.state.category = 0;
            needsSettings.adjustCategory();
        }
    },
    insertWSHTML(initNode, nodeForNeedsSettings) {
        let $initNode = typeof(initNode) == 'string' ? $(initNode):initNode;
        if ($initNode.hasClass('ws-init')) return;

        $initNode.addClass('ws-init');

        $('body').on("click", function deinitWS(e) {
            console.log($(e.target).closest('.ws-init'))
            if (!$(e.target).closest('.ws-init').length) {
                $('.what-search__more').remove();
                $initNode.removeClass('ws-init');
                $('body').off("click", deinitWS);
            }
        });

        $(nodeForNeedsSettings).append(needsSettings.needsHTMLcontent);

        needsSettings.initWS();
    },
    initWS() {
        needsSettings.setCategoryIDForItem();
        needsSettings.setSelect2ForNeeds();

        $(needsSettings.closeBtn).on("click", needsSettings.closeMoreSections);
        $(needsSettings.tabItem).on("click", function () {
            let thisTabId = $(this).data('ws-tab-id');
            needsSettings.setTabId(thisTabId)
        });
        $(needsSettings.categoryItem).on("click", needsSettings.initCategory);
        $(needsSettings.tabCloseBtn).on("click", needsSettings.resetTab);
        $('.what-search__category-headline').on("click", needsSettings.categoryAccordion);
    },
    init: () => {
        // needsSettings.insertWSHTML();
    },
};

export { needsSettings };
