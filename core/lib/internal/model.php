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
 * @license		http://mvc.collide-applications.com/license.txt               *
 * @link		http://mvc.collide-applications.com 						  *
 * @since		Version 1.0													  *
 *																			  *
 ******************************************************************************/

/**
 * Model class
 *
 * @package		Collide MVC Core
 * @subpackage	Libraries
 * @category	Models
 * @author		Collide Applications Development Team
 * @link		http://mvc.collide-applications.com/docs/
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
     * Database object (used to create queries in models)
     *
     * @access  public
     * @var     object  $db database object
     */
    public $db = null;

	/**
	 * Constructor
	 *
	 * @access	public
	 */
	public function __construct(){
        // instantiate log
        $this->log =& Log::getInstance();
        $this->log->write( 'Model::__construct()' );

        // add doctrine to models
        //self::loadDoctrine();

        // collide instance
        $collide =& thisInstance();

        // add reference of controller database object here to be visible in
        // all models
        $this->db =& $collide->db;
	}

	/**
	 * This function is called when method does not exists
	 *
	 * @access	public
	 * @param	string	$name	method name
	 * @param	array	$args	method arguments
     * @return  void
	 */
	public function  __call( $name,  $args ){
		$this->log->write( "Model::__call( '{$name}', " . print_r( $args, 1 ) . " )" );

		require_once( CORE_LIB_INT_PATH . 'collide_exception' . EXT );
        throw new Collide_exception( 'Function "' . $name . '" does not exists!' );
	}

    /**
     * Add doctrine to models
     *
     * @access  public
     * @return  void
     * @todo    add extra configuration for doctrine
     */
    public static function loadDoctrine(){
        //$this->log->write( 'Model::loadDoctrine()' );

        // collide instance
        $collide =& thisInstance();

        // if not connected yet to the database connect now
        if( is_null( $collide->db ) ){
            // include doctrine
            require_once( DOCTRINE_PATH . 'lib' . DS . 'Doctrine' . EXT );

            // set up doctrine
            spl_autoload_register( array( 'Doctrine', 'autoload' ) );
            $manager = Doctrine_Manager::getInstance();

            // load database config from application
            require( APP_CONFIG_PATH . 'db' . EXT );

            // create database connection
            $dsn =  $cfg['db']['driver']    . '://' .
                    $cfg['db']['user']      . ':'   .
                    $cfg['db']['pass']      . '@'   .
                    $cfg['db']['host']      . ':'   .
                    $cfg['db']['port']      . '/'   .
                    $cfg['db']['db_name'];

            $collide->db = Doctrine_Manager::connection( $dsn, $cfg['db']['conn_name'] );

            // set table prefix
            $collide->db->setAttribute( Doctrine_Core::ATTR_TBLNAME_FORMAT, $cfg['db']['prefix'] . '%s' );
            
            // set model loading method
            $manager->setAttribute( Doctrine_Core::ATTR_MODEL_LOADING, Doctrine_Core::MODEL_LOADING_CONSERVATIVE );

            // load models for autoloader
            Doctrine_Core::loadModels( APP_MODELS_PATH );
        }
    }
}

/* end of file: ./core/lib/internal/model.php */