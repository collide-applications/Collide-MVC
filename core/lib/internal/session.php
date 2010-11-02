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
 * Session library
 *
 * Provides support for session arrays
 *
 * @package     Collide MVC Core
 * @subpackage  Libraries
 * @category    Session
 * @author      Collide Applications Development Team
 * @link        http://mvc.collide-applications.com/docs/
 * @todo        implement set method
 */
class Session{
    /**
     * Internal session array
     *
     * @access  protected
     * @var     array   $sess  session array
     */
    protected $sess = array();

    /**
     * Constructor
     *
     * @access  public
     * @return  void
     */
    public function __construct(){
        logWrite( 'Session::__construct()' );

        // keep session in an internal array
        session_start();
        if( isset( $_SESSION ) ){
            $this->sess = array_merge_recursive( $this->sess, $_SESSION );

            unset( $_SESSION );
        }
    }

    /**
     * Get variable from session
     *
     * @access  public
     * @param   mixed   $var        if <code>null</code> return all array, else
     *                              return requested value<br>
     *
     *                              e.g:
     *                              - $obj->get( null ); // all $_SESSION array
     *                              - $obj->get( 'var' ); // $_SESSION['var'];
     *                              - $obj->get( array( 'var1', 'var2' ) );
     *                              // $_SESSION['var1']['var2']
     * @param   mixed   $callback   function name or array with functions to
     *                              apply on each element returned
     *                              OBS: if you use a Collide helper as callback
     *                                   load that helper first
     * @return  mixed   value from that index, null if not exists, false on
     *                  error
     */
    public function get( $var = null, $callback = null ){
        logWrite( 'Session::get( ' . $var . ', ' . $callback . ' )' );

        // create an array from $var
        if( !is_null( $var ) && !is_array( $var ) ){
            $var = array( $var );
        }

        // save session
        $sess = $this->sess;

        // loop through global array and try to return requested element
        if( is_array( $var ) && count( $var ) ){
            foreach( $var as $key => $index ){
                if( is_array( $sess ) && isset( $sess[$index] ) ){
                    $sess = $sess[$index];
                }else{
                    // if variable not found stop
                    $sess = null;
                    break;
                }
            }
        }

        // apply callbacks on each array elements
        if( !is_null( $sess ) ){
            if( !is_null( $callback ) && !is_array( $callback ) ){
                $callback = array( $callback );
            }

            if( is_array( $callback ) && count( $callback ) ){
                // call each function for each element in array
                foreach( $callback as $func ){
                    if( is_array( $sess ) ){
                        array_walk_recursive( $sess, $func );
                    }else{
                        $sess = $func( $sess );
                    }
                }
            }
        }

        return $sess;
    }
}