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
 * @todo
 * - check permissions;
 */
class Auth{
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
        logWrite( 'Auth::__construct()', 'core' );

        // initialize config array
        $collide =& Controller::getInstance();
        $collide->config->load( 'auth' );
        $this->cfg = $collide->config->get( array( 'auth' ) );
    }

    /**
     * Reinitialize config array
     *
     * Original config array (from app/config/auth.php) will be merged with
     * <code>$config</code> array provided here
     *
     * @access  public
     * @param   array   $config new config values
     * @return  void
     */
    public function config( $config = array() ){
        logWrite( 'Auth::config( $config )', 'core' );

        // merge array
        $this->cfg = array_merge( $this->cfg, $config );
    }

    /**
     * Login user to application by username and password
     *
     * Register session and redirect to success page or redirect to error page
     *
     * @access  public
     * @param   string  $user   username
     * @param   string  $pass   password
     * @return  mixed   user id or false on error
     */
    public function login( $user, $pass ){
        logWrite( "Auth::login( {$user}, \$pass, \$config )", 'core' );

        // check if already logged in
        $this->check();

        // is logged in or not?
        $logged = false;

        // load users model
        $collide =& Controller::getInstance();
        $collide->load->model( $this->cfg['model'] );

        $method = $this->cfg['method'];
        
        // call function to check if username and password matches
        if( $userInfo = $collide->users->$method( $user, $this->encryptPassword( $pass ), $this->cfg['fields'] ) ){
            // register session variables
            $logged = $collide->session->set( array( $this->cfg['session'] => $userInfo ) );
        }

        // check if logged in
        $this->redirect( $logged );
    }

    /**
     * Logout user from application
     *
     * Check if user logged in and delete session, then redirect to login page
     *
     * @access  public
     * @return  void
     */
    public function logout(){
        logWrite( 'Auth::logout()', 'core' );

        // check if already logged in
        $this->check();

        // unset fields registered at login from session
        $collide =& Controller::getInstance();
        $sess = $collide->session->get();
        var_dump( $sess );
        unset( $sess[$this->cfg['session']] );
        var_dump( $sess );
        $collide->session->set( $sess );

        // go to login page
        $this->redirect( false );
    }

    /**
     * Check if user is logged in
     *
     * @access  public
     * @param   boolean $redirect   redirect or return result
     * @return  boolean
     */
    public function check( $redirect = true ){
        logWrite( "Auth::check( " . (int)$redirect ." )", 'core' );

        $logged = false;

        // get fields from session
        $collide =& Controller::getInstance();
        $fields = $collide->session->get( $this->cfg['session'] );

        if( !is_null( $fields ) && count( $fields ) &&
                is_array( $this->cfg['fields'] ) && count( $this->cfg['fields'] ) ){
            $logged = true;

            // if any field is missing then user not logged in
            foreach( $this->cfg['fields'] as $field ){
                if( !isset( $fields[$field] ) ){
                    $logged = false;
                }
            }
        }

        // check result and redirect or return result
        if( $redirect ){
            $this->redirect( $logged );
        }else{
            return $logged;
        }
    }

    /**
     * Redirect to login page or to logged in page
     *
     * @access  protected
     * @param   boolean     $fwd    go forward or back?
     * @return  void
     */
    protected function redirect( $fwd = true ){
        logWrite( "Auth::redirect( " . (int)$fwd ." )", 'core' );

        $collide =& Controller::getInstance();

        if( $fwd ){
            // go to forward page or default page
            if( isset( $this->cfg['fwd'] ) ){
                $url = $this->cfg['fwd'];
            }else{
                $url = $collide->config->get( array( 'default', 'controller' ) );
            }

            // avoid multiple redirects
            if( $url != $collide->url->getSegments( 0 ) ){
                $collide->url->go( $url );
            }
        }else{
            // go to login page or back
            if( isset( $this->cfg['back'] ) ){
                // avoid multiple redirects by comparing back page with current segments (0 and 1)
                $segments = $collide->url->getSegments( 0 );
                $segments .= ( !is_null( $collide->url->getSegments( 1 ) ) ? '/' .
                             $collide->url->getSegments( 1 ) : '' );
                
                if( $this->cfg['back'] != $segments ){
                    // redirect
                    $collide->url->go( $this->cfg['back'] );
                }
            }else{
                if( $this->cfg['back'] != $collide->url->back( true ) ){
                    $collide->url->back();
                }
            }
        }
    }

    /**
     * Get plain password and encrypt it
     *
     * Overwrite this method to change encryption
     *
     * @access  public
     * @param   string  $pass   password to encrypt
     * @return  string  encrypted password
     */
    public function encryptPassword( $pass ){
        logWrite( 'Auth::encryptPassword( $pass )', 'core' );

        $pass = (string)$pass;

        // get security key from config
        $collide =& Controller::getInstance();
        $collide->config->load( 'config' );
        $key = $collide->config->get( array( 'security', 'key' ) );

        return hash( $this->cfg['algorithm'], $pass . ' ' . $key );
    }
}