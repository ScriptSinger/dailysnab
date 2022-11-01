import { config } from "../config";
import { needsSettings } from "./needsSettings";

var whatSearch = {
    block: '.what-search',
    blockDropdownBtn: '.search-all-form .ac-group__icon-dropdown',
    openMoreSections: function () {
        console.log('openMoreSections')
        $(this).closest(whatSearch.block).toggleClass('is-active')
        $(document).on("click", whatSearch.closeMoreSectionsFromOutside);
    },
    closeMoreSections: function () {
        console.log('closeMoreSections')
        $(whatSearch.block).removeClass('is-focus is-active');
        $('.what-search__more-section').hide();
    },
    closeMoreSectionsFromOutside(e) {
        if (!$(e.target).closest(whatSearch.block + '.is-active').length) {
            whatSearch.closeMoreSections();
            $(document).off("click", whatSearch.closeMoreSectionsFromOutside);
        }
    },
    init: () => {
        $(whatSearch.blockDropdownBtn).on("click", whatSearch.openMoreSections);
        $(whatSearch.block).on("mouseenter", function() {
            needsSettings.insertWSHTML($(this), '.what-search__inner');
        });

    },
};

export { whatSearch };
