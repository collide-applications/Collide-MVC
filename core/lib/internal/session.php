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
     * Session model object
     *
     * @access  protected
     * @var     object      $model  session model object
     */
    protected $model;

    protected $cfg = array();

    /**
     * Constructor
     *
     * @access  public
     * @return  void
     */
    public function __construct(){
        logWrite( 'Session::__construct()' );

        // keep session in an internal array
        @session_start();

        // merge native PHP $_SESSION array with $sess and unset $_SESSION
        if( isset( $_SESSION ) ){
            $this->sess = array_merge_recursive( $this->sess, $_SESSION );

            unset( $_SESSION );
        }

        // instantiate Collide MVC object, and load session model
        $collide =& Controller::getInstance();
        $collide->load->model( 'sessions' );
        $this->model = $collide->sessions;

        // load session config
        $collide->config->load( 'session' );
        $this->cfg = $collide->config->get( array( 'session' ) );
    }

    /**
     * Config session on runtime
     *
     * @access  public
     * @param   array   $config   overwrite configuration array
     */
    public function config( $config ){
        logWrite( "Session::config( \$conf )" );

        // overwrite config array
        if( is_array( $config ) ){
            foreach( $config as $key => $val ){
                $this->cfg[$key] = $val;
            }
        }
    }

    /**
     * Add value(s) to session
     * 
     * @access  public
     * @param   mixed   $key    this parameter has multiple meanings
     *                          e.g:
     *                          - if not array and <code>$val</code> not
     *                            provided will add that value to session
     *                            auto incrementing the integer index;
     *                          - if not array but <code>$val</code> provided
     *                            then this will be the key and the val will be
     *                            <code>$val</code>;
     *                          - if an array provided, <code>$val</code> will
     *                            be ignored and the array will be inserted
     *                            in session;
     * @param   mixed   $val    value to be added to session
     * @return  boolean
     */
    public function set( $key, $val = null ){
        logWrite( "Session::set( \$key, \$val )" );

        // try to clean database
        $this->garbageCollector();

        // check if overwrite is set
        if( $this->cfg['overwrite'] === true ){
            // empty session data
            $this->sess = array();

            // reset overwrite flag
            $this->cfg['overwrite'] = false;
        }

        // check if $key is array or not
        if( !is_array( $key ) ){
            if( is_null( $val ) ){
                // add $key as $val if $val not provided
                array_push( $this->sess, $key );
            }else{
                // add $key => $val
                $this->sess[$key] = $val;
            }
        }else{
            // merge provided array with current array overwriting original
            $this->sess = $key + $this->sess;
        }
        
        // serialize session array
        $sess = serialize( $this->sess );
        
        // try to add array into database using session model
        if( $this->model->setSession( $sess, $this->cfg['expire'] ) ){
            return true;
        }

        return false;
    }

    /**
     * Get variable from session
     *
     * @access  public
     * @param   mixed   $var        if <code>null</code> return all array, else
     *                              return requested value<br>
     *
     *                              e.g:
     *                              - $obj->get();        // all session array
     *                              - $obj->get( 'var' ); // $sess['var'];
     *                              - $obj->get( array( 'var1', 'var2' ) );
     *                                // $sess['var1']['var2']
     * @param   mixed   $callback   function name or array with functions to
     *                              apply on each element returned
     *                              OBS: if you use a Collide helper as callback
     *                                   load that helper first
     * @return  mixed   value from that index, null if not exists
     */
    public function get( $var = null, $callback = null ){
        logWrite( "Session::get( \$var, \$callback )" );

        // try to clean database
        $this->garbageCollector();

        // get session from database
        $sess = $this->model->getSession( $this->cfg['expire'] );
        if( !is_null( $sess ) ){
            $sess = unserialize( $sess['data'] );
        }else{
            return $sess;
        }

        // create an array from $var
        if( !is_null( $var ) && !is_array( $var ) ){
            $var = array( $var );
        }

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
                        $func( $sess );
                    }
                }
            }
        }

        return $sess;
    }

    /**
     * Delete inactive sessions from database
     *
     * @access  protected
     * @return  void
     */
    protected function garbageCollector(){
        logWrite( "Session::garbageCollector()" );

        if( isset( $this->cfg['cleanup'] ) && $this->cfg['cleanup'] > 0 ){
            if( rand( 0, 100 ) <= $this->cfg['cleanup'] ){
                $this->model->cleanup( $this->cfg['expire'] );
            }
        }
    }
}