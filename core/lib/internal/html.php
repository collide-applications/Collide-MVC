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
 * Html library
 *
 * Provides methods for HTML code generated from PHP
 *
 * @package     Collide MVC Core
 * @subpackage  Libraries
 * @category    Html
 * @author      Collide Applications Development Team
 * @link        http://mvc.collide-applications.com/docs/
 */
class Html{
    /**
     * Constructor
     *
     * @access  public
     * @return  void
     */
    public function __construct(){
        logWrite( 'Html::__construct()' );
    }

    /**
     * Generate html code for element attributes
     *
     * @access  private
     * @param   mixed   $conf   array or string with html attributes
     * @return  string  html code
     */
    private function attr( $conf = array() ){
        logWrite( 'Html::attr( $conf )');

        // element attributes
        $attr = '';

        // check configuration parameter and generate html
        if( isset( $conf ) ){
            if( is_string( $conf ) && !empty( $conf ) ){
                // string attributes
                $attr = ' ' . $conf;
            }else if( is_array( $conf ) && count( $conf ) ){
                // list of attributes
                foreach( $conf as $name => $val ){
                    $attr .= ' ' . $name . '="' . $val . '"';
                }
            }
        }

        return $attr;
    }

    /**
     * Generate element content if any
     *
     * @access  private
     * @param   mixed   $conf   config array or string
     * @return  string  content string
     */
    private function content( &$conf ){
        logWrite( 'Html::content( &$conf )' );

        // add content if set
        $content = '';
        if( isset( $conf['content'] ) ){
            $content = $conf['content'];
            unset( $conf['content'] );
        }

        return $content;
    }

    /**
     * Generate html textbox
     *
     * @access  public
     * @param   mixed   $conf   array or string with html attributes
     * @return  string  html code if $return param is true
     */
    public function textbox( $conf = array() ){
        logWrite( 'Html::textbox( $conf )' );

        return '<input type="text"' . $this->attr( $conf ) . " />\n";
    }

    /**
     * Generate html password
     *
     * @access  public
     * @param   mixed   $conf   array or string with html attributes
     * @return  string  html code if $return param is true
     */
    public function password( $conf = array() ){
        logWrite( 'Html::password( $conf )' );

        return '<input type="password"' . $this->attr( $conf ) . " />\n";
    }

    /**
     * Generate html checkbox
     *
     * @access  public
     * @param   mixed   $conf   array or string with html attributes
     * @return  string  html code if $return param is true
     */
    public function checkbox( $conf = array() ){
        logWrite( 'Html::checkbox( $conf )' );

        return '<input type="checkbox"' . $this->attr( $conf ) . " />\n";
    }

    /**
     * Generate html radio button
     *
     * @access  public
     * @param   mixed   $conf   array or string with html attributes
     * @return  string  html code if $return param is true
     */
    public function radio( $conf = array() ){
        logWrite( 'Html::radio( $conf )' );

        return '<input type="radio"' . $this->attr( $conf ) . " />\n";
    }

    /**
     * Generate html submit button
     *
     * @access  public
     * @param   mixed   $conf   array or string with html attributes
     * @return  string  html code if $return param is true
     */
    public function submit( $conf = array() ){
        logWrite( 'Html::submit( $conf )' );

        return '<input type="submit"' . $this->attr( $conf ) . " />\n";
    }

    /**
     * Generate html button
     *
     * @access  public
     * @param   mixed   $conf   array or string with html attributes
     * @return  string  html code if $return param is true
     */
    public function button( $conf = array() ){
        logWrite( 'Html::button( $conf )' );

        return '<input type="button"' . $this->attr( $conf ) . " />\n";
    }

    /**
     * Generate html reset button
     *
     * @access  public
     * @param   mixed   $conf   array or string with html attributes
     * @return  string  html code if $return param is true
     */
    public function submit( $conf = array() ){
        logWrite( 'Html::reset( $conf )' );

        return '<input type="reset"' . $this->attr( $conf ) . " />\n";
    }

    /**
     * Generate html textarea
     *
     * @access  public
     * @param   mixed   $conf   array or string with html attributes
     * @return  string  html code if $return param is true
     */
    public function textarea( $conf = array() ){
        logWrite( 'Html::textarea( $conf )' );

        return '<textarea' . $this->attr( $conf ) . '>' . 
                $this->content( $conf ) . "</textarea>\n";
    }

    /**
     * Generate html link
     *
     * @access  public
     * @param   mixed   $conf   array or string with html attributes
     * @return  string  html code if $return param is true
     */
    public function link( $conf = array() ){
        logWrite( 'Html::link( $conf )' );

        return '<a' . $this->attr( $conf ) . '>' . 
                $this->content( $conf ) . "</a>\n";
    }

    /**
     * Generate html form
     *
     * @access  public
     * @param   mixed   $conf   array or string with html attributes
     * @return  string  html code if $return param is true
     */
    public function form( $conf = array() ){
        logWrite( 'Html::form( $conf )' );

        return '<form' . $this->attr( $conf ) . '>' .
                $this->content( $conf ) . "</form>\n";
    }

    /**
     * Generate html table
     *
     * @access  public
     * @param   mixed   $conf   array or string with html attributes
     * @return  string  html code if $return param is true
     */
    public function table( $conf = array() ){
        logWrite( 'Html::table( $conf )' );

        // table attributes
        $attr = isset( $conf['attr'] ) ? $conf['attr'] : null;

        $html = '<table' . $this->attr( $attr ) . ">\n";

        if( isset( $conf['content'] ) && is_array( $conf['content'] ) ){
            // add each row
            foreach( $conf['content'] as $tr ){
                // check if has attributes
                $trAttr = isset( $tr['attr'] ) ? $this->attr( $tr['attr'] ) : '';
                if( isset( $tr['content'] ) && is_array( $tr['content'] ) ){
                    $tr = $tr['content'];
                }

                $html .= "\t<tr" . $trAttr . ">\n";

                if( is_array( $tr ) ){
                    // add each cell
                    foreach( $tr as $td ){
                        // check if has attributes
                        $tdAttr = '';
                        if( is_array( $td ) ){
                            if( isset( $td['attr'] ) ){
                                $tdAttr = $this->attr( $td['attr'] );
                            }

                            if( isset( $td['content'] ) ){
                                $td = $td['content'];
                            }
                        }

                        $html .= "\t\t<td" . $tdAttr . ">\n";

                        if( is_string ( $td ) ){
                            $html .= "\t\t\t" . $td . "\n";
                        }

                        $html .= "\t\t</td>\n";
                    }
                }

                $html .= "\t</tr>\n";
            }
        }

        $html .= "</table>\n";
        
        return $html;
    }
}