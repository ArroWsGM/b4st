<?php
/*
All the functions are in the PHP files in the `inc/` folder.
*/
require get_template_directory() . '/vendors/Html2Text.php';

require get_template_directory() . '/inc/constants.php';
require get_template_directory() . '/inc/cleanup.php';
require get_template_directory() . '/inc/setup.php';
require get_template_directory() . '/inc/enqueues.php';

require get_template_directory() . '/inc/classes/B4st.php';
require get_template_directory() . '/inc/classes/B4stHelpers.php';
$b4sth = B4stHelpers::getInstance();

require get_template_directory() . '/inc/classes/B4stThemeSettings.php';

//Custom posts type scaffolding
//Uncomment and fine tune if required
//require get_template_directory() . '/inc/classes/B4stCustomPostTypes.php';
//B4stCustomPostTypes::getInstance();

require get_template_directory() . '/inc/classes/B4stWalkerNavMenu.php';
require get_template_directory() . '/inc/navbar.php';

require get_template_directory() . '/inc/widgets.php';


require get_template_directory() . '/inc/single-split-pagination.php';