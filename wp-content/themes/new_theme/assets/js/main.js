document.addEventListener('DOMContentLoaded', () => {

  // Общие переменные
  let body = document.querySelector('body'),
      home = document.querySelector('.home'),
      doctorsSection = document.querySelector('.doctors-section'),
      directionsSection = document.querySelector('.directions-section');

  if(home) {

    // Главный слайдер
    const mainSlider = new Swiper(".main-slider", {
      navigation: {
        nextEl: ".main-swiper-navigation .swiper-button-next",
        prevEl: ".main-swiper-navigation .swiper-button-prev",
      },
      loop: true,
      // autoplay: true,
      // autoplay: {
      //   disableOnInteraction: false,
      // },
      
    });

    // Слайдер специалисты
    const doctorsSlider = new Swiper(".doctors-slider", {
      navigation: {
        nextEl: ".doctors-swiper-navigation .swiper-button-next",
        prevEl: ".doctors-swiper-navigation .swiper-button-prev",
      },
      loop: true,
      
      // slidesPerGroup: 4,
      // autoplay: true,
      // autoplay: {
      //   disableOnInteraction: false,
      // },
      breakpoints: {
        480: {
          slidesPerView: 2,
          spaceBetween: 15
        },
        768: {
          slidesPerView: 3,
          spaceBetween: 20
        },
        992: {
          slidesPerView: 4,
          spaceBetween: 30,
        }
      }
    });

    // Смотреть все направления
    let directionItem = document.querySelectorAll('.directions-section .item'),
        seeAllDirections = document.querySelector('.directions-section .see-all-directions-btn'),
        directionsScrollArray = [],
        directionsStep = 4;

    function showHiddenDirectionItem() {
      let hiddenItem = document.querySelectorAll('.directions-section .item-hidden');
      if (hiddenItem.length > 0) {
        for (let i = 0; i < hiddenItem.length; i++) {
          if (i < directionsStep) {
            hiddenItem[i].classList.remove('item-hidden');
          }
        }
        directionsScrollArray.push(window.pageYOffset);
      }

      if (seeAllDirections.innerHTML == "Свернуть") {

        for (let j = directionsStep; j < directionItem.length; j++) {
          directionItem[j].classList.add('item-hidden');
        }
        seeAllDirections.innerHTML = "Показать еще услуги";

        let toScroll = directionsScrollArray[0];
        scroll(0,toScroll);
      }

      if (hiddenItem.length > 4) {
        seeAllDirections.innerHTML = "Показать еще услуги";
      }
      if (hiddenItem.length == 4) {
        seeAllDirections.innerHTML = "Свернуть";
      }
    }

    seeAllDirections.onclick = showHiddenDirectionItem;

    // Аккордеон Направления
    let directionItems = document.querySelectorAll('.directions-section .item');
        directionItemsTitle = document.querySelectorAll('.directions-section .item-title')

    for (let i = 0; i < directionItemsTitle.length; i++) {
      directionItemsTitle[i].onclick = function(e) {
        directionItems[i].classList.toggle('active');
      }
    }

    // Слайдер О нас
    const aboutSlider = new Swiper(".about-slider", {
      navigation: {
        nextEl: ".about-swiper-navigation .swiper-button-next",
        prevEl: ".about-swiper-navigation .swiper-button-prev",
      },
      pagination: {
        el: ".about-swiper-pagination",
      },
      loop: true,
    });

    // Слайдер Отзывы
    const reviewsSlider = new Swiper(".reviews-slider", {
      navigation: {
        nextEl: ".reviews-swiper-navigation .swiper-button-next",
        prevEl: ".reviews-swiper-navigation .swiper-button-prev",
      },
      loop: true,
      slidesPerView: 1,
      breakpoints: {
        1200: {
          slidesPerView: 2,
          spaceBetween: 30,
        }
      }
    });

  }
  
  // to-top плавная прокрутка вверх
  document.getElementById("to-top").onclick = function() {
    scroll(0, 0);
  }
  
  window.onscroll = function() {
    // Показать to-top при скролле
    let scrToTop = window.pageYOffset || document.documentElement.scrollTop,
        toTop = document.getElementById("to-top");
    if (scrToTop > 200) {
      toTop.classList.add('active');
    } else {
      toTop.classList.remove('active');
    }
  
    // Фиксированное верхнее меню
    let scrFixedDesktopMenu = window.pageYOffset || document.documentElement.scrollTop,
        fixedDesktopMenu = document.querySelector(".fixed-desktop-menu");
    if (scrFixedDesktopMenu > 500) {
      fixedDesktopMenu.classList.add('active');
    } 
    if (scrFixedDesktopMenu < 750) {
      fixedDesktopMenu.classList.remove('active');
    }
  }

  // Модальные окна
  let modal = document.querySelectorAll('.modal'),
      doctorModals = document.querySelectorAll('.doctor-modal'),
      doctorItems = document.querySelectorAll('.doctors-section .item'),
      doctorSwiperSlide = document.querySelectorAll('.doctors-section .swiper-slide'),
      addReviewModal = document.querySelector('.add-review-modal'),
      addReviewBtn = document.querySelector('.add-review-btn'),
      modalCloseBtn = document.querySelectorAll('.modal-close');

  // Открытие окон Специалисты
  if (doctorSwiperSlide.length > 0) {
    for (let i = 0; i < doctorSwiperSlide.length; i++) {
      doctorSwiperSlide[i].onclick = function () {
        let slideIndex = this.getAttribute('data-swiper-slide-index');
        console.log(slideIndex);
        slideIndex = Number(slideIndex);
        modalOpen(doctorModals[slideIndex]);
      }
    }
  }

  if (addReviewBtn) {
    addReviewBtn.onclick = function () {
      modalOpen(addReviewModal);
    }
  }

  function modalOpen(win) {
    body.classList.add('overflow-hidden');
    win.style.display = "block";
  }

  // Закрытие окон
  for (let i = 0; i < modalCloseBtn.length; i++) {
    modalCloseBtn[i].onclick = function() {
      modalClose(modal[i]);
    }
  }

  for (let i = 0; i < modal.length; i++) {
    modal[i].onclick = function(event) {
      let classList = event.target.classList;
      for (let j = 0; j < classList.length; j++) {
        if (classList[j] == "modal" || classList[j] == "modal-wrapper") {
          modalClose(modal[i])
        }
      }
    }
  }

  function modalClose(win) {
    body.classList.remove('overflow-hidden');
    win.style.display = "";
  }
  
  // mobile menu
  let burgerMenuWrapper = document.querySelector('.burger-menu-wrapper'),
      mobileMenu = document.querySelector('.mobile-menu'),
      burgerMenu = document.querySelector('.burger-menu'),
      mobileMenuClose = document.querySelector('.mobile-menu .close');

  burgerMenuWrapper.onclick = function () {
    body.classList.toggle('overflow-hidden');
    mobileMenu.classList.toggle('down');
  }

  let listParentClick = document.querySelectorAll('.mobile-menu li.menu-item a');
  for (let i=0; i < listParentClick.length; i++) {
    listParentClick[i].onclick = closeMenu;
  }

  mobileMenuClose.onclick = function() {
    document.querySelector('.mobile-menu').classList.remove('down');
    document.querySelector('body').classList.remove('overflow-hidden');
  }

  function closeMenu (event) {
    event.preventDefault();
    document.querySelector('.mobile-menu').classList.remove('down');
    document.querySelector('body').classList.remove('overflow-hidden');
    let hrefClick = this.href;
    setTimeout(function() {location.href = hrefClick}, 500);
  }


  // Set cookie
  function setCookie(name, value, days) {
    let expires = "";
    if (days) {
      let date = new Date();
      date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
      expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/" + "; sameSite=Lax;";
  }

  function getCookie(name) {
    let matches = document.cookie.match(new RegExp("(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"));
    return matches ? decodeURIComponent(matches[1]) : undefined;
  }

  function loadMetrica() {
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
       m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
       (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
     
       ym(87939491, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true
       });
  }

  function checkCookies() {
    let cookieNote = document.querySelector('#cookie_note');
    let cookieBtnAccept = cookieNote.querySelector('#cookie_accept');
    const cookieBtnDontAccept = cookieNote.querySelector('#cookie_dont_accept');

    // Если куки we-use-cookie нет или она просрочена, то показываем уведомление
    if (!getCookie('we-use-cookie')) {
      cookieNote.classList.add('active');
    }

    if (getCookie('we-use-cookie') == 'true') {
      loadMetrica();
    }

    cookieBtnAccept.addEventListener('click', function () {
      setCookie('we-use-cookie', 'true', 365);
      cookieNote.classList.remove('active');
      loadMetrica();
    });

    cookieBtnDontAccept.addEventListener('click', function () {
      setCookie('we-use-cookie', 'false', 10);
      cookieNote.classList.remove('active');
    });
  }

  checkCookies();

})