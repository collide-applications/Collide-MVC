<?php if( !defined( 'ROOT_PATH' ) ) die( '403: Forbidden' );

/******************************************************************************
 *                                                                            *
 * Collide MVC Framework                                                      *
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
 * Collide controller
 *
 * Has methods for framework actions executed from browser.
 * OBS: Rename this controller!
 *
 * @package     Collide MVC App
 * @subpackage  Controllers
 * @category    Utils
 * @author      Collide Applications Development Team
 * @link        http://mvc.collide-applications.com/docs/
 */
class Collide_utilsController extends Controller{
    /**
     * Constructor
     *
     * @access  public
     * @return  void
     */
    public function __construct(){
        parent::__construct();
        
        logWrite( 'Collide_utilsController::__construct()' );
    }

    /**
     * Generate Doctrine models from database
     *
     * @access  public
     * @param   string  $action how to generate models
     * @return  void
     * @todo    test all cases
     */
    public function generateModelsFromDb(){
        logWrite( 'Collide_utilsController::generateModelsFromDb()' );

        $options = array(
            'generateBaseClasses'   => true,
            'phpDocPackage'         => 'Collide MVC',
            'phpDocSubpackage'      => 'Model',
            'phpDocName'            => 'Radu Graur',
            'phpDocEmail'           => 'radu.graur@gmail.com'
        );

        if( Doctrine::generateModelsFromDb( rtrim( APP_MODELS_PATH, DS ), array(), $options ) ){
            echo 'Models generated';
        }else{
            echo 'Models not generated!';
        }
    }

    /**
     * Generate sql from Doctrine models
     *
     * File will be generated in app/models/sql/ folder
     *
     * @access  public
     * @return  void
     * @todo    make it work
     */
    public function generateSqlFromModels(){
        logWrite( 'Collide_utilsController::generateSqlFromModels()' );

        // load config to get fixtures path
        $this->config->load( 'db' );
        $sqlPath = $this->config->get( array( 'db', 'doctrine', 'models_path' ) );
        $modelPrefix = $this->config->get( array( 'db', 'default', 'prefix' ) );
        $modelPrefix = rtrim( ucfirst( $modelPrefix ), '_' );

        // load all models based on models files in app/models folder
        $files = scandir( $sqlPath );
        foreach( $files as $file ){
            if( filetype( $sqlPath . '/' . $file ) == 'file' && $file != 'index.html' ){
                // exclude model prefix and extension
                preg_match( '/^' . $modelPrefix . '(.*)\.php/', $file, $matches );

                // load model
                $this->load->model( strtolower( $matches[1] ) );
            }
        }

        // generate sql
        $sql = Doctrine::generateSqlFromModels( $sqlPath );

        if( !empty( $sql ) ){
            // try to write sql to file
            $file = $this->config->get( array( 'db', 'doctrine', 'sql_path' ) ) .
                    '/' . date( 'h-i-s_d-m-Y' ) . '.sql';

            $fp = @fopen( $file, 'w');
            if( !$fp === false ){
                fwrite( $fp, $sql );
                fclose( $fp );

                echo 'SQL generated';
            }else{
                throw new Collide_exception( "Cannot create file <code>{$file}</code>" );
            }
        }else{
            throw new Collide_exception( "Cannot create file <code>{$file}</code>" );
        }
    }

    /**
     * Export data from database to yaml
     *
     * Files will be placed in models/fixtures folder
     * If param given on url a single file will be used
     *
     * @access  public
     * @param   mixed   $single     use single file
     * @return  void
     */
    public function exportDbData( $single = null ){
        logWrite( 'Collide_utilsController::exportDbData()' );
        
        // check if exporting to single file
        if( is_null( $single ) ){
            $single = true;
        }else{
            $single = false;
        }

        // load config to get fixtures path
        $this->config->load( 'db' );
        $fixturesPath = $this->config->get( array( 'db', 'doctrine', 'data_fixtures_path' ) );

        // dump data
        if( Doctrine::dumpData( $fixturesPath, $single ) ){
            echo 'Fixtures generated';
        }else{
            echo 'Fixtures not generated!';
        }
    }

    /**
     * Import data into database from yaml
     *
     * @access  public
     * @param   mixed   $append append data
     * @return  void
     * @todo    test this
     */
    public function importDbData( $append = null ){
        logWrite( 'Collide_utilsController::importDbData()' );

        // check if exporting to single file
        if( is_null( $append ) ){
            $append = true;
        }else{
            $append = false;
        }
        
        // load config to get fixtures path
        $this->config->load( 'db' );
        $fixturesPath = $this->config->get( array( 'db', 'doctrine', 'data_fixtures_path' ) );

        // dump data
        if( Doctrine::loadData( $fixturesPath, $append ) ){
            echo 'Database generated';
        }else{
            echo 'Database not generated!';
        }
    }
}