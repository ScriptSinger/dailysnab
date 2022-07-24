// Слайдер
let numElems = 0

$(window).ready(function () {
  window.requestSliderWrapper = function() {
    jQuery.each($('.request-slider-wrapper'), function () {
      if ($(this).hasClass('on')) return;
      
      $(this).addClass('on');
      numElems++;
      imgLen = $(this).find('img').length;
      stageLen = $(this).siblings().find('.request-stage').length;

      let txt = $(this).siblings().find('.request-days span')[0];

      if (txt) {
        var numb = txt.textContent.match(/\d/g);
        numb = numb.join("");
        let percent = (1 - numb / 30) * 100;
        $(this).siblings().find('.days-before').css('width', percent + '%');
        if (numb <= 2) {
          $(this).siblings().find('.request-days-line').addClass('days-red');
        }
      }

      // let timeString = $(this).siblings().find('.data-month');
      // //console.log(timeString.text().search('недел'))
      // if(timeString.text().search('Не срочно')>-1) {
      //   timeString.css('background','#b7b7b7');

      // } else if(timeString.text().search('Неделя')>-1) {
      //   timeString.css('background','#de6d2f');

      // }else if(timeString.text().search('Срочно')>-1) {
      //   timeString.css('background','#e22929');

      // }else if(timeString.text().search('недели')>-1) {
      //   timeString.css('background','#dec63d');
      // }


      let catName = $(this).siblings().find('.status-category');
      catName.attr('data-title', catName.text());

      
      let forItem = $(this).siblings();
      let forPics = $(this);

      if (imgLen == 0) {
        $(this).siblings().find('.request-data-name').css('top', '30px');
        $(this).siblings().find('.request-data-name p').css('max-width', '220px');
        $(this).siblings().find('.request-data-name p').css('width', '220px');
        $(this).siblings().find('.request-for-price').css('position', 'absolute');
        $(this).siblings().find('.request-for-price').css('bottom', '8px');
        $(this).siblings().find('.request-for-price').css('height', '0px');
        $(this).css('margin-right', '0px');
        $(this).addClass('d-none');
        $(this).siblings().find('.request-stage').css('margin-left', '0px');


        $('body').on('click', '.request-head-btn', function() {
          forItem.find('.request-stage').css('margin-left', '30px');
        })
      } else if(imgLen == 1) {
        $(this).find('.slider-control').addClass('single-slider');
      }

      if (stageLen > 1) {
        $(this).siblings().find('.request-data-name p').css('max-width', '220px');
        $(this).siblings().find('.request-data-name p').css('width', '220px');
        $(this).siblings().find('.request-stage').addClass('request-opacity');
        $(this).siblings().find('.request-for-price').css('position', 'absolute');
        $(this).siblings().find('.data-hidden-city').css('display', 'block');
        $(this).siblings().find('.data-city').css('display', 'none');
        $(this).addClass('d-none');

        $('.request-head-btn').click(function() {
          forItem.find('.request-stage').css('margin-left', '0px');
        })


        jQuery.each($(this).siblings().find('.image-wrapper'), function () {
          let innerImgLen = $(this).find('img').length;
          if (innerImgLen > 0) {
            let ex = 0;
            for (let i = 0; i < innerImgLen - 1; i++) {
              ex++;
              $(this).siblings().append('<span><a data-fancybox="gallery' + numElems + '" href="image/cars/' + ex + '.jpg"></a></span>')
            }

            $(this).closest('.request-stage').find('.request-hidden-images').css('display', 'block');

            let firstSrc = $(this).children().children().last().attr('src');

            $(this).closest('.request-stage').find('.request-data-name a').attr('data-fancybox', 'gallery' + numElems);
            $(this).closest('.request-stage').find('.request-data-name a').attr('href', '/' + firstSrc);

          }
          numElems++;
        })
      }

      if ($(this).closest('.buy-item_3').length) {
        jQuery.each($(this).find('.image-wrapper'), function () {
          let innerImgLen = $(this).find('img').length;
          let parent = '.container';

          if (innerImgLen > 0) {
            let ex = 0;
            for (let i = 0; i < innerImgLen; i++) {
              console.log(innerImgLen)
              ex++;
              $(this).siblings().append('<span><a data-fancybox="gallery' + numElems + '" href="image/cars/' + ex + '.jpg"></a></span>')
            }

            let firstSrc = $(this).find('img').last().attr('src');

            $(this).closest(parent).find('.buy-item-main-left__right-icon a').attr('data-fancybox', 'gallery' + numElems);
            $(this).closest(parent).find('.buy-item-main-left__right-icon a').attr('href', firstSrc);

          }
          numElems++;
        })
      }
      
      let quaImg = 0;
      jQuery.each($(this).find('.inner-wrapper img'), function() {
        quaImg++;
        let imgLoc = $(this).attr('src');
        
        if (quaImg > 5) {
          forPics.find('.slider-control').append('<span class="d-none"><a data-fancybox="gallery' + numElems + '" href="' + imgLoc + '"></a></span>')
        } else {
          forPics.find('.slider-control').append('<span><a data-fancybox="gallery' + numElems + '" href="' + imgLoc + '"></a></span>')
        }
      })

      sliderLen = $(this).children().length;
      $(this).find('span').css('width', 100 / imgLen + '%')
    })
}
  window.requestSliderWrapper();


$('.slider-control span').hover(function () {
  var circleIndex = $(this).index();
  let parentImg = $(this).parent().prev();
  let imgItem = parentImg.find(`img:eq(${circleIndex})`);

  $('.slider-control span').removeClass('active');
  parentImg.find('img').removeClass('activeSlide').removeClass('active');

  $(this).addClass('active');
  imgItem.addClass('active');
  }, function () {
    //sdf
  });
})