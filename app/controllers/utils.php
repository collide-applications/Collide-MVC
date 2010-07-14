<?php if( !defined( 'ROOT_PATH' ) ) die( NO_ACCESS_MSG );

/**
 * Utils controller
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
class UtilsController extends _Controller{
    /**
     * Constructor
     *
     * @access  public
     * @return  void
     */
    public function __construct(){
        parent::__construct();
        
        $this->log->write( 'UtilsController::__construct()' );
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
        $this->log->write( 'UtilsController::generateModelsFromDb()' );

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
}

/* end of file: ./app/controllers/utils.php */