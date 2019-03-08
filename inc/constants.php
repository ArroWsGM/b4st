<?php

//Theme text domain, option prefixes etc.
if ( ! defined( '_T_VERSION' ) ) {
    define( '_T_VERSION', 1.2 );
}

//Theme text domain, option prefixes etc.
if ( ! defined( '_B4ST_TTD' ) ) {
    define( '_B4ST_TTD', 'b4st' );
}

//Turn on or off separate logging
//Log will appear in theme directory, file name: _B4ST_TTD_.log
if ( ! defined( '_LOGGING_ON' ) ) {
    define( '_LOGGING_ON', true );
}

//Default logo src from theme root
if ( ! defined( '_DEFAULT_LOGO_SRC' ) ) {
    define( '_DEFAULT_LOGO_SRC', '/assets/img/default-logo.png' );
}

//Placeholder for font icons, like Font Awesome
if ( ! defined( '_FONTICON_PLACEHOLDER' ) ) {
    define( '_FONTICON_PLACEHOLDER', '<i class="%s"></i>' );
}
