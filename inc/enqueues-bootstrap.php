<?php
// Bootstrap js
// TODO: conditional function
global $minified;

////Bootstrap components
//      turn on popper/util and selected component(s) OR bootstrap bundle, but not both, and ONLY if it really needs
//		wp_register_script( 'popper-js',  get_template_directory_uri() . '/assets/node_modules/popper.js/dist/umd/popper.min.js', false, '1.14.0', true);
//		wp_enqueue_script( 'popper-js');

//		wp_register_script( 'bootstrap-js-util',  get_template_directory_uri() . "/assets/node_modules/bootstrap/js/dist/util{$minified}.js", false, '4.1.3', true);
//		wp_enqueue_script( 'bootstrap-js-util');

///////// Bootstrap alert (requires util)
//        wp_register_script( 'bootstrap-js-alert', get_template_directory_uri() . "/assets/node_modules/bootstrap/js/dist/alert{$minified}.js", array( 'jquery', 'bootstrap-js-util' ), '4.1.3', true);
//        wp_enqueue_script('bootstrap-js-alert');

///////// Bootstrap button
//        wp_register_script( 'bootstrap-js-button', get_template_directory_uri() . "/assets/node_modules/bootstrap/js/dist/button{$minified}.js", array( 'jquery' ), '4.1.3', true);
//        wp_enqueue_script('bootstrap-js-button');

///////// Bootstrap carousel (requires util)
//        wp_register_script( 'bootstrap-js-carousel', get_template_directory_uri() . "/assets/node_modules/bootstrap/js/dist/carousel{$minified}.js", array( 'jquery', 'bootstrap-js-util' ), '4.1.3', true);
//        wp_enqueue_script('bootstrap-js-carousel');

///////// Bootstrap collapse (requires util)
//        wp_register_script( 'bootstrap-js-collapse', get_template_directory_uri() . "/assets/node_modules/bootstrap/js/dist/collapse{$minified}.js", array( 'jquery', 'bootstrap-js-util' ), '4.1.3', true);
//        wp_enqueue_script('bootstrap-js-collapse');

///////// Bootstrap dropdown (requires popper and util)
//        wp_register_script( 'bootstrap-js-dropdown', get_template_directory_uri() . "/assets/node_modules/bootstrap/js/dist/dropdown{$minified}.js", array( 'jquery', 'popper.js', 'bootstrap-js-util' ), '4.1.3', true);
//        wp_enqueue_script('bootstrap-js-dropdown');

///////// Bootstrap modal (requires util)
//        wp_register_script( 'bootstrap-js-modal', get_template_directory_uri() . "/assets/node_modules/bootstrap/js/dist/modal{$minified}.js", array( 'jquery', 'bootstrap-js-util' ), '4.1.3', true);
//        wp_enqueue_script('bootstrap-js-modal');

///////// Bootstrap scrollspy (requires util)
//        wp_register_script( 'bootstrap-js-scrollspy', get_template_directory_uri() . "/assets/node_modules/bootstrap/js/dist/scrollspy{$minified}.js", array( 'jquery', 'bootstrap-js-util' ), '4.1.3', true);
//        wp_enqueue_script('bootstrap-js-scrollspy');

///////// Bootstrap tab (requires util)
//        wp_register_script( 'bootstrap-js-tab', get_template_directory_uri() . "/assets/node_modules/bootstrap/js/dist/tab{$minified}.js", array( 'jquery', 'bootstrap-js-util' ), '4.1.3', true);
//        wp_enqueue_script('bootstrap-js-tab');

///////// Bootstrap tooltip (requires popper and util)
//        wp_register_script( 'bootstrap-js-tooltip', get_template_directory_uri() . "/assets/node_modules/bootstrap/js/dist/tooltip{$minified}.js", array( 'jquery', 'popper.js', 'bootstrap-js-util' ), '4.1.3', true);
//        wp_enqueue_script('bootstrap-js-tooltip');

///////// Bootstrap popover (requires tooltip)
//        wp_register_script( 'bootstrap-js-popover', get_template_directory_uri() . "/assets/node_modules/bootstrap/js/dist/popover{$minified}.js", array( 'jquery', 'bootstrap-js-tooltip' ), '4.1.3', true);
//        wp_enqueue_script('bootstrap-js-popover');

////Bootstrap bundle
//        wp_register_script( 'bootstrap-js', get_template_directory_uri() . "/assets/vendors/bootstrap/dist/js/bootstrap.bundle{$minified}.js", array( 'jquery' ), '4.1.1', true);
//        wp_enqueue_script('bootstrap-js');