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
 * Config class
 *
 * Provides an interface to work with configuration arrays.
 * Features:
 * - load config file
 * - read config entry
 * - set config entry for the entire life of the current session
 *
 * @package     Collide MVC Core
 * @subpackage  Libraries
 * @category    Config
 * @author      Collide Applications Development Team
 * @link        http://mvc.collide-applications.com/docs/
 */
class Config{
    /**
     * All config arrays merged
     *
     * @access  protected
     * @var     array       $_cfg   config array
     */
    protected $_cfg = array();

    /**
     * Constructor
     *
     * @access	public
     * @return  void
     */
    public function __construct(){
        logWrite( 'Config::__construct()' );
    }

    /**
     * Get one config variable
     *
     * @access  public
     * @param   mixed   $var  if <code>null</code> return all array, else return requested value<br>
     *                        e.g:
     *                        - $obj->get(); // return all config array
     *                        - $obj->get( 'var' ); // return $cfg['var'];
     *                        - $obj->get( array( 'var1', 'var2' ) ); // return $cfg['var1']['var2']
     * @return  mixed   value from that index or null in not exists
     */
    public function get( $var = null ){
        logWrite( 'Config::get()' );

        // create an array from $var
        if( !is_null( $var ) && !is_array( $var ) ){
            $var = array( $var );
        }

        // default result (variable not found)
        $result = null;

        // get config array to search for variable
        $config = $this->_cfg;
        
        if( is_array( $var ) && count( $var ) ){
            // loop config array and try to return requested element
            foreach( $var as $key => $index ){
                if( is_array( $config ) && isset( $config[$index] ) ){
                    $config = $config[$index];
                }else{
                    // if variable not found stop
                    $config = null;
                    break;
                }
            }
        }

        return $config;
    }

    /**
     * Set one variable in config at runtime
     *
     * If variable already exists will be overwrited
     *
     * @access  public
     * @param   string  $var    config index to set
     * @param   mixed   $val    value to set at <code>$var</code> position
     * @return  mixed           modified value
     */
    public function set( $var, $val ){
        logWrite( 'Config::get("' . $var . '", ' . $val . ')' );

        $this->_cfg[$var] = $val;

        return $val;
    }

    /**
     * Load config script and load <code>$cfg</code> array from it
     *
     * @access  public
     * @param   string  $file   file to load
     * @param   boolean $force  force config loading (overwrite any changes)
     * @return  boolean
     */
    public function load( $file, $force = false ){
        logWrite( 'Config::load("' . $file . '")' );

        // collide instance
        $collide =& thisInstance();
        
        // clean file name
        $file = rtrim( trim( strtolower( $file ) ), EXT );
        $config = $file;
        $file   = APP_CONFIG_PATH . $file . EXT;

        // try to include file
        if( file_exists( $file ) ){
            // load config file if not loaded
            if( !$force ){
                $loadedConfigs = $collide->getLoaded( 'config' );

                // if not loaded before load it
                if( !in_array( $config, $loadedConfigs ) ){
                    $collide->addLoaded( 'config', $config );
                    require( $file );
                }
            }else{
                // load original config and overwrite changes
                require( $file );
            }

            // merge current config with the new one
            if( isset( $cfg ) && is_array( $cfg ) ){
                $this->_cfg = array_merge( $this->_cfg, $cfg );
            }
            
            return true;
        }

        return false;
    }
}