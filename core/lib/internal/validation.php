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
 * Validation library
 *
 * Provides methods for variables validation.
 * Could be extended to provide new validation patterns.
 *
 * @package     Collide MVC Core
 * @subpackage  Libraries
 * @category    Html
 * @author      Collide Applications Development Team
 * @link        http://mvc.collide-applications.com/docs/
 * @todo        to be implemented
 */
class Html{
    /**
     * Constructor
     *
     * @access  public
     * @return  void
     */
    public function __construct(){
        logWrite( 'Validation::__construct()' );
    }
}