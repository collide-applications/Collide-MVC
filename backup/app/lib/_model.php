<?php if( !defined( 'ROOT_PATH' ) ) die( NO_ACCESS_MSG );

/**
 * Custom model class
 *
 * @package		Collide MVC App
 * @subpackage	Libraries
 * @category	Models
 * @author		Collide Applications Development Team
 * @link		http://mvc.collide-applications.com/docs/
 */
class _Model extends Model{
	/**
	 * Constructor
	 *
	 * @access	public
     * @return  void
	 */
	public function __construct(){
		parent::__construct();

		echo '_Model::__construct()<br />';
	}
}

/* end of file: ./app/lib/_model.php */