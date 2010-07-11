<?php if( !defined( 'ROOT_PATH' ) ) die( NO_ACCESS_MSG );

/**
 * Output filters
 *
 * @package		Collide MVC App
 * @subpackage	Libraries
 * @category	Filters
 * @author		Collide Applications Development Team
 * @link		http://mvc.collide-applications.com/docs/
 */

/**
 * This is a demo filter
 *
 * Transform "MVC" to "MVC (Model View Controller)"
 *
 * @access  public
 * @param   string  $output page output
 * @return  void
 */
if( !function_exists( 'transformMVC ' ) ){
    function transformMVC( &$output ){
        $output = str_replace( 'MVC', 'MVC (Model View Controller)', $output );
    }
}

 /* end of file: ./app/lib/filters.php */