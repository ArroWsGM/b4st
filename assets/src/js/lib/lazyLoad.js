function execute (callback, delay) {
    if ( 'function' === typeof callback ) {
        if ( 'number' === typeof delay && delay > 0 ) {
            setTimeout(()=>{callback()}, delay)
        } else {
            callback();
        }
    }
}

const lazyLoad = ( $el, callback, delay ) => {
    if ( 'undefined' === typeof jQuery ) {
        return false
    }

    if ( $el.hasClass('loading') ) {
        let src = $el.data('background-img');
        if ( src ) {
            let img = new Image();

            img.src = src;

            img.onload = () => {
                $el.css({
                    backgroundImage: 'url(' + src + ')'
                }).removeClass('loading');

                execute (callback, delay);
            }
        } else {
            $el.removeClass('loading');
            execute (callback, delay);
        }

    }
}

export default lazyLoad