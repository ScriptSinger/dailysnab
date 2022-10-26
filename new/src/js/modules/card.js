import { config } from "../config";
import { Fancybox } from "../../../node_modules/@fancyapps/ui";

var card = {
    state: {
        customSizeCardWidth: undefined,
    },
    item: '.cards__item',
    content: '.cards__content',
    daysNumBlock: '.cards-info__nums-days',
    daysNum: '.j-cards-nums-days',
    daysNumScale: '.cards-info__nums-days-scale-thumb',
    manageItem: '.cards-info__manage-item',
    openOffersBtn: '.j-open-offers',
    cardMenuBtn: '.cards-info__menu',
    offers: '.cards-write-offers',
    openOffersModalBtn: '.j-modal-offers-open',
    offersModal: '.offers-modal',
    showMoreOffersBtn: '.cards-write-offers__show-more',
    turnBtn: '.cards-info__action-btn.btn_white-bd',
    infoBtn: '.cards-info__action-btn',
    editCardSubscribtions: '.cards_subscriptions .cards-info__manage-item-icon',
    gallery: '.cards-gallery',
    galleryInner: '.cards-gallery__inner',
    galleryItem: '.cards-gallery__item',
    daysScale: (el) => {
        $.each($(card.daysNumBlock), function () {
            let daysNumVal = +$(this).find(card.daysNum).text();

            if (daysNumVal < 5) $(this).find(card.daysNumScale).addClass('red');

            $(this).find(card.daysNumScale).width(daysNumVal / 1.5);
        })
    },
    manageItemToggle: function () {
        let item = $(this).closest(card.item);
        item.toggleClass('offers-on')
    },
    menuToggle: function () {
        let item = $(this).closest(card.content);
        item.toggleClass('menu-on');
        console.log(item.hasClass('menu-on'))
        if (item.hasClass('menu-on')) {
            let el = item.find('.cards-bottom__category');
            let elText = item.find('.cards-bottom__category-text');
            let elWidth = config.getElementWidth(elText);

            el.css('width', elWidth)
        } else {
            let el = item.find('.cards-bottom__category');

            el.css('width', '')
        }
    },
    showMore: function () {
        let offers = $(this).closest(card.offers);
        let thisText = $(this).find('span');

        offers.toggleClass('more-on');

        offers.hasClass('more-on') ?
            thisText.text('Свернуть') :
            thisText.text('Еще');
    },
    openOffersModal: function () {
        config.openModal(card.offersModal);
        $(card.galleryInner).slick('unslick')
        card.gallerySlider();
    },
    gallerySlider: function () {
        if (window.innerWidth > 1023) {
            if ($(card.galleryInner).hasClass('slick-slider'))
                $(card.galleryInner).slick('unslick')
            return;
        }
        if ($(card.galleryInner).hasClass('slick-slider'))
            return;
        $(card.galleryInner).slick({
            slidesToShow: 1,
            infinite: false,
            arrows: false,
            dots: true,
        })
    },
    hoverOnContent() {
        let publishedNode = $(this).find('.cards-info__status-published');
        let categoryNode = $(this).find('.cards-bottom__category');
        
        if (window.innerWidth < 1024 || card.state.customSizeCardWidth <= 824) return;

        if (publishedNode.length) {
            let publishedNodeText = $(this).find('.cards-info__status-published-text');
            let publishedNodeHeight = config.getElementHeight(publishedNodeText);

            publishedNode.css('height', publishedNodeHeight)
        }
        if (categoryNode.length) {
            let categoryNodeText = $(this).find('.cards-bottom__category-text');
            let categoryNodeWidth = config.getElementWidth(categoryNodeText);

            categoryNode.css('width', categoryNodeWidth)
        }
    },
    hoverOutContent() {
        let publishedNode = $(this).find('.cards-info__status-published');
        let categoryNode = $(this).find('.cards-bottom__category');

        if (window.innerWidth < 1024 || card.state.customSizeCardWidth <= 824) return;

        if (publishedNode.length) publishedNode.css('height', '');
        if (categoryNode.length) categoryNode.css('width', '');
    },
    switchCardSize() {
        let cardsNode = $('[data-cards="cus-size"]');
        card.state.customSizeCardWidth = cardsNode.width();
        console.log(cardsNode.width())
        if (cardsNode.width() < 748) {
            cardsNode.removeClass('cards_tablet');
            cardsNode.addClass('cards_mob');
        } else if (cardsNode.width() <= 824) {
            cardsNode.removeClass('cards_mob');
            cardsNode.addClass('cards_tablet');
        } else if (cardsNode.width() > 824) {
            cardsNode.removeClass('cards_tablet');
            cardsNode.removeClass('cards_mob');
        }
    },
    switchCardSizeCall() {
        card.switchCardSize();
        $(window).on('resize', resizeThrottler);
        var resizeTimeout;
        function resizeThrottler() {
            if (!resizeTimeout) {
                resizeTimeout = setTimeout(function () {
                    resizeTimeout = null;
                    card.switchCardSize();
                }, 66);
            }
        }
    },
    editSubscriptionUserModal() {

    },
    init: () => {
        card.daysScale();
        $(card.openOffersBtn).on('click', card.manageItemToggle)
        $(card.turnBtn).on('click', card.manageItemToggle)
        $(card.cardMenuBtn).on('click', card.menuToggle)
        $(card.showMoreOffersBtn).on('click', card.showMore)
        $(card.openOffersModalBtn).on('click', card.openOffersModal)
        $(card.editCardSubscribtions).on('click', () => {
            console.log(1)
            config.openModal('.edit-subs-user-modal')
        })

        if ($('[data-cards="cus-size"]').length) {
            card.switchCardSizeCall();
        }

        $(card.content).hover(card.hoverOnContent, card.hoverOutContent)

        card.gallerySlider();

        $(window).on('resize', () => card.gallerySlider());

        Fancybox.bind(card.galleryItem, {
            infinite: false,
        });


        // const swiper = new Swiper('.swiper', {
        // // Optional parameters
        // direction: 'vertical',
        // loop: true,

        // // If we need pagination
        // pagination: {
        //   el: '.swiper-pagination',
        // },

        // // Navigation arrows
        // navigation: {
        //   nextEl: '.swiper-button-next',
        //   prevEl: '.swiper-button-prev',
        // },

        // // And if we need scrollbar
        // scrollbar: {
        //   el: '.swiper-scrollbar',
        // },
        //   });
    },
};

export { card };
