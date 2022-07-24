import { config } from "../config";
import { Fancybox } from "../../../node_modules/@fancyapps/ui";

var product = {
    sliderMainEL: '.product__slider-main',
    sliderThumbnailsEL: '.product__slider-thumbnails',
    showMoreBtn: '.product__params-item_adds',
    aside: '.product__aside',
    showPhoneBtn: '.product__show-phone',
    switchSlideForHover(e) {
        var $currTarget = $(e.currentTarget),
            index = $currTarget.data('slick-index'),
            slickObj = $(product.sliderThumbnailsEL).slick('getSlick');
        slickObj.slickGoTo(index);
    },
    reassignmentImgLinks(e) {
        let itemId = $(this).data('slick-index'),
            imgItem = $(product.sliderThumbnailsEL).find('[data-slick-index="' + itemId + '"]').find('img');
        // imgItem.bind('click')
        // Fancybox.bind("[data-fancybox]", {
        //     infinite: false,
        //   });
        // console.log($(product.sliderThumbnailsEL).find('[data-slick-index="' + itemId + '"]'))
        // e.preventDefault();
        // return false;
        // setTimeout(() => {
        //     Fancybox.getInstance().jumpTo(3)
        // console.log(Fancybox.getInstance())

        // }, 200);
        // Fancybox.show('[data-fancybox="product-imgs"]');
        console.log(imgItem)
        imgItem.trigger('click');
        return false;
    },
    showMoreDropDown() {
        $(this).toggleClass('more-on');
    },
    showPhone() {
        $(this).closest(product.aside).addClass('is-open');
    },
    init: () => {
        $(product.sliderThumbnailsEL).on('mouseenter', '.slick-slide', product.switchSlideForHover);
        $(product.sliderMainEL).on('click', '.slick-slide', product.reassignmentImgLinks);
        $(product.showMoreBtn).on('click', product.showMoreDropDown)
        $(product.showPhoneBtn).on('click', product.showPhone)

        // Fancybox.bind(".product__slider-main-item", {
        //     startIndex: 2
        // });
        // Fancybox.bind('[data-fancybox-trigger="product-imgs"]', {
        //     on: {
        //         load: (fancybox, slide) => {
        //             console.log(fancybox)
        //             console.log(slide)
        //             // Fancybox.getInstance().jumpTo(3)
        //         },
        //     },
        // });

        $(product.sliderMainEL).slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            waitForAnimate: false,
            fade: true,
            asNavFor: product.sliderThumbnailsEL,
            infinite: false,
            prevArrow: '<div class="slick-prev"><svg class="icon icon-dropdown" viewBox="0 0 12 12"> <use xlink:href="/app/icons/sprite.svg#dropdown"></use></svg></div>',
            nextArrow: '<div class="slick-next"><svg class="icon icon-dropdown" viewBox="0 0 12 12"> <use xlink:href="/app/icons/sprite.svg#dropdown"></use></svg></div>',
        });
        $(product.sliderThumbnailsEL).slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            waitForAnimate: false,
            asNavFor: product.sliderMainEL,
            arrows: false,
            swipe: false,
            infinite: false,
        });
    },
};

export { product };
