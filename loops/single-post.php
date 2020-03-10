<?php
/*
The Single Post
===============
*/
?>

<?php if ( have_posts() ): while( have_posts() ): the_post(); ?>
    <article role="article" id="post_<?php the_ID() ?>" <?php post_class() ?>>
        <header class="mb-4">
            <h1>
                <?php the_title() ?>
            </h1>
            <div class="header-meta text-muted">
                <?php
                _e( 'От ', _B4ST_TTD );
                the_author_posts_link();
                _e( ' в ', _B4ST_TTD );
                ?>
                <?php echo B4stHelpers::post_date(); ?>
            </div>
        </header>
        <main>
            <?php
            the_post_thumbnail();
            the_content();
            wp_link_pages();
            ?>
        </main>
        <footer class="mt-5 border-top pt-3">
            <p>
                <?php _e( 'Категория: ', _B4ST_TTD );
                the_category( ', ' ) ?> | <?php if ( has_tag() ) {
                    the_tags( 'Tags: ', ', ' ); ?> | <?php }
                _e( 'Комментариев', _B4ST_TTD ); ?>: <?php printf( number_format_i18n( get_comments_number() ) ); ?>
            </p>
            <div class="author-bio media border-top pt-3">
                <?php echo B4stHelpers::author_avatar(); ?>
                <div class="media-body ml-3">
                    <p class="h4 author-name"><?php the_author_posts_link(); ?></p>
                    <p class="author-description"><?php echo B4stHelpers::author_description(); ?></p>
                    <p class="author-other-posts mb-0 border-top pt-3"><?php _e( 'Другие статьи от ', _B4ST_TTD );
                        the_author_posts_link(); ?></p>
                </div>
            </div><!-- /.author-bio -->
        </footer>
    </article>
    <?php
    if ( comments_open() || get_comments_number() ) :
        //comments_template();
        comments_template( '/loops/comments.php' );
    endif;
endwhile;
endif;
?>


<div class="row mt-5 border-top pt-3">
    <div class="col">
        <?php previous_post_link( '%link', '<i class="fas fa-fw fa-arrow-left"></i> ' . '%title' ); ?>
    </div>
    <div class="col text-right">
        <?php next_post_link( '%link', '%title' . ' <i class="fas fa-fw fa-arrow-right"></i>' ); ?>
    </div>
</div>
