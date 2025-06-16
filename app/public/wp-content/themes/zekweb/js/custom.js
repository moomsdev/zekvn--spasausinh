(function ($) {
  // Initialize AOS
  AOS.init();
  // Initialize Select2
  $('.select2').select2({});

  // Initialize functions after document ready
  $(document).ready(function() {
    initProductCategoryMobileSelect();
    initContactForm7Ajax();
    initDynamicClasses();
    initSwiperSliders();
    initStickyHeader();
    initMobileMenu();
    initBackToTop();
    initAccountUI();
    initFancybox();
    initReadMore();
  });

})(jQuery);

function initMobileMenu()
{
  $('#touch-menu').click(function () {
    $('body').addClass('active-menu');
  });
  $('.line-dark').click(function () {
    $('body').removeClass('active-menu');
  });
  $('#close-menu').click(function () {
    $('body').removeClass('active-menu');
  });
  $('#menu-mobile .menu li.menu-item-has-children> a').after(
    '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M201.4 342.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 274.7 86.6 137.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z"/></svg>'
  );
  $('#menu-mobile .menu li.menu-item-has-children svg').click(function () {
    $(this).parent('li').children('ul').stop(0).slideToggle(300);
    $(this).parent('li').toggleClass('re-arrow');
  });
}

// Back-top
function initBackToTop()
{
  $("#back-top").hide();
  $(window).scroll(function () {
      if ($(this).scrollTop() > 500) {
          $('#back-top').fadeIn();
      } else {
          $('#back-top').fadeOut();
      }
  });
  $('#back-top').click(function () {
      $('body,html').animate({ scrollTop: 0 }, 800);
      return false;
  });
}

// Header sticky when scroll
function initStickyHeader() 
{
  const $header = $('#header');
  let lastScrollTop = 0;
  let isScrolling;
  let headerHeight = $header.outerHeight();

  $(window).on('scroll', function () {
      let scrollTop = $(this).scrollTop();

      // Fixed header khi cuộn xuống vượt qua chiều cao của header
      if (scrollTop > headerHeight) {
          $header.addClass('is-fixed');
      } else {
          $header.removeClass('is-fixed');
      }

      // Add is-hidden class when scrolling in any direction
      $header.addClass('is-hidden');

      lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;

      // Dừng scroll thì hiển thị lại header sau 150ms
      clearTimeout(isScrolling);
      isScrolling = setTimeout(function () {
          $header.removeClass('is-hidden');
      }, 150);
  });
}

// Contact form 7 ajax
function initContactForm7Ajax() 
{
  $('.wpcf7-submit').click(function () {
      var thisElement = $(this);
      var oldVal = thisElement.val();
      var textLoading = 'Đang xử lý ...';
      $('.cf7_submit .ajax-loader').remove();
      thisElement.val(textLoading);
      document.addEventListener('wpcf7submit', function (event) {
          thisElement.val(oldVal);
      }, false);
  });
}

// Dynamic classes
function initDynamicClasses()
{
  $('table').wrap('<div class="table-responsive"></div>');
  $('.woocommerce-product-details__short-description').addClass('content-post clearfix');
  $('.page-description').addClass('term-description');
  $('.term-description').addClass('content-post clearfix');
  $('.woocommerce-MyAccount-content').addClass('content-post clearfix');
  $(".link-move").click(function (a) {
      var i = this.getAttribute("href");
      if ("" != i) {
          var t = $(i).offset().top - 67;
          $(window).width() <= 1190 && (t += 7), $("html, body").animate({ scrollTop: t }, 500)
      }
  });
  // Cuộn mượt tới id khi click <a href="#id">
  document.addEventListener('click', function (event) {
      if (event.target.tagName === 'A') {
          var href = event.target.getAttribute('href');
          if (href && href.startsWith('#')) {
              event.preventDefault();
              var targetId = href.slice(1);
              var targetElement = document.getElementById(targetId);
              if (targetElement) {
                  targetElement.scrollIntoView({ behavior: 'smooth' });
              }
          }
      }
  });
}

// Account UI
function initAccountUI() 
{
  $('.account-body #customer_login').removeClass('u-columns col2-set');
  $('.account-body #customer_login').children('.u-column1').removeClass('col-1');
  $('.account-body #customer_login').children('.u-column2').removeClass('col-2');
  $('.account-body .box-login .lost_password').insertAfter('.account-body .box-login .woocommerce-form-login__rememberme');
  $('.account-body .box-login .note .note1 a').click(function () {
      $('.account-body .box-login').addClass('active');
  });
  $('.account-body .box-login .note .note2 a').click(function () {
      $('.account-body .box-login').removeClass('active');
  });
}

// Swiper sliders
function initSwiperSliders() 
{
  // Slider logo
  new Swiper('.logo-slider', {
      spaceBetween: 20,
      loop: true,
      autoplay: {
          delay: 3000,
          disableOnInteraction: false
      },
      pagination: {
          el: '.swiper-pagination',
          clickable: true,
      },
      breakpoints: {
          0: {
              slidesPerView: 2
          },
          768: {
              slidesPerView: 3
          },
          1200: {
              slidesPerView: 5
          }
      }
  });

  // Slider banner
  new Swiper('.slider-hero', {
    direction: 'vertical',
    speed: 1000,
    allowTouchMove: window.innerWidth >= 991,
    autoplay: {
      delay: 5000,
      disableOnInteraction: true
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: false,
    },
    breakpoints: {
      0: {
        direction: "horizontal",
        allowTouchMove: false,
      },
      991: {
        direction: "vertical",
        allowTouchMove: true
      },
    }
  });


  // Slider testimonials
  new Swiper('.testimonials-slider', {
      slidesPerView: 1,
      spaceBetween: 40,
      centeredSlides: true,
      loop: true,
      autoplay: {
          delay: 8000,
          disableOnInteraction: false
      },
      pagination: {
          el: '.testimonials-pagination',
          clickable: true,
      },
  });

  // Slider product
  new Swiper('.products-latest', {
      slidesPerView: 4,
      spaceBetween: 20,
      loop: true,
      autoplay: {
          delay: 3000,
          disableOnInteraction: false
      },
      pagination: {
          el: '.swiper-pagination',
          clickable: true,
      },
      breakpoints: {
          0: {
              spaceBetween: 8,
              slidesPerView: 2
          },
          768: {
              spaceBetween: 20,
              slidesPerView: 3
          },
          1200: {
              slidesPerView: 4
          }
      }
  });

  // Slider materials
  new Swiper('.materials-slider', {
      slidesPerView: 4,
      spaceBetween: 20,
      loop: true,
      autoplay: {
          delay: 4000,
          disableOnInteraction: false
      },
      pagination: {
          el: '.swiper-pagination',
          clickable: true,
      },
      breakpoints: {
          0: {
              spaceBetween: 10,
              slidesPerView: 2
          },
          991: {
              spaceBetween: 20,
              slidesPerView: 2
          },
          1200: {
              slidesPerView: 4
          }
      }
  });
}

// Fancybox
function initFancybox() 
{
  Fancybox.bind('[data-fancybox]', {
    loop: true,
    buttons: [
      "zoom",
      "slideShow",
      "fullScreen",
      "close"
    ],
    animationEffect: "fade",
    transitionEffect: "fade"
  });
}

// Product category mobile select
function initProductCategoryMobileSelect() 
{
  var select = document.getElementById('products-cat-mobile');
  if (!select) return;

  // Remove old listeners (avoid double when using swup)
  select.onchange = null;
  select.addEventListener('change', function(){
      var termId = this.value;
      var tabBtn = document.getElementById('products-tab-' + termId);
      if(tabBtn) {
          tabBtn.click();
          // Scroll to tab content on mobile nếu cần
          var tabContent = document.getElementById('products-' + termId);
          if(tabContent) {
              setTimeout(function(){
                  tabContent.scrollIntoView({behavior:'smooth', block:'start'});
              }, 200);
          }
      }
  });

  // Remove old listeners on tabBtns if any
  var tabBtns = document.querySelectorAll('#products-tab button.nav-link');
  tabBtns.forEach(function(btn){
      btn.removeEventListener('shown.bs.tab', btn._catMobileSync);
      btn._catMobileSync = function(e){
          var id = btn.id.replace('products-tab-', '');
          select.value = id;
      };
      btn.addEventListener('shown.bs.tab', btn._catMobileSync);
  });
}

function initReadMore()
{
  var $desc = $('.cat-desc-content');
  var $btn = $('.cat-desc-toggle');
  if ($desc.length && $btn.length) {
    $btn.on('click', function () {
      $desc.toggleClass('expanded');
      if ($desc.hasClass('expanded')) {
        $btn.text('Thu gọn');
      } else {
        $btn.text('Đọc thêm');
      }
    });
  }
}

