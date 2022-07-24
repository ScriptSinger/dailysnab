var config = {
	getElementSize: (el, val, cssProps) => {
		let clone = el.clone(),
			cssSettings = {
				'position': 'fixed',
				'top': '0',
				'left': '0',
				'overflow': 'auto',
				'visibility': 'hidden',
				'height': 'unset',
				'pointer-events': 'none',
				'max-height': 'unset',
			};

		if (cssProps) {
			for (let key in cssProps) {
				cssSettings[key] = cssProps[key];
			}
		}

		clone.css(cssSettings);
		$('body').append(clone);
		let height = clone[0].getBoundingClientRect().height;
		let width = clone[0].getBoundingClientRect().width;
		clone.remove();

		if (val == 'height') {
			return height;
		} else if (val == 'width') {
			return width;
		}
	},
	getElementHeight: (el, cssProps) => {
		return config.getElementSize(el, 'height', cssProps);
	},
	getElementWidth: (el, cssProps) => {
		return config.getElementSize(el, 'width', cssProps);
	},
	openModal(selector) {
		config.closeModal();
		$("html, body").toggleClass("js-lock");
		$(selector).fadeIn()

		return false;
	},
	closeModal() {
		$("html, body").removeClass("js-lock");
		$('.modal').fadeOut()
	},
	accordion(ctx) {
		let $this = ctx.length ? ctx : $(this);
		$this.next().slideToggle().parent().toggleClass('expanded');
		return false;
	},
	copyToBuffer(copyText) {
		let body = document.querySelector('body');
		let tempInput = document.createElement('textarea');

		tempInput.value = copyText;

		body.appendChild(tempInput);

		tempInput.select();
		tempInput.setSelectionRange(0, 99999);

		document.execCommand('copy');

		tempInput.parentNode.removeChild(tempInput);
		return false;
	},

};

export { config };
