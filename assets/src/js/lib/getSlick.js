const getSlick = ($wrap, {
    autoplay = true,
    autoplaySpeed = 2000,
    centerMode = false,
    prevArrow = '<span class="slick-arrow prev"><i class="fas fa-long-arrow-left"></i></span>',
    nextArrow = '<span class="slick-arrow next"><i class="fas fa-long-arrow-right"></i></span>',
    slidesToShow = 1,
    slideToScroll = 1,
    responsive = []
} = {}) => {

    if ($wrap.length) {
        $wrap.slick({
            autoplay,
            autoplaySpeed,
            centerMode,
            prevArrow,
            nextArrow,
            slidesToShow,
            slideToScroll,
            responsive
        })
    }
}

export default getSlick