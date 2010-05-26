<?php if( !defined( 'ROOT_PATH' ) ) die( NO_ACCESS_MSG );

/******************************************************************************
 *																			  *
 * Collide PHP Framework													  *
 *																			  *
 * MVC framework for PHP.													  *
 *																			  *
 * @package		Collide MVC App												  *
 * @author		Collide Applications Development Team						  *
 * @copyright	Copyright (c) 2009, Collide Applications					  *
 * @license		http://mvc.collide-applications.com/license  				  *
 * @link		http://mvc.collide-applications.com 						  *
 * @since		Version 1.0													  *
 *																			  *
 ******************************************************************************/

/**
 * Application default config
 *
 * @package		Collide MVC App
 * @subpackage	Configs
 * @category	Application config
 * @author		Collide Applications Development Team
 * @link		http://mvc.collide-applications.com/docs/
 */

// create config array
$cfg = array();

/**
 * Configure log level.
 *
 * Defined log levels:
 * 0 - do not write to logs;
 * 1 - info
 * 2 - warning
 * 3 - error
 * 4 - debug
 * 5 - all
 */
$cfg['log']['level'] = 5;

/**
 * Set default values
 */

// default controller (called when controller is missing from url)
$cfg['default']['controller'] = 'welcome';

// default method (called when method is missing from url)
$cfg['default']['method'] = 'index';

// default controller class name sufix
$cfg['default']['controller_sufix'] = 'Controller';

// default model class name sufix
$cfg['default']['model_sufix'] = 'Model';

// default library class name prefix
$cfg['default']['lib_prefix'] = '_';

// default view name
$cfg['default']['view'] = 'index';

/* end of file: ./app/config/config.php */