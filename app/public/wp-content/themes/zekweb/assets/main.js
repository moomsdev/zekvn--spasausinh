import $ from 'jquery';
import jQuery from 'jquery';

window.$ = $;
window.jQuery = jQuery;

// Import CSS
import 'aos/dist/aos.css';
import "@fancyapps/ui/dist/fancybox/fancybox.css";
import './vendor/select2.min.css';
import './style.scss';
import 'swiper/swiper-bundle.css';
// import '@fortawesome/fontawesome-free/css/all.css'

// Import các file JS cơ bản
import 'bootstrap/dist/js/bootstrap.bundle';
import 'bootstrap/dist/css/bootstrap.css';

import { Fancybox } from "@fancyapps/ui";
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';

Swiper.use([Navigation, Pagination, Autoplay]);

// import './js/qty.js';
import './js/ytdefer.min.js';
import AOS from 'aos';
import Swup from 'swup';

jQuery(function($) {
    const swup = new Swup();
    swup.hooks.on('page:view', () => {
        initializePageFeatures();
    });

    initializePageFeatures();
});

function initializePageFeatures() {
    initAnimations();
    initMobileMenu();
    initSelect2();
    initBackToTop();
    initStickyHeader();
    initContactForm7Ajax();
    initDynamicClasses();
    initAccountUI();
    initSwiperSliders();
    initFancybox();
}

// 1. Hiệu ứng
function initAnimations() {
    AOS.init({
        duration: 400,
        once: true, // chỉ animate 1 lần
    });
    AOS.refreshHard();
}

// 2. Xử lý Menu Mobile
function initMobileMenu() {
    $('#touch-menu').click(function () {
        $('body').addClass('active-menu');
    });
    $('.line-dark, #close-menu').click(function () {
        $('body').removeClass('active-menu');
    });
    $("#menu-mobile .menu li.menu-item-has-children> a").after('<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path d="M201.4 342.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 274.7 86.6 137.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z"/></svg>');
    $('#menu-mobile .menu li.menu-item-has-children svg').click(function () {
        $(this).parent('li').children('ul').stop(0).slideToggle(300);
        $(this).parent('li').toggleClass('re-arrow');
    });
}

// 3. Khởi tạo Select2
function initSelect2() {
    if ($.fn.select2) {
        $('.select2').select2({});
    }
}

// 4. Nút Back-to-Top
function initBackToTop() {
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

// 5. Head dính khi cuộn
function initStickyHeader() {
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

// 6. Xử lý nút gửi form Contact Form 7 (ajax)
function initContactForm7Ajax() {
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

// 7. Thêm class, hiệu ứng cho các thành phần động
function initDynamicClasses() {
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

// 8. Tối ưu giao diện trang tài khoản
function initAccountUI() {
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

// 9. Khởi tạo các slider Swiper
function initSwiperSliders() {

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
        effect: 'fade',
        speed: 1000,
        autoplay: {
            delay: 5000,
            disableOnInteraction: true
        },
        allowTouchMove: false,
        touchRatio: 0,
        direction: "vertical",
        pagination: {
            el: '.swiper-pagination',
            clickable: false,
        },
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
            el: '.swiper-pagination',
            clickable: true,
        },
    });

    // Slider product
    new Swiper('.products-latest', {
        // slidesPerView: 4,
        // spaceBetween: 20,
        // // loop: true,
        // // autoplay: {
        // //     delay: 3000,
        // //     disableOnInteraction: false
        // // },
        // pagination: {
        //     el: '.swiper-pagination',
        //     clickable: true,
        // },
        breakpoints: {
            0: {
                slidesPerView: 2
            },
            768: {
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
                slidesPerView: 1
            },
            991: {
                slidesPerView: 2
            },
            1200: {
                slidesPerView: 4
            }
        }
    });
}

// 10. Khởi tạo fancybox
function initFancybox() {
    Fancybox.bind("[data-fancybox]", {
        // Các tùy chọn
        slideShow: {
            autoStart: true,
            speed: 1000,
        },
        Thumbs: {
            autoStart: true,
        },
    });
}