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
     * @access  private
     * @var     array   $_levels    log levels
     */
    private $_levels = array(
        'info'      => 1,
        'warning'   => 2,
        'error'     => 3,
        'debug'     => 4,
        'all'       => 5
    );

    /**
     * Message to write
     *
     * This is set in "write" method
     *
     * @access  private
     * @var     string  $_msg   message to write
     */
    private $_msg;

    /**
     * Message level
     *
     * This is set in "write" method
     *
     * @access  private
     * @var     string  $_level message level
     */
    private $_level;

    /**
     * FirePHP instance
     *
     * @access  private
     * @var     object  $_firephp   FirePHP instance
     */
    private $_firephp;

    /**
     * Constructor
     *
     * @access  public
     * @return  void
     */
    public function __construct(){
        // include FirePHP external library for firephp log type
        require( CORE_LIB_EXT_PATH . 'FirePHPCore-0.3.1/FirePHP.class.php' );

        // get instance of FirePHP
        $this->_firephp = FirePHP::getInstance( true );
        // create group
        $this->_firephp->group(
            'Collide MVC Log',
            array(
                'Collapsed' => false,
                'Color' => '#FF0000'
            )
        );
    }

    /**
     * Write to logs
     *
     * This method writes to all log types activated in config
     *
     * @access  public
     * @param   string  $msg    message to log
     * @param   string  $level  log level (defined in config)
     * @return  boolean check if at least one log was writed
     */
    public function write( $msg, $level = 'info' ){
        // Collide instance
        $collide = Controller::getInstance();

        // set parameters
        $this->_msg     = $msg;
        $this->_level   = strtolower( trim( $level ) );

        // get log types
        $logTypes = $collide->config->get( array( 'log', 'types' ) );

        // check if at least one log was writed
        $writed = false;

        // for each enabled type try to write log
        foreach( $logTypes as $type => $properties ){
            // if type not enabled continue
            if( !$properties['enabled'] ){
                continue;
            }

            // get log level
            $logLevel = $properties['level'];

            // if level is ok try to write log
            if( $logLevel >= $this->_levels[$this->_level] ){
                // check if method exists for each type
                if( method_exists( $this, $type ) ){
                    $options = array();

                    // set options if any
                    if( isset( $properties['options'] ) ){
                        $options = $properties['options'];
                    }
                    
                    // call method
                    if( $this->$type( $options ) ){
                        $writed = true;
                    }
                }
            }
        }

        return $writed;
    }

    /**
     * Write logs to files
     *
     * Each day will have its own log
     *
     * @access  private
     * @param   array   $opt    options for this log type
     * @return  boolean
     */
    private function file( $opt = array() ){
        // Collide instance
        $collide = Controller::getInstance();

        // check if folder is writable and do nothing otherwise
        if( !is_writable( CORE_LOG_PATH ) ){
            return false;
        }

        // text to write
        $text = '';

        // file to write to
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
 *                                                                            *
 * Collide PHP Framework                                                      *
 *                                                                            *
 * Log file generated automaticaly                                            *
 *                                                                            *
 ******************************************************************************/


EOF;
        }else{
            // check if existent file is writable and do nothing otherwise
            if( !is_writable( $fileName ) ){
                return false;
            }
        }

        // create message line
        $text .= date( 'h:i:s - ' ) . ucfirst( $this->_level ) . ' - ' . $this->_msg . "\n";

        // write to log file
        $fp = fopen( $fileName, $openType );
        fwrite( $fp, $text );
        fclose( $fp );

        return true;
    }

    /**
     * Send log on email
     *
     * @access  private
     * @param   array   $opt    options for this log type
     * @return  boolean
     * @todo    to be implemented when emailing sistem is done
     */
    private function email( $opt = array() ){

        return true;
    }

    /**
     * Display logs in Firebug console
     *
     * FirePHP addon for Firefox required
     * This method is using FirePHP library
     *
     * @access  private
     * @param   array   $opt    options for this log type
     * @return  boolean
     */
    private function firephp( $opt = array() ){
        // set options if any
        if( is_array( $opt ) ){
            $this->_firephp->getOptions();
            $this->_firephp->setOptions( $opt );
        }

        // call log function
        switch( $this->_level ){
            case 'info':
                $this->_firephp->info( $this->_msg );
                break;
            case 'warning':
                $this->_firephp->warn( $this->_msg );
                break;
            case 'error':
                $this->_firephp->error( $this->_msg );
                break;
            default:
                // other log levels
                $this->_firephp->log( $this->_msg, strtoupper( $this->_level ) );
        }

        // add trace if set in config
        if( isset( $opt['trace'] ) && $opt['trace'] === true ){
            $this->_firephp->trace( 'Trace' );
        }

        return true;
    }
}

/* end of file: ./core/lib/internal/log.php */