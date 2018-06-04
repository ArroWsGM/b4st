<?php

class B4stCustomPostTypes {
    /**
     * Static property to hold our singleton instance
     *
     */
    static $instance = false;

    /**
     * This is our constructor
     *
     * @return void
     */
    private function __construct() {
        // back end
        add_action( 'init', array( $this, 'add_quotes_post_type' ) );
        add_action( 'init', array( $this, 'add_quotes_post_type_tax' ) );
    }

    /**
     * If an instance exists, this returns it.  If not, it creates one and
     * retuns it.
     *
     * @return B4stCustomPostTypes
     */
    public static function getInstance() {
        if ( ! self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * add video post type
     */
    public function add_quotes_post_type() {
        register_post_type( _TTD . 'quotes',
                            array(
                                'labels'        => array(
                                    'name'               => __( 'Цитаты и анекдоты', _TTD ),
                                    'singular_name'      => __( 'Цитата', _TTD ),
                                    'add_new'            => _x( 'Добавить', 'Добавить цитату', _TTD ),
                                    'add_new_item'       => __( 'Добавить новую цитату', _TTD ),
                                    'new_item'           => __( 'Новая цитата', _TTD ),
                                    'edit_item'          => __( 'Изменить цитату', _TTD ),
                                    'view_item'          => __( 'Посмотреть цитату', _TTD ),
                                    'all_items'          => __( 'Все цитаты', _TTD ),
                                    'search_items'       => __( 'Искать цитаты', _TTD ),
                                    'parent_item_colon'  => __( 'Родительская цитата:', _TTD ),
                                    'not_found'          => __( 'Цитаты не найдены.', _TTD ),
                                    'not_found_in_trash' => __( 'В корзине цитаты не найдены.', _TTD ),
                                    'menu_name'          => __( 'Цитаты', _TTD ),
                                ),
                                'public'        => true,
                                'has_archive'   => true,
                                'menu_position' => 6,
                                'menu_icon'     => 'dashicons-format-quote',
                                'supports'      => array(
                                    'title',
                                    'editor',
//                                    'thumbnail',
//                                    'comments',
//                                    'post-formats',
                                ),
                                'rewrite'       => array(
                                    'slug'       => 'quotes',
                                    'with_front' => false,
                                    'pages'      => true,
                                ),
                            )
        );
    }

    /**
     * Add video post tax
     */
    public function add_quotes_post_type_tax () {
        register_taxonomy( _TTD . 'quotes_cat',
                           _TTD . 'quotes',
                           array(
                               'labels'            => array(
                                   'name'              => _x( 'Категории цитат и анекдотов', 'taxonomy general name', _TTD ),
                                   'singular_name'     => _x( 'Категория', 'taxonomy singular name', _TTD ),
                                   'search_items'      => __( 'Искать категории', _TTD ),
                                   'all_items'         => __( 'Все категории', _TTD ),
                                   'parent_item'       => __( 'Родительская категория', _TTD ),
                                   'parent_item_colon' => __( 'Родительская категория:', _TTD ),
                                   'edit_item'         => __( 'Изменить категорию', _TTD ),
                                   'update_item'       => __( 'Обновить категорию', _TTD ),
                                   'add_new_item'      => __( 'Добавить категорию', _TTD ),
                                   'new_item_name'     => __( 'Имя новой категории', _TTD ),
                                   'menu_name'         => __( 'Категории', _TTD ),
                               ),
                               'hierarchical'      => true,
                               'show_ui'           => true,
                               'show_admin_column' => true,
                               'show_in_nav_menus' => false,
                               'query_var'         => true,
                               'rewrite'           => array( 'slug' => 'quotes-category' ),
                           )
        );
    }

}