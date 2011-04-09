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
 * Session config
 *
 * @package     Collide MVC App
 * @subpackage  Configs
 * @category    Session
 * @author      Collide Applications Development Team
 * @link        http://mvc.collide-applications.com/docs/
 */

// global session configuration
$cfg['session'] = array(
    'overwrite' => false,   // overwrite all session array when session set
    'expire'    => 3600,    // session life time (in seconds)
    'cleanup'   => 25       // garbage collector frequency (between 0% and 100%)
);