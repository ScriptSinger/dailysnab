import { config } from "../config";
import tippy from '../../../node_modules/tippy.js';

var tips = {
    addListViewInCardBtn: '.cards-write-offers__list',
    manageWarningCardBtn: '.cards-info__manage-warning',
    subscriptionEmexInfoBn: '.subscription-emex-modal__info-btn',
    
    init: () => {
        tippy(tips.addListViewInCardBtn, {
            content: 'Скоро появится возможность добавлять списком',
            delay: 200,
            maxWidth: '36rem',
        });
        tippy(tips.manageWarningCardBtn, {
            content: 'Скоро можно будет писать об ошибках',
            delay: 200,
        });
    },
};
export { tips };
