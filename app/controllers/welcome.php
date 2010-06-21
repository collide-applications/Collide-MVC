<?php if( !defined( 'ROOT_PATH' ) ) die( NO_ACCESS_MSG );

/**
 * Welcome page
 *
 * @package		Collide MVC App
 * @subpackage	Controllers
 * @category	Welcome
 * @author		Collide Applications Development Team
 * @link		http://mvc.collide-applications.com/docs/
 */
class WelcomeController extends _Controller{
	/**
	 * Constructor
	 *
	 * @access	public
     * @return  void
	 */
	public function __construct(){
		parent::__construct();
        
        $this->log->write( 'WelcomeController::__construct()' );
	}

	/**
	 * Default method
	 *
	 * This function url could be:<br>
	 * http://localhost/collide/welcome/index/val1/val2/val3<br>
	 * or<br>
	 * http://localhost/collide/welcome/index/val1/val2<br>
	 *
	 * @access	public
	 * @param	mixed	$param1	first parameter
	 * @param	mixed	$param2	second parameter
	 * @param	string	$param3	third parameter (default value)
     * @return  void
	 */
	public function index(){
        $this->log->write( 'WelcomeController::index()' );

        // log examples
        $this->log->write( 'Test info log' );
        $this->log->write( 'Test info log', 'info' );
        $this->log->write( 'Test warning log', 'warning' );
        $this->log->write( 'Test error log', 'error' );
        $this->log->write( 'Test exclusive firephp info log', 'info', 'firephp' );
        $this->log->write( 'Test exclusive firephp and file info log', 'info', array( 'firephp', 'file' ) );

        // you can render an array of views with data like this
        /**
		 * $views = array( 'index' );
         * $info['header']     = 'header';
         * $info['lpanel']     = 'left panel';
         * $info['content']    = 'content';
         * $info['footer']     = 'footer';
		 * $this->view->render( $views, $info );
        */

        // you can assign each view with its own data and give them to another view

        // get info from default model and assign them to views
		$header['title']        = $this->model->getTitle();
        $left_panel['content']  = $this->model->getLeftPanel();

        /**
         * You can load and call two models like this
         *
         * // load model to get framework name
         * $nameParams = array( 'collide' );
         * $this->load->model( 'name', $nameParams, 'name_model' );
		 * $frameworkName = $this->name_model->getName();
         *
         * // load model to get framework version
         * $versionParams = array( '1.0' );
         * $this->load->model( 'version', $versionParams, 'version_model' );
		 * $frameworkVersion = $this->version_model->getVersion();
         */
        
        // load and call both models at once
        $params = array( 'name' => array( 'collide' ) );    // params for name model

        // loat both models with params for first model and an alternative name for second model
        $this->load->model( array( 'name', 'version' ), $params, array( null, 'version_model' ) );

        // call models methods
		$frameworkName = $this->name->getName();
        $frameworkVersion = $this->version_model->getVersion();

        // get page content
        $content = $this->model->getContent( $frameworkName, $frameworkVersion );
        
        $params = array( 'content' => $content );
        $this->load->lib( 'demo', $params, 'demo_lib' );
        $content = $this->demo_lib->prepareContent();

        $this->load->helper( 'url' );
        $content .= ' <a href="' . siteUrl() . 'welcome/">&laquo; Back</a>';

        // collect views
        $info['header']     = $this->view->render( '_common/header',
                                                   $header, true );
        $info['lpanel']     = $this->view->render( 'welcome/left_panel',
                                                   $left_panel, true );
        // because $content is not an array will assign $info variable
        $info['content']    = $this->view->render( 'welcome/content',
                                                   $content, true );
        $info['footer']     = $this->view->render( '_common/footer',
                                                   null, true );

        // assign collected views to another view
        $this->view->render( 'index', $info, false, 'transformMVC' );
	}

    /**
     * Function that does nothing
     *
     * @access  public
     * @return  void
     */
    public function nothing(){
        $this->log->write( 'WelcomeController::nothing()' );
    }
}

/* end of file: ./app/controllers/welcome.php */