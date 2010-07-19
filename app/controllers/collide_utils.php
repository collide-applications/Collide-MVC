<?php if( !defined( 'ROOT_PATH' ) ) die( NO_ACCESS_MSG );

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
class Collide_utilsController extends _Controller{
    /**
     * Constructor
     *
     * @access  public
     * @return  void
     */
    public function __construct(){
        parent::__construct();
        
        $this->log->write( 'Collide_utilsController::__construct()' );
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
        $this->log->write( 'Collide_utilsController::generateModelsFromDb()' );

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
     * @access  public
     * @return  void
     * @todo    make it work
     */
    public function generateSqlFromModels(){
        $this->log->write( 'Collide_utilsController::generateSqlFromModels()' );

        // load config to get fixtures path
        $this->config->load( 'db' );
        $sqlPath = $this->config->get( array( 'db', 'doctrine', 'sql_path' ) );
        
        if( Doctrine::generateSqlFromModels( $sqlPath ) ){
            echo 'SQL generated';
        }else{
            echo 'SQL not generated!';
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
        $this->log->write( 'Collide_utilsController::exportDbData()' );
        
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
        $this->log->write( 'Collide_utilsController::importDbData()' );

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

/* end of file: ./app/controllers/utils.php */