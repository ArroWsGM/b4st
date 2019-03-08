<?php
/**
 * Enqueues
 */
if (
    ! defined( '_T_VERSION' ) ||
    ! defined( '_B4ST_TTD' )
) {
    wp_die( 'Core constants missing in  ' . basename(__FILE__, '.php') );
}

if ( ! function_exists( 'b4st_enqueues' ) ) {
    function b4st_enqueues() {
        wp_register_style( 'b4st-css', get_template_directory_uri() . "/assets/css/styles.min.css", null, _T_VERSION );
        wp_enqueue_style( 'b4st-css' );

        if ( ! is_admin() ) {
            wp_deregister_script( 'jquery' );

            //// Vendors script
            //This is not only jQuery but all other vendors bundle, including:
            //jQuery 3.3.1
            //slick-carousel 1.8.1
            //Bootstrap 4 Dropdown, Collapse
            wp_register_script( 'jquery', get_template_directory_uri() . "/assets/js/vendors.min.js", false, '3.3.1', true );
            wp_enqueue_script( 'jquery' );
        }

        //Custom script, includes font awesome 5
        wp_register_script( 'b4st-js', get_template_directory_uri() . '/assets/js/script.min.js', array( 'jquery' ), _T_VERSION, true );
        wp_enqueue_script( 'b4st-js' );

        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
    }
}
add_action( 'wp_enqueue_scripts', 'b4st_enqueues', 100 );

if ( ! function_exists( 'b4st_admin_enqueues' ) ) {
    function b4st_admin_enqueues() {
        wp_register_style( 'b4st-admin-css', get_template_directory_uri() . "/assets/css/styles-admin.min.css", null, _T_VERSION );
        wp_enqueue_style( 'b4st-admin-css' );
    }
}
add_action( 'admin_enqueue_scripts', 'b4st_admin_enqueues', 100 );

if ( ! function_exists( 'b4st_block_editor_styles' ) ) {
    function b4st_block_editor_styles() {
        wp_register_style( 'b4st-editor', get_template_directory_uri() . "/assets/css/styles-editor.min.css", null, _T_VERSION );
        wp_enqueue_style( 'b4st-editor' );
    }
}
add_action( 'enqueue_block_editor_assets', 'b4st_block_editor_styles' );