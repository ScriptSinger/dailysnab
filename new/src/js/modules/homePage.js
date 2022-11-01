import { config } from "../config";

var homePage = {
    section: '.home-page',
    manageBlock: '.manage-block',
    // placeNeed: '.place-need',
    // enter: '.home-page__enter',
    // whatSearch: '.what-search',
    mainNodesActive: 0, // 1 - enter, 2 - place needs, 3 - input search
    mainNodes: [
        {
            selector: '.home-page__enter',
            dependencySelector: ['.registration-modal', '.j-reg-next'],
            id: 1
        },
        {
            selector: '.place-need',
            id: 2
        },
        {
            selector: '.what-search',
            id: 3
        },
    ],
    adjustMainNodesActive(eTarget) {
        let isTargetMainNode = false;

        homePage.mainNodes.forEach((el) => {
            let mainNode = $(el.selector);
            let isMainNode = $(eTarget).closest(el.selector).length;
            let isDependencyOfMainNode = eTarget.closest(el.dependencySelector);
            // console.log($(eTarget))
            // console.log($(eTarget).parent())
            // console.log($(eTarget).closest('.modal'))
            if (isMainNode || isDependencyOfMainNode) {
                mainNode.addClass('is-focus')
                mainNode.removeClass('collapse')
                homePage.mainNodesActive = el.id;
                isTargetMainNode = true;
            } else {
                mainNode.removeClass('is-focus')
                mainNode.addClass('collapse')

                // $(mainNode).animate({
                //     width: '30',
                // }, 1000, function () {
                //     // Animation complete.
                // });
                // $(".what-search").animate({
                //     width: '30',
                // }, 3000, function () {
                //     // Animation complete.
                // });
            }
        });

        if (!isTargetMainNode) homePage.mainNodesActive = 0;
        if (!homePage.mainNodesActive) $('.collapse').removeClass('collapse')
    },
    initMainNodes(e) {
        // console.log(e.target)
        homePage.adjustMainNodesActive(e.target)
    },
    extendManageBlock() {
        $(this).toggleClass('extended');

        // $(document).on("click", function collapseManageBlock(e) {
        // 	if (!$(e.target).closest(homePage.manageBlock).length) {
        // 		$(homePage.manageBlock).removeClass('extended');
        // 		$(document).off("click", collapseManageBlock);
        // 	}
        // });
    },
    init: () => {
        if (!location.href.includes('main')) return;

        $('body').on("click", homePage.initMainNodes);
        $(homePage.manageBlock).on("mouseenter mouseleave", homePage.extendManageBlock);
    },
};

export { homePage };