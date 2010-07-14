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
 * Collide exception class
 *
 * @package		Collide MVC Core
 * @subpackage	Libraries
 * @category	Exception
 * @author		Collide Applications Development Team
 * @link		http://mvc.collide-applications.com/docs/
 */
class Collide_exception extends Exception{
    /**
     * Constructor
     *
     * @access  public
     * @param   string  $message exception message
     * @return  void
     */
    public function __construct( $message ){
        parent::__construct( $message, 0 );
    }

    /**
     * Show exception message
     *
     * @access  public
     * @return  void
     */
    public function  __toString(){
        $html =<<< EOT
<html>
    <head>
        <title>Error</title>
        <style type="text/css">
            div#error{
                border:1px solid #dddddd;
                font-family: Verdana, Arial;
                color:#555555;
                padding:10px;
                -moz-border-radius:5px;     /* round corners (Firefox) */
                -webkit-border-radius:5px;  /* round corners (Webkit) */
                text-shadow: #aaa 1px 1px 1px;
                -moz-box-shadow: 2px  2px 3px #969696;      /* box shadow (Firefox) */
                -webkit-box-shadow: 2px 2px 3px #969696;    /* box shadow (Webkit) */
                background-image: -moz-linear-gradient(top, #ffffff, #dddddd);                                                  /* gradient (Firefox) */
                background-image: -webkit-gradient(linear,left bottom,left top,color-stop(0, #dddddd),color-stop(1, #ffffff));  /* gradient (Webkit) */
            }
            div#error div#title{
                font-weight:bold;
                font-size:1.1em;
                border-bottom:1px dotted #ff0000;
            }
            div#error span#message{
                font-weight:bold;
                color:#ff0000;
            }
        </style>
    </head>
    <body>
        <div id="error">
            <div id="title">Collide MVC Framework</div>
            <span id="message">Error: </span>
EOT;
        
        $html .= parent::getMessage();

        $html .=<<< EOT

        </div>
    </body>
</html>
EOT;
        
        die( $html );
    }

}

/* end of file: ./core/lib/internal/log.php */