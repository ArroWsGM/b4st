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
     * reruns it.
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
        register_post_type( _B4ST_TTD . 'quotes',
                            array(
                                'labels'        => array(
                                    'name'               => __( 'Цитаты и анекдоты', _B4ST_TTD ),
                                    'singular_name'      => __( 'Цитата', _B4ST_TTD ),
                                    'add_new'            => _x( 'Добавить', 'Добавить цитату', _B4ST_TTD ),
                                    'add_new_item'       => __( 'Добавить новую цитату', _B4ST_TTD ),
                                    'new_item'           => __( 'Новая цитата', _B4ST_TTD ),
                                    'edit_item'          => __( 'Изменить цитату', _B4ST_TTD ),
                                    'view_item'          => __( 'Посмотреть цитату', _B4ST_TTD ),
                                    'all_items'          => __( 'Все цитаты', _B4ST_TTD ),
                                    'search_items'       => __( 'Искать цитаты', _B4ST_TTD ),
                                    'parent_item_colon'  => __( 'Родительская цитата:', _B4ST_TTD ),
                                    'not_found'          => __( 'Цитаты не найдены.', _B4ST_TTD ),
                                    'not_found_in_trash' => __( 'В корзине цитаты не найдены.', _B4ST_TTD ),
                                    'menu_name'          => __( 'Цитаты', _B4ST_TTD ),
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
        register_taxonomy( _B4ST_TTD . 'quotes_cat',
                           _B4ST_TTD . 'quotes',
                           array(
                               'labels'            => array(
                                   'name'              => _x( 'Категории цитат и анекдотов', 'taxonomy general name', _B4ST_TTD ),
                                   'singular_name'     => _x( 'Категория', 'taxonomy singular name', _B4ST_TTD ),
                                   'search_items'      => __( 'Искать категории', _B4ST_TTD ),
                                   'all_items'         => __( 'Все категории', _B4ST_TTD ),
                                   'parent_item'       => __( 'Родительская категория', _B4ST_TTD ),
                                   'parent_item_colon' => __( 'Родительская категория:', _B4ST_TTD ),
                                   'edit_item'         => __( 'Изменить категорию', _B4ST_TTD ),
                                   'update_item'       => __( 'Обновить категорию', _B4ST_TTD ),
                                   'add_new_item'      => __( 'Добавить категорию', _B4ST_TTD ),
                                   'new_item_name'     => __( 'Имя новой категории', _B4ST_TTD ),
                                   'menu_name'         => __( 'Категории', _B4ST_TTD ),
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