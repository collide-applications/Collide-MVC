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
 * Set up environment
 *
 * @package     Collide MVC Core
 * @subpackage  Libraries
 * @category    Initialization
 * @author      Collide Applications Development Team
 * @link        http://mvc.collide-applications.com/docs/
 */

 /************************
  * Begin security setup *
  ************************/

/**
 * Check environment type and display or log errors
 */
if( !function_exists( 'setDisplayErrors' ) ){
    function setDisplayErrors(){
        if( trim( strtolower( ENVIRONMENT ) ) == 'dev' ){   // dev
            // display all errors
            error_reporting( E_ALL );
            ini_set( 'display_errors', 'On' );
        }else{                                              // prod
            // do not display errors
            error_reporting( E_ALL );
            ini_set( 'display_errors', 'Off' );
            ini_set( 'log_errors', 'On' );
            ini_set( 'error_log', CORE_PATH . DS . 'logs' . DS . 'std_error.log' );
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
 * @return  boolean true on success false on error
 * @TODO    split in small functions ore move functionality to controller
 */
if( !function_exists( 'initHook' ) ){
    function initHook(){
        incLib( 'collide_exception' );

        // load default application config
        require( APP_CONFIG_PATH . 'config' . EXT );

        // instantiate log library
        $logClassName = incLib( 'log' );
        $log = new Log();

        // logs support
        if( file_exists( APP_HELPERS_PATH . 'log' . EXT ) ){
            require( APP_HELPERS_PATH . 'log' . EXT );
        }else{
            require( CORE_HELPERS_PATH . 'log' . EXT );
        }

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
        $objController = new $controllerClassName();

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
 * @param   string  $libName    library name
 * @return  mixed   false on error or class name on success
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
 * Check if Collide MVC is prepared
 *
 * @access  public
 * @return  void
 */
if( !function_exists( 'checkCollide' ) ){
    function checkCollide(){
        incLib( 'collide_exception' );

        // check if default security key was changed
        require( APP_CONFIG_PATH . 'config.php' );
        if( isset( $cfg['security']['key'] ) && hash( 'md5', 'Collide MVC' ) == $cfg['security']['key'] ){
            throw new Collide_exception( 'Default security key not changed. Change <code>$cfg[\'security\'][\'key\']</code> value from application config.' );
        }

        // check if Utils class has default name (prevent using by others)
        if( file_exists( APP_CONTROLLERS_PATH . 'collide' . EXT ) ){
            throw new Collide_exception( '<code>collide.php</code> controller has the default name! Delete this controller or rename it (if you rename don\'t forget to rename the class name too).' );
        }
    }
}

// check for framework errors
checkCollide();

// call initialization hook
try{
    initHook();
}catch( Collide_exception $e ){
    $e->__toString();

    return false;
}