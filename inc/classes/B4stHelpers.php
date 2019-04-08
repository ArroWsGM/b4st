<?php

class B4stHelpers extends B4st {
    /**
     * @var B4st Static property to hold singleton instance
     */
    static $instance = false;

    public function __construct() {
        //Calling parent constructor
        parent::__construct();

        //Custom theme code below
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
}