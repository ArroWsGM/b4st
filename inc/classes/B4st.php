<?php

class B4st {
    /**
     * @var array Theme settings
     */
    public static $options;

    /**
     * @var string Theme base directory
     */
    protected $dir;

    /**
     * @var B4st Static property to hold singleton instance
     */
    static $instance = false;

    /**
     * B4st constructor.
     * @uses wp_die()
     */
    public function __construct() {
        if (
                ! defined( '_B4ST_TTD' ) ||
                ! defined( '_FONTICON_PLACEHOLDER' ) ||
                ! defined( '_DEFAULT_LOGO_SRC' ) ||
                ! defined( '_LOGGING_ON' )
        ) {
            wp_die('Can\'t find core constant!');
        }

        $this->dir = get_stylesheet_directory();
        //Set theme options
        self::$options = get_option( _B4ST_TTD . '_theme_options' );
    }

    /**
     * Singleton. If an instance exists, this returns it.  If not, it creates one and
     * returns it.
     *
     * @return B4st
     */
    public static function getInstance() {
        if ( ! self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Prepare data and write it to log
     *
     * @param mixed $log
     *
     * @uses _LOGGING_ON
     * @uses log_write()
     */
    public function log( $log ) {
        if ( _LOGGING_ON ) {
            if ( is_array( $log ) || is_object( $log ) ) {
                $this->log_write( print_r( $log, true ) );
            } else {
                $this->log_write( $log );
            }
        }
    }

    /**
     * Write content into a file
     *
     * @param string $log
     *
     * @uses $dir
     * @uses _B4ST_TTD
     */
    protected function log_write( $log ) {
        $file   = $this->dir . '/_' . _B4ST_TTD . '_.log';
        $output = '[' . date( "Y-m-d H:i:s" ) . ']: ';
        $output .= $log;
        $output .= "\n";
        file_put_contents( $file, $output, FILE_APPEND | LOCK_EX );
    }

    /**
     * Return site logo src
     *
     * @param bool $default return default logo or not
     *
     * @uses get_theme_mod()
     * @uses wp_get_attachment_image_url()
     * @uses get_template_directory_uri()
     * @uses _DEFAULT_LOGO_SRC
     *
     * @return string
     */
    protected function get_logo_src( $default = false ) {
        $custom_logo_id = get_theme_mod( 'custom_logo' );

        if ( $custom_logo_id && ! $default ) {
            $logo = wp_get_attachment_image_url( $custom_logo_id, 'full', true );
            return $logo ?: '';
        } else {
            return _DEFAULT_LOGO_SRC ? get_template_directory_uri() . _DEFAULT_LOGO_SRC : '';
        }
    }

    /**
     * Displays site logo
     *
     * @param bool $img_only draw only img tag or full wrapper (not applicable for svg logo)
     *
     * @uses get_theme_mod()
     * @uses get_post_mime_type()
     * @uses wp_get_attachment_image()
     * @uses wp_get_attachment_image_src()
     * @uses home_url()
     * @uses bloginfo()
     * @uses get_bloginfo()
     * @uses get_custom_logo()
     */
    public function get_logo( $img_only = false ) {
        $custom_logo_id = get_theme_mod( 'custom_logo' );
        $type           = get_post_mime_type( $custom_logo_id );

        switch ( $type ) {
            case 'image/jpeg':
            case 'image/png':
            case 'image/gif':
                $type = 'image';
                break;
            case 'image/svg+xml':
                $type = 'svg';
                break;
            default:
                $type = '';
        }

        if ( $type == 'svg' ) {
            $src = wp_get_attachment_image_src( $custom_logo_id );
            if ( is_array( $src ) ) {
                $logo = '<a href="' . home_url( '/' ) . '" class="custom-logo-link navbar-brand" rel="home" itemprop="url"><span class="custom-logo" >%s</span></a>';
                $svg  = trim( preg_replace( '/<\?xml.*?\?>/i', '', file_get_contents( $src[0] ) ) ); //strip xml header and remove spaces
                printf( $logo, $svg );
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
                       href="<?php echo home_url( '/' ); ?>"><?php bloginfo( 'name' ); ?></a>
                    <?php
                }
            }
        }
    }

    /**
     * Returns the post excerpt
     *
     * @param int $trim_words maximum excerpt length if needed
     * @param bool $mode use standard wp function or not
     * @param null|WP_Post $post WP Post object or null
     * @param string $more append symbol
     *
     * @uses get_the_excerpt()
     * @uses $wp_version
     * @uses excerpt_remove_blocks()
     * @uses strip_shortcodes()
     * @uses Html2Text
     *
     * @return string
     */
    public function get_the_excerpt( $trim_words = 35, $mode = true, $post = null, $more = '&hellip;' ) {
        if ( $mode ) {
            $excerpt = get_the_excerpt( $post );
        } else {
            if ( ! is_a( $post, 'WP_Post' ) ) {
                global $post;
            }

            $more_pos = mb_stripos( $post->post_content, '<!--more-->' );

            if ( $more_pos != false ) {
                $excerpt = mb_substr( $post->post_content, 0, $more_pos );
            } else {
                $excerpt = $post->post_content;
            }

            global $wp_version;
            if ( version_compare( $wp_version, '5.0', '>=' ) ) {
                $excerpt = excerpt_remove_blocks( strip_shortcodes( $excerpt ) );
            } else {
                $excerpt = strip_shortcodes( $excerpt );
            }

            $h2t = new Html2Text( $excerpt, array( 'do_links' => 'none', 'width' => 0 ) );
            $h2t->set_allowed_tags( '<i><em><strong>' );

            $excerpt = nl2br( $h2t->getText() );

            if ( $more_pos != false ) {
                return $excerpt;
            }
        }

        return wp_trim_words( $excerpt, (int) $trim_words, $more );
    }

    /**
     * Pass parameters and display small template part. Can be used multiple times
     *
     * @param string $slug template name relative to theme or parent theme directory
     * @param array $opt options to pass
     */
    public function get_chunk( $slug, $opt = array() ) {
        if ( $slug && is_string( $slug ) ) {
            $templates[] = "$slug.php";

            $this->find_template( $templates, false, $opt );
        }
    }

    /**
     * Loads template with optional parameters
     *
     * @param array $template_names array of  template names to load relative to theme or parent theme directory
     * @param bool $require_once check if template already loaded or not
     * @param array $opt options to pass. Currently `set_query_var` is used
     *
     * @uses get_stylesheet_directory()
     * @uses get_template_directory()
     * @uses esc_attr()
     * @uses set_query_var()
     * @uses load_template()
     *
     * TODO: [Maybe] Use WP transient API or custom session-based flash for passing params
     */
    protected function find_template( $template_names, $require_once = true, $opt = array() ) {
        if ( is_array( $template_names ) ) {

            $located = '';

            foreach ( $template_names as $template_name ) {
                if ( ! $template_name ) {
                    continue;
                }
                if ( file_exists( get_stylesheet_directory() . "/$template_name" ) ) {
                    $located = get_stylesheet_directory() . "/$template_name";
                    break;
                } elseif ( file_exists( get_template_directory() . "/$template_name" ) ) {
                    $located = get_template_directory() . "/$template_name";
                    break;
                }
            }

            if ( $located != '' ) {

                if ( is_array( $opt ) && ! empty( $opt ) ) {
                    if ( isset( $opt['id'] ) && $opt['id'] ) {
                        $opt['id'] = esc_attr( $opt['id'] );
                    }

                    if ( isset( $opt['class'] ) && $opt['class'] ) {
                        $opt['class'] = esc_attr( $opt['class'] );
                    }

                    if ( isset( $opt['style'] ) && $opt['style'] ) {
                        $opt['style'] = esc_attr( $opt['style'] );
                    }

                    if ( ! empty( $opt ) ) {
                        set_query_var( 'chunk_options', $opt );
                    }
                }

                load_template( $located, $require_once );
            }

        }
    }

    /**
     * Converts HEX color representation into rgb(a)
     *
     * @param string $hex color code
     * @param bool $alpha convert with alpha-channel or not
     *
     * @return string
     */
    protected function hexToRgbColor( $hex, $alpha = false ) {
        $hex    = str_replace( '#', '', $hex );
        $length = strlen( $hex );
        $red    = hexdec( $length == 6 ? substr( $hex, 0, 2 ) : ( $length == 3 ? str_repeat( substr( $hex, 0, 1 ), 2 ) : 0 ) );
        $green  = hexdec( $length == 6 ? substr( $hex, 2, 2 ) : ( $length == 3 ? str_repeat( substr( $hex, 1, 1 ), 2 ) : 0 ) );
        $blue   = hexdec( $length == 6 ? substr( $hex, 4, 2 ) : ( $length == 3 ? str_repeat( substr( $hex, 2, 1 ), 2 ) : 0 ) );
        if ( $alpha !== false ) {
            return "rgba($red, $green, $blue, $alpha)";
        } else {
            return "rgb($red, $green, $blue)";
        }

    }

    /**
     * Returns or displays human readable phone number for international formatted numbers
     *
     * @param string $phone
     * @param bool $echo
     *
     * @uses _e()
     * @uses __()
     * @uses _B4ST_TTD
     *
     * @return void|string
     */
    public function get_formatted_phone( $phone, $echo = false ) {
        if ( ! preg_match( '/^\+[0-9]{10,15}$/', $phone ) ) {
            if ( $echo ) {
                _e( 'Неверный номер телефона', _B4ST_TTD );
            } else {
                return __( 'Неверный номер телефона', _B4ST_TTD );
            }
        } else {
            $matches = null;
            preg_match( '/^(\d{2})(\d{2})(\d{3})(\d{2})(.+)$/', strrev( $phone ), $matches );

            $string = strrev( "{$matches[1]}-$matches[2]-{$matches[3]} ){$matches[4]}( {$matches[5]}" );

            if ( $echo ) {
                echo $string;
            } else {
                return $string;
            }
        }
    }

    /**
     * Returns first contact phone number from theme options.
     *
     * @return string
     */
    protected function get_first_contact_phone() {
        return isset( self::$options['contacts_phone'] ) && is_array( self::$options['contacts_phone'] )
            ? reset( self::$options['contacts_phone'] ) : '';
    }

    /**
     * Return email from theme settings (if presents) or admin email
     *
     * @uses get_option()
     *
     * @return string
     */
    protected function get_email() {
        return isset( self::$options['contacts_email'] ) ? self::$options['contacts_email'] : get_option( 'admin_email', 'admin@example.com' );
    }

    /**
     * Display pagination with Twitter Bootstrap 4 styling
     *
     * @param null|WP_Query $wp_query
     *
     * @uses $wp_query
     * @uses get_pagenum_link()
     * @uses get_query_var()
     * @uses paginate_links()
     */
    public static function get_pagination( $wp_query = null ) {
        if ( ! $wp_query ) {
            global $wp_query;
        }
        $big = 999999999; // This needs to be an unlikely integer
        // For more options and info view the docs for paginate_links()
        // http://codex.wordpress.org/Function_Reference/paginate_links
        $paginate_links = paginate_links( array(
                                              'base'      => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
                                              'current'   => max( 1, get_query_var( 'paged' ) ),
                                              'total'     => $wp_query->max_num_pages,
                                              'mid_size'  => 5,
                                              'prev_next' => true,
                                              'prev_text' => __( '<i class="fas fa-angle-left"></i> Новее', _B4ST_TTD ),
                                              'next_text' => __( 'Старее <i class="fas fa-angle-right"></i>', _B4ST_TTD ),
                                              'type'      => 'list',
                                          ) );
        $paginate_links = str_replace( "<ul class='page-numbers'>", "<ul class='pagination'>", $paginate_links );
        $paginate_links = str_replace( "<li>", "<li class='page-item'>", $paginate_links );
        $paginate_links = str_replace( "<li class='page-item'><span aria-current='page' class='page-numbers current'>", "<li class='page-item active'><a class='page-link' href='#'>", $paginate_links );
        $paginate_links = str_replace( "<a", "<a class='page-link' ", $paginate_links );

        $paginate_links = str_replace( "</span>", "</a>", $paginate_links );
        $paginate_links = preg_replace( "/\s*page-numbers/", "", $paginate_links );
        // Display the pagination if more than one page is found
        if ( $paginate_links ) {
            echo $paginate_links;
        }
    }

    /**
     * Returns socials list HTML
     *
     * @param string $class additional wrapper class
     * @param bool $show_slug Show network name if ico presents
     *
     * @uses _FONTICON_PLACEHOLDER
     *
     * @return string
     */
    public function get_socials( $class = '', $show_slug = false ) {
        $socials = self::$options['socials'];

        $html = '';

        if ( ! empty( $socials ) && is_array( $socials ) ) {
            foreach ( $socials as $social ) {
                if ( ! $social['url'] || ! ( $social['slug'] || $social['ico'] ) ) {
                    continue;
                }

                $item = '<li><a href="' . $social['url'] . '" target="_blank" rel="nofollow noopener noreferrer">%s%s</a></li>';

                if ( $social['ico'] ) {
                    $social['ico'] = sprintf( _FONTICON_PLACEHOLDER, $social['ico'] );

                    if ( $show_slug && $social['slug'] ) {
                        $social['slug'] = '&nbsp;' . $social['slug'];
                    } else {
                        $social['slug'] = '';
                    }
                }

                $html .= sprintf( $item, $social['ico'], $social['slug'] );
            }

            if ( $html ) {
                $html = '<ul class="social-list ' . esc_attr( $class ) . '">' . $html . '</ul>';
            }
        }

        return $html;
    }

    /**
     * Displays socials list HTML
     *
     * @param string $class additional wrapper class
     * @param bool $show_slug Show network name if ico presents
     */
    public function the_socials( $class = '', $show_slug = false ) {
        echo $this->get_socials( $class, $show_slug );
    }
}