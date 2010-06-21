<?php if( !defined( 'ROOT_PATH' ) ) die( NO_ACCESS_MSG );

/**
 * Custom view class
 *
 * @package		Collide MVC App
 * @subpackage	Libraries
 * @category	Views
 * @author		Collide Applications Development Team
 * @link		http://mvc.collide-applications.com/docs/
 */
class _View extends View{
    /**
     * Collide MVC instance
     *
     * access   private
     * @var     object  $_collide   mvc instance
     */
    private $_collide;

	/**
	 * Constructor
	 *
	 * @access	public
     * @return  void
	 */
	public function __construct(){
		parent::__construct();

        $this->_log->write( '_View::__construct()' );
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
        $this->_log->write( "_View::__call( '{$name}', " . print_r( $args, 1 ) . " )" );

		echo 'Function ' . $name . '(' . implode( ',', $args ) . ') does not exists!';
	}
}

/* end of file: ./core/lib/internal/model.php */