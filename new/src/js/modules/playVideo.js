import { config } from "../config";

var playVideo = {
    btn: '.j-v-play',
    modalCode: `
        <div class="play-video-modal modal">
            <div class="modal__container">
                <div class="modal__inner">
                    <div class="modal__content">
                        <div class="modal__close" data-close="close">
                            <svg class="icon icon-cross " viewBox="0 0 24 24">
                                <use xlink:href="/infopart/icons/sprite.svg#cross"></use>
                            </svg>
                        </div>
                        <div class="modal__body">
                            <div class="play-video-modal__video">
                                <iframe src="https://www.youtube.com/embed/FGUp-8BzJU0?autoplay=1&enablejsapi=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`,
    startVideo() {
        if (!$('.play-video-modal').length) {
            $('body').append(playVideo.modalCode);
        }
        config.openModal('.play-video-modal');
    },
    stopVideo() {
        $('iframe')[0].contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*')
    },
    init: () => {
        $(document).on('click', playVideo.btn, playVideo.startVideo)
        $(document).on('click', '.play-video-modal [data-close="close"]', playVideo.stopVideo)
    },
};
export { playVideo };
