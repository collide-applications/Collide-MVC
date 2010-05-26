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
 * Controller class
 *
 * @package		Collide MVC Core
 * @subpackage	Libraries
 * @category	Log
 * @author		Collide Applications Development Team
 * @link		http://mvc.collide-applications.com/docs/
 */
class Log{
    /**
     * Log levels
     *
     * @var array   $_levels    log levels
     */
    private $_levels = array(
        'info'      => 1,
        'warning'   => 2,
        'error'     => 3,
        'debug'     => 4,
        'all'       => 5
    );

    public function write( $msg, $type = 'info' ){
        $text = '';

        // define this controller object
        $collide = Controller::getInstance();

        // get log level
        $logLevel = $collide->config->get( array( 'log', 'level' ) );

        if( $logLevel >= $this->_levels[$type] ){
            $fileName = CORE_LOG_PATH . date( 'm_d_Y' ) . '.php';

            // write message
            $logNew = $collide->config->get( array( 'log', 'new' ) );
            $openType = 'a';
            if( $logNew ){
                $openType = 'w';
            }

            if( !file_exists( $fileName ) || $logNew ){
                $text .= <<<EOF
<?php if( !defined( 'ROOT_PATH' ) ) die( NO_ACCESS_MSG );

/******************************************************************************
 *																			  *
 * Collide PHP Framework													  *
 *                                                                            *
 * Log file generated automaticaly                                            *
 *																			  *
 ******************************************************************************/


EOF;
            }

            // create message line
            $text .= date( 'h:i:s - ' ) . ucfirst( $type ) . ' - ' . $msg . "\n";

            // write to log file
            $fp = fopen( $fileName, $openType );
            fwrite( $fp, $text );
            fclose( $fp );

            return true;
        }

        return false;
    }
}

/* end of file: ./core/lib/internal/log.php */