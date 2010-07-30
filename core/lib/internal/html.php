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
 * Html class
 *
 * @package     Collide MVC Core
 * @subpackage  Libraries
 * @category    Html
 * @author      Collide Applications Development Team
 * @link        http://mvc.collide-applications.com/docs/
 */
class Html{
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
     * @access  public
     * @return  void
     */
    public function __construct(){
        // instantiate log
        $this->_log =& Log::getInstance();
        $this->_log->write( 'Html::__construct()' );
    }

    /**
     * Load static content (images, javascript, styles)
     *
     * @access  public
     * @param   string  $type   e.g: img, js, css
     * @param   string  $file   file to load
     * @param   mixed   $attr   string or array with html attributes
     * @return  string  html or empty string if error
     */
    public function load( $type, $file, $attr = array() ){
        $this->_log->write( 'Html::load( "' . $type . '", "' . $attr . '" )' );

        $html = '';

        return $html;
    }
}

/* end of file: ./core/lib/internal/html.php */