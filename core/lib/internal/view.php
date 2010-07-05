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
 * View class
 *
 * @package		Collide MVC Core
 * @subpackage	Libraries
 * @category	Views
 * @author		Collide Applications Development Team
 * @link		http://mvc.collide-applications.com/docs/
 * @TODO        Add SMARTY support
 */
class View{
    /**
     * Log object reference
     *
     * @access  protected
     * @var     object  $log    log reference
     */
    protected $_log = null;

	/**
	 * Array with variables to be assigned to views
	 *
	 * @access	private
	 * @var		array	$info	variables to be assigned to views
	 */
	private $_info = array();

	/**
	 * Constructor
	 *
	 * @access	public
     * @return  void
	 */
	public function __construct(){
        // instantiate log
    	$this->_log =& Log::getInstance();
        $this->_log->write( 'View::__construct()' );
	}

	/**
	 * This function is called when method does not exists
	 *
	 * @access	public
	 * @param	string	$name	method name
	 * @param	array	$args	method arguments
     * @return  void
	 */
	public function  __call( $name,  $args ){
        $this->_log->write( 'View::__call(' . $name . ', ' . $args . ')' );

		echo 'Function ' . $name . '(' . implode( ',', $args ) . ') does not exists!<br />';
	}

	/**
	 * Render requested views
	 *
	 * @access	public
	 * @param	mixed	$views	views to include and display<br>
	 *							if null, display default view
	 * @param	array	$info	variables to assign to views
     * @param   boolean $return render output or return it?
     * @return  void
	 */
	public function render( $views = null, $info = array(), $return = false, $filters = null ){
        $this->_log->write( 'View::render()' );

        // define this controller object
        $collide = Controller::getInstance();
        
        // initialization
        if( is_array( $info ) ){
            $this->_info = $info;
        }else{
            $this->_info['info'] = $info;
        }
        $output = '';

		// collect all views here
		$arrViews = array();

		// if view is not provided display default view
		// default view folder has the same name as this controller
		// default view name is set in application default config
		if( !$views ){
            $arrViews[] = $collide->config->get( array( 'default', 'view' ) );
		}

		// if view is string include that view create array with this name
		if( is_string( $views ) ){
			$arrViews[] = $views;
		}

		// multiple views provided
		if( is_array( $views ) ){
			$arrViews = $views;
		}

		// include each view
		foreach( $arrViews as $view ){
			$output .= $this->getView( $view );
		}

        // apply filters
        if( $filters ){
            $this->applyFilters( $filters, $output );
        }

        if( $return ){          // if return output is activated return output
            return $output;
        }else{                  // display the output
            echo $output;
        }

        return null;
	}

	/**
	 * Include view
	 *
	 * @access	private
	 * @param	string	$view	view file name (no extension)
     * @return  mixed   boolean or content if <var>$return</var> is true
	 */
	private function getView( $view ){
        $this->_log->write( 'View::getView("' . $view . '")' );

        // define this controller object
        $collide = Controller::getInstance();

        // what to print
        $output = '';

		// vrite variables into symbol table
		extract( $this->_info );
		
		// prepare file name
		$view = trim( strtolower( $view ) );

        // collect content in buffer
        ob_start();

		// include view
        $viewFile = APP_VIEWS_PATH . $collide->getControllerName() . DS . $view . EXT;
		if( is_file( $viewFile ) ){
            // try filename from controller folder
			include( $viewFile );
		}else if( is_file( APP_VIEWS_PATH . $view . DS .
						   $collide->config->get( array( 'default', 'view' ) ) . EXT ) ){
            // try folder name and default file name
			include( APP_VIEWS_PATH . $view . DS .
					 $collide->config->get( array( 'default', 'view' ) ) . EXT );
        }else if( is_file( APP_VIEWS_PATH . $view . EXT ) ){
            // try file name from views folder root
            include( APP_VIEWS_PATH . $view . EXT );
		}else{															// not found
			throw new Collide_exception( 'View "' . $view . '" does not exist!' );
		}

        // return content and clean the buffer
        $output .= ob_get_contents();
        ob_end_clean();

        return $output;
	}

    /**
	 * Apply filters to output
	 *
	 * @access	private
	 * @param	mixed	$filters	filter name or array of filters
     * @param   string  $output     output text to be filtered
     * @return  boolean true on success or false on error
	 */
	private function applyFilters( $filters, &$output ){
        $this->_log->write( 'View::applyFilters( ' . print_r( $filters, 1) . ', $output)' );

        // include filters script
        if( is_file( APP_LIB_PATH . 'filters' . EXT ) ){
            require_once( APP_LIB_PATH . 'filters' . EXT );
        }else{
            throw new Collide_exception( 'Filters script does not exist!' );
        }

        // apply filters
        if( is_string( $filters ) ){    // filter name
            // make array of filters
            $filters = array( $filters );
        }
        
        if( is_array( $filters ) && count( $filters ) ){  // array of filters
            // apply each filter
            foreach( $filters as $filter ){
                // check if function really exists
                if( function_exists( $filter ) ){
                    $filter( $output );
                }else{
                    throw new Collide_exception( 'Filter "' . $filter . '" does not exist!' );
                }
            }
        }else{  // anything else
            return false;
        }

        return true;
    }
}

/* end of file: ./core/lib/internal/view.php */