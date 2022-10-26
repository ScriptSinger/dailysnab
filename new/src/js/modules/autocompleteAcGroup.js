import { config } from "../config";
import { defaults } from "./defaults";
import { needsSettings } from "./needsSettings";

var acGroup = {
    searchInput: '.ac-group__input',
    searchForm: '.ac-group',
    listForSearchAllForm: [
        {
            label: "Scania P400",
            cats: ['История', 'Грузовики']
        },
        {
            label: "Scania P4001",
            cats: ['История', 'Грузовики', 'Техника']
        },
        {
            label: "Scania P4002",
            cats: ['История']
        },
        {
            label: "Scania P4002",
            cats: ['История', 'Грузовики', 'Техника']
        },
        {
            label: "Scania P4002",
            cats: ['История', 'Грузовики']
        },
        {
            label: "Scania P4002",
            cats: ['История', 'Грузовики']
        },
        {
            label: "Scania P4002",
            cats: ['История', 'Грузовики']
        },
        {
            label: "Scania P4002",
            cats: ['История', 'Грузовики']
        },
    ],
    listForLocationForm: [
        {
            label: "Уфа",
            district: ", Республика Башкирстан",
        },
        {
            label: "Верхний Уфалей",
            district: ", Челябинская область",
        },
        {
            label: "д. Уфа",
            district: ", р-н Каширский, Пермский край ",
        },
        {
            label: "Уфа",
            district: ", Республика Башкирстан",
        },
        {
            label: "Верхний Уфалей",
            district: ", Челябинская область",
        },
        {
            label: "д. Уфа",
            district: ", р-н Каширский, Пермский край ",
        },
    ],
    autocompleteForAcGroup() {
        if (location.href.includes('infoPart')) return;

        let form = $(this).closest('form'),
            currentNode = {};



        if (form.hasClass('search-all-form')) {
            currentNode.id = needsSettings.nodesTabs.category.id;
            currentNode.source = acGroup.listForSearchAllForm;
            // currentNode.appendTo = '.what-search__inner';
            currentNode.class = 'ac-group-menu_search-all';
        } else if (form.hasClass('location-form')) {
            currentNode.id = needsSettings.nodesTabs.location.id;
            currentNode.source = acGroup.listForLocationForm;
            // currentNode.appendTo = '.what-search__inner';
            currentNode.class = 'ac-group-menu_location';
        }
        console.log(form)
        $(this).autocomplete({
            // appendTo: currentNode.appendTo,
            appendTo: $(this).closest('.what-search__inner'),
            minLength: 0,
            source: function (request, response) {
                $.post("/autocomplete_search_k", { value: request.term },
                    function (postResponse) {
                        let responseData = JSON.parse(postResponse);
                        console.log(responseData)
                        response(responseData.data);
                    }
                );
            },
            position: {
                at: "left bottom",
                collision: "none",
                my: "left top",
                of: form,
            },
            response: function (event, ui) {
                if (!ui.content.length) {
                    let noResult = { value: "", label: "Совпадений не найдено" };
                    ui.content.push(noResult);
                }
                form.addClass('search-on')
            },
            close: function (event, ui) {
                form.removeClass('search-on')
            },
            select: function (event, ui) {
                $(this).val(ui.item.label);
                if (currentNode.id == 3) {
                    needsSettings.state.location = ui.item.value + ui.item.district;
                    needsSettings.setCategoryInTab();
                }
                return false;
            }
        }).autocomplete("instance")._renderMenu = function (ul, items) {
            let that = this;

            this._resizeMenu = function () {
                console.log(form.width())
                this.menu.element.outerWidth(form.width() + 2);
            };

            this._renderItem = function (ul, item) {
                console.log(item)
                let secondaryList = '',
                    itemLabel = item.label;

                if (item.cats)
                    item.cats.forEach(el => {
                        secondaryList += `
                                <div class="ac-group-menu__cat">
                                    <span class="ac-group-menu__icon"><svg class="icon icon-arrowLong " viewBox="0 0 18 18"> <use xlink:href="/infopart/icons/sprite.svg#arrowLong"></use> </svg></span>
                                    <span class="ac-group-menu__cat-name">` + el + `</span>
                                </div>
                                `;
                    });
                if (item.district) {
                    secondaryList += `<span>` + item.district + `</span>`;
                    itemLabel = '<b>' + item.label + '</b>';
                }

                return $("<li>").addClass('ac-group-menu__li')
                    .append('<div class="ac-group-menu__item">' + itemLabel + secondaryList + '</div>')
                    .appendTo(ul);
            };

            $.each(items, function (index, item) {
                that._renderItemData(ul, item)
            });

            $(ul).addClass("ac-group-menu").addClass(currentNode.class);
        }
    },
    searchBrands(e) {
        // let formdata = new FormData();
        // let term = $(this).find('input').val();
        // formdata.append('value', term);
        // formdata.append('where', '/infopart');
        // formdata.append('group', '');
        // formdata.append('flag', 'infopart');
        // $.post('/search_brend_etp', formdata)
        e.preventDefault();

        let term = $(this).find('input').val();

        SearchBuySell(term, '', true, 'infopart');

        function SearchBuySell(value, group, enter13, flag) {
            if (!(/^[0-9]{3,9}$/g.test(value))) {
                $.notify('Введите корректный артикул', "error");
                return;
            }
            if (enter13 && value) {// проверяем выводить вопросы для Этп (бренды), только по нажатию клавиши enter
                $.post("/search_brend_etp", { value: value, where: '/infopart', group: group, flag: flag },
                    function (response) {
                        let data = JSON.parse(response)
                        console.log(data)
                        if (data.code) {
                            let modalCode = `
                                <div class="search-brands-modal modal">
                                    <div class="modal__container">
                                        <div class="modal__inner">
                                            <div class="modal__content">
                                                <div class="modal__close" data-close="close">
                                                    <svg class="icon icon-cross " viewBox="0 0 24 24">
                                                        <use xlink:href="/infopart/icons/sprite.svg#cross"></use>
                                                    </svg>
                                                </div>
                                                <div class="modal__body">
                                                    ${data.code}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                            $('body').append(modalCode);
                            config.openModal('.search-brands-modal')
                            $(".search_brend_etp").on("click", function () {
                                defaults.loading.on();
                                var dd = $(this).data();

                                $(this).remove();

                                var values = {};
                                $(".checkbox_qrq_article_id_").each(function (indx, element) {
                                    if ($(element).prop('checked')) {
                                        var dd = $(element).data();
                                        var addmenu = { brand: dd.brand };
                                        values[indx] = addmenu;

                                    }
                                });

                                $.post("/get_sell_by_amo_accountsetp", { values: values, value: value, categories_id: dd.categories_id },
                                    function (response) {
                                        let data = JSON.parse(response)

                                        defaults.loading.off();

                                        if (data.ok) {
                                            SearchBuySell(value, group, false, 'etp_sell');
                                        } else {
                                            $.notify(data.code, "error");
                                        }
                                    }
                                );

                            });
                            $(".no_search_brend_etp").on("click", function () {
                                SearchBuySell(value, group, false);
                            });
                        } else {
                            SearchBuySell(value, group, false);
                        }
                    }
                );
            } else {
                $.post("/search_buy_sell", {
                    value: value,
                    where: '/infopart',
                    group: group,
                    enter13: enter13,
                    flag: flag
                },
                    function (response) {
                        let data = JSON.parse(response)
                        console.log(data)
                        location.href = data.url
                    }
                );

            }

            return false;
        };
    },
    init: () => {
        $(document).on('click', acGroup.searchInput, acGroup.autocompleteForAcGroup)
        $(document).on('submit', '.search-all-form', acGroup.searchBrands)
    },
};

export { acGroup };
