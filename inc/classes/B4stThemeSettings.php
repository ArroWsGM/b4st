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
        if (
                ! defined( '_B4ST_VERSION' ) ||
                ! defined( '_B4ST_TTD' )
        ) {
            wp_die( 'Core constants missing in  ' . basename(__FILE__, '.php') );
        }

        $this->on = _B4ST_TTD . '_theme_options';

        add_action( 'admin_enqueue_scripts', array( $this, 'add_media_support' ) );
        add_action( 'admin_footer', array( $this, 'add_media_script' ) );
        add_action( 'admin_menu', array( $this, 'add_theme_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );

        add_action( 'admin_notices', function() {
            settings_errors( _B4ST_TTD . '_settings_errors' );
        } );
    }

    /**
     * Add options page
     */
    public function add_theme_page() {
        add_theme_page(
            __( 'Настройки темы', _B4ST_TTD ),
            __( 'Настройки темы', _B4ST_TTD ),
            'manage_options',
            _B4ST_TTD . '-settings',
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
            <h1><?php _e( 'Настройки темы', _B4ST_TTD ) ?></h1>
            <form method="post" action="options.php">
                <?php
                // This prints out all hidden setting fields
                settings_fields( _B4ST_TTD . '-theme-options' );
                do_settings_sections( _B4ST_TTD . '-settings' );
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
            _B4ST_TTD . '-theme-options', // Option group
            $this->on, // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'contacts_section', // ID
            __( 'Контакты', _B4ST_TTD ), // Title
            array( $this, 'print_contacts_section_info' ), // Callback
            _B4ST_TTD . '-settings' // Page
        );

        add_settings_field(
            'contacts_email', // ID
            __( 'Email', _B4ST_TTD ), // Title
            array( $this, 'contacts_email_callback' ), // Callback
            _B4ST_TTD . '-settings', // Page
            'contacts_section' // Section
        );

        add_settings_field(
            'contacts_phone',
            __( 'Номер телефона', _B4ST_TTD ),
            array( $this, 'contacts_phone_callback' ),
            _B4ST_TTD . '-settings',
            'contacts_section'
        );

        add_settings_field(
            'contacts_address', // ID
            __( 'Адрес', _B4ST_TTD ), // Title
            array( $this, 'contacts_address_callback' ), // Callback
            _B4ST_TTD . '-settings', // Page
            'contacts_section' // Section
        );

        add_settings_section(
            'social_section', // ID
            __( 'Профили социальных сетей', _B4ST_TTD ), // Title
            array( $this, 'print_socials_section_info' ), // Callback
            _B4ST_TTD . '-settings' // Page
        );

        add_settings_field(
            'social_profiles', // ID
            __( 'Соц. сети', _B4ST_TTD ), // Title
            array( $this, 'social_callback' ), // Callback
            _B4ST_TTD . '-settings', // Page
            'social_section' // Section
        );

        add_settings_section(
            'analytics_section', // ID
            __( 'Аналитика и реклама', _B4ST_TTD ), // Title
            array( $this, 'print_analytics_section_info' ), // Callback
            _B4ST_TTD . '-settings' // Page
        );

        add_settings_field(
            'analytics_callback', // ID
            __( 'Коды и идентификаторы аналитики и рекламных аккаунтов', _B4ST_TTD ), // Title
            array( $this, 'analytics_callback' ), // Callback
            _B4ST_TTD . '-settings', // Page
            'analytics_section' // Section
        );
        add_settings_field(
            'analytics_callback_foot', // ID
            __( 'Коды и идентификаторы аналитики и рекламных аккаунтов', _B4ST_TTD ), // Title
            array( $this, 'analytics_callback' ), // Callback
            _B4ST_TTD . '-settings', // Page
            'analytics_section' // Section
        );

        add_settings_section(
            'banners_section', // ID
            __( 'Баннеры', _B4ST_TTD ), // Title
            array( $this, 'print_banners_section_info' ), // Callback
            _B4ST_TTD . '-settings' // Page
        );

        add_settings_field(
            'banners_callback', // ID
            __( 'Изображения и ссылки для баннеров', _B4ST_TTD ), // Title
            array( $this, 'banners_callback' ), // Callback
            _B4ST_TTD . '-settings', // Page
            'banners_section' // Section
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
        $setting   = _B4ST_TTD . '_settings_errors';
        $code      = 'settings_updated';

        if ( isset( $input['contacts_email'] ) && ! empty( $input['contacts_email'] ) ) {
            $new_input['contacts_email'] = sanitize_email( $input['contacts_email'] );
        }

        if ( isset( $input['contacts_phone'] ) && ! empty( $input['contacts_phone'] ) ) {
            foreach ( $input['contacts_phone'] as $key => $val ) {
                $output = preg_replace( '/[^0-9]/', '', $val );

                $length = strlen( $output );
                if ( $length > 15 || $length < 10 ) {
                    if ( strlen( $output > 0 ) ) {
                        add_settings_error(
                            $setting,
                            $code,
                            __( 'Неверный номер телефона!', _B4ST_TTD ),
                            'error'
                        );
                    }
                    continue;
                }

                $new_input['contacts_phone'][ $key ] = '+' . $output;
            }
        }

        if ( isset( $input['contacts_address'] ) && ! empty( $input['contacts_address'] ) ) {
            $data = trim( wp_kses_post( $input['contacts_address'] ) );

            if ( $data ) {
                $new_input['contacts_address'] = $data;
            }
        }

        if ( isset( $input['socials'] ) && ! empty( $input['socials'] ) && is_array( $input['socials'] ) ) {
            $i = 0;
            foreach ( $input['socials'] as $social ) {
                if ( ! empty( $social['url'] ) ) {
                    if ( empty( $social['slug'] ) && empty( $social['ico'] ) ) {
                        add_settings_error(
                            $setting,
                            $code,
                            __( 'Поля `Название сети` и `Иконка` пустые. Должно быть заполнено хотя бы одно поле!', _B4ST_TTD ),
                            'error'
                        );
                        continue;
                    }

                    $url = esc_url( $social['url'], array( 'http', 'https' ) );

                    if ( ! $url ) {
                        add_settings_error(
                            $setting,
                            $code,
                            __( 'Ошибка в поле URL!', _B4ST_TTD ),
                            'error'
                        );
                        continue;
                    }

                    $new_input['socials'][ $i ]['url']  = $url;
                    $new_input['socials'][ $i ]['slug'] = trim( esc_attr( $social['slug'] ) );
                    $new_input['socials'][ $i ]['ico']  = trim( esc_attr( $social['ico'] ) );

                    $i++;
                }
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

        add_settings_error(
            $setting,
            $code,
            __( 'Настройки обновлены.', _B4ST_TTD ),
            'updated'
        );

        return $new_input;
    }

    /**
     * Add media library pop-up
     */
    public function add_media_support() {
        wp_enqueue_media();

        wp_register_style( _B4ST_TTD . '-admin-css', get_template_directory_uri() . '/assets/css/styles-admin.min.css', null, _B4ST_VERSION );
        wp_enqueue_style( _B4ST_TTD . '-admin-css' );
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

                        //Extend the wp.media object
                        custom_uploader = wp.media.frames.file_frame = wp.media({
                            title: '<?php _e( 'Выберите баннер', _B4ST_TTD ) ?>',
                            button: {
                                text: '<?php _e( 'Выберите баннер', _B4ST_TTD ) ?>'
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
        _e( 'Введите контактную информацию.', _B4ST_TTD );
    }

    /**
     * Print the Section text
     */
    public function print_socials_section_info() {
        _e( 'Введите адреса профилей для социальных сетей.', _B4ST_TTD );
    }

    /**
     * Print the Section text
     */
    public function print_banners_section_info() {
        _e( 'Баннеры.', _B4ST_TTD );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function contacts_email_callback() {
        $contacts_email = isset( $this->options['contacts_email'] ) ? $this->options['contacts_email'] : '';

        echo '<p><input type="email" id="contacts_email" name="' . $this->on . '[contacts_email]" value="' . $contacts_email . '" placeholder="' . get_option( 'admin_email', 'email@example.com') . '" class="regular-text ltr"></p>';
        ?>
        <p class="description"><?php _e( 'Если email не указан, будет использоваться почта из основных настроек CMS.', _B4ST_TTD ) ?></p>
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
        <p class="description"><?php _e( 'Вводите номера в международном формате. Для удаления номера просто очистите поле.', _B4ST_TTD ) ?></p>
        <?php
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function contacts_address_callback() {
        $contacts_address = isset( $this->options['contacts_address'] ) ? $this->options['contacts_address'] : '';

        wp_editor( $contacts_address, 'contacts_address', array(
            'wpautop'       => false,
            'media_buttons' => true,
            'textarea_name' => $this->on . '[contacts_address]',
            'textarea_rows' => 5,
            'teeny'         => true,
        ) );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function social_callback() {
        $socials = isset( $this->options['socials'] ) && ! empty( $this->options['socials'] ) ? $this->options['socials'] : '';
        $i       = 0;

        if ( ! empty( $socials ) && is_array( $socials ) ) {
            foreach ( $socials as $social ) {
                echo '<h4>' . $social['slug'] . '</h4>';
                echo '<p><label for="socials-' . $i . '-slug">' . __( 'Название сети', _B4ST_TTD ) . '</label>  <input type="text" id="socials-' . $i . '-slug" name="' . $this->on . '[socials][' . $i . '][slug]" value="' . $social['slug'] . '" placeholder="' . __( 'Название сети', _B4ST_TTD ) . '" class="regular-text ltr"><br>';
                echo '<label for="socials-' . $i . '-ico">' . __( 'Класс иконки FA5', _B4ST_TTD ) . '</label><input type="text" id="socials-' . $i . '-ico" name="' . $this->on . '[socials][' . $i . '][ico]" value="' . $social['ico'] . '" placeholder="' . __( 'Класс иконки Font Awesome 5', _B4ST_TTD ) . '" class="regular-text ltr"><br>';
                echo '<label for="socials-' . $i . '-url">' . __( 'URL профиля сети', _B4ST_TTD ) . '</label><input type="url" id="socials-' . $i . '-url" name="' . $this->on . '[socials][' . $i . '][url]" value="' . $social['url'] . '" placeholder="' . __( 'URL социальной сети', _B4ST_TTD ) . '" class="regular-text ltr">';
                echo '</p>';
                $i ++;
            }
        }

        echo '<h4>' . __( 'Добавьте новую сеть', _B4ST_TTD ) . '</h4>';
        echo '<p><label for="socials-' . $i . '-slug">' . __( 'Название сети', _B4ST_TTD ) . '</label>  <input type="text" id="socials-' . $i . '-slug" name="' . $this->on . '[socials][' . $i . '][slug]" placeholder="' . __( 'Название сети', _B4ST_TTD ) . '" class="regular-text ltr"><br>';
        echo '<label for="socials-' . $i . '-ico">' . __( 'Класс иконки FA5', _B4ST_TTD ) . '</label><input type="text" id="socials-' . $i . '-ico" name="' . $this->on . '[socials][' . $i . '][ico]" placeholder="' . __( 'Класс иконки Font Awesome 5', _B4ST_TTD ) . '" class="regular-text ltr"><br>';
        echo '<label for="socials-' . $i . '-url">' . __( 'URL профиля сети', _B4ST_TTD ) . '</label><input type="url" id="socials-' . $i . '-url" name="' . $this->on . '[socials][' . $i . '][url]" placeholder="' . __( 'URL социальной сети', _B4ST_TTD ) . '" class="regular-text ltr">';
        echo '</p>';

        echo '<p class="description">'
             . __( 'Для удаления сети просто очистите соответствующее поле URL.', _B4ST_TTD )
             . __( ' Список всех иконок <a href="https://fontawesome.com/icons?d=gallery" target="_blank">здесь.</a>.', _B4ST_TTD )
             . __( ' По умолчанию доступны Facebook, Instagram, Linkedin, Telegram, Twitter, Youtube и RSS.', _B4ST_TTD )
             . __( ' Если Вам нужны другие, обратитесь к программисту с просьбой добавить необходимую иконку.', _B4ST_TTD )
             . '</p>';
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
        <p><?php _e( 'Баннер 1', _B4ST_TTD ) ?></p>
        <?php
        $this->banner_field($banner_0, $link_0);
        ?>
        <br>
        <p><?php _e( 'Баннер 2', _B4ST_TTD ) ?></p>
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
             alt="<?php _e( 'Баннер', _B4ST_TTD ) ?>"
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
        ><?php _e( 'Выберите баннер', _B4ST_TTD ) ?></button>

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
    public function print_analytics_section_info() {
        _e( 'Настройки аналитики и рекламы.', _B4ST_TTD );
    }
    /**
     * Get the settings option array and print one of its values
     */
    public function analytics_callback() {
        ?>
        <div class="section-preferences">
            <h3><?php _e( 'SEO-аналитика в head.', _B4ST_TTD ); ?></h3>
            <?php
            $analytics_head = isset( $this->options['analytics_head'] ) ? $this->options['analytics_head'] : '';
            echo '<p><label for="analytics_head">' . __( 'Вставьте код(ы) аналитики. Будьте внимательны! Ошибки в этом поле могут вызвать проблемы с отображением сайта или даже сделать его полностью неработоспособным!', _B4ST_TTD ) . '</label>';
            echo '<textarea id="analytics_head" name="' . $this->on . '[analytics_head]" class="large-text code" rows="10" cols="25">' . $analytics_head . '</textarea></p>';
            ?>
        </div>
        <?php
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function analytics_callback_foot() {
        ?>
        <div class="section-preferences">
            <h3><?php _e( 'SEO-аналитика в foot.', _B4ST_TTD ); ?></h3>
            <?php
            $analytics_foot = isset( $this->options['analytics_foot'] ) ? $this->options['analytics_foot'] : '';
            echo '<p><label for="analytics_foot">' . __( 'Вставьте код(ы) аналитики. Будьте внимательны! Ошибки в этом поле могут вызвать проблемы с отображением сайта или даже сделать его полностью неработоспособным!', _B4ST_TTD ) . '</label>';
            echo '<textarea id="analytics_foot" name="' . $this->on . '[analytics_foot]" class="large-text code" rows="10" cols="25">' . $analytics_foot . '</textarea></p>';
            ?>
        </div>
        <?php
    }
}

if ( is_admin() ) {
    new B4stThemeSettings();
}