<?php if( !defined( 'ROOT_PATH' ) ) die( NO_ACCESS_MSG );

/******************************************************************************
 *																			  *
 * Collide PHP Framework													  *
 *																			  *
 * MVC framework for PHP.													  *
 *																			  *
 * @package		Collide	MVC Core											  *
 * @author		Collide Applications Development Team						  *
 * @copyright	Copyright (c) 2009, Collide Applications					  *
 * @license		http://mvc.collide-applications.com/license  				  *
 * @link		http://mvc.collide-applications.com 						  *
 * @since		Version 1.0													  *
 *																			  *
 ******************************************************************************/

/**
 * Config class
 *
 * @package		Collide MVC Core
 * @subpackage	Libraries
 * @category	Config
 * @author		Collide Applications Development Team
 * @link		http://mvc.collide-applications.com/docs/
 */
class Config{
    /**
     * All config arrays merged
     *
     * @access  private
     * @var     array
     */
    public $_cfg = array();

	/**
	 * Constructor
	 *
	 * @access	public
     * @return  void
	 */
	public function __construct(){
		echo 'Config::__construct()<br />';
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
        echo 'Config::get("' . print_r( $var, 1 ) . '")<br />';

        // create an array from $var
        if( !is_null( $var ) && !is_array( $var ) ){
            $var = array( $var );
        }

        // default result (variable not found)
        $result = null;
        
        if( is_array( $var ) && count( $var ) ){
            $config = $this->_cfg;

            // loop config array and try to return requested element
            foreach( $var as $key => $index ){
                if( isset( $config[$index] ) ){
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
     * @return  void
     */
    public function set( $var, $val ){
        echo 'Config::get("' . $var . '", ' . $val . ')<br />';

        $this->_cfg[$var] = $val;
    }

    /**
     * Load config script and load <code>$cfg</code> array from it
     *
     * @access  public
     * @param   $string $file   file to load
     * @return  boolean
     */
    public function load( $file ){
        echo 'Config::load("' . $file . '")<br />';
        
        // clean file name
        $file = rtrim( trim( strtolower( $file ) ), EXT );
        $config = $file;
        $file   = APP_CONFIG_PATH . $file . EXT;

        // try to include file
        if( file_exists( $file ) ){
            if( $config == 'config'){
                require( $file );
            }else{
                require_once( $file );
            }            

            // merge current config with the new one
            $this->_cfg = array_merge( $this->_cfg, $cfg );
            
            return true;
        }

        return false;
    }
}

/* end of file: ./core/lib/internal/config.php */