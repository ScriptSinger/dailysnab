import { config } from "../config";
import { needsSettings } from "./needsSettings";

var needsPublish = {
    state: {
        slide: 1,
    },
    changeState() {
        let thisSlideState = $(this).data('next');
        console.log(thisSlideState)
        $('.needs-modal__need-name-input').find('input').removeClass('error');

        if (thisSlideState == 1) {
            if ($('.needs-modal__need-name-input').find('input').val() < 2) {
                $('.needs-modal__need-name-input').find('input').addClass('error')
                return;
            }
        }

        needsPublish.state.slide = $(this).data('next') + 1;
        $('[data-next]').data('next', needsPublish.state.slide);
        needsPublish.adjustContent();
    },
    adjustContent() {
        $('.what-search__suggested, .what-search__features').hide();

        if (needsPublish.state.slide == 1) {
            $('.needs-modal__bottom .btn_blue')
                .replaceWith(`<div class="needs-modal__next btn btn_blue btn_m" data-next="1">Продолжить</div>`);
        } else if (needsPublish.state.slide == 2) {
            $('.what-search__more').show()
            needsSettings.setTabId(4)
        } else if (needsPublish.state.slide == 3) {
            needsSettings.setTabId(5)
            $('.needs-modal__bottom .btn_blue').replaceWith(`
                <div class="needs-modal__publish btn btn_blue btn_dropdown btn_m">Опубликовать
                    <svg class="icon icon-dropdown cards-info__action-btn-icon" viewBox="0 0 12 12">
                        <use xlink:href="/app/icons/sprite.svg#dropdown"></use>
                    </svg>
                </div>`);
        } else if (needsPublish.state.slide == 4) {
            $('.needs-modal__bottom .btn_blue')
                .replaceWith(`<div class="needs-modal__next btn btn_blue btn_m" data-next="2">Продолжить</div>`);
        }
    },
    clearForm() {
        $('.what-search__features-form')[0].reset()
    },
    openModal() {
        needsPublish.state.slide = 1;
        needsPublish.adjustContent();
        config.openModal('.needs-modal');
        needsSettings.insertWSHTML('.needs-modal', '.needs-modal__needs');
    },
    resetNeeds() {
        config.closeModal();
        needsPublish.state.slide = 1;
        setTimeout(() => {
            needsPublish.adjustContent();
        }, 350);
    },
    init: () => {
        $(document).on('click', '.place-need__double', needsPublish.openModal)
        $(document).on('click', '[data-next]', needsPublish.changeState)
        $(document).on('click', '.what-search__features-clear-form', needsPublish.clearForm)
        $(document).on('click', '[data-ws-tab-id]', function () {
            if (needsPublish.state.slide == 3) {
                needsPublish.state.slide = 4;
                needsPublish.adjustContent();
            }
        })

        $(document).on('click', '.j-open-category-section', () => $('[data-ws-tab-id="2"]').trigger('click'))
        $(document).on('click', '.needs-modal__publish', needsPublish.resetNeeds)


        // window.onload = () => config.openModal('.needs-modal');
    },
};
export { needsPublish };