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
 * @license		http://mvc.collide-applications.com/license.txt               *
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

/**
 * Defined log types: file, email, firephp
 *
 * You can add another log types by extending "Log" library and create another
 * method with the same name as one type defined in the following array.
 */

/**
 * Defined log levels:
 * 0 - do not write to logs;
 * 1 - info
 * 2 - warning
 * 3 - error
 * 4 - debug
 * 5 - all
 */
$cfg['log']['types']['file']     = array( 'enabled' => true, 'level' => 5 );
$cfg['log']['types']['email']    = array( 'enabled' => true, 'level' => 5 );

// set firephp options
$firePhpOptions = array(
    'maxObjectDepth'        => 10,
    'maxArrayDepth'         => 20,
    'useNativeJsonEncode'   => true,
    'includeLineNumbers'    => true,
    'trace'                 => false,       // include trace
    'collapsed'             => true         // show collapsed
);
$cfg['log']['types']['firephp']  = array( 'enabled' => true, 'level' => 5, 'options' => $firePhpOptions );

// if set to true will overwrite the log file at each instance
// !!! use it with caution (all previews log messages for current day will be lost)
// @TODO fix this to write all logs from one refresh
$cfg['log']['new'] = false;

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