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
 * Controller class
 *
 * @package		Collide MVC Core
 * @subpackage	Libraries
 * @category	Controllers
 * @author		Collide Applications Development Team
 * @link		http://mvc.collide-applications.com/docs/
 */
class Controller{
    /**
	 * This controller instance
	 *
	 * @access	private
	 * @var		object	this controller instance
	 */
    private static $thisInstance;

	/**
	 * Default model (a model with the same name as the called controller)
	 *
	 * @access	protected
	 * @var		object	default model instance
	 */
	protected $model = null;

	/**
	 * Default view
	 *
	 * @access	protected
	 * @var		object	default view instance
	 */
	protected $view = null;

    /**
	 * Load library reference
	 *
	 * @access	public
	 * @var		object	load library reference
	 */
	public $load = null;

    /**
	 * Config reference
	 *
	 * @access	public
	 * @var		object	config reference
	 */
	public $config = null;

    /**
	 * Log reference
	 *
	 * @access	public
	 * @var		object	log reference
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
        'libraries' => array(
            'model', 'view', 'load', 'config', 'log'
        ),
        'models'    => array(),

        'configs'   => array(
            'config'
        )
     );

	/**
	 * Constructor
     *
     * Initialize this controller instance
     * Set this controller name
	 *
	 * @access	public
     * @return  void
	 */
	public function __construct(){
        self::$thisInstance =& $this;

        // instantiate log
        $this->log = Log::getInstance();
        $this->log->write( 'Controller::__construct()' );

        // get global objects and add to class, then unset them
        if( isset( $GLOBALS['autoload'] ) ){
            foreach( $GLOBALS['autoload'] as $name => $obj ){
                if( !is_null( $obj ) ){
                    $this->setAutoloadedLib( $name, $obj );
                }
            }
        }
        unset( $GLOBALS['autoload'] );

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
	 * @access	public
	 * @param	string	$name	method name
	 * @param	array	$args	method arguments
     * @return  void
	 */
	public function  __call( $name,  $args ){
		$this->log->write( "Controller::__call()" );

		echo 'Function ' . $name . '(' . implode( ',', $args ) . ') does not exists!';
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
     * Set extra class objects
     * Objects came from $GLOBALS['autoload'] array
     *
     * @access  private
     * @param   string  $name   object name
     * @param   object  $obj    object to add
     * @return  void
     */
    private function setAutoloadedLib( $name, $obj ){
        $this->log->write( "Controller::setAutoloadedLib()" );
        
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