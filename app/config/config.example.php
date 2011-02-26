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
 * Application default config
 *
 * @package     Collide MVC App
 * @subpackage  Configs
 * @category    Application config
 * @author      Collide Applications Development Team
 * @link        http://mvc.collide-applications.com/docs/
 */

/**
 * Security key used to concatenate on hashes
 *
 * Default security key is MD5( 'Collide MVC' )
 * !!!OBS: It is recommended to change default security key
 */
$cfg['security']['key'] = 'c953a8af38791d0a6e0d5d7268152e561';

/**
 * Defined log types: file, email, firephp
 *
 * You can add another log types by extending "Log" library and create another
 * method with the same name as one type defined in the following array.
 */

/**
 * Defined log levels:
 * 0 - core
 * 1 - info
 * 2 - warning
 * 3 - error
 * 4 - debug
 */
$cfg['log']['types']['file']     = array( 'level' => array( 0, 1, 2, 3, 4 ) );
$cfg['log']['types']['email']    = array( 'level' => array() );

// set console options
$consoleLogOptions = array(
    'maxObjectDepth'        => 10,
    'maxArrayDepth'         => 20,
    'useNativeJsonEncode'   => true,
    'includeLineNumbers'    => true,
    'trace'                 => false,       // include trace
    'collapsed'             => true         // show collapsed
);
$cfg['log']['types']['firephp'] = array(
    'level' => array(),
    'options' => $consoleLogOptions
);
$cfg['log']['types']['chromephp'] = array(
    'level' => array(),
    'options' => $consoleLogOptions
);

// if set to true will overwrite the log file at each instance
// !!! use it with caution (all previews log messages for current day will be lost)
// @TODO fix this to write all logs from one refresh
$cfg['log']['new'] = false;

/**
 * Set default values
 */

// default controller (called when controller is missing from url)
$cfg['default']['controller'] = 'home';

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

// default template name (relative to "tpl" folder in public folder)
$cfg['default']['template']['name']         = 'default';
$cfg['default']['template']['title']        = 'Collide MVC';
$cfg['default']['template']['keywords']     = 'page, keywords, here';
$cfg['default']['template']['description']  = 'Page description here';
$cfg['default']['template']['favicon']      = array(
    'cdn'   => '',
    'file'  => ''
);
$cfg['default']['template']['css']          = array(
    'cdn'   => '',
    'files' => array(
    )
);
$cfg['default']['template']['js']          = array(
    'cdn'   => '',
    'files' => array(
    )
);

$cfg['xss']['enable'] = true;