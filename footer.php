<?php global $b4sth; ?>
<footer class="site-footer mt-5">

    <div class="container">

        <?php if ( is_active_sidebar( 'footer-widget-area' ) ): ?>
            <div class="row border-bottom pt-5 pb-4" id="footer" role="navigation">
                <?php dynamic_sidebar( 'footer-widget-area' ); ?>
            </div>
        <?php endif; ?>

        <div class="row pt-3">
            <div class="col">
                <p class="text-center">&copy; <?php echo date( 'Y' ); ?> <a
                            href="<?php echo home_url( '/' ); ?>"><?php bloginfo( 'name' ); ?></a></p>
                <?php if ( $b4sth->get_email() || $b4sth->has_contact_phones() || $b4sth->get_address() ) : ?>
                    <ul class="list-unstyled mb-3">
                        <?php if ( $b4sth->get_email() ) : ?>
                            <li><?php _e( 'Пишите: ', _B4ST_TTD );
                                $b4sth->the_email() ?></li>
                        <?php endif; ?>
                        <?php if ( $b4sth->has_contact_phones() ) : ?>
                            <li><?php _e( 'Звоните: ', _B4ST_TTD );
                                $b4sth->the_contact_phones() ?></li>
                        <?php endif; ?>
                        <?php if ( $b4sth->get_address() ) : ?>
                            <li><?php _e( 'Заходите: ', _B4ST_TTD );
                                $b4sth->the_address() ?></li>
                        <?php endif; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>

    </div>

</footer>


<?php wp_footer(); ?>
<?php echo isset( B4stHelpers::$options['analytics_foot'] ) ? B4stHelpers::$options['analytics_foot'] : '' ?>
</body><!-- /body from header.php -->
</html><!-- /html from header.php -->
