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
 * Model class
 *
 * @package		Collide MVC Core
 * @subpackage	Libraries
 * @category	Models
 * @author		Collide Applications Development Team
 * @link		http://mvc.collide-applications.com/docs/
 * @TODO        Add Doctrine support
 */
class Model{
	/**
	 * Constructor
	 *
	 * @access	public
	 */
	public function __construct(){
		echo 'Model::__construct()<br />';
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
		//$this->log->write( "Model::__call( '{$name}', " . print_r( $args, 1 ) . " )" );

		echo 'Function ' . $name . '(' . implode( ',', $args ) . ') does not exists!';
	}
}

/* end of file: ./core/lib/internal/model.php */