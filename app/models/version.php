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
class VersionModel extends _Model{
    /**
     * Framework version
     *
     * @access  private
     * @var     string  $_version  framework version
     */
    private $_version = '';

	/**
	 * Constructor
     *
     * Set framework version
	 *
	 * @access	public
     * @param   string  $name   framework version
     * @return  void
	 */
	public function __construct( $version = '1.0' ){
		parent::__construct();

        $this->log->write( 'VersionModel::__construct()' );

        // set framework name
        $this->_version = trim( $version );
	}

	/**
	 * Return framework version
	 *
	 * @access	public
	 * @return	string	framework version
	 */
	public function getVersion(){
        $this->log->write( 'VersionModel::getVersion()' );

		return $this->_version;
	}
}

/* end of file: ./app/models/version.php */