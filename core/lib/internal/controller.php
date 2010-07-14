<?php if( !defined( 'ROOT_PATH' ) ) die( NO_ACCESS_MSG );

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
 * @since       Version 1.0                                                   *
 *                                                                            *
 ******************************************************************************/

/**
 * Controller class
 *
 * @package     Collide MVC Core
 * @subpackage  Libraries
 * @category    Controllers
 * @author      Collide Applications Development Team
 * @link        http://mvc.collide-applications.com/docs/
 */
class Controller{
    /**
     * This controller instance
     *
     * @access  private
     * @var     object  this controller instance
     */
    private static $thisInstance;

    /**
     * Default model (a model with the same name as the called controller)
     *
     * @access  protected
     * @var     object  default model instance
     */
    protected $model = null;

    /**
     * Default view
     *
     * @access  protected
     * @var     object  default view instance
     */
    protected $view = null;

    /**
     * Load library reference
     *
     * @access  public
     * @var     object  load library reference
     */
    public $load = null;

    /**
     * Config reference
     *
     * @access  public
     * @var     object  config reference
     */
    public $config = null;

    /**
     * Log reference
     *
     * @access  public
     * @var     object  log reference
     */
    public $log = null;

    /**
     * This controller name
     *
     * @access  private
     * @var     string  this controller name
     */
     private $_controllerName = '';

     /**
      * Loaded items
      *
      * @access private
      * @var    array   $_loaded    loaded items
      * @todo   add here for each item loaded
      */
     private $_loaded = array(
        'lib'       => array(
            'model', 'view', 'load', 'config', 'log'
        ),
        'model'     => array(),
        'config'    => array(),
        'helper'    => array()
     );

    /**
     * Database object (singleton)
     *
     * @access  public
     * @var     object  $db database object
     */
    public $db = null;

    /**
     * Constructor
     *
     * Initialize this controller instance
     * Set this controller name
     *
     * @access  public
     * @return  void
     */
    public function __construct(){
        self::$thisInstance =& $this;

        // instantiate log  
        $this->log =& Log::getInstance();
        $this->log->write( 'Controller::__construct()' );

        // get url segments
        $arrUrl = explode( '/', URL );

        // get controller
        if( isset( $arrUrl[0] ) && !empty( $arrUrl[0] ) ){
            $this->_controllerName = $arrUrl[0];
            unset( $arrUrl );
        }
    }

    /**
     * Getter for controller name
     *
     * @access  public
     * @return  string
     */
    public function getControllerName(){
        $this->log->write( 'Controller::getControllerName()' );

        return $this->_controllerName;
    }

    /**
     * This function is called when method does not exists
     *
     * @access  public
     * @param   string  $name   method name
     * @param   array   $args   method arguments
     * @return  void
     */
    public function  __call( $name,  $args ){
        $this->log->write( "Controller::__call()" );

        require_once( CORE_LIB_INT_PATH . 'collide_exception' . EXT );
        throw new Collide_exception( 'Function "' . $name . '" does not exists!' );
    }

    /**
     * Return this controller instance
     *
     * @access	public
     * @return  object  this controller instance reference
     */
    public static function &getInstance(){

        return self::$thisInstance;
    }

    /**
     * Getter for loaded array
     *
     * @access  public
     * @param   mixed   $types   loaded type or types (if empty return all types)
     * @return  array
     */
    public function getLoaded( $types = '' ){
        $this->log->write( "Controller::getLoaded()" );

        // if empty array or empty string return all loaded items
        if( ( is_array( $types ) && count( $types ) < 1 ) ||
            ( is_string( $types ) && empty( $types ) ) ){
            return $this->_loaded;
        }

        // transform type to array
        if( is_string( $types ) ){
            $types = array( $types );
        }

        // get items and return them
        $items = array();
        foreach( $types as $type ){
            // prepare type name
            $type = strtolower( trim( $type ) );

            if( isset( $this->_loaded[$type] ) ){
                $items[ $type ] = $this->_loaded[$type];
            }
        }

        return $items;
    }

    /**
     * Add loaded item
     *
     * @access  public
     * @param   string  $type   item type (e.g: library/model/config)
     * @param   string  $item   item name
     * @return  boolean
     */
    public function addLoaded( $type, $item ){
        $this->log->write( "Controller::addLoaded()" );

        // prepare type and item
        $type = strtolower( trim( $type ) );
        $item = strtolower( trim( $item ) );

        // check if item type is valid
        $valid = false;
        foreach( $this->_loaded as $available => $items ){
            if( $type == $available ){
                $valid = true;
            }
        }

        if( !$valid ){
            return false;
        }

        // add element
        $this->_loaded[$type][] = $item;

        return true;
    }

    /**
     * Add extra class objects
     *
     * @access  public
     * @param   string  $name   object name
     * @param   object  $obj    object to add
     * @return  void
     */
    public function addObject( $name, $obj ){
        $this->log->write( "Controller::addObject()" );

        $this->$name = $obj;
    }
}

/**
 * Get instance of MVC
 * 
 * @return  object  MVC instance
 */
function &thisInstance(){
    return Controller::getInstance();
}

/* end of file: ./core/lib/internal/controller.php */