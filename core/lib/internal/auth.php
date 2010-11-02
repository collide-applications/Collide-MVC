<?php if( !defined( 'ROOT_PATH' ) ) die( '403: Forbidden' );

/******************************************************************************
 *                                                                            *
 * Collide PHP Framework                                                      *
 *                                                                            *
 * MVC framework for PHP.                                                     *
 *                                                                            *
 * @package     Collide MVC Core                                              *
 * @author      Collide Applications Development Team                         *
 * @copyright   Copyright (c) 2009, Collide Applications                      *
 * @license     http://mvc.collide-applications.com/license.txt               *
 * @link        http://mvc.collide-applications.com                           *
 * @since       Version 0.1                                                   *
 *                                                                            *
 ******************************************************************************/

/**
 * Authentication library
 *
 * @package     Collide MVC Core
 * @subpackage  Libraries
 * @category    Auth
 * @author      Collide Applications Development Team
 * @link        http://mvc.collide-applications.com/docs/
 */
class Auth{
    /**
     * Collide MVC object
     *
     * @access  protected
     * @var     object      $collide    collide mvc object
     */
    protected $collide;

    /**
     * Auth config array
     *
     * Located in "app/config" folder
     *
     * @access  protected
     * @var     array       $cfg   config array
     */
    protected $cfg = array();

    /**
     * Constructor
     *
     * @access  public
     * @return  void
     */
    public function __construct(){
        logWrite( 'Auth::__construct()' );

        // initialize config array
        $this->collide =& Controller::getInstance();
        $this->collide->config->load( 'auth' );
        $this->cfg = $this->collide->config->get( array( 'auth' ) );
    }

    /**
     * Login user to application by username and password
     *
     * Register session and redirect to success page or redirect to error page
     *
     * @access  public
     * @param   string  $user   username
     * @param   string  $pass   password
     * @param   array   $config config array
     * @return  mixed   user id or false on error
     */
    public function login( $user, $pass, $config = array() ){
        logWrite( "Auth::login( {$user}, \$pass, \$config )" );

        // merge array
        $this->cfg = array_merge( $this->cfg, $config );

        // load users model
        $this->collide->load->model( $this->cfg['model'] );

        $method = $this->cfg['method'];
        
        // call function to check if username and password matches
        if( $isUser = $this->collide->users->$method( $user, $this->encryptPassword( $pass ) ) ){
            // register session variables

            // go to logged in page
            if( isset( $config['fwd'] ) ){
                $this->collide->url->go( $config['fwd'] );
            }
        }else{
            // go to login page
            if( isset( $config['back'] ) ){
                $this->collide->url->go( $config['back'] );
            }else{
                $this->collide->url->back();
            }
        }
    }

    /**
     * Logout user from application
     *
     * Check if user logged in and delete session, then redirect to login page
     *
     * @access  public
     * @return  boolean true on success or false if already logged out
     */
    public function logout(){
        logWrite( "Auth::logout()" );
        
    }

    /**
     * Check if user is logged in
     *
     * @access  public
     * @return  boolean
     */
    public function check(){
        logWrite( "Auth::check()" );

    }

    /**
     * Get plain password and encrypt it
     *
     * Overwrite this method to change encryption
     *
     * @access  protected
     * @param   string  $pass   password to encrypt
     * @return  string  encrypted password
     */
    protected function encryptPassword( $pass ){
        $pass = (string)$pass;

        $this->collide->config->load( 'config' );
        $key = $this->collide->config->get( array( 'security', 'key' ) );

        return hash( $this->cfg['algorithm'], $pass . ' ' . $key );
    }
}