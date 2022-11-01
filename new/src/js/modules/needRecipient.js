import { config } from "../config";

var needRec = {
	card: '.cards__item',
	contentSection: '.section',
	cardCheckbox: '.cards-top__checkbox',
	cardLink: '.cards-top__item-name-text',
	cancelBtn: '.j-cancel-need-recipient',
	selectBtn: '.j-select-need-recipient',
	checkbox: '.j-cb-share-need',
	checkboxAll: '.j-cb-share-need-all',
	sendMailBtn: '.j-send-need-mail',
	copyLinkBtn: '.j-copy-need-link',
	nameCompany: '.j-needs-name',
	submenu: '.submenu',
	shareNeedMenu: '.share-need',
	openShareNeedMenuBtn: '.j-open-share-need-menu',
	groupLegalForm: '.modal_edit-card .form__legal-form',
	groupCalc: '.modal_edit-card .form__calculations',
	selectAllNeeds: function () {
		$(this).prop("checked") ?
			$(needRec.checkbox).prop("checked", true) :
			$(needRec.checkbox).prop("checked", false);
	},
	takeOffCheckboxAllNeeds: function () {
		$.each($(needRec.checkbox), function () {
			if (!$(this).prop("checked")) $(needRec.checkboxAll).prop("checked", false)
		})
	},
	closeShareNeedMenu: () => {
		$(needRec.checkbox).prop("checked", false)
		$(needRec.checkboxAll).prop("checked", false)
	},
	openModalSendingNeeds: function () {
		if (!$(needRec.checkbox + ':checked').length) return false;

		config.openModal('.sending-needs-modal');
	},
	sendMail: function () {
		config.openModal('.need-sent-modal');
	},
	copyLinks: function () {
		let selectedNeedsLink = [];

		$.each($(needRec.checkbox + ':checked'), function () {
			let thisLink = $(this).closest(needRec.card).find(needRec.cardLink).attr('href');

			selectedNeedsLink.push(thisLink)
		})

		config.copyToBuffer(selectedNeedsLink)
		config.openModal('.link-copied-modal');
	},
	openShareNeedMenu: function () {
		$(needRec.submenu).hide();
		$(needRec.shareNeedMenu).show();
		$(needRec.contentSection).find(needRec.cardCheckbox).show();
	},
	closeShareNeedMenu: function () {
		$(needRec.submenu).show();
		$(needRec.shareNeedMenu).hide();
		$(needRec.contentSection).find(needRec.cardCheckbox).hide();
	},
	adjustCreateSupplierFields: function () {
		$(this).val() == "fl" ?
			$(needRec.groupCalc).hide() :
			$(needRec.groupCalc).show();

	},
	// q: function () {
	// 	$(nameCompany).select2({
	// 		tags: true,
	// 		tokenSeparators: [',', ' ']
	// 	})
	// },
	q: function () {
		// <div class="create-supplier btn btn_blue btn_m">Создать поставщика</div>
		config.openModal('.create-supplier-modal');
	},
	init: () => {
		$(needRec.cancelBtn).on("click", needRec.closeShareNeedMenu);
		$(needRec.checkboxAll).on("change", needRec.selectAllNeeds);
		$(needRec.checkbox).on("click", needRec.takeOffCheckboxAllNeeds);
		$(needRec.selectBtn).on("click", needRec.openModalSendingNeeds);
		$(needRec.sendMailBtn).on("click", needRec.sendMail);
		$(needRec.copyLinkBtn).on("click", needRec.copyLinks);
		$(needRec.openShareNeedMenuBtn).on("click", needRec.openShareNeedMenu);
		$(needRec.groupLegalForm).find('select').on("change", needRec.adjustCreateSupplierFields);

		$(needRec.nameCompany).on("click", needRec.q);

		// var availableTags = [
		// 	"Тимур",
		// 	"AppleScript",
		// 	"AppleScript",
		// 	"AppleScript",
		// 	"Asp",
		// 	"BASIC",
		// ];
		// $(needRec.nameCompany).autocomplete({
		// 	source: availableTags,
		// 	response: function (event, ui) {
		// 		$(this).data( "ui-autocomplete" )._renderItem = function (ul, item) {
		// 			console.log(1)
		// 			console.log(ul)
		// 			console.log(item)
		// 			// return $("<li></li>").data("item.autocomplete", item).append("<div>" + item.label + "</div>").appendTo(ul);
		// 			$("<li></li>").data("item.autocomplete", item).append(`<div class="create-supplier btn btn_blue btn_m">Создать поставщика</div>`).appendTo(ul)
		// 			// return $("<li></li>").data("item.autocomplete", item).append(`<div class="create-supplier btn btn_blue btn_m">Создать поставщика</div>`).appendTo(ul);
		// 			return false;
		// 		};
		// 		// if (!ui.content.length)
		// 	}
		// })
		// window.onload = config.openModal('.create-supplier-modal');

		// $( '.j-needs-name' ).autocomplete( "instance" )
	},
};
export { needRec };
