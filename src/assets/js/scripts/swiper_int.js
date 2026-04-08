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
            centeredSlides: true,
        },

        700: {
            slidesPerView: 2.1,
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

const thumbEl = document.querySelector('[data-single-category-hero-swiper-thumb]');
const mainEl = document.querySelector('[data-single-category-hero-swiper]');

if (!mainEl) {
    // на странице нет основного блока — выходим
} else if (thumbEl) {
    const singleCategoryHeroThumbSwiper = new Swiper(thumbEl, {
        slidesPerView: 2,
        spaceBetween: 6,
        watchSlidesProgress: true,
        watchSlidesVisibility: true,
        slideToClickedSlide: true,
        breakpoints: {
            320: { slidesPerView: 3, spaceBetween: 8 },
            374: { slidesPerView: 4, spaceBetween: 10 },
            600: { slidesPerView: 6, spaceBetween: 12 },
            768: { slidesPerView: 7.5, spaceBetween: 12 },
        },
    });

    const singleCategoryHeroSwiper = new Swiper(mainEl, {
        slidesPerView: 1,
        thumbs: {
            swiper: singleCategoryHeroThumbSwiper,
        },
    });
} else {
    // миниатюр нет — только основной слайдер
    const singleCategoryHeroSwiper = new Swiper(mainEl, {
        slidesPerView: 1,
    });
}

// Связка двух свайперов + пагинация для about-description
const aboutDescriptionSwiper = new Swiper("[data-about-description-swiper]", {
    slidesPerView: 1,
    pagination: {
        el: "[data-about-description-pagination]",
    },
});

const aboutDescriptionThumbSwiper = new Swiper("[data-about-description-swiper-thumb]", {
    slidesPerView: 6.5,
    spaceBetween: 12,
});

aboutDescriptionSwiper.controller.control = aboutDescriptionThumbSwiper;
aboutDescriptionThumbSwiper.controller.control = aboutDescriptionSwiper;

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