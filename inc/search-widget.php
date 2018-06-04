<?php
/**!
 * Search form in widget
 */

if ( ! function_exists( 'b4st_search_form' ) ) {

    function b4st_search_form( $form ) {
        $form = '<form class="form-inline mb-3" role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
      <input class="form-control mr-sm-1" type="text" value="' . get_search_query() . '" placeholder="' . __( 'Поиск', _TTD ) . '..." name="s" id="s" />
      <button type="submit" id="searchsubmit" value="' . __( 'Поиск', _TTD ) . '" class="btn btn-primary"><i class="far fa-search"></i></button>
    </form>';

        return $form;
    }
}
add_filter( 'get_search_form', 'b4st_search_form' );