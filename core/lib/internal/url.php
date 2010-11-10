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
 * URL library
 *
 * Provides support for URL manipulation
 *
 * @package     Collide MVC Core
 * @subpackage  Libraries
 * @category    URL
 * @author      Collide Applications Development Team
 * @link        http://mvc.collide-applications.com/docs/
 */
class Url{
    /**
     * Server protocol (e.g: http or https)
     *
     * @access  private
     * @var     string  $_protocol (http or https)
     */
    private $_protocol;

    /**
     * Server domain name (e.g: collide-applications.com)
     *
     * @access  private
     * @var     string  $_domain site domain
     */
    private $_domain;

    /**
     * Server port (e.g: 80)
     *
     * @access  private
     * @var     string  $_port  server port
     */
    private $_port;

    /**
     * URL query string
     *
     * @access  private
     * @var     string  $_queryString
     */
    private $_queryString;

    /**
     * Site subfolder
     *
     * If the site is not in server root the path will be returned based on URL
     *
     * @access  private
     * @var     string  $_subfolder
     */
    private $_subfolder;

    /**
     * URL segments (excluding subfolder)
     *
     * segment 1    = controller
     * segment 2    = method
     * segment 3..n = parameters
     *
     * @access  private
     * @var     string  $_segments
     */
    private $_segments;

    /**
     * Constructor
     *
     * Set class variables with url info (protocol, domain, port, query string,
     * site subfolder relative to server root)
     *
     * @access  public
     * @return  void
     */
    public function __construct(){
        logWrite( 'Url::__construct' );
        
        // url segments
        $protocol               = 'http';
        $this->_domain          = $_SERVER['SERVER_NAME'];
        $this->_queryString     = $_SERVER['REQUEST_URI'];

        // try to get subfolder from the root of the server to the folder of the site
        $tmpDocRoot         = str_replace( '\\', '/', $_SERVER['DOCUMENT_ROOT'] );
        $tmpRootPath        = str_replace( '\\', '/', ROOT_PATH );
        $this->_subfolder   = trim( str_replace( $tmpDocRoot, '', $tmpRootPath ), '/' ) . '/';

        // add "https" if required
        $https = isset( $_SERVER['HTTPS'] ) ? strtolower( $_SERVER['HTTPS'] ) : null;
        if( !is_null( $https ) && !empty( $https ) && $https != 'off' ) {
            $protocol .= 's';
        }
        $protocol .= '://';
        $this->_protocol = $protocol;

        // if any port
        $httpHost = $_SERVER['HTTP_HOST'];
        if( strstr( $httpHost, ':' ) ){
            // set port
            $this->_port = trim( substr( $httpHost, strpos( $httpHost, ':' ) + 1 ) );
        }else{
            $this->_port = '80';
        }

        // set segments
        $this->_segments = substr(
            $this->_queryString,
            strpos(
                $this->_queryString,
                $this->_subfolder
            ) + strlen( $this->_subfolder ),
            strlen( $this->_queryString )
        );
    }

    /**
     * Getter for protocol
     *
     * @access  public
     * @return  string
     */
    public function getProtocol(){
        return $this->_protocol;
    }

    /**
     * Getter for domain name
     *
     * @access  public
     * @return  string
     */
    public function getDomain(){
        return $this->_domain;
    }

    /**
     * Getter for port
     *
     * @access  public
     * @return  string
     */
    public function getPort(){
        return $this->_port;
    }

    /**
     * Getter for query string
     *
     * @access  public
     * @return  string
     */
    public function getQueryString(){
        return $this->_queryString;
    }

    /**
     * Getter for site subfolder
     *
     * @access  public
     * @return  string
     */
    public function getSubfolder(){
        return $this->_subfolder;
    }

    /**
     * Getter site segments
     *
     * If no position provided all segments array will be returned
     *
     * @access  public
     * @param   integer $position   segment position (first position is 0)
     * @return  mixed   array of segments if no position provided or string
     */
    public function getSegments( $position = null ){
        logWrite( "Url::getSegments( {$position} )" );
        
        $segments = explode( '/', $this->_segments );

        if( !is_null( $position ) ){
            return $segments[$position];
        }

        return $segments;
    }

    /**
     * Get site URL
     *
     * @access  public
     * @param   boolean $complete   if true, return query string too
     * @return  string  site url (with tailing slash)
     */
    public function get( $complete = false ){
        logWrite( 'Url::get( ' . (int)$complete . ' )' );

        // if port is default do not add it
        ( $this->_port === '80' ) ? $port = '' : $port = $this->_port;

        // create url
        $url = $this->_protocol . $this->_domain . $port;

        // display query string too
        if( $complete ){
            $url .= $this->_queryString;
        }else{
            // add tailing slash
            $url = rtrim( $url, '/' ) . '/' . $this->_subfolder;
        }

        return $url;
    }

    /**
     * Go to another url
     *
     * @access  public
     * @param   string  $url    url to redirect to
     * @param   boolean $force  redirect using javascript
     * @return  string  site url (with tailing slash)
     */
    public function go( $url = '', $force = false ){
        logWrite( "Url::go( '{$url}', '" . (int)$force . "' )" );
        
        // check if headers already sent or force redirect specified
        if( $force === false && headers_sent() === true ){
            $force = true;
        }

        // prepare url
        $url = trim( strtolower( $url ), '/' );

        // if no url specified refresh page
        if( empty( $url ) ){
            $url = $this->get( true );
        }else{
            $url = $this->get() . $url;
        }

        // if force url needed echo javascript refresh in page (no warning returned)
        if( $force === true ){
            die( '<script type="text/javascript">window.location="' . $url . '";' );
        }else{
            // redirect using headers
            header( 'Location: ' . $url );
        }
    }

    /**
     * Go to previews page
     *
     * @access  public
     * @param   boolean $return return result or redirect?
     * @return  void
     */
    public function back( $return = false ){
        logWrite( "Url::back( " . (int)$return . " )" );

        // strip generic info (protocol, domain, port, subfolder) from referer
        $url = str_replace( 
                $this->getProtocol() . $this->getDomain() . 
                ( $this->getPort() != '80' ? $this->getPort() : '' ) . '/' .
                $this->getSubfolder(),
                '', $_SERVER['HTTP_REFERER'] );

        if( $return ){
            // return back url
            return $url;
        }else{
            // go to previews url
            $this->go( $url );
        }
    }
}