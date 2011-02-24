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
 * Globals library
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
     * XSS enabled from application config
     *
     * @access  private
     * @var     boolean $_xss   xss enabled from app config
     */
    private $_xss = false;

    /**
     * Constructor
     *
     * Unset $_GET global array
     * Get xss enabled from config
     *
     * @access  public
     * @return  void
     */
    public function __construct(){
        logWrite( 'Globals::__construct()', 'core' );

        // unset get array (method parameters used instead)
        if( isset( $_GET ) ){
            unset( $_GET );
        }

        // if xss cleanup required add it to callback functions
        $collide =& thisInstance();
        $this->_xss = $collide->config->get( array( 'xss', 'enable' ) );
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
     * @param   boolean $xss        apply an xss filter on each element
     * @param   mixed   $callback   function name or array with functions to
     *                              apply on each element returned
     *                              OBS: if you use a Collide helper as callback
     *                              load that helper first
     * @return  mixed   value from that index, null if not exists, false on
     *                  error
     */
    public function get( $var = null, $type = 'post', $xss = false, $callback = null ){
        //logWrite( 'Globals::get( $var, "' . $type . '", "' . $callback . '" )', 'core' );

        $globals = false;

        // available types
        $types = array( 'post', 'cookie', 'request', 'server', 'env', 'files' );

        // create an array from $var
        if( !is_null( $var ) && !is_array( $var ) ){
            $var = array( $var );
        }

        // check if type is valid
        $type = trim( $type );
        if( !in_array( $type, $types ) ){
            return false;
        }

        // prepare parameters
        $type = '_' . strtoupper( $type );

        // get array type from globals to search for variable
        $globals = $GLOBALS[$type];

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

            // global xss (from app config) or xss parameter must be enabled
            if( $xss || $this->_xss ){
                // call xss method from this class
                $callback[] = array( $this, 'xss' );
            }

            if( is_array( $callback ) && count( $callback ) ){
                // call each function for each element in array
                foreach( $callback as $func ){
                    if( is_array( $globals ) ){
                        array_walk_recursive( $globals, $func );
                        $x=3;
                    }else{
                        // if method from class called
                        if( is_array( $func ) ){
                            $func[0]->$func[1]( $flobals );
                        }else{
                            $globals = $func( $globals );
                        }
                    }
                }
            }
        }

        return $globals;
    }

    /**
     * XSS filter on globals
     * 
     * Could be set in app config or as get method parameter
     * "htmlentities" php function used to filter globals
     *
     * @access  private
     * @param   mixed   $item   any element (only strings will be escaped)
     * @return  void
     */
    private function xss( &$item ){
        //logWrite( 'Globals::xss()', 'core' );

        // apply htmlentities on strings
        if( is_string( $item ) ){
            $item = htmlentities( $item );
        }
    }
}