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
	 * @access	protected
	 * @var		object	load library reference
	 */
	protected $load = null;

	/**
	 * Constructor
     *
     * Initialize this controller instance
	 *
	 * @access	public
     * @return  void
	 */
	public function __construct(){
		echo 'Controller::__construct()<br />';

        self::$thisInstance =& $this;
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
	 * @access	public
	 * @param	object	$objModel	model reference
     * @return  void
	 */
	public function setModel( $objModel ){
		$this->model = $objModel;
	}

	/**
	 * Set view instance for this controller
	 *
	 * @access	public
	 * @param	object	$objView	view reference
     * @return  void
	 */
	public function setView( $objView ){
		$this->view = $objView;
	}

    /**
	 * Set load library object for this controller
	 *
	 * @access	public
	 * @param	object	$objLoad	load library reference
     * @return  void
	 */
	public function setLoad( $objLoad ){
		$this->load = $objLoad;
	}

    /**
	 * Load model
	 *
	 * @access	protected
	 * @param	mixed   $name       model name or array with names
     * @param	array   $params     parameters to give to model constructor
     * @param	mixed   $newName    new model name or array with new names
     * @return  void
	 */
	protected function loadModel( $name, $params = array(), $newName = '' ){
		$this->view = $objView;
	}
}

function &thisInstance(){
	return Controller::getInstance();
}

/* end of file: ./core/lib/internal/controller.php */