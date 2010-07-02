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
 * Application loading config
 *
 * @package		Collide MVC App
 * @subpackage	Configs
 * @category	Application loading config
 * @author		Collide Applications Development Team
 * @link		http://mvc.collide-applications.com/docs/
 */

// create loading config array
$cfg['load'] = array(
    'configs'       => array(),
    'libs'          => array(),
    'models'        => array(),
    'helpers'       => array()
);

/* end of file: ./app/config/load.php */