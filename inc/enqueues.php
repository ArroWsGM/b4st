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

        //// Slick
        wp_register_style( 'slick-css', get_template_directory_uri() . "/assets/vendors/slick/slick{$minified}.css", false, '1.8.0' );
        wp_enqueue_style( 'slick-css' );

        wp_register_style( 'b4st-css', get_template_directory_uri() . "/assets/css/b4st{$minified}.css", array( 'bootstrap-css', 'slick-css'), '1.0');
        wp_enqueue_style('b4st-css');

        // Scripts
        //// Font awesome 5
        wp_register_script( 'font-awesome-config', get_template_directory_uri() . "/assets/vendors/fontawesome-pro/fontawesome-config{$minified}.js", false, null, null );
        wp_enqueue_script( 'font-awesome-config' );

        wp_register_script( 'font-awesome-set-brands', get_template_directory_uri() . '/assets/vendors/fontawesome-pro/js/fa-brands.min.js', false, '5.0.12', null );
        wp_enqueue_script( 'font-awesome-set-brands' );

//        wp_register_script( 'font-awesome-set-solid', get_template_directory_uri() . '/assets/vendors/fontawesome-pro/js/fa-solid.min.js', false, '5.0.12', null );
//        wp_enqueue_script( 'font-awesome-set-solid' );

        wp_register_script( 'font-awesome-set-regular', get_template_directory_uri() . '/assets/vendors/fontawesome-pro/js/fa-regular.min.js', false, '5.0.12', null );
        wp_enqueue_script( 'font-awesome-set-regular' );

        wp_register_script( 'font-awesome', get_template_directory_uri() . '/assets/vendors/fontawesome-pro/js/fontawesome.min.js', false, '5.0.12', null );
        wp_enqueue_script( 'font-awesome' );
//
//		wp_register_script('modernizr',  'https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js', false, '2.8.3', true);
//		wp_enqueue_script('modernizr');

        //// JQuery
        if ( ! is_admin() ) {
            wp_deregister_script( 'jquery' );

            wp_register_script( 'jquery', get_template_directory_uri() . "/assets/vendors/jquery/3.3.1/jquery{$minified}.js", false, '3.3.1', true );
            wp_enqueue_script( 'jquery' );
        }

        ////Bootstrap
//      turn on this two OR bootstrap bundle
//		wp_register_script('popper',  'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js', false, '1.14.0', true);
//		wp_enqueue_script('popper');
//
//		wp_register_script('bootstrap-js', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.0/js/bootstrap.min.js', array( 'jquery', 'popper' ), '4.1.1', true);
//		wp_enqueue_script('bootstrap-js');

        ////Bootstrap bundle
        wp_register_script( 'bootstrap-js', get_template_directory_uri() . "/assets/vendors/bootstrap/dist/js/bootstrap.bundle{$minified}.js", array( 'jquery' ), '4.1.1', true);
        wp_enqueue_script('bootstrap-js');

        //// Slick
        wp_register_script( 'slick-js', get_template_directory_uri() . '/assets/vendors/slick/slick.min.js', array( 'jquery' ), '1.8.0', true );
        wp_enqueue_script( 'slick-js' );

        wp_register_script('b4st-js', get_template_directory_uri() . '/assets/js/b4st.js', array('jquery', 'bootstrap-js', 'slick-js'), '1.0', true);
        wp_enqueue_script('b4st-js');

        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }
}
add_action('wp_enqueue_scripts', 'b4st_enqueues', 100);
