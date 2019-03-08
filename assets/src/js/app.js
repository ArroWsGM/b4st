import isIE from './lib/isIE'
import getSlick from './lib/getSlick'

$(document).on('click', '.smooth-scroll', function (e) {
    e.preventDefault()

    let target = document.querySelector(this.dataset.target),
        height = $(this).hasClass('to-top') ? target.getBoundingClientRect().top : $(target).outerHeight() + target.getBoundingClientRect().top

    if (target && height) {
        window.scrollBy({
            top: height,
            behavior: 'smooth'
        })
    }
})

$(function() {
    if (isIE())
        $('body').addClass('is-ie')

    getSlick($('.sample-carousel'), {
        autoplay: false,
        slidesToShow: 3,
        slideToScroll: 1,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });
})
