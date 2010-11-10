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
 * Controller library
 *
 * The main component of the MVC Framework.
 * Provides methods and objects to for the most common tasks in the application.
 *
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
      * Globals reference
      *
      * @access public
      * @var    object  globals reference
      */
     public $globals = null;

     /**
     * URL library reference
     *
     * @access  public
     * @var     object  URL library reference
     */
    public $url = null;

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
        'lib'           => array(
            'model', 'view', 'load', 'config', 'log', 'url', 'session' // default loaded
        ),
        'model'         => array(),
        'config'        => array(),
        'helper'        => array(),
        'connection'    => array()
     );

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

        logWrite( 'Controller::__construct()' );

        // instantiate config library and load application config
        $configClassName = incLib( 'config' );
        $objConf = new $configClassName();
        $objConf->load( 'config' );
        $this->config = $objConf;

        // instantiate view library
        $viewClassName = incLib( 'view' );
        $objView = new $viewClassName();
        $this->view = $objView;

        // include model library and initialize default Doctrine connection
        incLib( 'model' );
        $this->_loaded['connection'][] = Model::loadDoctrine();

        // instantiate load library
        $loadClassName = incLib( 'load' );
        $objLoad = new $loadClassName();
        $this->load = $objLoad;

        // load globals lib for PHP $GLOBALS array abstractization
        $globalsClassName = incLib( 'globals' );
        $objGlobals = new $globalsClassName();
        $this->globals = $objGlobals;

        // instantiate url library
        $urlClassName = incLib( 'url' );
        $objUrl = new $urlClassName();
        $this->url = $objUrl;

        // load session lib for session abstractization
        $sessionClassName = incLib( 'session' );
        $objSession = new $sessionClassName();
        $this->session = $objSession;

        // autoload items from load config in application
        $this->autoload();

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
        logWrite( 'Controller::getControllerName()' );

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
        logWrite( "Controller::__call()" );

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
        logWrite( "Controller::getLoaded()" );

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
        logWrite( "Controller::addLoaded()" );

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
        logWrite( "Controller::addObject()" );

        $this->$name = $obj;
    }

    /**
     * Autoload items and add them to controller
     *
     * Autoloaded items are set in load config in application
     *
     * @access  private
     * @return  void
     */
    private function autoload(){
        logWrite( "Controller::autoload()" );

        // load application config
        require( APP_CONFIG_PATH . 'load' . EXT );

        // autoload items from load config in application
        foreach( $cfg['load'] as $type => $items ){
            // if any item to load in this type
            if( count( $items ) > 0 ){
                foreach( $items as $item => $attr ){
                    // configs are using their own loading method
                    if( $type != 'config' ){
                        // set default parameters and new name
                        if( !isset( $attr['params'] ) ){
                            $attr['params'] = array();
                        }
                        if( !isset( $attr['name'] ) ){
                            $attr['name'] = '';
                        }

                        // load item
                        $this->load->$type( $item, $attr['params'], $attr['name'] );
                    }else{
                        // load configs here
                        $this->config->load( $item );
                    }
                }
            }
        }
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