<?php
/**!
 * Widgets
 */

function b4st_widgets_init() {

  /*
  Sidebar (one widget area)
   */
  register_sidebar( array(
    'name'            => __( 'Сайдбар', _B4ST_TTD ),
    'id'              => 'sidebar-widget-area',
    'description'     => __( 'Виджеты сайдбара', _B4ST_TTD ),
    'before_widget'   => '<section class="%1$s %2$s">',
    'after_widget'    => '</section>',
    'before_title'    => '<h2 class="h4">',
    'after_title'     => '</h2>',
  ) );

  /*
  Footer (1, 2, 3, or 4 areas)

  Flexbox `col-sm` gives the correct the column width:

  * If only 1 widget, then this will have full width ...
  * If 2 widgets, then these will each have half width ...
  * If 3 widgets, then these will each have third width ...
  * If 4 widgets, then these will each have quarter width ...
  ... above the Bootstrap `sm` breakpoint.
   */

  register_sidebar( array(
    'name'            => __( 'Подвал', _B4ST_TTD ),
    'id'              => 'footer-widget-area',
    'description'     => __( 'Виджеты подвала', _B4ST_TTD ),
    'before_widget'   => '<div class="%1$s %2$s col-sm">',
    'after_widget'    => '</div>',
    'before_title'    => '<h2 class="h4">',
    'after_title'     => '</h2>',
  ) );

}
add_action( 'widgets_init', 'b4st_widgets_init' );