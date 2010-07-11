<?php if( !defined( 'ROOT_PATH' ) ) die( NO_ACCESS_MSG );

/**
 * Utils controller
 *
 * Has methods for framework actions executed from browser.
 * OBS: Rename this controller!
 *
 * @package		Collide MVC App
 * @subpackage	Controllers
 * @category	Utils
 * @author		Collide Applications Development Team
 * @link		http://mvc.collide-applications.com/docs/
 */
class UtilsController extends _Controller{
	/**
	 * Constructor
	 *
	 * @access	public
     * @return  void
	 */
	public function __construct(){
		parent::__construct();
        
        $this->log->write( 'UtilsController::__construct()' );
	}

    /**
     * Generate Doctrine models
     *
     * Possible actions:
     *
     * build-all
     * build-all-load
     * build-all-reload
     * compile
     * create-db
     * create-tables
     * dql
     * drop-db
     * dump-data
     * generate-migration
     * generate-migrations-db
     * generate-migrations-models
     * generate-models-db
     * generate-models-yaml
     * generate-sql
     * generate-yaml-db
     * generate-yaml-models
     * load-data
     * migrate
     * rebuild-db
     *
     * @access  public
     * @param   string  $action how to generate models
     * @return  void
     * @todo    test all cases
     */
	public function generateModels( $action ){
        $action = array( 0 => '', 1 => $action );
        $this->log->write( 'UtilsController::generateModels()' );

        $this->config->load( 'db' );
        $conf = $this->config->get( array( 'db', 'doctrine' ) );

        define( 'STDOUT', '' );

        $cli = new Doctrine_Cli( $conf );
        $cli->run( $action );
    }
}

/* end of file: ./app/controllers/utils.php */