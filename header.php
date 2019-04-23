<?php
if ( ! class_exists( 'B4stHelpers' ) )
    wp_die( 'Class B4stHelpers not found!' );

global $b4sth;
?>
<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<nav class="navbar navbar-expand-md navbar-light bg-light">
    <div class="container">

        <?php $b4sth->get_logo(); ?>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarDropdown"
                aria-controls="navbarDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarDropdown">
            <?php
            wp_nav_menu( array(
                             'theme_location' => 'navbar',
                             'container'      => false,
                             'menu_class'     => '',
                             'fallback_cb'    => '__return_false',
                             'items_wrap'     => '<ul id="%1$s" class="navbar-nav mr-auto mt-2 mt-lg-0 %2$s">%3$s</ul>',
                             'depth'          => 2,
                             'walker'         => new B4stWalkerNavMenu(),
                         ) );
            ?>

            <?php $b4sth->the_socials( 'navbar-text ml-lg-4' ); ?>

            <form class="form-inline ml-auto pt-2 pt-md-0" role="search" method="get" id="header_search" action="<?php echo home_url( '/' ) ?>">
                <div class="input-group">
                    <input
                           id="header_search_s"
                           class="form-control"
                           type="text"
                           value="<?php the_search_query() ?>"
                           placeholder="<?php _e( 'Поиск', _B4ST_TTD ) ?>..."
                           aria-label="<?php _e( 'Поиск', _B4ST_TTD ) ?>"
                           name="s"
                    >
                    <div class="input-group-append">
                        <button type="submit" id="header_search_searchsubmit" value="<?php _e( 'Поиск', _B4ST_TTD ) ?>" class="btn btn-primary"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</nav>
