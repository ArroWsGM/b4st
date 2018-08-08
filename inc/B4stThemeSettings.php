<?php

class B4stThemeSettings {
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;
    private $on;
    private static $banner_number = 0;

    /**
     * Start up
     */
    public function __construct() {
        $this->on = _TTD . '_theme_options';

        add_action( 'admin_enqueue_scripts', array( $this, 'add_media_support' ) );
        add_action( 'admin_footer', array( $this, 'add_media_script' ) );
        add_action( 'admin_menu', array( $this, 'add_theme_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );

        add_action( 'admin_notices', function() {
            settings_errors( _TTD . '_settings_errors' );
        } );
    }

    /**
     * Add options page
     */
    public function add_theme_page() {
        add_theme_page(
            __( 'Настройки темы', _TTD ),
            __( 'Настройки темы', _TTD ),
            'manage_options',
            _TTD . '-settings',
            array( $this, 'settings_page' )
        );
    }

    /**
     * Options page callback
     */
    public function settings_page() {
        // Set class property
        $this->options = get_option( $this->on );
        ?>
        <div class="wrap">
            <h1><?php _e( 'Настройки темы', _TTD ) ?></h1>
            <form method="post" action="options.php">
                <?php
                // This prints out all hidden setting fields
                settings_fields( _TTD . '-theme-options' );
                do_settings_sections( _TTD . '-settings' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init() {
        register_setting(
            _TTD . '-theme-options', // Option group
            $this->on, // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'contacts_section', // ID
            __( 'Контакты', _TTD ), // Title
            array( $this, 'print_contacts_section_info' ), // Callback
            _TTD . '-settings' // Page
        );

        add_settings_field(
            'contacts_email', // ID
            __( 'Email', _TTD ), // Title
            array( $this, 'contacts_email_callback' ), // Callback
            _TTD . '-settings', // Page
            'contacts_section' // Section
        );

        add_settings_field(
            'contacts_phone',
            __( 'Номер телефона', _TTD ),
            array( $this, 'contacts_phone_callback' ),
            _TTD . '-settings',
            'contacts_section'
        );

        add_settings_field(
            'contacts_address', // ID
            __( 'Адрес', _TTD ), // Title
            array( $this, 'contacts_address_callback' ), // Callback
            _TTD . '-settings', // Page
            'contacts_section' // Section
        );

        add_settings_section(
            'social_section', // ID
            __( 'Профили социальных сетей', _TTD ), // Title
            array( $this, 'print_socials_section_info' ), // Callback
            _TTD . '-settings' // Page
        );

        add_settings_field(
            'social_profiles', // ID
            __( 'Соц. сети', _TTD ), // Title
            array( $this, 'social_callback' ), // Callback
            _TTD . '-settings', // Page
            'social_section' // Section
        );

        add_settings_section(
            'banners_section', // ID
            __( 'Баннеры', _TTD ), // Title
            array( $this, 'print_banners_section_info' ), // Callback
            _TTD . '-settings' // Page
        );

        add_settings_field(
            'banners_callback', // ID
            __( 'Изображения и ссылки для баннеров', _TTD ), // Title
            array( $this, 'banners_callback' ), // Callback
            _TTD . '-settings', // Page
            'banners_section' // Section
        );

        add_settings_section(
            'other_section', // ID
            __( 'Другие настройки', _TTD ), // Title
            array( $this, 'print_other_section_info' ), // Callback
            _TTD . '-settings' // Page
        );

        add_settings_field(
            'other_callback', // ID
            __( 'Остальные настройки темы', _TTD ), // Title
            array( $this, 'other_callback' ), // Callback
            _TTD . '-settings', // Page
            'other_section' // Section
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     *
     * @return array
     */
    public function sanitize( $input ) {

        $new_input = array();
        $type      = '';
        $message   = __( 'Настройки обновлены.', _TTD );

        if ( isset( $input['contacts_email'] ) ) {
            $new_input['contacts_email'] = sanitize_email( $input['contacts_email'] );
        }

        if ( isset( $input['contacts_address'] ) ) {
            $data = trim( wp_kses_post( $input['contacts_address'] ) );

            if ( $data ) {
                $new_input['contacts_address'] = $data;
            }
        }

        if ( isset( $input['social_profiles'] ) && ! empty( $input['social_profiles'] ) && is_array( $input['social_profiles'] ) ) {
            foreach ( $input['social_profiles'] as $key => $val ) {
                if ( ! empty( $input['social_profiles'][$key] ) ) {
                    $new_input['social_profiles'][$key] = esc_url( $input['social_profiles'][$key], array( 'http', 'https' ) );
                }
            }
        }

        if ( isset( $input['contacts_phone'] ) ) {
            foreach ( $input['contacts_phone'] as $key => $val ) {
                $output = preg_replace( '/[^0-9]/', '', $val );

                if ( strlen( $output ) != 12 ) {
                    if ( strlen( $output > 0 ) ) {
                        $type    = 'error';
                        $message = __( 'Неверный номер телефона!', _TTD );
                    }
                    continue;
                }

                $new_input['contacts_phone'][ $key ] = '+' . $output;
            }
        }

        if ( isset( $input['banner_0'] ) ) {
            $new_input['banner_0'] = esc_url( $input['banner_0'], array( 'http', 'https' ) );
        }

        if ( isset( $input['banner_0_link'] ) ) {
            $new_input['banner_0_link'] = esc_url( $input['banner_0_link'], array( 'http', 'https' ) );
        }

        if ( isset( $input['banner_1'] ) ) {
            $new_input['banner_1'] = esc_url( $input['banner_1'], array( 'http', 'https' ) );
        }

        if ( isset( $input['banner_1_link'] ) ) {
            $new_input['banner_1_link'] = esc_url( $input['banner_1_link'], array( 'http', 'https' ) );
        }

        if ( isset( $input['pop_threshold'] ) ) {
            $pop_threshold = abs( (int) $input['pop_threshold'] );
            $pop_threshold = $pop_threshold < _POP_TR ? _POP_TR : $pop_threshold;
            $new_input['pop_threshold'] = $pop_threshold;
        }

        $type = $type ?: 'updated';
        add_settings_error(
            _TTD . '_settings_errors',
            esc_attr( 'settings_updated' ),
            $message,
            $type
        );

        return $new_input;
    }

    /**
     * Add media library pop-up
     */
    public function add_media_support() {
        wp_enqueue_media();

        wp_register_style( _TTD . '-admin-css', get_template_directory_uri() . '/assets/css/' . _TTD . '-admin.css', null, '1.0' );
        wp_enqueue_style( _TTD . '-admin-css' );
    }

    /**
     * Add media library pop-up
     */
    public function add_media_script() {
        ?>

        <script>
            (function ($) {
                $(function () {
                    var custom_uploader,
                        btnAdd = $('.banner-img, .banner-img-btn-add'),
                        btnRemove = $('.banner-img-btn-del')

                    btnAdd.click(function (e) {
                        e.preventDefault()
                        var targetInput = $('#' + $(this).data('target') + '_input'),
                            targetImg = $('#' + $(this).data('target') + '_img')
                        //
                        // //If the uploader object has already been created, reopen the dialog
                        // if (custom_uploader) {
                        //     custom_uploader.open()
                        //     return
                        // }
                        //Extend the wp.media object
                        custom_uploader = wp.media.frames.file_frame = wp.media({
                            title: '<?php _e( 'Выберите баннер', _TTD ) ?>',
                            button: {
                                text: '<?php _e( 'Выберите баннер', _TTD ) ?>'
                            },
                            multiple: false,
                            library: {
                                post_mime_type: [
                                    'image/png',
                                    'image/jpeg',
                                    'image/gif'
                                ]
                            }
                        })
                        //When a file is selected, grab the URL and set it as the text field's value
                        custom_uploader.on('select', function () {
                            var attachment = custom_uploader.state().get('selection').first().toJSON()
                            targetInput.val(attachment.url)
                            targetImg.attr('src', attachment.url).css('display', 'block')
                        })
                        //Open the uploader dialog
                        custom_uploader.open()
                    })

                    btnRemove.click(function (e) {
                        e.preventDefault()
                        var targetInput = $('#' + $(this).data('target') + '_input'),
                            targetImg = $('#' + $(this).data('target') + '_img')

                        targetInput.val('')
                        targetImg.hide()
                    })
                })
            }(jQuery))
        </script>

        <?php
    }

    /**
     * Print the Section text
     */
    public function print_contacts_section_info() {
        _e( 'Введите контактную информацию.', _TTD );
    }

    /**
     * Print the Section text
     */
    public function print_socials_section_info() {
        _e( 'Введите адреса профилей для социальных сетей.', _TTD );
    }

    /**
     * Print the Section text
     */
    public function print_banners_section_info() {
        _e( 'Баннеры.', _TTD );
    }

    /**
     * Print the Section text
     */
    public function print_other_section_info(){
        _e( 'Настройки, не подпадающие под другие категории.', _TTD );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function contacts_email_callback() {
        $contacts_email = isset( $this->options['contacts_email'] ) ? $this->options['contacts_email'] : '';

        echo '<p><input type="text" id="contacts_email" name="' . $this->on . '[contacts_email]" value="' . $contacts_email . '" placeholder="email@example.com" class="regular-text ltr"></p>';
        ?>
        <p class="description"><?php _e( 'Если email не указан, будет использоваться почта из основных настроек CMS.', _TTD ) ?></p>
        <?php
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function contacts_phone_callback() {
        $contacts_phones = isset( $this->options['contacts_phone'] ) ? $this->options['contacts_phone'] : [];

        ?>
        <p>
            <?php

            if ( count( $contacts_phones ) > 0 ) {
                foreach ( $contacts_phones as $key => $val ) {
                    echo '<input type="text" id="contacts_phone" name="' . $this->on . '[contacts_phone][' . $key . ']" value="' . $val . '" class="regular-text ltr"><br>';
                }
            }

            echo '<input type="text" id="contacts_phone" name="' . $this->on . '[contacts_phone][phone_' . ( count( $contacts_phones ) + 1 ) . ']" value="" placeholder="+380xxxxxxxxx" class="regular-text ltr">';
            ?>
        </p>
        <p class="description"><?php _e( 'Вводите номера в международном формате. Для удаления номера просто очистите поле.', _TTD ) ?></p>
        <?php
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function contacts_address_callback() {
        $contacts_address = isset( $this->options['contacts_address'] ) ? $this->options['contacts_address'] : '';

        echo '<p><textarea rows="5" id="contacts_address" name="' . $this->on . '[contacts_address]" class="regular-text ltr">' . $contacts_address . '</textarea></p>';
        ?>
        <p class="description"><?php _e( 'Введите адрес. Поддерживаются простейшие html-теги.', _TTD ) ?></p>
        <?php
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function social_callback() {
        $social_fb = isset( $this->options['social_profiles']['social_fb'] ) ? $this->options['social_profiles']['social_fb'] : '';
        echo '<p>' . __('Facebook', _TTD) . '<br>';
        echo '<input type="text" id="social_fb" name="' . $this->on . '[social_profiles][social_fb]" value="' . $social_fb . '" placeholder="' . __('URL социальной сети', _TTD) . '" class="regular-text ltr">';
        echo '</p>';

        $social_twitter = isset( $this->options['social_profiles']['social_twitter'] ) ? $this->options['social_profiles']['social_twitter'] : '';
        echo '<p>' . __('Twitter', _TTD) . '<br>';
        echo '<input type="text" id="social_twitter" name="' . $this->on . '[social_profiles][social_twitter]" value="' . $social_twitter . '" placeholder="' . __('URL социальной сети', _TTD) . '" class="regular-text ltr">';
        echo '</p>';

        $social_youtube = isset( $this->options['social_profiles']['social_youtube'] ) ? $this->options['social_profiles']['social_youtube'] : '';
        echo '<p>' . __('Youtube', _TTD) . '<br>';
        echo '<input type="text" id="social_youtube" name="' . $this->on . '[social_profiles][social_youtube]" value="' . $social_youtube . '" placeholder="' . __('URL социальной сети', _TTD) . '" class="regular-text ltr">';
        echo '</p>';

        $social_instagram = isset( $this->options['social_profiles']['social_instagram'] ) ? $this->options['social_profiles']['social_instagram'] : '';
        echo '<p>' . __('Instagram', _TTD) . '<br>';
        echo '<input type="text" id="social_instagram" name="' . $this->on . '[social_profiles][social_instagram]" value="' . $social_instagram . '" placeholder="' . __('URL социальной сети', _TTD) . '" class="regular-text ltr">';
        echo '</p>';

        $social_telegram = isset( $this->options['social_profiles']['social_telegram'] ) ? $this->options['social_profiles']['social_telegram'] : '';
        echo '<p>' . __('Telegram', _TTD) . '<br>';
        echo '<input type="text" id="social_telegram" name="' . $this->on . '[social_profiles][social_telegram]" value="' . $social_telegram . '" placeholder="' . __('URL социальной сети', _TTD) . '" class="regular-text ltr">';
        echo '</p>';

        $social_rss = isset( $this->options['social_profiles']['social_rss'] ) ? $this->options['social_profiles']['social_rss'] : '';
        echo '<p>' . __('RSS feed', _TTD) . '<br>';
        echo '<input type="text" id="social_rss" name="' . $this->on . '[social_profiles][social_rss]" value="' . $social_rss . '" placeholder="' . __('URL социальной сети', _TTD) . '" class="regular-text ltr">';
        echo '</p>';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function banners_callback() {
        $banner_0 = isset( $this->options['banner_0'] ) ? $this->options['banner_0'] : '';
        $link_0 = isset( $this->options['banner_0_link'] ) ? $this->options['banner_0_link'] : '';
        $banner_1 = isset( $this->options['banner_1'] ) ? $this->options['banner_1'] : '';
        $link_1 = isset( $this->options['banner_1_link'] ) ? $this->options['banner_1_link'] : '';

        ?>
        <p><?php _e( 'Баннер для левой колонки главной страницы', _TTD ) ?></p>
        <?php
        $this->banner_field($banner_0, $link_0);
        ?>
        <br>
        <p><?php _e( 'Баннер для правой колонки всего сайта', _TTD ) ?></p>
        <?php
        $this->banner_field($banner_1, $link_1);
    }

    /**
     * Draw banner section
     */
    private function banner_field ($banner, $link) {
        $display = $banner ? 'display: block; ' : 'display: none; ';
        ?>
        <p>
        <img src="<?php echo esc_url( $banner, array( 'http', 'https' ) ) ?>"
             alt="<?php _e( 'Баннер', _TTD ) ?>"
             style="<?php echo $display; ?>max-width: 350px; height: auto; margin-bottom: 15px"
             class="banner-img"
             data-target="banner_<?php echo self::$banner_number; ?>"
             id="banner_<?php echo self::$banner_number; ?>_img"
        >

        <input
            type="hidden"
            name="<?php echo $this->on; ?>[banner_<?php echo self::$banner_number; ?>]"
            value="<?php echo $banner; ?>"
            data-target="banner_<?php echo self::$banner_number; ?>"
            id="banner_<?php echo self::$banner_number; ?>_input"
        >
        </p>

        <p>
        <button
            type="button"
            class="button banner-img-btn-add"
            data-target="banner_<?php echo self::$banner_number; ?>"
        ><?php _e( 'Выберите баннер', _TTD ) ?></button>

        <button
            type="button"
            class="button button-danger banner-img-btn-del"
            data-target="banner_<?php echo self::$banner_number; ?>"
        >x</button>
        </p>
        <p>
        <input
            type="text"
            name="<?php echo $this->on; ?>[banner_<?php echo self::$banner_number; ?>_link]"
            value="<?php echo $link; ?>"
            placeholder="Ссылка для баннера"
            class="regular-text ltr"
        >
        </p>
        <?php

        self::$banner_number++;
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function other_callback() {
        $pop_threshold = isset( $this->options['pop_threshold'] ) ? $this->options['pop_threshold'] : '';

        echo '<p>' . __('Минимальное значение количества просмотров для присвоения ярлыка `Популярное`', _TTD) . '</p>';
        echo '<input type="number" id="pop_threshold" name="' . $this->on . '[pop_threshold]" value="' . $pop_threshold . '" placeholder="' . __('Минимум ' . _POP_TR, _TTD) . '" class="regular-text ltr">';
    }
}

if ( is_admin() ) {
    new B4stThemeSettings();
}