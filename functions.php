<?php
/*
All the functions are in the PHP files in the `functions/` folder.
*/

require get_template_directory() . '/inc/constants.php';
require get_template_directory() . '/inc/cleanup.php';
require get_template_directory() . '/inc/setup.php';
require get_template_directory() . '/inc/enqueues.php';

require get_template_directory() . '/inc/B4stHelpers.php';
$b4sth = B4stHelpers::getInstance();

require get_template_directory() . '/inc/B4stThemeSettings.php';
require get_template_directory() . '/inc/B4stCustomPostTypes.php';
B4stCustomPostTypes::getInstance();

require get_template_directory() . '/inc/navbar.php';
require get_template_directory() . '/inc/widgets.php';


require get_template_directory() . '/inc/index-pagination.php';
require get_template_directory() . '/inc/single-split-pagination.php';