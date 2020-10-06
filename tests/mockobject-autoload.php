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
	 * Note: this autoloader MUST be registered before the Composer autoload file
	 * is registered.
	 * That way, the file we try to load here will be loaded if available and if not,
	 * the PHPUnit native ones will be loaded.
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
			if ( file_exists( $wp_dir . 'tests/phpunit/includes/phpunit7/MockObject/LICENSE' ) === false ) {
				// This is not WP 5.6/master.
				return;
			}

			if ( stripos( $class, 'PHPUnit\Framework\MockObject' ) !== 0 ) {
				// Bow out, not a class this autoloader handles.
				return;
			}

			$file = '';

			switch ( $class ) {
				case 'PHPUnit\Framework\MockObject\Builder\NamespaceMatch':
					$file = $wp_dir . 'tests/phpunit/includes/phpunit7/MockObject/Builder/NamespaceMatch.php';
					break;

				case 'PHPUnit\Framework\MockObject\Builder\ParametersMatch':
					$file = $wp_dir . 'tests/phpunit/includes/phpunit7/MockObject/Builder/ParametersMatch.php';
					break;

				case 'PHPUnit\Framework\MockObject\InvocationMocker':
					$file = $wp_dir . 'tests/phpunit/includes/phpunit7/MockObject/InvocationMocker.php';
					break;

				case 'PHPUnit\Framework\MockObject\MockMethod':
					$file = $wp_dir . 'tests/phpunit/includes/phpunit7/MockObject/MockMethod.php';
					break;
			}

			$file = realpath( $file );

			if ( file_exists( $file ) ) {
				require_once $file;
			}
		},
		true,
		// Prepend the autoloader!
		true
	);

	// Make sure the autoloader will only get registered once.
	define( 'YOAST_NEWS_TEST_AUTOLOADER', true );
}
