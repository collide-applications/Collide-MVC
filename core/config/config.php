<?php if( !defined( 'ROOT_PATH' ) ) die( '403: Forbidden' );

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

/**
 * Define core constants used by core libraries
 *
 * @package     Collide MVC Core
 * @subpackage  Configs
 * @category    Initialization
 * @author      Collide Applications Development Team
 * @link        http://mvc.collide-applications.com/docs/
 */

/**
 * Define core paths
 */

// path to logs folder
define( 'CORE_LOG_PATH', CORE_PATH . 'logs' . DS );
// path to lib
define( 'CORE_LIB_PATH', CORE_PATH . 'lib' . DS );
// path to internal lib
define( 'CORE_LIB_INT_PATH', CORE_LIB_PATH . 'internal' . DS );
// path to external lib
define( 'CORE_LIB_EXT_PATH', CORE_LIB_PATH . 'external' . DS );
// path to helpers
define( 'CORE_HELPERS_PATH', CORE_PATH . 'helpers' . DS );

/**
 * Define paths to external libraries
 */


/**
 * Doctrine
 */

// Doctrine version
define( 'DOCTRINE_VERSION', '1.2.2' );
// path to Doctrine
define( 'DOCTRINE_PATH', CORE_LIB_EXT_PATH . 'Doctrine-' . DOCTRINE_VERSION . DS );


/**
 * Define application paths
 */

// path to application folder
// !!! If you move application to another path change this value and change
// path to public folder from .htaccess.
define( 'APP_PATH', ROOT_PATH . 'app' . DS );
// path to application config folder
define( 'APP_CONFIG_PATH', APP_PATH . 'config' . DS );
// path to application models folder
define( 'APP_MODELS_PATH', APP_PATH . 'models' . DS );
// path to application views folder
define( 'APP_VIEWS_PATH', APP_PATH . 'views' . DS );
// path to application controllers folder
define( 'APP_CONTROLLERS_PATH', APP_PATH . 'controllers' . DS );
// path to application libraries folder
define( 'APP_LIB_PATH', APP_PATH . 'lib' . DS );
// path to application helpers folder
define( 'APP_HELPERS_PATH', APP_PATH . 'helpers' . DS );
// path to public section
define( 'APP_PUBLIC_PATH', APP_PATH . 'public' . DS );
// path to application templates
define( 'APP_TPL_PATH', APP_PATH . 'tpl' . DS );
// path to application validation rules
define( 'APP_VALIDATION_PATH', APP_PATH . 'validation' . DS );

// path to custom templates
define( 'APP_CUST_VIEWS_PATH', APP_VIEWS_PATH . 'standard' . DS );
// path to custom error templates
define( 'APP_CUST_ERR_VIEWS_PATH', APP_CUST_VIEWS_PATH . 'errors' . DS );
// path to custom error templates
define( 'APP_CUST_ERR_404_PATH', APP_CUST_ERR_VIEWS_PATH . '404' . EXT );

/**
 * Define other constants
 */

// current version
define( 'VERSION', '1.0' );

// custom libraries prefix
define( 'LIB_PREFIX', '_' );