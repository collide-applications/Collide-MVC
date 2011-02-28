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
 * Controller library overwrited
 *
 * @package     Collide MVC App
 * @subpackage  Libraries
 * @category    Controller
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
        
        logWrite( '_Controller::__construct()' );

        // check if user is logged in
        $this->load->lib( 'auth' );
        $this->auth->check();

//        $collide->config->load( 'auth' );

//        if( $this->auth->check( false ) ){
//            $this->url->go( $this->config->get( array( 'auth', 'fwd' ) ) );
//        }else{
//            $this->url->go( $this->config->get( array( 'auth', 'back' ) ) );
//        }
    }
}