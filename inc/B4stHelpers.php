<?php

class B4stHelpers {
    public static $options;
    /**
     * Static property to hold singleton instance
     */
    static $instance = false;
    protected $dir;

    public function __construct() {
        $this->dir = get_stylesheet_directory();
        //Retrieve theme options
        self::$options = get_option( _TTD . '_theme_options' );
    }

    /**
     * Singletone. If an instance exists, this returns it.  If not, it creates one and
     * retuns it.
     *
     * @return B4stHelpers
     */
    public static function getInstance() {
        if ( ! self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function log( $log ) {
        if ( _LOGGING_ON ) {
            if ( is_array( $log ) || is_object( $log ) ) {
                $this->log_write( print_r( $log, true ) );
            } else {
                $this->log_write( $log );
            }
        }
    }

    protected function log_write ($log) {
        $file = $this->dir . '/_' . _TTD . '_.log';
        $output = '[' . date("Y-m-d H:i:s") . ']: ';
        $output .= $log;
        $output .= "\n";
        file_put_contents($file, $output, FILE_APPEND | LOCK_EX);
    }

    /**
     * @param bool $rss include rss link
     */
    public function get_socials( $rss = false ) {
        $feed_url = isset( self::$options['social_profiles']['social_telegram'] ) && ! empty( self::$options['social_profiles']['social_telegram'] ) ? self::$options['social_profiles']['social_telegram'] : get_bloginfo('rss2_url');
        $rss = $rss ? $feed_url : false;
        if (
            is_array( self::$options ) &&
            (
                self::$options['social_profiles']['social_fb'] ||
                self::$options['social_profiles']['social_twitter'] ||
                self::$options['social_profiles']['social_youtube'] ||
                self::$options['social_profiles']['social_instagram'] ||
                self::$options['social_profiles']['social_telegram'] ||
                $rss
            )
        ) :
            ?>
            <ul class="social-links">
                <?php
                if ( self::$options['social_profiles']['social_fb'] ) :
                    ?>
                    <li>
                        <a href="<?php echo self::$options['social_profiles']['social_fb'] ?>" class="social-link social-fb text-muted"
                           rel="nofollow" target="_blank"><i class="fab fa-facebook"></i></i></a>
                    </li>
                <?php
                endif;
                if ( self::$options['social_profiles']['social_twitter'] ) :
                    ?>
                    <li>
                        <a href="<?php echo self::$options['social_profiles']['social_twitter'] ?>"
                           class="social-link social-twitter text-muted" rel="nofollow" target="_blank"><i
                                class="fab fa-twitter"></i></i></a>
                    </li>
                <?php
                endif;
                if ( self::$options['social_profiles']['social_youtube'] ) :
                    ?>
                    <li>
                        <a href="<?php echo self::$options['social_profiles']['social_youtube'] ?>"
                           class="social-link social-youtube text-muted" rel="nofollow" target="_blank"><i
                                class="fab fa-youtube"></i></i></a>
                    </li>
                <?php
                endif;
                if ( self::$options['social_profiles']['social_instagram'] ) :
                    ?>
                    <li>
                        <a href="<?php echo self::$options['social_profiles']['social_instagram'] ?>"
                           class="social-link social-instagram text-muted" rel="nofollow" target="_blank"><i
                                class="fab fa-instagram"></i></i></a>
                    </li>
                <?php
                endif;
                if ( self::$options['social_profiles']['social_telegram'] ) :
                    ?>
                    <li>
                        <a href="<?php echo self::$options['social_profiles']['social_telegram'] ?>"
                           class="social-link social-telegram text-muted" rel="nofollow" target="_blank"><i
                                class="fab fa-telegram"></i></i></a>
                    </li>
                <?php
                endif;
                if ( $rss ) :
                    ?>
                    <li>
                        <a href="<?php echo $rss ?>"
                           class="social-link rss text-muted" rel="nofollow" target="_blank"><i
                                class="far fa-rss"></i></i></a>
                    </li>
                <?php
                endif;
                ?>
            </ul>
        <?php
        endif;
    }

    public function search_form( $echo = true, $class = 'form-inline mb-3', $id = 'searchform' ) {
        $form =   '<form class="' . $class . '" role="search" method="get" id="' . $id . '" action="' . home_url( '/' ) . '">';
        $form .=       '<div class="input-group">';
        $form .=           '<input class="form-control" type="text" value="' . get_search_query() . '" placeholder="' . __( 'Поиск', _TTD ) . '..." name="s" id="' . $id . '_s" />';
        $form .=           '<div class="input-group-append">';
        $form .=               '<button type="submit" id="' . $id . '_searchsubmit" value="' . __( 'Поиск', _TTD ) . '" class="btn btn-primary"><i class="far fa-search"></i></button>';
        $form .=           '</div>';
        $form .=       '</div>';
        $form .=  '</form>';

        if ( $echo ) {
            echo $form;
        } else {
            return $form;
        }
    }

    public function get_banner( $slug ) {
        if ( ! $slug ) {
            return null;
        }

        $img  = self::$options[ $slug ];
        $link = self::$options[ $slug . '_link' ];
        $alt  = self::$options[ $slug . '_title' ] ?: __( 'Баннер', _TTD );

        if ( ! $img ) {
            return null;
        }

        $img = '<img class="img-fluid d-block mx-auto" src="' . esc_url( $img ) . '" alt="' . $alt . '">';

        if ( $link ) {
            ?>
            <div class="banner-wrapper">
                <a href="<?php echo esc_url( $link ) ?>" class="d-block" rel="nofollow" target="_blank">
                    <?php echo $img ?>
                </a>
            </div>
            <?php
        } else {
            echo '<div class="banner-wrapper">' . $img . '</div>';
        }
    }

    public function get_logo( $img_only = false ) {
        $custom_logo_id = get_theme_mod( 'custom_logo' );
        $type = get_post_mime_type( $custom_logo_id );

        switch ( $type ) {
            case 'image/jpeg':
            case 'image/png':
            case 'image/gif': $type = 'image'; break;
            case 'image/svg+xml': $type = 'svg'; break;
            default: $type = '';
        }

        if ( $type == 'svg' ){
            $src = wp_get_attachment_image_src($custom_logo_id);
            if ( is_array( $src ) ) {
                $logo = '<a href="' . home_url('/') . '" class="custom-logo-link navbar-brand" rel="home" itemprop="url"><span class="custom-logo" >%s</span></a>';
                $svg = file_get_contents( $src[0] );
                printf($logo, $svg);
            }
        } elseif ( $img_only ) {
            $custom_logo_id = get_theme_mod( 'custom_logo' );

            // We have a logo.
            if ( $custom_logo_id ) {
                $custom_logo_attr = array(
                    'class'    => 'custom-logo',
                    'itemprop' => 'logo',
                    'alt'      => get_bloginfo( 'name', 'display' ),
                );

                echo wp_get_attachment_image( $custom_logo_id, 'full', false, $custom_logo_attr );
            }
        } else {
            if ( function_exists( 'get_custom_logo' ) ) {
                $logo = get_custom_logo();
                if ( $logo ) {
                    echo $logo;
                } else {
                    ?>
                    <a class="navbar-brand"
                       href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
                    <?php
                }
            }
        }
    }

    public function get_the_excerpt( $trim_words = 35, $mode = true, $post = null ) {
        if ( $mode ) {
            $excerpt = get_the_excerpt();
        } elseif ( ! $mode && is_a($post, 'WP_Post') ) {
            $excerpt = $post->post_content;
        } else {
            return '';
        }

        return wp_trim_words( $excerpt, (int) $trim_words, '&hellip;' );
    }
}