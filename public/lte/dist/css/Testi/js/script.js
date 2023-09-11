var swiper = new Swiper(".slides-content", {
  slidesPerView: 3,
  spaceBetween: 30,
  slidesPerGroup: 3,
  loop: true,
  centerSlide: 'true',
  fade: 'true',
  grabCursor: 'true',
  loopFillGroupWithBlank: true,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
    dynamicBullets: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  breakpoints: {
    0: {
      slidesPerView: 1,
    },
    520: {
      slidesPerView: 2,
    },
    950: {
      slidesPerView: 3,
    },
  }
});

// Fungsi untuk berpindah ke halaman selanjutnya
function goToNextPage() {
  swiper.slideNext();
}

// Membuat interval tiap 5 detik
var interval = setInterval(goToNextPage, 10000); // 5000 milidetik = 5 detik
