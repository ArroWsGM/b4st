<?php
//// Font awesome 5
////// TODO: tree shaking!!!

global $minified;

wp_register_script( 'fa5-config', get_template_directory_uri() . "/assets/js/fontawesome-pro/fontawesome-config{$minified}.js", false, null, null );
wp_enqueue_script( 'fa5-config' );

wp_register_script( 'fa5-set-brands', get_template_directory_uri() . '/assets/node_modules/@fortawesome/fontawesome-pro/js/brands.min.js', false, '5.3.1', null );
wp_enqueue_script( 'fa5-set-brands' );

//wp_register_script( 'fa5-set-solid', get_template_directory_uri() . '/assets/node_modules/@fortawesome/fontawesome-pro/js/solid.min.js', false, '5.3.1', null );
//wp_enqueue_script( 'fa5-set-solid' );

wp_register_script( 'fa5-set-regular', get_template_directory_uri() . '/assets/node_modules/@fortawesome/fontawesome-pro/js/regular.min.js', false, '5.3.1', null );
wp_enqueue_script( 'fa5-set-regular' );

wp_register_script( 'fa5', get_template_directory_uri() . '/assets/node_modules/@fortawesome/fontawesome-pro/js/fontawesome.min.js', false, '5.3.1', null );
wp_enqueue_script( 'fa5' );