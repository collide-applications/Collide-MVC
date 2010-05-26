<?php if( !defined( 'ROOT_PATH' ) ) die( NO_ACCESS_MSG );

/**
 * Custom library class
 *
 * @package		Collide MVC App
 * @subpackage	Libraries
 * @category	Library
 * @author		Collide Applications Development Team
 * @link		http://mvc.collide-applications.com/docs/
 */
class Demo{
    /**
     * Page content
     *
     * @access  private
     * @var     string  $_content   page content
     */
    private $_content = '';

	/**
	 * Constructor
     *
     * Set content
	 *
	 * @access	public
     * @return  void
	 */
	public function __construct( $content ){
		echo 'Demo::__construct()<br />';

        $this->_content = $content;
	}

    /**
	 * Return prepared page content
	 *
	 * @access	public
	 * @return	string	framework name
	 */
	public function prepareContent(){
		echo 'Demo::prepareContent()<br />';

        $this->_content = str_replace( 'Collide',
                                       '<span style="color:#f00;">Collide</span>',
                                       $this->_content
                                     );

		return $this->_content;
	}
}

/* end of file: ./app/lib/demo.php */