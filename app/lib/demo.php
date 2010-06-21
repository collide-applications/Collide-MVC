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
     * Collide MVC instance
     * 
     * access   private
     * @var     object  $_collide   mvc instance
     */
    private $_collide;

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
        // initialize mvc instance
        $this->_collide = &thisInstance();

        $this->_collide->log->write( 'Demo::__construct()' );

        $this->_content = $content;
	}

    /**
	 * Return prepared page content
	 *
	 * @access	public
	 * @return	string	framework name
	 */
	public function prepareContent(){
        $this->_collide->log->write( 'Demo::prepareContent()' );

        $this->_content = str_replace( 'Collide',
                                       '<span style="color:#f00;">Collide</span>',
                                       $this->_content
                                     );

		return $this->_content;
	}
}

/* end of file: ./app/lib/demo.php */