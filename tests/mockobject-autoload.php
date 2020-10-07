<?php
/**
 * Autoloader file for the PHPUnit 9 MockObject classes.
 *
 * @package WPSEO_News\Tests
 */

if ( defined( 'YOAST_NEWS_TEST_AUTOLOADER' ) === false ) {
	/*
	 * Hack around PHPUnit < 9.3 mocking not being compatible with PHP 8.
	 *
	 * This allows for cross-version compatibility with various PHP, PHPUnit and WP versions.
	 *
	 * @param string $class Class name to load.
	 *
	 * @return void
	 */
	spl_autoload_register(
		static function ( $class ) {
			if ( getenv( 'WP_DEVELOP_DIR' ) === false ) {
				return;
			}

			$wp_dir = getenv( 'WP_DEVELOP_DIR' );
			if ( file_exists( $wp_dir ) === false ) {
				// This install is not setup for running the integration tests.
				return;
			}

			$handle = [
				'PHPUnit\Framework\MockObject\Builder\NamespaceMatch' => true,
				'PHPUnit\Framework\MockObject\Builder\ParametersMatch' => true,
				'PHPUnit\Framework\MockObject\InvocationMocker' => true,
				'PHPUnit\Framework\MockObject\MockMethod' => true,
			];

			if ( isset( $handle[ $class ] ) === false ) {
				// Bow out, not a class this autoloader handles.
				return;
			}

			// Try getting the overloaded file included in WP 5.6/master first.
			$partial_filename = strtr( substr( $class, 18 ), '\\', DIRECTORY_SEPARATOR ) . '.php';
			$file             = realpath( $wp_dir . '/tests/phpunit/includes/phpunit7/' . $partial_filename );

			if ( $file !== false && file_exists( $file ) ) {
				require_once $file;
				return;
			}

			// If those don't exist, just try loading them from PHPUnit itself.
			$file = realpath( dirname( __DIR__ ) . 'vendor/phpunit/phpunit/src/Framework/' . $partial_filename );
			if ( $file !== false && file_exists( $file ) ) {
				require_once $file;
			}
		}
	);

	// Make sure the autoloader will only get registered once.
	define( 'YOAST_NEWS_TEST_AUTOLOADER', true );
}
