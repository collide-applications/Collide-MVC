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
	 * Constructor
	 *
	 * @access	public
     * @return  void
	 */
	public function __construct(){
		parent::__construct();

        //$this->log->write( '_View::__construct()' );
		echo '_View::__construct()<br />';
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
		echo "_View::__call( '{$name}', " . print_r( $args, 1 ) . " )";

		echo 'Function ' . $name . '(' . implode( ',', $args ) . ') does not exists!';
	}
}

/* end of file: ./core/lib/internal/model.php */