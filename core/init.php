<?php if( !defined( 'ROOT_PATH' ) ) die( '403: Forbidden' );

/******************************************************************************
 *                                                                            *
 * Collide MVC Framework                                                      *
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

if( !function_exists( 'setDisplayErrors' ) ){
    /**
     * Check environment type and display or log errors
     */
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

if( !function_exists( 'initHook' ) ){
    /**
     * Instantiate controller and required libraries and call requested methods
     *
     * @access  public
     * @return  boolean true on success false on error
     * @TODO    split in small functions ore move functionality to controller
     */
    function initHook(){
        incLib( 'collide_exception' );
        
        // load default application config
        require( APP_CONFIG_PATH . 'config' . EXT );

        // instantiate log library
        $logClassName = incLib( 'log' );
        $log = new Log();

        // include log helper
        if( file_exists( APP_HELPERS_PATH . 'log' . EXT ) ){
            require( APP_HELPERS_PATH . 'log' . EXT );
        }
        require( CORE_HELPERS_PATH . 'log' . EXT );

        // set default values
        $controller = $cfg['default']['controller'];
        $method		= $cfg['default']['method'];

        // get url segments
        $arrUrl = explode( '/', URL );

        // include standard controller library
        incLib( 'controller' );

        // get controller
        if( count( $arrUrl ) ){
            $controllerPath = '';

            // get each url segment and check if it is a file or folder
            // if it is a file include it, if it is a folder go further until
            // a file is reached and include it
            foreach( $arrUrl as $urlSegment ){
                $urlSegment = strtolower( $urlSegment );

                // check if this segment is file and include it
                if( isset( $urlSegment ) && !empty( $urlSegment ) ){
                    if( file_exists( APP_CONTROLLERS_PATH .
                        $controllerPath . $urlSegment . EXT ) ){
                        require_once(
                            APP_CONTROLLERS_PATH .
                            $controllerPath . $urlSegment . EXT
                        );

                        // keep file name to use it in class name
                        $controller = $urlSegment;
                        array_shift( $arrUrl );

                        break;
                    }else if( is_dir( APP_CONTROLLERS_PATH . $urlSegment ) ){
                        // if this is a folder keep it and go further
                        $controllerPath .= $urlSegment . '/';
                        array_shift( $arrUrl );
                    }else{
                        // if no file or folder the url is incorrect
                        throw new Collide_exception( 'Page not found!' );
                    }
                }else{
                    // if no segment provided include default controller
                    if( file_exists( APP_CONTROLLERS_PATH . $controller . EXT ) ){
                        require_once( APP_CONTROLLERS_PATH . $controller . EXT );
                    }else{
                        // if default controller not found the url is incorrect
                        throw new Collide_exception( 'Page not found!' );
                    }
                }
            }
        }

        // get method
        if( isset( $arrUrl[0] ) && !empty( $arrUrl[0] ) ){
            $method = $arrUrl[0];
            array_shift( $arrUrl );
        }
        
        // query string
        $params = $arrUrl;

        // instantiate controller
        $controllerClassName = ucfirst( $controller ) . $cfg['default']['controller_sufix'];

        // if class exists instantiate it
        if( class_exists( $controllerClassName ) ){
            $objController = new $controllerClassName();
        }else{
            throw new Collide_exception( 'Page not found!' );
        }

        // try to call method
        if( (int)method_exists( $controllerClassName, $method ) ){
            call_user_func_array( array( $objController, $method ), $params );
        }else{
            throw new Collide_exception( 'Page not found!' );
        }

        return true;
    }
}

if( !function_exists( 'incLib' ) ){
    /**
     * Include standard and custom libraries
     *
     * @access  public
     * @param   string  $libName    library name
     * @return  mixed   false on error or class name on success
     */
    function incLib( $libName ){
        require_once( CORE_LIB_INT_PATH . 'collide_exception' . EXT );

        if( file_exists( APP_CONFIG_PATH . 'config' . EXT ) ){
            require( APP_CONFIG_PATH . 'config' . EXT );
        }else{
            throw new Collide_exception( 'Cannot find application config file <code>app/config/config.php</code>' );
        }

        // prepare library name
        $libName    = trim( strtolower( $libName ) );
        $className  = ucfirst( $libName );

        if( empty( $libName ) ){
            return false;
        }
        
        // include requested standard library first
        if( file_exists( CORE_LIB_INT_PATH . $libName . EXT ) ){
            require_once( CORE_LIB_INT_PATH . $libName . EXT );
        }else{
            throw new Collide_exception( 'Standard library not found!' );

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

if( !function_exists( 'checkCollide' ) ){
    /**
     * Check if Collide MVC is prepared
     *
     * @access  public
     * @return  void
     */
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

// first set display errors based on environment mode set in app config
setDisplayErrors();

// check for framework fatal errors
checkCollide();

// call initialization hook
initHook();