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
 * Set up environment
 *
 * @package		Collide MVC Core
 * @subpackage	Libraries
 * @category	Initialization
 * @author		Collide Applications Development Team
 * @link		http://mvc.collide-applications.com/docs/
 */

 /************************
  * Begin security setup *
  ************************/

/**
 * Check environment type and display or log errors
 */
if( !function_exists( 'setDisplayErrors' ) ){
	function setDisplayErrors(){
		if( trim( strtolower( ENVIRONMENT ) ) == 'dev' ){	// dev
			// display all errors
			error_reporting( E_ALL );
			ini_set( 'display_errors', 'On' );
		}else{												// prod
			// do not display errors
			error_reporting( E_ALL );
			ini_set( 'display_errors', 'Off' );
			ini_set( 'log_errors', 'On' );
			ini_set( 'error_log', CORE_PATH . DS . 'logs' . DS . 'std_error.log' );
		}
	}
}

/**
 * Strip slashes on multidimensional arrays
 *
 * @param	array	$arr	array to strip slashes from
 * @return	array	$arr	array without slashes
 */
if( !function_exists( 'arrayStripSlashes' ) ){
	function arrayStripSlashes( $arr ){
		if( is_array( $arr ) ){
			// go deep
			array_map( 'arrayStripSlashes', $arr );
		}else{
			stripslashes( $arr );
		}
		return $arr;
	}
}

/**
 * Strip slashes from $_GET, $_POST and $_COOKIE global arrays
 */
if( !function_exists( 'removeMagicQuotes' ) ){
	function removeMagicQuotes(){
		if( get_magic_quotes_gpc() ){
			$_GET    = arrayStripSlashes( $_GET );
			$_POST   = arrayStripSlashes( $_POST );
			$_COOKIE = arrayStripSlashes( $_COOKIE );
		}
	}
}

/**
 * Remove global arrays
 * @TODO create methods for globals
 */
if( !function_exists( 'unsetGlobalArrays' ) ){
	function unsetGlobalArrays(){
		if( ini_get( 'register_globals' ) ){
			// put all global arrays together
			$arr = array( '_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST',
						  '_SERVER', '_ENV', '_FILES' );

			// remove each global variable
			foreach( $arr as $val ){
				foreach( $GLOBALS[$val] as $key => $var ){
					if( $var === $GLOBALS[$key] ){
						unset( $GLOBALS[$key] );
					}
				}
			}
		}
	}
}

/**********************
 * End security setup *
 **********************/

/**
 * Instantiate controller and required libraries and call requested methods
 *
 * @access  public
 * @return	boolean	true on success false on error
 * @TODO    split in small functions ore move functionality to controller
 */
if( !function_exists( 'initHook' ) ){
	function initHook(){
        $logClassName = incLib( 'collide_exception' );

        // load default application config
        require( APP_CONFIG_PATH . 'config' . EXT );

		// set default values
		$controller = $cfg['default']['controller'];
		$method		= $cfg['default']['method'];

		// get url segments
		$arrUrl = explode( '/', URL );
		
		// get controller
		if( isset( $arrUrl[0] ) && !empty( $arrUrl[0] ) ){
			$controller = $arrUrl[0];
			array_shift( $arrUrl );
		}

		// get method
		if( isset( $arrUrl[0] ) && !empty( $arrUrl[0] ) ){
			$method = $arrUrl[0];
			array_shift( $arrUrl );
		}
		
		// query string
		$params = $arrUrl;    

        // include standard controller library
		incLib( 'controller' );

        // include requested controller
        if( file_exists( APP_CONTROLLERS_PATH .
                         strtolower( $controller ) . EXT ) ){
            require_once( APP_CONTROLLERS_PATH .
                          strtolower( $controller ) . EXT );
        }else{
            throw new Collide_exception( 'Page not found!' );
        }

        // instantiate controller
		$controllerClassName = ucfirst( $controller ) . $cfg['default']['controller_sufix'];

        // include and instantiate log library to be visible in internal
        // controller constructor
        $logClassName = incLib( 'log' );
        $objLog = new $logClassName();

        // instantiate controller
        $objController = new $controllerClassName();

        // add log object to controller
        $objController->addObject( 'log', $objLog );

        // add config to controller
        $configClassName = incLib( 'config' );
		$objConf = new $configClassName();
        $objConf->load( 'config' );
        $objController->addObject( 'config', $objConf );

		// include view library
		$viewClassName = incLib( 'view' );
		// instantiate view
		$objView = new $viewClassName();
        $objController->addObject( 'view', $objView );

		// include model library and initialize Doctrine
		incLib( 'model' );
        Model::loadDoctrine();

        // include load library, instantiate and add it to this controller
		$loadClassName = incLib( 'load' );
		$objLoad = new $loadClassName();
        $objController->addObject( 'load', $objLoad );

        // autoload items from load config in application
        autoload( $objController );

        // try to call method
        if( (int)method_exists( $controllerClassName, $method ) ){
            call_user_func_array( array( $objController, $method ), $params );
        }else{
            throw new Collide_exception( 'Method not foud!' );
        }

		return true;
	}
}

/**
 * Include standard and custom libraries
 *
 * @access  public
 * @param	string	$libName	library name
 * @return	mixed   false on error or class name on success
 */
if( !function_exists( 'incLib' ) ){
	function incLib( $libName ){
        require_once( CORE_LIB_INT_PATH . 'collide_exception' . EXT );

        require( APP_CONFIG_PATH . 'config' . EXT );

		// prepare library name
		$libName    = trim( strtolower( $libName ) );
        $className  = ucfirst( $libName );

        if( empty( $libName ) ){
            return false;
        }
        
        try{
            // include requested standard library first
            if( file_exists( CORE_LIB_INT_PATH . $libName . EXT ) ){
                require_once( CORE_LIB_INT_PATH . $libName . EXT );
            }else{
                throw new Collide_exception( 'Standard library not found!' );

                return false;
            }
        }catch( Collide_exception $e ){
            $e->__toString();

            return false;
        }

		// include requested custom library if exists
		if( file_exists( APP_LIB_PATH . $cfg['default']['lib_prefix'] .
						 $libName . EXT ) ){
			require_once( APP_LIB_PATH . $cfg['default']['lib_prefix'] .
						  $libName . EXT );
            $className = $cfg['default']['lib_prefix'] . $className;
		}

		return $className;
	}
}

/**
 * Autoload items and add them to controller
 *
 * Autoloaded items are set in load config in application
 *
 * @access  public
 * @param   object  $objController  controller reference
 * @return  void
 */
if( !function_exists( 'autoload' ) ){
	function autoload( &$objController ){
        // load application config
        require( APP_CONFIG_PATH . 'load' . EXT );

        // autoload items from load config in application
        foreach( $cfg['load'] as $type => $items ){            
            // if any item to load in this type
            if( count( $items ) > 0 ){
                foreach( $items as $item => $attr ){
                    // configs are using their own loading method
                    if( $type != 'config' ){
                        // set default parameters and new name
                        if( !isset( $attr['params'] ) ){
                            $attr['params'] = array();
                        }
                        if( !isset( $attr['name'] ) ){
                            $attr['name'] = '';
                        }

                        // load item
                        $objController->load->$type( $item, $attr['params'], $attr['name'] );
                    }else{
                        // load configs here
                        $objController->config->load( $item );
                    }
                }
            }
        }
    }
}

// @TODO: create autoload system
/**
 * Autoload requested classes
 *
 * @param	string	$className	class to autoload
 */
/*if( !function_exists( '__autoload' ) ){
	function __autoload( $className ){
		if( file_exists( CORE_PATH . DS . 'lib' . DS . 'internal' . DS .	// lib
						 strtolower( $className ) . EXT ) ){
			require_once( CORE_PATH . DS . 'lib' . DS . 'internal' . DS .
						 strtolower( $className ) . EXT );
		}else if( file_exists( APP_PATH . 'controllers' . DS .
							   strtolower( $className ) . EXT ) ){			// controller
			require_once( APP_PATH . 'controllers' . DS .
						  strtolower( $className ) . EXT );
		}else if( file_exists( APP_PATH . 'models' . DS .					// model
							   strtolower( $className ) . EXT ) ){
			require_once( APP_PATH . 'models' . DS .
						  strtolower( $className ) . EXT );
		}else{																// not found
			throw new Collide_exception( 'Page not found!' );
		}
	}
}*/

// call each initialization function
setDisplayErrors();
removeMagicQuotes();
unsetGlobalArrays();

// call initialization hook
try{
    initHook();
}catch( Collide_exception $e ){
    $e->__toString();

    return false;
}

/* end of file: ./core/lib/internal/init.php */