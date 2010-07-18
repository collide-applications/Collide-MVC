<?php if( !defined( 'ROOT_PATH' ) ) die( NO_ACCESS_MSG );

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
 * @since       Version 1.0                                                   *
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
        // url segments
        $protocol       = 'http';
        $domain         = $_SERVER['SERVER_NAME'];
        $port           = '';
        $queryString    = $_SERVER["REQUEST_URI"];

        // try to get subfolder from the root of the server to the folder of the site
        $tmpDocRoot     = str_replace( '\\', '/', $_SERVER['DOCUMENT_ROOT'] );
        $tmpRootPath    = str_replace( '\\', '/', ROOT_PATH );
        $subfolder      = trim( str_replace( $tmpDocRoot, '', $tmpRootPath ), '/' );

        // add "https" in required
        if( isset( $_SERVER['HTTPS'] ) &&
            !empty( $_SERVER['HTTPS'] ) &&
            trim( strtolower( $_SERVER['HTTPS'] ) ) != 'off' ) {

            $protocol .= 's';
        }
        $protocol .= '://';

        $port = '';
        // if any port
        if( strstr( $_SERVER["HTTP_HOST"], ':' ) ){
            // get port
            $port = ':' . trim( substr( $_SERVER["HTTP_HOST"],
                                  strpos( $_SERVER['HTTP_HOST'], ':' ) + 1
                               )
                          );
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

 /* end of file: ./core/helpers/url.php */