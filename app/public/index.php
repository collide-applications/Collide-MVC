<?php
/******************************************************************************
 *                                                                            *
 * Collide MVC Framework                                                      *
 *                                                                            *
 * MVC framework for PHP.                                                     *
 *                                                                            *
 * @package     Collide MVC Core                                              *
 * @author      Collide Applications Development Team                         *
 * @copyright   Copyright (c) 2009, Collide Applications                      *
 * @license     http://mvc.collide-applications.com/license.txt               *
 * @link        http://mvc.collide-applications.com                           *
 * @since       Version 0.1                                                   *
 *                                                                            *
 ******************************************************************************/

// start output buffering to allow printing before view loading
ob_start();

/**
 * Set error reporting level.
 * Possible values: dev, prod
 * Dev environment will show all errors and warnings
 * Prod environment will not show errors but will log them instead.
 */
define( 'ENVIRONMENT', 'dev' );

// define directory separator (e.g: '/' for UNIX and '\' for Windows)
define( 'DS', DIRECTORY_SEPARATOR );

// define root folder
define( 'ROOT_PATH', dirname( dirname( dirname( __FILE__ ) ) ) . DS );

/**
 * Define core folder.
 * We recommend to put the core folder outside of the web server root to
 * avoid unauthorized access to core files.
 * This could be done by calling PHP dirname function on <code>ROOT_PATH</code>
 * when creating <code>CORE_PATH</code> constant
 * e.g:
 * <code>define( 'CORE_PATH', dirname( ROOT_PATH ) . DS . 'core' . DS );</code>
 *
 * or by specifying the full path to the core folder
 * e.g:
 * <code>define( 'CORE_PATH', '/var/www/core' );</code>
 */
define( 'CORE_PATH', ROOT_PATH . 'core' . DS );

// php scripts extension
define( 'EXT', '.' . pathinfo( __FILE__, PATHINFO_EXTENSION ) );

// no direct access to scripts message
define( 'NO_ACCESS_MSG', 'Access to this script is forbidden!' );

// get requested url
define( 'URL', rtrim( $_GET['url'], '/' ) );

require_once( CORE_PATH . 'bootstrap' . EXT );