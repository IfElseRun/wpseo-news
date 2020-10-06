<?php
/**
 * Yoast SEO: News plugin test file.
 *
 * @package WPSEO_News\Tests
 */

// Disable Xdebug backtrace.
if ( function_exists( 'xdebug_disable' ) ) {
	xdebug_disable();
}

echo 'Welcome to the Yoast News SEO test suite' . PHP_EOL;
echo 'Version: 1.0' . PHP_EOL . PHP_EOL;

if ( getenv( 'WP_DEVELOP_DIR' ) !== false ) {
	define( 'WP_DEVELOP_DIR', getenv( 'WP_DEVELOP_DIR' ) );
}

if ( getenv( 'WP_PLUGIN_DIR' ) !== false ) {
	define( 'WP_PLUGIN_DIR', getenv( 'WP_PLUGIN_DIR' ) );
}

$GLOBALS['wp_tests_options'] = [
	'active_plugins' => [ 'wordpress-seo/wp-seo.php', 'wpseo-news/wpseo-news.php' ],
];

if ( file_exists( dirname( __DIR__ ) . '/tests/mockobject-autoload.php' ) ) {
	// This file MUST be loaded before the Composer autoload file.
	require_once dirname( __DIR__ ) . '/tests/mockobject-autoload.php';
}

if ( file_exists( dirname( __DIR__ ) . '/vendor/autoload.php' ) === false ) {
	echo PHP_EOL, 'ERROR: Run `composer install` to generate the autoload files before running the unit tests.', PHP_EOL;
	exit( 1 );
}

if ( defined( 'WP_DEVELOP_DIR' ) ) {
	if ( file_exists( WP_DEVELOP_DIR . 'tests/phpunit/includes/bootstrap.php' ) ) {
		require WP_DEVELOP_DIR . 'tests/phpunit/includes/bootstrap.php';
	}
	else {
		echo PHP_EOL, 'ERROR: Please check the WP_DEVELOP_DIR environment variable. Based on the current value ', WP_DEVELOP_DIR, ' the WordPress native unit test bootstrap file could not be found.', PHP_EOL;
		exit( 1 );
	}
}
elseif ( file_exists( '../../../../tests/phpunit/includes/bootstrap.php' ) ) {
	require '../../../../tests/phpunit/includes/bootstrap.php';
}
else {
	echo PHP_EOL, 'ERROR: The WordPress native unit test bootstrap file could not be found. Please set the WP_DEVELOP_DIR environment variable either in your OS or in a custom phpunit.xml file.', PHP_EOL;
	exit( 1 );
}

if ( ! defined( 'WP_PLUGIN_DIR' ) || file_exists( WP_PLUGIN_DIR . '/wpseo-news/wpseo-news.php' ) === false ) {
	echo PHP_EOL, 'ERROR: Please check whether the WP_PLUGIN_DIR environment variable is set and set to the correct value. The unit test suite won\'t be able to run without it.', PHP_EOL;
	exit( 1 );
}

// Include unit test base class.
require_once __DIR__ . '/framework/unittestcase.php';
