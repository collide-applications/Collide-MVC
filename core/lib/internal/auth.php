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
     * Constructor
     *
     * @access  public
     * @return  void
     */
    public function __construct(){
        logWrite( 'Auth::__construct()' );   
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
     * <code>
     * array( 'back' => 'error/page', 'fwd' => 'success/page' )
     * </code>
     * @return  mixed   user id or false on error
     */
    public function login( $user, $pass, $config = array() ){
        logWrite( "Auth::login( {$user}, \$pass )" );

        $collide =& thisInstance();

        if( true ){
            if( isset( $config['fwd'] ) ){
                $collide->url->go( $config['fwd'] );
            }
        }else{
            if( isset( $config['back'] ) ){
                $collide->url->go( $config['back'] );
            }else{
                $collide->url->back();
            }
        }
    }

    /**
     * Logout user from application
     *
     * Check if user logged in and delete sesson, then redirect to login page
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
}