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
 * Internationalization library
 *
 * Provides methods for multilanguage environments
 *
 * @package     Collide MVC Core
 * @subpackage  Libraries
 * @category    i18n
 * @author      Collide Applications Development Team
 * @link        http://mvc.collide-applications.com/docs/
 * @todo        finish implementation
 */
class I18n{
    /**
     * Constructor
     *
     * @access  public
     * @return  void
     */
    public function __construct(){
        logWrite( 'I18n::__construct()' );
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
        logWrite( 'Html::load( "' . $type . '", "' . $attr . '" )' );

        $html = '';

        return $html;
    }
}