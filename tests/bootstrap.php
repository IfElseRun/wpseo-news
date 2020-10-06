<?php
/**
 * PHPUnit bootstrap file
 *
 * @package WPSEO_News\Tests
 */

define( 'ABSPATH', true );
define( 'WPSEO_INDEXABLES', true );

define( 'MINUTE_IN_SECONDS', 60 );
define( 'HOUR_IN_SECONDS', 3600 );
define( 'DAY_IN_SECONDS', 86400 );
define( 'WEEK_IN_SECONDS', 604800 );
define( 'MONTH_IN_SECONDS', 2592000 );
define( 'YEAR_IN_SECONDS', 31536000 );

define( 'DB_HOST', 'nowhere' );
define( 'DB_NAME', 'none' );
define( 'DB_USER', 'nobody' );
define( 'DB_PASSWORD', 'nothing' );

if ( function_exists( 'opcache_reset' ) ) {
	opcache_reset();
}

if ( file_exists( __DIR__ . '/mockobject-autoload.php' ) ) {
	// This file MUST be loaded before the Composer autoload file.
	require_once __DIR__ . '/mockobject-autoload.php';
}

if ( file_exists( dirname( __DIR__ ) . '/vendor/autoload.php' ) === false ) {
	echo PHP_EOL, 'ERROR: Run `composer install` to generate the autoload files before running the unit tests.', PHP_EOL;
	exit( 1 );
}

require_once __DIR__ . '/../vendor/autoload.php';
