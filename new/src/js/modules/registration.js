import { config } from "../config";
import { notifyjs } from "../../../node_modules/notifyjs-browser/dist/notify";

var regCtx = {
    state: {
        slide: 1,
        userContact: false,
    },
    btnLogin: '.j-login',
    slides: {
        1: {
            modalClasses: 'registration-modal_simple',
            headText: 'Вход и&nbsp;Регистрация',
            body: `
                <div class="modal__advantages">
                    <p class="modal__advantages-p">Быстро</p>
                    <p class="modal__advantages-p">Эффективно</p>
                    <p class="modal__advantages-p">удобно</p>
                        <p class="modal__advantages-p">бесплатно</p>
                </div>
                <form class="modal__form form registration-form">
                    <div class="form-group">
                        <input class="input registration-form__email" type="text" placeholder="Телефон или&nbsp;E-mail" name="email">
                    </div>
                    <div class="form-group">
                        <input class="input registration-form__pass" type="password" placeholder="Пароль" name="pass">
                    </div><a class="modal__get-pass mark j-reg-next">Получить пароль</a>
                    <button class="modal__btn btn btn_blue btn_m" data-btn="submit">Войти</button>
                    <div class="modal__agreement">При входе вы подтверждаете согласие с&nbsp;политикой конфиденциальности и&nbsp;пользовательским соглашением</div>
                </form>
            `
        },
        2: {
            modalClasses: 'registration-modal_simple',
            headText: 'Получение пароля',
            body: `
                <div class="modal__advantages">
                    <p class="modal__advantages-p">Быстро</p>
                    <p class="modal__advantages-p">Эффективно</p>
                    <p class="modal__advantages-p">удобно</p>
                    <p class="modal__advantages-p">бесплатно</p>
                </div>
                <form class="modal__form form reg-get-pass-form">
                    <div class="form-group">
                        <input class="input reg-get-pass-form__contact" type="text"
                            placeholder="Телефон или&nbsp;E-mail" name="phone_email">
                    </div>
                    <div class="modal__captcha" style="display:none">Капча</div>
                    <button class="modal__btn btn btn_blue btn_m" data-btn="submit">Получить код</button>
                </form>
            `
        },
        31: {
            modalClasses: 'registration-modal_simple',
            headText: 'Подтверждение почты',
            body: `
                <div class="modal__advantages">
                    <p class="modal__advantages-p">Быстро</p>
                    <p class="modal__advantages-p">Эффективно</p>
                    <p class="modal__advantages-p">удобно</p>
                    <p class="modal__advantages-p">бесплатно</p>
                </div>
                <form class="modal__form form reg-confirmation-form">
                    <div class="form-group">
                        <input class="input reg-confirmation-form__code" type="text"
                            placeholder="Код подтверждения">
                    </div>
                    <div class="modal__info">В течении 2х минут вы получите смс
                        <br>с&nbsp;кодом подтверждения на&nbsp;почту <b
                            class="reg-confirmation-form__contact">89171111111</b>
                    </div>
                    <div class="reg-confirmation-form__timer-block mark">Получить новый код
                        <br>можно через&nbsp;<span class="reg-confirmation-form__timer"></span>
                    </div>
                    <button class="modal__btn btn btn_blue btn_m" data-btn="submit">Отправить</button>
                </form>
            `
        },
        32: {
            modalClasses: 'registration-modal_simple',
            headText: 'Подтверждение номера',
            body: `
                <div class="modal__advantages">
                    <p class="modal__advantages-p">Быстро</p>
                    <p class="modal__advantages-p">Эффективно</p>
                    <p class="modal__advantages-p">удобно</p>
                    <p class="modal__advantages-p">бесплатно</p>
                </div>
                <form class="modal__form form reg-confirmation-form">
                    <div class="form-group">
                        <input class="input reg-confirmation-form__code" type="text"
                            placeholder="Код подтверждения" name="phone_email_code">
                    </div>
                    <div class="modal__info">В течении 2х минут вы получите смс
                        <br>с&nbsp;кодом подтверждения на&nbsp;номер <b
                            class="reg-confirmation-form__contact">89171111111</b>
                    </div>
                    <div class="reg-confirmation-form__timer-block mark">Получить новый код
                        <br>можно через&nbsp;<span class="reg-confirmation-form__timer"></span>
                    </div>
                    <button class="modal__btn btn btn_blue btn_m" data-btn="submit">Отправить</button>
                </form>
            `
        },
        4: {
            modalClasses: 'registration-modal_simple',
            headText: 'Создание нового пароля',
            body: `
                <div class="modal__advantages">
                    <p class="modal__advantages-p">Быстро</p>
                    <p class="modal__advantages-p">Эффективно</p>
                    <p class="modal__advantages-p">удобно</p>
                    <p class="modal__advantages-p">бесплатно</p>
                </div>
                <form class="modal__form form reg-new-pass-form">
                    <div class="form-group">
                        <input class="input reg-new-pass-form__pass" type="password" placeholder="Новый пароль" name="new_pass">
                    </div>
                    <button class="modal__btn btn btn_blue btn_m" data-btn="submit">Сохранить</button>
                </form>
            `
        },
        5: {
            modalClasses: 'registration-modal_wide',
            headText: 'Регистрация компании',
            body: `
                <form class="modal__form form registration-company-form">
                    <div class="form-group">
                        <div class="select-box require">
                            <select>
                                <option>Правовая форма</option>
                                <option>Вариант 1</option>
                                <option>Вариант 2</option>
                            </select>
                            <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                                <use xlink:href="/infopart/icons/sprite.svg#dropdown"></use>
                            </svg>
                        </div>
                    </div>
                    <div class="form-group">
                        <input class="input require" type="text" placeholder="Наименование">
                    </div>
                    <div class="form-group">
                        <div class="select-box">
                            <select>
                                <option>Категория</option>
                                <option>Вариант 1</option>
                                <option>Вариант 2</option>
                            </select>
                            <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                                <use xlink:href="/infopart/icons/sprite.svg#dropdown"></use>
                            </svg>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="select-box require">
                            <select>
                                <option>Система налогообложения</option>
                                <option>Вариант 1</option>
                                <option>Вариант 2</option>
                            </select>
                            <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                                <use xlink:href="/infopart/icons/sprite.svg#dropdown"></use>
                            </svg>
                        </div>
                    </div>
                    <div class="form-group">
                        <input class="input require" type="text" placeholder="Адрес">
                    </div>
                    <div class="form-group">
                        <div class="select-box require">
                            <select>
                                <option>Продавец или&nbsp;Покупатель</option>
                                <option>Вариант 1</option>
                                <option>Вариант 2</option>
                            </select>
                            <svg class="icon icon-dropdown " viewBox="0 0 12 12">
                                <use xlink:href="/infopart/icons/sprite.svg#dropdown"></use>
                            </svg>
                        </div>
                    </div>
                    <div class="form-group">
                        <input class="input require" type="text" placeholder="Должность">
                    </div>
                    <label class="checkbox form-group">
                        <input class="checkbox__input" type="checkbox" name=""><span class="checkbox__control"><span
                                class="checkbox__icon"><svg class="icon icon-check " viewBox="0 0 16 16">
                                    <use xlink:href="/infopart/icons/sprite.svg#check"></use>
                                </svg></span></span><span class="checkbox__text">Продолжить, как компания</span>
                    </label>
                    <div class="modal__bottom">
                        <div class="modal__btn btn btn_gray-bd btn_m j-reg-next">Пропустить</div>
                        <div class="modal__btn btn btn_blue btn_m j-reg-next">Сохранить</div>
                    </div>
                </form>
            `
        },
        6: {
            modalClasses: 'registration-modal_simple',
            headText: 'Подписка на&nbsp;навыки',
            body: `
                <div class="modal__advantages">
                    <p class="modal__advantages-p">Ещё Быстре</p>
                    <p class="modal__advantages-p">Ещё Эффективнее</p>
                    <p class="modal__advantages-p">Ещё удобнее</p>
                    <p class="modal__advantages-p">платно</p>
                </div>
                <div class="modal__tariffs">
                    <div class="modal__tariffs-item" data-reg-tariff="1">
                        <div class="modal__tariffs-head">
                            <div class="btn-double-switch-group">
                                <div class="modal__btn btn btn_blue btn_m modal__tariffs-head-btn">Pro</div>
                                <div class="btn-double btn modal__tariffs-head-btn-double">
                                    <div class="btn-double__item btn btn_blue j-reg-next" data-pay-method="card">Картой</div>
                                    <div class="btn-double__item btn btn_blue j-reg-next" data-pay-method="invoice">По счёту</div>
                                </div>
                            </div>
                            <svg class="icon icon-questionInRound modal__tariffs-question" viewBox="0 0 29 29">
                                <use xlink:href="/infopart/icons/sprite.svg#questionInRound"></use>
                            </svg>
                        </div>
                        <div class="modal__tariffs-descr">Стоимость подписки Pro в&nbsp;первые три месяца составляет <b>399</b> рублей в&nbsp;месяц, далее <b>3990</b> рублей в&nbsp;месяц, и&nbsp;будет списываться с&nbsp;вашего баланса каждый календарный месяц.
                            <br> <b>Отменить подписку можно в&nbsp;любой момент</b> в&nbsp;разделе Баланс. Оплатив, вы подтверждаете, что ознакомились и&nbsp;безоговорочно соглашаетесь с&nbsp;настоящими условиями.</div>
                    </div>
                    <div class="modal__tariffs-item" data-reg-tariff="2">
                        <div class="modal__tariffs-head">
                            <div class="btn-double-switch-group">
                                <div class="modal__btn btn btn_blue btn_m modal__tariffs-head-btn">Vip</div>
                                <div class="btn-double btn modal__tariffs-head-btn-double">
                                    <div class="btn-double__item btn btn_blue j-reg-next" data-pay-method="card">Картой</div>
                                    <div class="btn-double__item btn btn_blue j-reg-next" data-pay-method="invoice">По счёту</div>
                                </div>
                            </div>
                            <svg class="icon icon-questionInRound modal__tariffs-question" viewBox="0 0 29 29">
                                <use xlink:href="/infopart/icons/sprite.svg#questionInRound"></use>
                            </svg>
                        </div>
                        <div class="modal__tariffs-descr">Стоимость подписки Vip составляет <b>51000</b> рублей в&nbsp;месяц, и&nbsp;будет списываться с&nbsp;вашего баланса каждый календарный месяц.
                            <br> <b>Отменить подписку можно в&nbsp;любой момент</b> в&nbsp;разделе Баланс. Нажимая “Картой” или&nbsp;"По счету", вы подтверждаете, что ознакомились и&nbsp;безоговорочно соглашаетесь с&nbsp;настоящими условиями.</div>
                    </div>
                </div>
                <div class="modal__btn-skip btn btn_gray-bd btn_m m-a j-reg-next">Пропустить</div>
            `
        },
        7: {
            modalClasses: 'registration-modal_wide',
            headText: 'Формирование счета на&nbsp;оплату',
            body: `
                <form class="modal__form form invoice-generation-form">
                    <div class="form-group">
                        <input class="input" type="text" placeholder="Введите ваш ИНН">
                    </div>
                    <div class="form-group">
                        <input class="input" type="text" placeholder="КПП">
                    </div>
                    <div class="form-group">
                        <input class="input" type="text" placeholder="Наименование компании">
                    </div>
                    <div class="form-group">
                        <input class="input" type="text" placeholder="Юридический адрес">
                    </div>
                    <div class="form-group">
                        <input class="input" type="text" placeholder="Расчетный счет">
                    </div>
                    <div class="form-group">
                        <input class="input" type="text" placeholder="Кор. счет">
                    </div>
                    <div class="form-group">
                        <input class="input" type="text" placeholder="Бик">
                    </div>
                    <div class="modal__bottom">
                        <div class="modal__btn btn btn_blue btn_m j-reg-next">Скачать счёт</div>
                    </div>
                </form>
            `
        },
        81: {
            modalClasses: 'registration-modal_simple registration-modal_success',
            headText: 'Платеж получен',
            body: `
                <p class="modal__p">Ура! Теперь Вы можете подкючать Навыки и&nbsp;экономить время и&nbsp;деньги</p>
                <div class="modal__btn btn btn_blue btn_m m-a j-reg-next">Старт</div>
            `
        },
        82: {
            modalClasses: 'registration-modal_simple registration-modal_success',
            headText: 'Счет скачивается',
            body: `
                <p class="modal__p">Ура! Счет скачивается. Оплатите его. Вы можете связаться с нами и мы подключим навыки до поступления денег. <br>8 (800) 250 26 10</p>
                <div class="modal__btn btn btn_blue btn_m m-a j-reg-next">Старт</div>
            `
        },
        83: {
            modalClasses: 'registration-modal_simple registration-modal_success',
            headText: 'Поделитесь промокодом',
            body: `
                <p class="modal__p">Подарим 290 рублей, тому кого вы приведёте. И вам 29% с каждого его платежа.</p>
                <div class="modal__btn btn btn_blue btn_m m-a j-reg-next" data-promocode="PROMOCODETLDR9898">Копировать промокод</div>
            `
        },

    },
    // openTariffDescription() {
    //     $(this).closest('.modal__tariffs-item').siblings().find('.modal__tariffs-descr').slideUp()
    //     $(this).closest('.modal__tariffs-item').find('.modal__tariffs-descr').slideToggle()
    // },
    activateDoubleSwitchGroup() {
        $('.registration-modal .btn-double-switch-group').removeClass('is-on');
        $(this).addClass('is-on');
        $(this).closest('.modal__tariffs-item').siblings().find('.modal__tariffs-descr').slideUp()
        $(this).closest('.modal__tariffs-item').find('.modal__tariffs-descr').slideToggle()
    },
    setValidationOnSlide() {

    },
    submitSlide() {
        let currentSlideId = +$(this).closest('.registration-modal').attr('data-slide');
        let form = $(this).closest('form');

        switch (currentSlideId) {
            case 1:
            case 31:
            case 32:
                break;
            case 4:
                break;
            case 5:
                break;
            case 6:
                break;
            case 7:
                break;
            case 81:
                break;
            case 82:
                break;
            case 83:
                return;
        }
    },
    nextSlide() {
        let currentSlideId = +$(this).closest('.registration-modal').attr('data-slide');

        switch (currentSlideId) {
            case 1:
                regCtx.state.slide = 2;
                break;
            case 2:
                break;
            case 31:
            case 32:
                break;
            case 4:
                regCtx.state.slide = 5;
                break;
            case 5:
                regCtx.state.slide = 6;
                break;
            case 6:
                let payMethod = $(this).data('pay-method');

                if (payMethod == 'card') {
                    regCtx.state.slide = 81;
                } else if (payMethod == 'invoice') {
                    regCtx.state.slide = 7;
                } else {
                    regCtx.state.slide = 83;
                }

                break;
            case 7:
                regCtx.state.slide = 82;
                break;
            case 81:
                regCtx.state.slide = 83;
                break;
            case 82:
                regCtx.state.slide = 83;
                break;
            case 83:
                regCtx.state.slide = 1;
                config.copyToBuffer($(this).data('promocode'));
                config.closeModal('.modal');
                return;
        }

        regCtx.insertSlideContent();
    },
    initSlide() {
        if (regCtx.state.slide == 1) regCtx.insertSlideContent();
        config.openModal('.registration-modal')
    },
    insertSlideContent() {
        $('.registration-modal')
            .removeClass('registration-modal_simple registration-modal_success registration-modal_wide')
            .addClass(regCtx.slides[regCtx.state.slide].modalClasses)
            .attr('data-slide', regCtx.state.slide);

        let head = `
            <div class="modal__head">
                <div class="modal__close" data-close="close">
                    <svg class="icon icon-cross " viewBox="0 0 24 24">
                        <use xlink:href="/infopart/icons/sprite.svg#cross"></use>
                    </svg>
                </div>
                <div class="modal__head-text">`+ regCtx.slides[regCtx.state.slide].headText + `</div>
            </div>`,
            body = '<div class="modal__body">' + regCtx.slides[regCtx.state.slide].body + '</div>',
            content = '<div class="modal__content">' + head + body + '</div>'

        $('.registration-modal .modal__inner').html(content);

        regCtx.adjustSlide();
    },
    adjustSlide() {
        let form = $('.registration-modal').find('form');
        console.log(form)
        let validation = new JustValidate(form[0], {
            errorFieldCssClass: 'error-field',
        })
        switch (regCtx.state.slide) {
            case 1:
                validation.addField('.registration-form__email', [
                    {
                        rule: 'required',
                        errorMessage: 'Укажите телефон или email'
                    },
                ]).addField('.registration-form__pass', [
                    {
                        rule: 'required',
                        errorMessage: 'Введите пароль'
                    },
                ]).onSuccess(e => {
                    console.log(e)
                    $.post("/authorization_sms", form.serialize(),
                        function (response) {
                            let data = JSON.parse(response);
                            console.log(data)
                            if (data.ok) {
                                location.href = '/';
                                config.closeModal();
                            } else {
                                $.notify(data.code, "error");
                            }
                        }
                    );
                })
                break;
            case 2:
                validation.addField('.reg-get-pass-form__contact', [{
                    validator: (userContact, context) => {
                        let regexEmail = /^[^@\s]+@[^@\s]+\.[^@\s]+$/,
                            regexPhone = /^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/;

                        regCtx.state.userContact = userContact;

                        return regexPhone.test(userContact) || regexEmail.test(userContact)
                    },
                    errorMessage: 'Некорректный телефон или e-mail',
                },
                ]).onSuccess(e => {
                    console.log(e)
                    $.post("/get_sms_email", form.serialize(),
                        function (response) {
                            let data = JSON.parse(response);
                            console.log(data)
                            if (data.ok) {
                                let userContact = regCtx.state.userContact,
                                    regexEmail = /^[^@\s]+@[^@\s]+\.[^@\s]+$/,
                                    regexPhone = /^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/;

                                if (regexPhone.test(userContact)) {
                                    regCtx.state.slide = 32;
                                } else if (regexEmail.test(userContact)) {
                                    regCtx.state.slide = 31;
                                }

                                regCtx.insertSlideContent();
                            } else {
                                $.notify(data.code, "error");
                            }
                        }
                    );
                })
                break;
            case 31:
            case 32:
                $('.reg-confirmation-form__contact').text(regCtx.state.userContact);

                let timerNode = $('.reg-confirmation-form__timer'),
                    timeInSeconds = 120;
                    // timeInSeconds = 5;

                clearTimeout(timer);

                let timer = setTimeout(function timerGetCode() {
                    let minutes = Math.floor(timeInSeconds / 60),
                        second = timeInSeconds - minutes * 60;

                    if (minutes < 10) minutes = '0' + minutes;
                    if (second < 10) second = '0' + second;

                    timerNode.text(minutes + ':' + second);

                    if (timeInSeconds == 0) {
                        $('.reg-confirmation-form__timer-block')
                            .hide()
                            .after('<div class="modal__btn btn btn_gray-bd btn_m" data-btn="get-code">Получить код</div>');

                        $('[data-btn="get-code"]').on('click', () => {
                            $.post("/resending_code", () => {
                                regCtx.insertSlideContent();
                            });
                        })
                        return;
                    }

                    timeInSeconds--;

                    setTimeout(timerGetCode, 1000);
                }, 0);

                validation.addField('.reg-confirmation-form__code', [{
                    rule: 'required',
                    errorMessage: 'Введите код',
                }]).onSuccess(e => {
                    $.post("/check_code", form.serialize(),
                        function (response) {
                            let data = JSON.parse(response);
                            console.log(data)
                            if (data.ok) {
                                regCtx.state.slide = 4;
                                regCtx.insertSlideContent();
                            } else {
                                $.notify("Неверный код", "error");
                            }
                        }
                    );

                })

                break;
            case 4:
                validation.addField('.reg-new-pass-form__pass', [{
                    rule: 'required',
                    errorMessage: 'Введите пароль',
                },
                {
                    rule: 'password',
                    errorMessage: 'Слабый пароль',
                }]).onSuccess(e => {
                    let sentData = form.serialize() +'&new_pass_again='+ $('.reg-new-pass-form__pass').val()
                    $.post("/save_password", sentData,
                        function (response) {
                            let data = JSON.parse(response);
                            console.log(data)
                            if (data.code) {
                                config.closeModal();
                                location.href= '/profile'
                            }
                        }
                    );

                })
                break;
        }
    },
    init: () => {
        $('body').on('click', regCtx.btnLogin, regCtx.initSlide)

        $('body').on('click', '.registration-modal .j-reg-next', regCtx.nextSlide)
        $('body').on('click', '.registration-modal [data-btn="submit"]', regCtx.submitSlide)
        // $('body').on('click', '.registration-modal .modal__tariffs-question', regCtx.openTariffDescription)
        $('body').on('click', '.registration-modal .btn-double-switch-group', regCtx.activateDoubleSwitchGroup)
    },
};

export { regCtx };