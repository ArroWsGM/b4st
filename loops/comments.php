<?php
/**!
 * Custom Feedback
 * https://codex.wordpress.org/Function_Reference/wp_list_comments#Comments_Only_With_A_Custom_Comment_Display
 */
// Do not delete this section
if ( isset( $_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'Please do not load this page directly. Thanks!' );
}
if ( post_password_required() ) { ?>
    <div class="alert alert-warning">
        <?php _e( 'Эта статья защищена паролем. Введите пароль, чтобы увидеть комментарии', _B4ST_TTD ); ?>
    </div>
    <?php
    return;
}
// End do not delete section

function b4st_comment( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    extract( $args, EXTR_SKIP );
    if ( 'div' == $args['style'] ) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }
    ?>

    <<?php echo $tag ?><?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
    <?php if ( 'div' != $args['style'] ) : ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
    <?php endif; ?>

    <div class="comment-author vcard">
        <div class="float-left pr-3">
            <?php echo get_avatar( $comment->comment_author_email, $size = '52' ); ?>
        </div>
        <div>
            <h4 class="m-0"><?php comment_author(); ?></h4>
            <p class="comment-meta commentmetadata"><a
                        href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf( '%1$s ' . __( 'в', _B4ST_TTD ) . ' %2$s', get_comment_date(), get_comment_time() ) ?></a>
            </p>
            <?php if ( $comment->comment_approved == '0' ) : ?>
                <p><em class="comment-awaiting-moderation"><?php _e( 'Ваш комментарий на модерации.', _B4ST_TTD ) ?></em>
                </p>
            <?php endif; ?>
        </div>
    </div>

    <div>
        <?php comment_text() ?>
    </div>

    <div class="reply">
        <p>
            <?php comment_reply_link( array_merge( $args, array(
                                          'add_below'  => $add_below,
                                          'reply_text' => __( '<i class="fas fa-reply"></i> Ответить', 'textdomain' ),
                                          'depth'      => $depth,
                                          'max_depth'  => $args['max_depth'],
                                      ) )
            ); ?>
            <?php edit_comment_link( '<span class="btn btn-info">' . __( '<i class="fas fa-edit"></i> Редактировать', _B4ST_TTD ) . '</span>', ' ', '' ); ?>
        </p>
    </div>

    <?php if ( 'div' != $args['style'] ) : ?>
        </div>
    <?php endif;
}

/**!
 * Custom Comments Form
 */

if ( have_comments() ) : ?>

    <h3 class="mt-5 mb-3">
        <?php printf(
        /* translators: 1: title. */
            esc_html__( 'Комментарии', _B4ST_TTD ),
            '<span>' . get_the_title() . '</span>'
        ); ?>
    </h3>

    <p><i class="fas fa-comment"></i> <?php
        $comment_count = get_comments_number();
        if ( '1' === $comment_count ) {
            printf(
            /* translators: 1: title. */
                esc_html__( 'Один комментарий к &ldquo;%1$s&rdquo;', _B4ST_TTD ),
                '<span>' . get_the_title() . '</span>'
            );
        } else {
            printf(
            /* translators: 1: comment count number, 2: title. */
                esc_html( _nx( '%1$s комментарий к &ldquo;%2$s&rdquo;', '%1$s комментариев к &ldquo;%2$s&rdquo;', $comment_count, 'comments title', _B4ST_TTD ) ),
                number_format_i18n( $comment_count ),
                '<span>' . get_the_title() . '</span>'
            );
        }
        ?>
    </p>

    <ol class="commentlist">
        <?php wp_list_comments( 'type=comment&callback=b4st_comment' ); ?>
    </ol>

    <p class="text-muted">
        <?php paginate_comments_links(); ?>
    </p>

<?php
else :
    if ( comments_open() ) :
        echo '<p class="alert alert-info">' . __( 'Оставьте первый комментарий.', _B4ST_TTD ) . '</p>';
    else :
        echo '<p class="alert alert-warning">' . __( 'Комментарии к этой статье закрыты.', _B4ST_TTD ) . '</p>';
    endif;
endif;
?>

<?php if ( comments_open() ) : ?>
    <section id="respond">

        <h3 class="mt-5"><?php comment_form_title( __( 'Оставьте комментарий', _B4ST_TTD ), __( 'Ответить %s', _B4ST_TTD ) ); ?></h3>
        <p><?php cancel_comment_reply_link(); ?></p>
        <?php if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ) : ?>
            <p><?php printf( __( 'Вы должны <a href="%s">войти</a> чтобы оставить комментарий.', _B4ST_TTD ), wp_login_url( get_permalink() ) ); ?></p>
        <?php else : ?>

            <form action="<?php echo get_option( 'url' ); ?>/wp-comments-post.php" method="post" id="commentform">

                <?php if ( is_user_logged_in() ) : ?>
                    <p>
                        <?php printf( __( 'Вы вошли как', _B4ST_TTD ) . ' <a href="%s/wp-admin/profile.php">%s</a>.', get_option( 'url' ), $user_identity ); ?>
                        <a href="<?php echo wp_logout_url( get_permalink() ); ?>"
                           title="<?php __( 'Выйти из этого аккаунта', _B4ST_TTD ); ?>"><?php echo __( 'Выйти', _B4ST_TTD ) . ' <i class="fas fa-arrow-right"></i>'; ?></a>
                    </p>
                <?php else : ?>

                    <div class="form-group">
                        <label for="author"><?php _e( 'Ваше имя', _B4ST_TTD );
                            if ( $req ) {
                                echo ' <span class="text-muted">' . __( '(обязательно)', _B4ST_TTD ) . '</span>';
                            } ?></label>
                        <input type="text" class="form-control" name="author" id="author"
                               placeholder="<?php _e( 'Ваше имя', _B4ST_TTD ); ?>"
                               value="<?php echo esc_attr( $comment_author ); ?>" <?php if ( $req ) {
                            echo 'aria-required="true"';
                        } ?>>
                    </div>

                    <div class="form-group">
                        <label for="email"><?php _e( 'Ваш email', _B4ST_TTD );
                            if ( $req ) {
                                echo '&nbsp;<span class="text-muted">' . __( '(обязательно, но не будет опубликовано)', _B4ST_TTD ) . '</span>';
                            } ?></label>
                        <input type="email" class="form-control" name="email" id="email"
                               placeholder="<?php _e( 'Ваш email', _B4ST_TTD ); ?>"
                               value="<?php echo esc_attr( $comment_author_email ); ?>" <?php if ( $req ) {
                            echo 'aria-required="true"';
                        } ?>>
                    </div>

                    <div class="form-group">
                        <label for="url"><?php echo __( 'Ваш сайт', _B4ST_TTD ) . ' <span class="text-muted">' . __( 'не обязательно', _B4ST_TTD ) . '</span>'; ?></label>
                        <input type="url" class="form-control" name="url" id="url"
                               placeholder="<?php _e( 'URL вашего сайта', _B4ST_TTD ); ?>"
                               value="<?php echo esc_attr( $comment_author_url ); ?>">
                    </div>

                <?php endif; ?>

                <div class="form-group">
                    <label for="comment"><?php _e( 'Ваш комментарий', _B4ST_TTD ); ?></label>
                    <textarea name="comment" class="form-control" id="comment"
                              placeholder="<?php _e( 'Ваш комментарий', _B4ST_TTD ); ?>" rows="8"
                              aria-required="true"></textarea>
                </div>

                <p><input name="submit" class="btn btn-default" type="submit" id="submit"
                          value="<?php _e( 'Отправить', _B4ST_TTD ); ?>"></p>

                <?php comment_id_fields(); ?>
                <?php do_action( 'comment_form', $post->ID ); ?>
            </form>
        <?php endif; ?>

    </section>
<?php endif; ?>
