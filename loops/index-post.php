<?php
/*
The Index Post (or excerpt)
===========================
Used by index.php, category.php and author.php
*/
global $b4sth;
?>

<article class="mb-5" role="article" id="post_<?php the_ID() ?>" <?php post_class(); ?> >
    <header>
        <h2>
            <a href="<?php the_permalink(); ?>">
                <?php the_title() ?>
            </a>
        </h2>
        <p class="text-muted">
            <i class="fas fa-calendar-alt"></i>&nbsp;<?php B4stHelpers::post_date(); ?>&nbsp;|
            <i class="fas fa-user"></i>&nbsp; <?php _e( 'От ', _B4ST_TTD );
            the_author_posts_link(); ?>&nbsp;|
            <i class="fas fa-comment"></i>&nbsp;<a
                    href="<?php comments_link(); ?>"><?php printf( _nx( 'Один комментарий', '%1$s комментариев', get_comments_number(), 'Link to comments with total number', _B4ST_TTD ), number_format_i18n( get_comments_number() ) ); ?></a>
        </p>
    </header>
    <div>
        <?php the_post_thumbnail(); ?>

        <p><?php echo $b4sth->get_the_excerpt( 100, false ) ?></p>
    </div>
</article>
