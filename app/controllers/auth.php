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
class AuthController extends _Controller{
    /**
     * Constructor
     *
     * @access  public
     * @return  void
     */
    public function __construct(){
        parent::__construct();
        
        logWrite( 'AuthController::__construct()' );
    }

    /**
     * Show login page
     *
     * @access  public
     * @return  void
     */
    public function index(){
        logWrite( 'AuthController::index()' );

        // if already logged in go to default controller
        if( $this->auth->check( false ) ){
            $this->url->go( $this->config->get( array( 'default', 'controller' ) ) );
        }

        // load view
        $info['main'] = $this->view->get( 'auth/index' );

        // load template
        $this->view->template( $info, 'simple' );
    }

    /**
     * Try to login user
     *
     * Redirect to default page on success or to login page on error
     *
     * @access  public
     * @return  void
     */
    public function login(){
        logWrite( 'AuthController::login()' );

        $form = $this->globals->get( 'form' );

        // if logged in go to default controller
        if( $this->auth->login( $form['user'], $form['pass'] ) ){
            $this->url->go( $this->config->get( array( 'default', 'controller' ) ) );
        }
    }

    /**
     * Try to logout user
     *
     * Redirect to login page
     *
     * @access  public
     * @return  void
     */
    public function logout(){
        logWrite( 'AuthController::logout()' );

        $this->auth->logout();
    }
}