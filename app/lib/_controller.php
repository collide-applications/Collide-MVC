<?php if( !defined( 'ROOT_PATH' ) ) die( NO_ACCESS_MSG );

/**
 * Custom controller class
 *
 * @package     Collide MVC App
 * @subpackage  Libraries
 * @category    Controllers
 * @author      Collide Applications Development Team
 * @link        http://mvc.collide-applications.com/docs/
 */
class _Controller extends Controller{
    /**
     * Constructor
     *
     * @access  public
     * @return  void
     */
    public function __construct(){
        parent::__construct();

        $this->log->write( '_Controller::__construct()' );
    }
}

/* end of file: ./app/lib/_controller.php */