<?php if( !defined( 'ROOT_PATH' ) ) die( NO_ACCESS_MSG );

/******************************************************************************
 *																			  *
 * Collide PHP Framework													  *
 *																			  *
 * MVC framework for PHP.													  *
 *																			  *
 * @package		Collide MVC Core											  *
 * @author		Collide Applications Development Team						  *
 * @copyright	Copyright (c) 2009, Collide Applications					  *
 * @license		http://mvc.collide-applications.com/license  				  *
 * @link		http://mvc.collide-applications.com 						  *
 * @since		Version 1.0													  *
 *																			  *
 ******************************************************************************/

/**
 * Load class
 *
 * @package		Collide MVC Core
 * @subpackage	Libraries
 * @category	Load
 * @author		Collide Applications Development Team
 * @link		http://mvc.collide-applications.com/docs/
 */
class Load{
    /**
     * Log object reference
     *
     * @access  protected
     * @var     object  $log    log reference
     */
    protected $_log = null;

	/**
	 * Constructor
	 *
	 * @access	public
     * @return  void
	 */
	public function __construct(){
        // instantiate log
    	$this->_log = Log::getInstance();
        $this->_log->write( 'Load::__construct()' );
	}

    /**
     * Include file
     *
     * @access  private
     * @param   string  $fileName   file name
     * @param   string  $type       file type (e.g: model, lib, helper)
     * @return	boolean	true on success false on error
     */
    private function incFile( $fileName, $type = 'model' ){
        $this->_log->write( 'Load::incFile( "' . $fileName . '")' );

        // check and prepare parameters
        if( empty( $fileName ) || empty( $type ) ){
            return false;
        }

        // define this controller object
        $collide = Controller::getInstance();
        
        $type = trim( strtolower( $type ) );
        
        // libraries and helpers may have files in core, try to include them
        if( $type == 'lib' || $type == 'helper' ){      // lib, helper
            // set different paths for helpers or libs
            if( $type == 'helper' ){
                $corePath   = CORE_HELPERS_PATH;
                $appPath    = APP_HELPERS_PATH;
            }else{
                $corePath   = CORE_LIB_INT_PATH;
                $appPath    = APP_LIB_PATH;
            }

            // initializations
            $filePrefix = '';
            $isCore     = false;
            $isApp      = false;

            // check if this file exists in core
            $coreFile = $corePath . $fileName . EXT;
            if( file_exists( $coreFile ) ){
                $isCore = true;
                $filePrefix = $collide->config->get( array( 'default', 'lib_prefix' ) );
            }

            // check if this file exists in app
            $appFile = $appPath . $filePrefix . $fileName . EXT;
            if( file_exists( $appFile ) ){
                $isApp = true;
            }

            if( $type == 'helper' ){
                if( $isApp ){
                    require_once( $appFile );
                }else if( $isCore ){
                    require_once( $coreFile );
                }else{
                    throw new Collide_exception( '"' . $fileName . ' helper does not exists!' );
                }
            }else{
                if( $isApp ){
                    if( $isCore ){
                        require_once( $coreFile );
                    }

                    require_once( $appFile );
                }else if( $isCore ){
                    require_once( $coreFile );
                }else{
                    throw new Collide_exception( '"' . $fileName . '" library does not exists!' );
                }
            }
        }else{                                          // model
            // models path
            $path = APP_MODELS_PATH;
            
            // file to include
            $file = $path . $fileName . EXT;
            
            // include requested custom library if exists
            if( file_exists( $file ) ){
                require_once( $file );
            }else{
                throw new Collide_exception( '"' . $fileName . '" class not found!' );
            }
        }		

		return true;
    }

    /**
	 * Instantiate class
	 *
	 * @access	private
	 * @param	mixed   $className      class name
     * @param	mixed   $type           class type (e.g: lib, model, helper)
     * @param	boolean $multiple       multiple class loaded
     * @param	array   $params         parameters to give to constructor
     * @param	mixed   $newClassName   new class name or array with new names
     * @return	boolean	true on success false on error
	 */
	private function instantiate( $className, $type, $multiple, $params = array(), $newClassName = '' ){
        $this->_log->write( 'Load::instantiate()' );

        // prepare parameters
        $newClassName = trim( strtolower( $newClassName ) );

        // prepare class name
        $oldClassName = $className;
        $className = ucfirst( $className );
        // model class convention is: file - my_class.php, class - My_classModel
        if( $type == 'model' ){
            $className .= $type;
        }
        
        // make a reflection object
        $objReflection = new ReflectionClass( $className );

        if( is_string( $params ) ){
            $params[$oldClassName] = $params;
        }

        // if multiple class parameters provided and this class parameters provided get them
        if( $multiple && isset( $params[$oldClassName] ) && is_array( $params[$oldClassName] ) ){
            $params = $params[$oldClassName];
        }else if( $multiple ){  // if multiple class parameters provided but not for this class
            $params = array();
        }else{
            // for one class keep parameters array as it is
        }
        
        // use reflection object to create a new instance with provided parameters
        // same as: new myClass( 'a', 'b' );
        if( count( $params ) ){
            $obj = $objReflection->newInstanceArgs( $params );
        }else{
            $obj = $objReflection->newInstanceArgs();
        }

        // add new object to this controller
        // if new name provided use this name
        if( !empty( $newClassName ) ){
            $oldClassName = $newClassName;
        }
        
        $thisInstance = Controller::getInstance();
        $thisInstance->$oldClassName =& $obj;
    }

    /**
	 * Load libraries, helpers, models, configs
	 *
	 * @access	private
	 * @param	mixed   $name           class name or array with names
     * @param	mixed   $type           class type (e.g: lib, model, helper)
     * @param	array   $params         parameters to give to class constructor
     * @param	mixed   $newClassName   new class name or array with new names
     * @return	boolean	true on success false on error
	 */
    private function load( $name, $type, $params = array(), $newClassName = '' ){
        $this->_log->write( 'Load::load()' );

        // Collide instance
        $collide = Controller::getInstance();

        // initialization
        $names          = array();
        $newClassNames  = array();
        $multiple       = false;

        // check if multiple models loaded
        if( is_array( $name ) && count( $name ) ){
            $multiple = true;
        }

        // if name is string create array of names with this name
        if( is_string( $name ) ){
            $names[] = $name;
        }

        // multiple names provided
        if( is_array( $name ) ){   
            $names = $name;
        }

        // if new class name is string create array of class names with this name
        if( is_string( $newClassName ) ){
            $newClassNames[] = $newClassName;
        }

        // multiple new class names provided
        if( is_array( $name ) ){
            $newClassNames = $newClassName;
        }

        // for each name instantiate class
        foreach( $names as $index => $name ){
            // prepare name
            $name = trim( strtolower( $name ) );

            // if object already instantiated go further
            if( isset( $collide->$name ) ){
                continue;
            }
            
            // include file
            $incRes = $this->incFile( $name, $type );
            
            if( !$incRes ){
                return false;
            }
            
            // instantiate lib and model class
            if( $type == 'lib' || $type == 'model' ){
                $this->instantiate( $name, $type, $multiple, $params, $newClassNames[$index] );
            }
        }

        return true;
    }

    /**
	 * Load model
	 *
	 * @access	public
	 * @param	mixed   $name       model name or array with names
     * @param	array   $params     parameters to give to model constructor
     * @param	mixed   $newName    new model name or array with new names
     * @return	boolean	true on success false on error
	 */
	public function model( $name, $params = array(), $newName = '' ){
        $this->_log->write( 'Load::model()' );

        // load class
        if( !$this->load( $name, 'model', $params, $newName ) ){
            return false;
        }

        return true;
	}

    /**
	 * Load library
	 *
	 * @access	public
	 * @param	mixed   $name       library name or array with names
     * @param	array   $params     parameters to give to library constructor
     * @param	mixed   $newName    new library name or array with new names
     * @return	boolean	true on success false on error
	 */
	public function lib( $name, $params = array(), $newName = '' ){
        $this->_log->write( 'Load::lib()' );

        // load class
        if( !$this->load( $name, 'lib', $params, $newName ) ){
            return false;
        }

        return true;
	}

    /**
	 * Load helper
	 *
	 * @access	public
	 * @param	mixed   $name       helper name or array with names
     * @param	array   $params     parameters to give to helper constructor
     * @param	mixed   $newName    new helper name or array with new names
     * @return	boolean	true on success false on error
	 */
	public function helper( $name, $params = array(), $newName = '' ){
        $this->_log->write( 'Load::helper()' );

        // load class
        if( !$this->load( $name, 'helper', $params, $newName ) ){
            return false;
        }

        return true;
	}
}

/* end of file: ./core/lib/internal/load.php */