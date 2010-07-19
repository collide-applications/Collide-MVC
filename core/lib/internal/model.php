<?php if( !defined( 'ROOT_PATH' ) ) die( NO_ACCESS_MSG );

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
 * @since       Version 1.0                                                   *
 *                                                                            *
 ******************************************************************************/

/**
 * Model class
 *
 * @package     Collide MVC Core
 * @subpackage  Libraries
 * @category    Models
 * @author      Collide Applications Development Team
 * @link        http://mvc.collide-applications.com/docs/
 * @TODO        Add Doctrine support
 */
class Model{
    /**
     * Log object reference
     *
     * @access  public
     * @var     object  $log    log reference
     */
    public $log = null;

    /**
     * Constructor
     *
     * @access  public
     */
    public function __construct(){
        // instantiate log
        $this->log =& Log::getInstance();
        $this->log->write( 'Model::__construct()' );
    }

    /**
     * Add doctrine to models
     *
     * @access  public
     * @param   string  $connName   connection name
     * @return  array   connection name => connection object
     * @todo    add extra configuration for doctrine
     */
    public static function loadDoctrine( $connName = 'default' ){
        //$this->log->write( 'Model::loadDoctrine()' );

        // prepare param
        if( empty( $connName ) ){
            $connName = 'default';
        }

        // include doctrine
        require_once( DOCTRINE_PATH . 'lib' . DS . 'Doctrine' . EXT );

        // set up doctrine
        spl_autoload_register( array( 'Doctrine', 'autoload' ) );
        $manager = Doctrine_Manager::getInstance();

        // load database config from application
        require( APP_CONFIG_PATH . 'db' . EXT );

        // create database connection
        $dsn =  $cfg['db'][$connName]['driver']    . '://' .
                $cfg['db'][$connName]['user']      . ':'   .
                $cfg['db'][$connName]['pass']      . '@'   .
                $cfg['db'][$connName]['host']      . ':'   .
                $cfg['db'][$connName]['port']      . '/'   .
                $cfg['db'][$connName]['db_name'];

        $conn = Doctrine_Manager::connection( $dsn, $connName );

        // set table prefix
        $conn->setAttribute( Doctrine_Core::ATTR_TBLNAME_FORMAT, $cfg['db'][$connName]['prefix'] . '%s' );
        $resp = array( $connName => $conn );
        
        return $resp;
    }
}

/* end of file: ./core/lib/internal/model.php */