<?php if( !defined( 'ROOT_PATH' ) ) die( '403: Forbidden' );

/******************************************************************************
 *                                                                            *
 * Collide PHP Framework                                                      *
 *                                                                            *
 * MVC framework for PHP.                                                     *
 *                                                                            *
 * @package     Collide MVC App                                               *
 * @author      Collide Applications Development Team                         *
 * @copyright   Copyright (c) 2009, Collide Applications                      *
 * @license     http://mvc.collide-applications.com/license.txt               *
 * @link        http://mvc.collide-applications.com                           *
 * @since       Version 0.1                                                   *
 *                                                                            *
 ******************************************************************************/

/**
 * Authentication page
 *
 * @package     Collide MVC App
 * @subpackage  Controllers
 * @category    Auth
 * @author      Collide Applications Development Team
 * @link        http://mvc.collide-applications.com/docs/
 */
class AuthController extends Controller{
    /**
     * Constructor
     *
     * @access  public
     * @return  void
     */
    public function __construct(){
        parent::__construct();
        
        logWrite( 'AuthController::__construct()' );

        $this->load->lib( 'auth' );
    }

    /**
     * Show login page
     *
     * @access  public
     * @return  void
     */
    public function index(){
        logWrite( 'AuthController::index()' );

        // load view
        $info['main'] = $this->view->get( 'auth/index' );

        $this->load->lib( 'session' );
        
        $this->session->set( 'val1' );
        $this->session->set( 2, array( 'test' => 'val3', 8 => 5 ) );
//        $this->session->config( array( 'overwrite' => true ) );
        $this->session->set( array( 3 => 'val7', 8 => 5 ) );
        $this->session->set( 'val5' );
        $sess = $this->session->get();
        var_dump( $sess );

        // load template
        $this->view->template( $info, 'simple' );
    }

    /**
     * Try to login user
     *
     * Redirect to blog posts page on success or to login page on error
     *
     * @access  public
     * @return  void
     */
    public function login(){
        logWrite( 'AuthController::login()' );

        $form = $this->globals->get( 'form' );

        $conf = array(
            'back'  => 'auth',
            'fwd'   => 'blog'
        );

        $this->auth->login( $form['user'], $form['pass'], $conf );
    }
}