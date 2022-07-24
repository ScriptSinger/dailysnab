import { config } from "../config";

var brandGroups = {
    btn: '.j-brand-gr-btn',
    modalCode: `
        <div class="play-video-modal modal">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>`,
    startVideo() {
        // if (!$('.play-video-modal').length) {
        //     $('body').append(playVideo.modalCode);
        // }
        // config.openModal('.play-video-modal');
    },
    init: () => {
        // $(document).on('click', playVideo.btn, playVideo.startVideo)
        // window.onload = ()=> config.openModal('.brand-groups-modal')
        // $('.brand-groups-modal select').select2();s
    },
};

export { brandGroups };