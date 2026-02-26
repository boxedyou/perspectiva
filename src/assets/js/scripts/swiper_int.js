// Слайдер для главной страницы (hero)
const swiperBack = new Swiper("[data-similar-product-swiper]", {
    slidesPerView: 1,

    spaceBetween: 8,
    breakpoints: {
        320: {
            slidesPerView: 1.1,
            loop: true,
            centeredSlides: true,
        },

        700: {
            slidesPerView: 2.1,
            loop: true,
            centeredSlides: true,
        },
        991: {
            slidesPerView: 3.1,
            loop: false,
            centeredSlides: false,
        },
        1200: {
            slidesPerView: 4,
            centeredSlides: false,
        },
    },
    navigation: {
        nextEl: "[data-similar-product-swiper-next]",
        prevEl: "[data-similar-product-swiper-prev]",
    },
});

// Слайдер для главной страницы (hero)
const swiperMaterials = new Swiper("[data-materials-swiper]", {
    slidesPerView: 1,

    spaceBetween: 8,
    breakpoints: {
        320: {
            slidesPerView: 1.1,
            loop: true,
            centeredSlides: true,
        },

        700: {
            slidesPerView: 2.1,
            loop: true,
            centeredSlides: true,
        },
        991: {
            slidesPerView: 3.1,
            loop: false,
            centeredSlides: false,
        },
        1200: {
            slidesPerView: 4,
            centeredSlides: false,
        },
    },
    navigation: {
        nextEl: "[data-materials-swiper-next]",
        prevEl: "[data-materials-swiper-prev]",
    },
});

// Синхронизированные слайдеры для single-category-hero
const singleCategoryHeroSwiper = new Swiper("[data-single-category-hero-swiper]", {
    slidesPerView: 1,
});

const singleCategoryHeroThumbSwiper = new Swiper("[data-single-category-hero-swiper-thumb]", {
    slidesPerView: 2,
    spaceBetween: 6,
    slideToClickedSlide: true,
    breakpoints: {
        320: {
            slidesPerView: 3,
            spaceBetween: 8,
        },
        374: {
            slidesPerView: 4,
            spaceBetween: 10,
        },
        600: {
            slidesPerView: 6,
            spaceBetween: 12,
        },
        768: {
            slidesPerView: 7.5,
            spaceBetween: 12,
        },
    },
});

// Синхронизация: при изменении основного слайдера обновляем миниатюры
singleCategoryHeroSwiper.controller.control = singleCategoryHeroThumbSwiper;
singleCategoryHeroThumbSwiper.controller.control = singleCategoryHeroSwiper;

// Слайдер для объектов
const objectsProductSwiper = new Swiper("[data-objects-product-swiper]", {
    slidesPerView: 1,
    spaceBetween: 8,
    breakpoints: {
        320: {
            slidesPerView: 1.1,
            loop: true,
            centeredSlides: true,
        },
        700: {
            slidesPerView: 2.1,
            loop: true,
            centeredSlides: true,
        },
        991: {
            slidesPerView: 3.1,
            loop: false,
            centeredSlides: false,
        },
        1200: {
            slidesPerView: 4,
            centeredSlides: false,
        },
    },
    navigation: {
        nextEl: "[data-objects-product-swiper-next]",
        prevEl: "[data-objects-product-swiper-prev]",
    },
});