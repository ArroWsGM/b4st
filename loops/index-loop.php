<?php
/**!
 * The Default Loop (used by index.php, category.php and author.php)
 * =================================================================
 * If you require only post excerpts to be shown in index and category pages,
 * use the [---more---] line within blog posts.
 */
?>

<?php if ( have_posts() ) : while( have_posts() ) : the_post(); ?>

    <?php get_template_part( 'loops/index-post', get_post_format() ); ?>

<?php endwhile; ?>

    <?php if ( class_exists( 'B4stHelpers' ) ) {
        B4stHelpers::get_pagination();
    } else if ( is_paged() ) { ?>
        <ul class="pagination">
            <li class="page-item older">
                <?php next_posts_link( '<i class="fas fa-arrow-left"></i> ' . __( 'Пред.', _B4ST_TTD ) ) ?></li>
            <li class="page-item newer">
                <?php previous_posts_link( __( 'След.', _B4ST_TTD ) . ' <i class="fas fa-arrow-right"></i>' ) ?></li>
        </ul>
    <?php } ?>

<?php
endif;
?>
