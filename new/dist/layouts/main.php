<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1">
    <title></title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&amp;display=fallback" rel="stylesheet">
    <link rel="stylesheet" href="/app/css/app.css?v=1657458539219">
    <script>
        function canUseWebP(){var e=document.createElement("canvas");return!(!e.getContext||!e.getContext("2d"))&&0==e.toDataURL("image/webp").indexOf("data:image/webp")}var root=document.getElementsByTagName("html")[0];canUseWebP()?root.classList.add("ws"):root.classList.add("wn");
    </script>
</head>

<body>
    <main></main>
    <div class="modal registration-modal registration-modal_simple registration-modal_success">
        <div class="modal__container">
            <div class="modal__inner"></div>
        </div>
    </div>
    <div class="needs-modal modal">
        <div class="modal__container">
            <div class="modal__inner">
                <div class="modal__content">
                    <div class="modal__close" data-close="close">
                        <svg class="icon icon-cross " viewBox="0 0 24 24">
                            <use xlink:href="/app/icons/sprite.svg#cross"></use>
                        </svg>
                    </div>
                    <div class="modal__body">
                        <div class="needs-modal__header">
                            <div class="needs-modal__photos">
                                <svg class="icon icon-cameraSharp " viewBox="0 0 17 17">
                                    <use xlink:href="/app/icons/sprite.svg#cameraSharp"></use>
                                </svg>
                            </div>
                            <div class="needs-modal__need-name-input form-group">
                                <input class="input require" type="text" placeholder="Название">
                            </div>
                        </div>
                        <div class="needs-modal__needs"></div>
                        <div class="needs-modal__bottom">
                            <div class="needs-modal__save">
                                <svg class="icon icon-floppyDisk " viewBox="0 0 24 24">
                                    <use xlink:href="/app/icons/sprite.svg#floppyDisk"></use>
                                </svg>
                            </div>
                            <div class="needs-modal__next btn btn_blue btn_m" data-next="1">Продолжить</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script src="/app/js/app.js?v=1657458539222"></script>
</body>

</html>