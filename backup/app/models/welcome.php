<?php if( !defined( 'ROOT_PATH' ) ) die( NO_ACCESS_MSG );

/**
 * Welcome page model
 *
 * @package		Collide MVC App
 * @subpackage	Models
 * @category	Welcome
 * @author		Collide Applications Development Team
 * @link		http://mvc.collide-applications.com/docs/
 */
class WelcomeModel extends _Model{
	/**
	 * Constructor
	 *
	 * @access	public
     * @return  void
	 */
	public function __construct(){
		parent::__construct();
		
		echo 'WelcomeModel::__construct()<br />';
	}

	/**
	 * Return page title
	 *
	 * @access	public
	 * @return	string	page title
	 */
	public function getTitle(){
		echo 'WelcomeModel::getTitle()<br />';
		
		return 'Collide MVC Framework';
	}

    /**
	 * Return page left panel
	 *
	 * @access	public
	 * @return	string	page left panel
	 */
	public function getLeftPanel(){
		echo 'WelcomeModel::getLeftPanel()<br />';

		return 'left panel';
	}

    /**
	 * Return page content
	 *
	 * @access	public
     * @param   string  $name       framework name
     * @param   string  $version    framework version
	 * @return	string	page content
	 */
	public function getContent( $name, $version ){
		echo 'WelcomeModel::getContent()<br />';

		return "Welcome to {$name} MVC Framework, version {$version}";
	}
}

/* end of file: ./app/models/welcome.php */