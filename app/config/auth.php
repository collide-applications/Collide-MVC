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
 * Blog config
 *
 * @package     Collide MVC App
 * @subpackage  Configs
 * @category    Auth
 * @author      Collide Applications Development Team
 * @link        http://mvc.collide-applications.com/docs/
 */

$cfg['auth'] = array(
    'back'      => 'auth',          // page to go if login fails
    'model'     => 'users',         // model to load for checking users
    'method'    => 'login',         // method to call to check user and pass
    'algorithm' => 'sha1',          // password encryption algorithm
    'session'   => 'user',          // session array name
    'fields'   => array(            // what user fields to keep in session
        'id',
        'user'
    )
);