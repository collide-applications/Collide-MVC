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
 * URL Helper
 *
 * @package     Collide MVC Core
 * @subpackage  Standard Helper
 * @category    Helpers
 * @author      Collide Applications Development Team
 * @link        http://mvc.collide-applications.com/docs/
 */

/**
 * Get site URL
 *
 * @access  public
 * @param   boolean $complete   if true, return query string too
 * @return  string  site url (with tailing slash)
 */
if( !function_exists( 'siteUrl' ) ){
    function siteUrl( $complete = false ){
        // get collide object
        $collide =& thisInstance();

        // url segments
        $protocol       = 'http';
        $domain         = $collide->globals->get( 'SERVER_NAME', 'server' );
        $port           = '';
        $queryString    = $collide->globals->get( 'REQUEST_URI', 'server' );

        // try to get subfolder from the root of the server to the folder of the site
        $tmpDocRoot     = str_replace( '\\', '/', $collide->globals->get( 'DOCUMENT_ROOT', 'server' ) );
        $tmpRootPath    = str_replace( '\\', '/', ROOT_PATH );
        $subfolder      = trim( str_replace( $tmpDocRoot, '', $tmpRootPath ), '/' );

        // add "https" in required
        $https = $collide->globals->get( 'HTTPS', 'server', array( 'strtolower', 'trim' ) );
        if( !is_null( $https ) && !empty( $https ) && $https != 'off' ) {
            $protocol .= 's';
        }
        $protocol .= '://';

        $port = '';
        // if any port
        $httpHost = $collide->globals->get( 'HTTP_HOST', 'server' );
        if( strstr( $httpHost, ':' ) ){
            // get port
            $port = ':' . trim( substr( $httpHost, strpos( $httpHost, ':' ) + 1 ) );
        }

        // if port is default do not add it
        if( $port === '80' ){
            $port = '';
        }

        // create url
        $url = $protocol . $domain . $port;

        // display query string too
        if( $complete ){
            $url .= $queryString;
        }else{
            // add tailing slash
            $url = rtrim( $url, '/' ) . '/' . $subfolder . '/';
        }
        
        return $url;
    }
}

/**
 * Redirect to another url
 *
 * @access  public
 * @param   string  $url    url to redirect to
 * @return  string  site url (with tailing slash)
 */
if( !function_exists( 'redirect' ) ){
    function redirect( $url = '', $hard = false ){
        // check if headers already sent or hard redirect specified
        if( $hard === false && headers_sent() === true ){
            $hard = true;
        }
        
        // prepare url
        $url = trim( strtolower( $url ), '/' );

        // if no url specified refresh page
        if( empty( $url ) ){
            $url = siteUrl( true );
        }else{
            $url = siteUrl() . $url;
        }

        // if hard url needed echo javascript refresh in page (no warning returned)
        if( $hard === true ){
            die( '<script type="text/javascript">window.location="' . $url . '";' );
        }else{
        // redirect using headers
            header( 'Location: ' . $url );
        }
    }
}

/**
 * Load template resources (css/js/favicon)
 *
 * If $file parameter is provided as array or string, files from load config
 * array will be ignored
 *
 * @access  public
 * @param   string  $type  resource type (css/js/fav)
 * @param   mixed   $files  resource file to load ignoring array from load config
 * @return  string  html code for loaded resources
 */
if( !function_exists( 'loadRes' ) ){
    function loadRes( $type, $files = null ){
        $html = ''; // result

        // prepare parameters
        $type = strtolower( trim( $type ) );

        // include load config file
        require( APP_CONFIG_PATH . 'load' . EXT );

        // define code templates
        $tplCss = "<link type=\"text/css\" rel=\"stylesheet\" href=\"" . siteUrl() . "css/%s\" />\n";
        $tplJs  = "<script type=\"text/javascript\" src=\"" . siteUrl() . "js/%s\"></script>\n";
        $tplFav = "<link type=\"img/png\" rel=\"shortcut icon\" href=\"" . siteUrl() . "img/%s\" />\n" .
                  "<link rel=\"apple-touch-icon\" href=\"" . siteUrl() . "img/%s\" />\n";

        // check what to load
        if( is_null( $files ) &&
            // load default files
            isset( $cfg['res'][$type] ) &&
            is_array( $cfg['res'][$type] ) ){

            $files = $cfg['res'][$type];
        }else if( is_string( $files ) ){
            $files[0] = $files;
        }

        // create html
        foreach( $files as $file ){
            $tpl = 'tpl' . ucfirst( $type );
            $html .= sprintf( $$tpl, $file );
        }

        return $html;
    }
}