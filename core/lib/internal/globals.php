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
 * Globals class
 *
 * Abstractization of global arrays in PHP ($_GET, $_POST, $_COOKIE, $_SESSION)
 *
 * @package     Collide MVC Core
 * @subpackage  Libraries
 * @category    Globals
 * @author      Collide Applications Development Team
 * @link        http://mvc.collide-applications.com/docs/
 */
class Globals{
    /**
     * Globals array
     *
     * @access  protected
     * @var     array   $_globals   globals array
     */
    protected $_globals = array();

    /**
     * Avalilable global arrays
     *
     * @access  protected
     * @var     array   $_availableTypes    available global arrays
     */
    protected $_availableTypes = array(
        '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES'
    );

    /**
     * Constructor
     *
     * @access  public
     * @return  void
     */
    public function __construct(){
        logWrite( 'Globals::__construct()' );

        // unset globals array and create an internal one
        foreach( $this->_availableTypes as $type ){
            if( isset( $GLOBALS[$type] ) ){
                $this->_globals[$type] = $GLOBALS[$type];                
                unset( $GLOBALS[$type] );

                // unset individual global array too
                if( isset( $$type ) ){
                    unset( $$type );
                }
            }
        }

        // unset globals too
        unset( $GLOBALS );
    }

    /**
     * Get variable from global array
     *
     * @access  public
     * @param   mixed   $var        if <code>null</code> return all array, else
     *                              return requested value<br>
     *
     *                              e.g:
     *                              - $obj->get( null, 'post' ); //all $_POST
     *                              - $obj->get( 'var', 'post' );
     *                                // $_POST['var'];
     *                              - $obj->get( array( 'var1', 'var2' ),
     *                                                  'post' );
     *                              // return $_POST['var1']['var2']
     * @param   string  $type       array type to return (e.g: session, post,
     *                              get, cookie, request, server, env, files)
     * @param   mixed   $callback   function name or array with functions to
     *                              apply on each element returned
     *                              OBS: if you use a Collide helper as callback
     *                              load that helper first
     * @return  mixed   value from that index, null if not exists, false on
     *                  error
     */
    public function get( $var = null, $type = 'post', $callback = null ){
        //logWrite( 'Globals::get( $var, "' . $type . '", "' . $callback . '" )' );

        // prepare parameters
        $type = '_' . trim( strtoupper( $type ) );

        // check if type exists
        if( !in_array( $type, $this->_availableTypes ) ){
            return false;
        }

        // create an array from $var
        if( !is_null( $var ) && !is_array( $var ) ){
            $var = array( $var );
        }

        // get array type from globals to search for variable
        $globals = $this->_globals[$type];

        // loop through global array and try to return requested element
        if( is_array( $var ) && count( $var ) ){
            foreach( $var as $key => $index ){
                if( is_array( $globals ) && isset( $globals[$index] ) ){
                    $globals = $globals[$index];
                }else{
                    // if variable not found stop
                    $globals = null;
                    break;
                }
            }
        }

        // apply callbacks on each array elements
        if( !is_null( $globals ) ){
            if( !is_null( $callback ) && !is_array( $callback ) ){
                $callback = array( $callback );
            }

            if( is_array( $callback ) && count( $callback ) ){
                // call each function for each element in array
                foreach( $callback as $func ){
                    if( is_array( $globals ) ){
                        array_walk_recursive( $globals, $func );
                    }else{
                        $globals = $func( $globals );
                    }
                }
            }
        }

        return $globals;
    }
}