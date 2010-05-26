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
     * This controller name
     *
     * @access  private
     * @var     string  this controller name
     */
     private $_controllerName = '';

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
		//$this->log->write( 'Controller::__construct()' );

        self::$thisInstance =& $this;

        // get global objects and add to class, then unset them
        $this->setView( $GLOBALS['objView'] );
        unset( $GLOBALS['objView'] );
        $this->setModel( $GLOBALS['objModel'] );
        unset( $GLOBALS['objModel'] );
        $this->setLoad( $GLOBALS['objLoad'] );
        unset( $GLOBALS['objLoad'] );
        $this->setConf( $GLOBALS['objConf'] );
        unset( $GLOBALS['objConf'] );

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
        echo 'Controller::getControllerName()<br />';

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
		//$this->log->write( "Controller::__call( '{$name}', " . print_r( $args, 1 ) . " )" );

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
	 * Set default model for this controller
	 *
	 * @access	private
	 * @param	object	$objModel	model reference
     * @return  void
	 */
	private function setModel( $objModel ){
		$this->model = $objModel;
	}

	/**
	 * Set view instance for this controller
	 *
	 * @access	private
	 * @param	object	$objView	view reference
     * @return  void
	 */
	private function setView( $objView ){
		$this->view = $objView;
	}

    /**
	 * Set load library object for this controller
	 *
	 * @access	private
	 * @param	object	$objLoad	load library reference
     * @return  void
	 */
	private function setLoad( $objLoad ){
		$this->load = $objLoad;
	}

    /**
	 * Set config object for this controller
	 *
	 * @access	private
	 * @param	object	$objConf	load library reference
     * @return  void
	 */
	private function setConf( $objConf ){
		$this->config = $objConf;
	}
}

function &thisInstance(){
	return Controller::getInstance();
}

/* end of file: ./core/lib/internal/controller.php */