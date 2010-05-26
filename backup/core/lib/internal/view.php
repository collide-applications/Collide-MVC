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
	 * Default application config array
	 *
	 * @access	private
	 * @var		array	$_cfg	default application config array
	 */
	private $_cfg = array();

	/**
	 * This controller name
	 *
	 * @access	private
	 * @var		string	$_controller	this controller name
	 */
	private $_controller = '';

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
		echo 'View::__construct()<br />';
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
        echo 'View::__call()<br />';

		echo 'Function ' . $name . '(' . implode( ',', $args ) . ') does not exists!<br />';
	}

	/**
	 * Set default application config array
	 *
	 * @access	public
	 * @param	array	$cfg	default application config array
     * @return  void
	 */
	public function setCfg( $cfg ){
        echo 'View::setCfg(' . $cfg . ')<br />';

		if( is_array( $cfg ) ){
			$this->_cfg = $cfg;
		}
	}

	/**
	 * Set this controller name
	 *
	 * @access	public
	 * @param	string	$controller	this controller name
     * @return  void
	 */
	public function setController( $controller ){
        echo 'View::setController(' . $controller . ')<br />';

		$this->_controller = trim( strtolower( $controller ) );
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
        echo 'View::render( ' . print_r( $views, 1) . ', ' . print_r( $info, 1) . ', ' . $return . ', ' . print_r( $filters, 1) . ')<br />';

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
			$arrViews[] = $this->_cfg['default']['view'];
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
        echo 'View::getView( ' . $view . ')<br />';

        // what to print
        $output = '';

		// vrite variables into symbol table
		extract( $this->_info );
		
		// prepare file name
		$view = trim( strtolower( $view ) );

        // collect content in buffer
        ob_start();

		// include view
		if( is_file( APP_VIEWS_PATH . $this->_controller . DS . $view . EXT ) ){
            // try filename from controller folder
			include( APP_VIEWS_PATH . $this->_controller . DS . $view . EXT );
		}else if( is_file( APP_VIEWS_PATH . $view . DS .
						   $this->_cfg['default']['view'] . EXT ) ){
            // try folder name and default file name
			include( APP_VIEWS_PATH . $view . DS .
					 $this->_cfg['default']['view'] . EXT );
        }else if( is_file( APP_VIEWS_PATH . $view . EXT ) ){
            // try file name from views folder root
            include( APP_VIEWS_PATH . $view . EXT );
		}else{															// not found
			echo "View {$view} does not exists!";

			// @TODO: display error when view is missing
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
        echo 'View::applyFilters( ' . print_r( $filters, 1) . ', $output)<br />';

        // include filters script
        if( is_file( APP_LIB_PATH . 'filters' . EXT ) ){
            require_once( APP_LIB_PATH . 'filters' . EXT );
        }else{
            echo './app/lib/filters.php does not exists!<br />';

            // @TODO: display error if filter library is not there

            return false;
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
                    echo "Filter {$filter} does not exists!";

                    // @TODO: display error if filter function is not there

                    return false;
                }
            }
        }else{  // anything else
            return false;
        }

        return true;
    }
}

/* end of file: ./core/lib/internal/view.php */