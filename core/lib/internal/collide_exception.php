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
 * @license		http://mvc.collide-applications.com/license  				  *
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
                border:1px solid #ff0000;
                font-family: Verdana, Arial;
                color:#555555;
                padding:10px;
            }
            div#error div#title{
                font-weight:bold;
                font-size:1.1em;
                border-bottom:1px dotted #555555;
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