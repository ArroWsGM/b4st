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

if ( ! function_exists( 'b4st_avatar_attributes' ) ) {
	function b4st_avatar_attributes($avatar_attributes) {
		$display_name = get_the_author_meta( 'display_name' );
		$avatar_attributes = str_replace('alt=\'\'', 'alt=\'Avatar for '.$display_name.'\' title=\'Gravatar for '.$display_name.'\'',$avatar_attributes);
		return $avatar_attributes;
	}
}
add_filter('get_avatar','b4st_avatar_attributes');

if ( ! function_exists( 'b4st_author_avatar' ) ) {
	function b4st_author_avatar() {

		echo get_avatar('', $size = '96');
	}
}

if ( ! function_exists( 'b4st_author_description' ) ) {
	function b4st_author_description() {
		echo get_the_author_meta('user_description');
	}
}

if ( ! function_exists( 'b4st_post_date' ) ) {
	function b4st_post_date() {
		if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';

			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time> <time class="updated" datetime="%3$s">(updated %4$s)</time>';
			}

			$time_string = sprintf( $time_string,
				esc_attr( get_the_date( 'c' ) ),
				get_the_date(),
				esc_attr( get_the_modified_date( 'c' ) ),
				get_the_modified_date()
			);

			echo $time_string;
		}
	}
}

function change_logo_class( $html ) {
    $html = str_replace( 'class="custom-logo-link"', 'class="custom-logo-link navbar-brand"', $html );

    return $html;
}
add_filter( 'get_custom_logo', 'change_logo_class' );

add_action( 'after_setup_theme', function () {
    load_theme_textdomain( _B4ST_TTD, get_template_directory() . '/languages' );
} );