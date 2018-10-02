<?php
/**!
 * Enqueues
 */

if ( ! function_exists('b4st_enqueues') ) {
    function b4st_enqueues() {

        $minified = WP_DEBUG ? '' : '.min';

        // Styles
        //// Bootstrap
        wp_register_style( 'bootstrap-css', get_template_directory_uri() . "/assets/css/bootstrap{$minified}.css", false, '4.1.1', null);
        wp_enqueue_style('bootstrap-css');

        wp_register_style( 'b4st-css', get_template_directory_uri() . "/assets/css/b4st{$minified}.css", array( 'bootstrap-css' ), '1.0');
        wp_enqueue_style('b4st-css');

        // Scripts
        //Include Fonts Awesome 5
        require ('enqueues-fa5.php');
//
//		wp_register_script('modernizr',  'https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js', false, '2.8.3', true);
//		wp_enqueue_script('modernizr');

        //// JQuery
        if ( ! is_admin() ) {
            wp_deregister_script( 'jquery' );

            wp_register_script( 'jquery', get_template_directory_uri() . "/assets/node_modules/jquery/dist/jquery{$minified}.js", false, '3.3.1', true );
            wp_enqueue_script( 'jquery' );
        }

        //Optionally include bootstrap JS
        require ('enqueues-bootstrap.php');

        //// Slick
        wp_register_script( 'slick-js', get_template_directory_uri() . '/assets/node_modules/slick-carousel/slick/slick.min.js', array( 'jquery' ), '1.8.1', true );
        wp_enqueue_script( 'slick-js' );

        wp_register_script('b4st-js', get_template_directory_uri() . '/assets/js/b4st.js', array('jquery', 'slick-js'), '1.0', true);
        wp_enqueue_script('b4st-js');

        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }
}
add_action('wp_enqueue_scripts', 'b4st_enqueues', 100);
