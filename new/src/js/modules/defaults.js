import { config } from "../config";
import { Fancybox } from "../../../node_modules/@fancyapps/ui";
import ru from "../../../node_modules/@fancyapps/ui/src/Fancybox/l10n/ru.js";

var defaults = {
	sendMailBtn: '.j-send-need-mail',
	copyLinkBtn: '.j-copy-need-link',
	requireField: '.require, .require select, .require input',
	showMoreDropDownContainer: '.j-show-more-dd',
	showMoreDropDownBtn: '.j-show-more-dd-btn',
	placeNeedBtn: '.place-need',
	loading: {
		on() {
			$('body').append('<div class="loading"><img src="/infopart/img/loading.gif"></div>')
		},
		off() {
			$('body').remove('.loading')
		},
	},
	toggleMenu: (e) => {
		$("html, body").toggleClass("js-lock");
		$('.sidebar').toggleClass('is-active');

		$(document).on("click", function closeMenuFromOutside(e) {
			if (!$(e.target).closest('.sidebar').length) {
				$("html, body").toggleClass("js-lock");
				$('.sidebar').toggleClass('is-active');
				$(document).off("click", closeMenuFromOutside);
			}
		});
	},
	toggleSubmenu: function (e) {
		$('.submenu').toggleClass('is-active');

		if ($('.submenu').hasClass('is-active')) {
			let h = config.getElementHeight($('.submenu-nav__list'))
			$('.submenu-nav__inner').height(h)
		} else {
			$('.submenu-nav__inner').height('')
		}
		e.preventDefault();
	},
	submenuNavSlider: () => {
		if (window.innerWidth < 1024 || $('.submenu-nav__list').width() < $('.submenu-nav__inner').width()) {
			if ($('.submenu-nav__list').hasClass('slick-slider'))
				$('.submenu-nav__list').slick('unslick')
			return;
		}

		$('.submenu-nav__list:not(.slick-slider)').slick({
			slidesToShow: 4,
			variableWidth: true,
			infinite: false,
			swipe: false,
			prevArrow: '<div class="slick-prev"><svg class="icon icon-dropdown" viewBox="0 0 12 12"><use xlink:href="/app/icons/sprite.svg#dropdown"></use></svg></div>',
			nextArrow: '<div class="slick-next"><svg class="icon icon-dropdown" viewBox="0 0 12 12"> <use xlink:href="/app/icons/sprite.svg#dropdown"></use> </svg></div>',
		});

		$('.submenu-nav__list .slick-arrow').on('click', function (event, slick, direction) {
			let lastSlide = $('.submenu-nav__item:last-child');
			let lastSlideWidth = lastSlide.width() * ($(this).hasClass('slick-next') ? 1 : -1);
			let sliderCoordX = $('.submenu-nav__list')[0].getBoundingClientRect().right;
			let itemCoordX = lastSlide[0].getBoundingClientRect().right;

			((itemCoordX - lastSlideWidth) <= sliderCoordX) ?
				$('.slick-next').fadeOut() :
				$('.slick-next').fadeIn();
		});
	},
	adjustRequireFields: function () {
		if ($(this).val().length) {
			if ($(this).closest('.input-select-box').length || $(this).closest('.select-box').length) {
				$(this).closest('.require').removeClass('require')
			} else {
				$(this).removeClass('require')
			}
		} else {
			if ($(this).closest('.input-select-box').length) {
				$(this).closest('.input-select-box').addClass('require')
			} else if ($(this).closest('.select-box').length) {
				$(this).closest('.select-box').addClass('require')
			} else {
				$(this).addClass('require')
			}
		}
	},
	placeActiveFocusToggle() {
		$(this).addClass('is-on')

		$(document).on("click", function closePlaceNeedFromOutside(e) {
			if (!$(e.target).closest(defaults.placeNeedBtn).length) {
				$(defaults.placeNeedBtn).removeClass('is-on');
				$(document).off("click", closePlaceNeedFromOutside);
			}
		});
	},
	btnRouter() {
		let action = $(this).data('btn');
		switch (action) {
			case 'subscribe':
				let btnState = +$(this).data('state');

				if (!btnState) {
					$(this).data('state', 1)
						.addClass('btn-double btn-double_white-blue')
						.removeClass('btn_blue')
						.html(`
                        <div class="btn-double__item cards-info__action-btn-buy"><span class="btn-double__text">Заявки</span>
                        </div>
                        <div class="btn-double__item cards-info__action-btn-sell"><span class="btn-double__text">Объявления</span>
                        </div>
                    `)
				} else if (btnState == 1) {
					$(this).data('state', 2)
						.css('transition', 'unset')
						.addClass('btn_white-bd')
						.removeClass('btn-double btn-double_white-blue')
						.html('<span>Отписаться</span>');
					config.openModal('.subscription-emex-modal')
				} else if (btnState == 2) {
					$(this).data('state', 0)
						.css('transition', '')
						.removeClass('btn_white-bd')
						.addClass('btn_blue')
						.find('span').text('Подписаться');
				}
				break;
			case 'show-phone':
				$(this).addClass('btn_gray-bd').removeClass('btn_blue').text('+7 (917) 775-67-98');
				break;
		}
	},
	// placeNeedFocusOut() {
	// 	$(this).removeClass('is-focus')
	// },
	// showMoreDropDown(startText, endText) {
	//     let container = $(this).closest(defaults.showMoreDropDownContainer);
	//     let thisText = $(this).find('span');

	//     container.toggleClass('more-on');

	//     container.hasClass('more-on') ?
	//         thisText.text(startText) :
	//         thisText.text(endText);
	// },
	init: () => {
		$(".ham").on("click", defaults.toggleMenu);
		$('.submenu-nav__item:first-child').on("click", defaults.toggleSubmenu);
		$(defaults.placeNeedBtn).on("click", defaults.placeActiveFocusToggle);
		$(document).on("click", '.btn[data-btn]', defaults.btnRouter);
		// $(defaults.placeNeedBtn).on("bind", defaults.placeActiveFocusToggle);

		defaults.submenuNavSlider();

		$(window).on('resize', function () {
			defaults.submenuNavSlider();
		})

		$('body').on("click", '[data-close="close"]', config.closeModal);
		$('body').on("click", '.cards-info__status-name-text', () => config.openModal('.need-history-modal'));

		$(defaults.requireField).on("change", defaults.adjustRequireFields);

		Fancybox.defaults.l10n = ru;
		Fancybox.defaults.Toolbar = {
			display: [
				"close",
			],
		};

		$('.hints .icon-cross').on("click", function () {
			$(this).closest('.hints__inner').children().length == 1 ?
				$(this).closest('.hints').remove() :
				$(this).parent().remove();
		});

		// window.onload = () => config.openModal('.offers-modal')

		// $(defaults.showMoreDropDownBtn).on('click', function () { defaults.showMoreDropDown('Еще', 'Свернуть') })

	},
};

export { defaults };