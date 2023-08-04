<?php

declare( strict_types = 1 );

/**
 * Setup PHP ini vars
 */
ini_set( 'memory_limit', '-1' );
ini_set( 'error_reporting', '-1' );
ini_set( 'log_errors_max_len', '0' );
ini_set( 'zend.assertions', '1' );
ini_set( 'assert.exception', '1' );
ini_set( 'xdebug.show_exception_trace', '0' );

/**
 * Load function stubs
 */
require_once __DIR__ . '/stubs/admin-functions.php';
require_once __DIR__ . '/stubs/hook-functions.php';
require_once __DIR__ . '/stubs/post-functions.php';
require_once __DIR__ . '/stubs/sanitise-escape-functions.php';

/**
 * Load class stubs
 */
require_once __DIR__ . '/stubs/class-wp-query.php';
