<?php
/**!
 * Cleanup
 */

// Less stuff in <head>

if ( ! function_exists( 'b4st_cleanup_head' ) ) {
    function b4st_cleanup_head() {
        remove_action('wp_head', 'wp_generator');
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
        remove_action('wp_head', 'wp_shortlink_wp_head', 10);
    }
}
add_action( 'init', 'b4st_cleanup_head' );

// Show less info to users on failed login for security.
// (Will not let a valid username be known.)

if ( ! function_exists( 'b4st_show_less_login_info' ) ) {
    function b4st_show_less_login_info() {
        return __( '<strong>Ошибка</strong>: Неверный ввод!', _B4ST_TTD );
    }
}
add_filter( 'login_errors', 'b4st_show_less_login_info' );