import Swiper from 'swiper';

window.addEventListener('load', () => {
    let slider = document.getElementById('swiper-slider')

    slider.classList.remove('hidden');
    slider.classList.add('flex');

    let swiper = new Swiper('.swiper-container', {
        loop: true,
        slidesPerView: 1,
        spaceBetween: 0,

        breakpoints: {
            640: {
                slidesPerView: 1,
                spaceBetween: 0,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 0,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 0,
            },
            1200: {
                slidesPerView: window.location.pathname === "/" ? 4 : 3,
                spaceBetween: 0,
            }
        }
    });

    document.getElementById("swiper-prev-button").addEventListener('click', () => {
        swiper.slidePrev();
    })

    document.getElementById("swiper-next-button").addEventListener('click', () => {
        swiper.slideNext();
    })
})
    
