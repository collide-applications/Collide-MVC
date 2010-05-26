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
 * @category	Log
 * @author		Collide Applications Development Team
 * @link		http://mvc.collide-applications.com/docs/
 */
class Log{
    private $collide;

	/**
	 * Constructor
	 *
	 * @access	public
     * @return  void
	 */
	public function __construct(){
		echo 'Log::__construct()<br />';
	}

    public function write( $msg, $type = 'notice' ){
        $this->collide = thisInstance();
        var_dump($this->collide);
    }
}

/* end of file: ./core/lib/internal/log.php */