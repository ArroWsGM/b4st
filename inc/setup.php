<?php
/**!
 * Setup
 */

if ( ! function_exists('b4st_setup') ) {
	function b4st_setup() {
		add_editor_style('assets/css/b4st-editor.css');

		add_theme_support('title-tag');

		add_theme_support('post-thumbnails');

		update_option('thumbnail_size_w', 255); /* internal max-width of col-3 */
		update_option('small_size_w', 350); /* internal max-width of col-4 */
		update_option('medium_size_w', 730); /* internal max-width of col-8 (col-9 825) */
		update_option('large_size_w', 1110); /* internal max-width of col-12 */

		if ( ! isset($content_width) ) {
			$content_width = 1110;
		}

		add_theme_support( 'post-formats', array(
//			'aside',
			'gallery',
//			'link',
//			'image',
//			'quote',
//			'status',
			'video',
//			'audio',
//			'chat'
		) );

		add_theme_support('automatic-feed-links');

        add_theme_support( 'custom-logo', array(
            'height'      => 110,
            'width'       => 110,
            'flex-height' => true,
            'flex-width'  => true,
            'header-text' => array( 'site-title' ),
        ) );
	}
}
add_action('init', 'b4st_setup');

add_action( 'after_setup_theme', function () {
    load_theme_textdomain( _B4ST_TTD, get_template_directory() . '/languages' );
} );