<?php if( !defined( 'ROOT_PATH' ) ) die( '403: Forbidden' );
/******************************************************************************
 *                                                                            *
 * Collide PHP Framework                                                      *
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
 * Application loading config
 *
 * @package     Collide MVC App
 * @subpackage  Configs
 * @category    Application loading config
 * @author      Collide Applications Development Team
 * @link        http://mvc.collide-applications.com/docs/
 */

/**
 * Scripts loading array
 * 
 * All items here are loaded after controller initialization
 *
 * Format for config:
 * 'config_1', 'config_2, 'config_N'
 *
 * Format for lib/model/helper:
 * 'item_name' => array(
 *      'params'    => array( 'param1', 'param2', ..., 'paramN' ),
 *      'name'      => 'new_item_name'
 * )
 */
$cfg['load'] = array(
    'config'        => array(
        'blog'
    ),
    'lib'           => array(
    ),
    'model'         => array(
    ),
    'helper'        => array(
        'url'       => null
    )
);