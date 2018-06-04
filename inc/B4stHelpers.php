<?php

class B4stHelpers {
    /**
     * Static property to hold singleton instance
     */
    static $instance = false;
    protected $dir;

    public function __construct() {
        $this->dir = get_stylesheet_directory();
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
}