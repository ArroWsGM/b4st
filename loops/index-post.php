<?php
/*
The Index Post (or excerpt)
===========================
Used by index.php, category.php and author.php
*/
?>

<article class="mb-5" role="article" id="post_<?php the_ID() ?>" <?php post_class(); ?> >
    <header>
        <h2>
            <a href="<?php the_permalink(); ?>">
                <?php the_title() ?>
            </a>
        </h2>
        <p class="text-muted">
            <i class="far fa-calendar-alt"></i>&nbsp;<?php b4st_post_date(); ?>&nbsp;|
            <i class="far fa-user"></i>&nbsp; <?php _e( 'От ', _TTD );
            the_author_posts_link(); ?>&nbsp;|
            <i class="far fa-comment"></i>&nbsp;<a
                    href="<?php comments_link(); ?>"><?php printf( _nx( 'Один комментарий', '%1$s комментариев', get_comments_number(), 'Link to comments with total number', _TTD ), number_format_i18n( get_comments_number() ) ); ?></a>
        </p>
    </header>
    <div>
        <?php the_post_thumbnail(); ?>

        <?php if ( has_excerpt( $post->ID ) ) {
            the_excerpt();
            ?><p><a href="<?php the_permalink(); ?>">
                <?php _e( '&hellip; ' . __( 'Читать дальше', _TTD ) . ' <i class="far fa-arrow-right"></i>', _TTD ) ?>
            </a></p>
        <?php } else {
            the_content( __( '&hellip; ' . __( 'Читать дальше', _TTD ) . ' <i class="far fa-arrow-right"></i>', _TTD ) );
        } ?>
    </div>
</article>
