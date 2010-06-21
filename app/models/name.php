<?php if( !defined( 'ROOT_PATH' ) ) die( NO_ACCESS_MSG );

/**
 * Demo model
 *
 * @package		Collide MVC App
 * @subpackage	Models
 * @category	Demo
 * @author		Collide Applications Development Team
 * @link		http://mvc.collide-applications.com/docs/
 */
class NameModel extends _Model{
    /**
     * Framework name
     *
     * @access  private
     * @var     string  $_name  framework name
     */
    private $_name = '';

	/**
	 * Constructor
     *
     * Set framework name
	 *
	 * @access	public
     * @param   string  $name   framework name
     * @return  void
	 */
	public function __construct( $name ){
		parent::__construct();

        $this->log->write( 'NameModel::__construct(' . $name . ')' );

        // set framework name
        $this->_name = trim( ucfirst( $name ) );
	}

	/**
	 * Return framework name
	 *
	 * @access	public
	 * @return	string	framework name
	 */
	public function getName(){
        $this->log->write( 'NameModel::getName()' );

		return $this->_name;
	}
}

/* end of file: ./app/models/name.php */