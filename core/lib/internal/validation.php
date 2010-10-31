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
class Validation{
    /**
     * Rules array
     *
     * @access  protected
     * @var     array       $_rules rules array
     */
    protected $_rules = array();

    /**
     * Constructor
     *
     * @access  public
     * @return  void
     */
    public function __construct(){
        logWrite( 'Validation::__construct()' );
    }

    /**
     * Load rules array
     *
     * @access  public
     * @param   string  $file   file to load
     * @return  boolean
     */
    public function load( $file ){
        logWrite( "Config::load( '{$file}' )" );

        // collide instance
        $collide =& thisInstance();
        
        // clean file name
        $file = rtrim( trim( strtolower( $file ) ), EXT );
        $rule = $file;
        $file   = APP_VALIDATION_PATH . $file . EXT;

        // try to include file
        if( file_exists( $file ) ){
            // load rules file
            require( $file );

            if( isset( $rules ) && is_array( $rules ) ){
                $this->_rules = $rules;

                return true;
            }
        }

        return false;
    }

    /**
     * Validate array
     *
     * @access  public
     * @return  boolean
     */
    public function check(){
        logWrite( 'Validation::check()' );

        return true;
    }
}