<?php if( !defined( 'ROOT_PATH' ) ) die( NO_ACCESS_MSG );

/******************************************************************************
 *																			  *
 * Collide PHP Framework													  *
 *																			  *
 * MVC framework for PHP.													  *
 *																			  *
 * @package		Collide	MVC App												  *
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
 * Configure database connection.
 */

// database driver to use
$cfg['db']['driver']		= 'mysql';
// database username
$cfg['db']['user']			= 'root';
// database password
$cfg['db']['pass']			= 'keplerpass';
// database host
$cfg['db']['host']			= 'localhost';
// database port
// leave it blank to use default port
$cfg['db']['port']			= '3306';
// database name
$cfg['db']['db_name']		= 'test1';
// database configuration name (for multiple connections)
$cfg['db']['conn_name']		= 'default';
// tables prefix
$cfg['db']['prefix']		= 'c_';
// use persistent connection
$cfg['db']['persistent']	= FALSE;

/* end of file: ./app/config/db.php */