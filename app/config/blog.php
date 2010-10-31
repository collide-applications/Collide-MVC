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
 * @category    Application config
 * @author      Collide Applications Development Team
 * @link        http://mvc.collide-applications.com/docs/
 */

// menu array (e.g: menu page title => controller name)
$cfg['blog']['menu'] = array(
    'All posts' => '',
    'Add post' => 'blog/add'
);