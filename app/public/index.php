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

// define core folder
define( 'CORE_PATH', ROOT_PATH . 'core' . DS );

// php scripts extension
define( 'EXT', '.' . pathinfo( __FILE__, PATHINFO_EXTENSION ) );

// no direct access to scripts message
define( 'NO_ACCESS_MSG', 'Access to this script is forbidden!' );

// get requested url
define( 'URL', rtrim( $_GET['url'], '/' ) );

require_once( CORE_PATH . 'bootstrap' . EXT );