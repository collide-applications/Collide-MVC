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
 * View class
 *
 * @package     Collide MVC Core
 * @subpackage  Libraries
 * @category    Views
 * @author      Collide Applications Development Team
 * @link        http://mvc.collide-applications.com/docs/
 * @TODO        Add SMARTY support
 */
class View{
    /**
     * Array with variables to be assigned to views
     *
     * @access  private
     * @var     array   $info   variables to be assigned to views
     */
    private $_info = array();

    private $_tplTitle = '';
    private $_tplKey = '';
    private $_tplDesc = '';
    private $_tplFav = '';
    private $_tplFavCdn = '';
    private $_tplCss = array();
    private $_tplCssCdn = array();
    private $_tplJs = array();
    private $_tplJsCdn = array();

    public $url = null;

    /**
     * Constructor
     *
     * @access  public
     * @return  void
     */
    public function __construct(){
        logWrite( 'View::__construct()' );

        // set values for template from config (could be overwrited with setters)
        // define this controller object
        $collide =& thisInstance();
        $tplInfo = $collide->config->get( array( 'default', 'template' ) );
        $this->setTplInfo( $tplInfo );
        unset( $collide );
        
        // instantiate url library
        $urlClassName = incLib( 'url' );
        $objUrl = new $urlClassName();
        $this->url = $objUrl;
    }

    /**
     * Get requested views
     *
     * @access  public
     * @param   mixed   $views      views to include and display<br>
     *                              if null, display default view
     * @param   array   $info       variables to assign to views
     * @param   mixed   $filters    array or string with filters to apply
     * @return  void
     */
    public function get( $views = null, $info = array(), $filters = null ){
        logWrite( 'View::render()' );

        // define this controller object
        $collide =& thisInstance();
        
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

        return $output;
    }

    /**
     * Render site template
     *
     * Best practice:
     * Load site sections in views with render method and add response in array.
     * Load site template and provide sections array as parameter.
     *
     * @access  public
     * @param   array   $info   variables to assign to template
     * @param   string  $name   template name (path allowed)
     * @return  void
     */
    public function template( $info = array(), $name = null ){
        logWrite( 'View::template( array(), "' . $name . '" )' );
        
        // define this controller object
        $collide =& thisInstance();

        // if no template get default template from app config
        if( is_null( $name ) || empty( $name ) ){
            $name = $collide->config->get( array( 'default', 'template', 'name' ) );
        }

        // prepare template name (remove extension and separator)
        $name = rtrim( $name , EXT );
        $name = ltrim( $name, DS );

        // write variables into symbol table
        if( is_array( $info ) && count( $info ) ){
            extract( $info );
        }

        // load template
        $template = APP_TPL_PATH . $name . EXT;
        if( is_file( $template ) ){
            include( $template );
        }else{
            throw new Collide_exception( 'Template "' . $name . '" does not exist!' );
        }
    }

    /**
     * Include view
     *
     * @access  private
     * @param   string  $view   view file name (no extension)
     * @return  mixed   boolean or content if <var>$return</var> is true
     */
    private function getView( $view ){
        logWrite( 'View::getView("' . $view . '")' );

        // define this controller object
        $collide =& thisInstance();

        // what to print
        $output = '';
        
        // write variables into symbol table
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
        }else{  // not found
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
     * @access  private
     * @param   mixed   $filters    filter name or array of filters
     * @param   string  $output     output text to be filtered
     * @return  boolean true on success or false on error
     */
    private function applyFilters( $filters, &$output ){
        logWrite( 'View::applyFilters( ' . print_r( $filters, 1) . ', $output)' );

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

    /**
     * Set template info based on an array
     *
     * Will set template title, keywords, description, favicon
     *
     * @access  public
     * @param   array   $info   template info
     * @return  boolean
     */
    private function setTplInfo( $info ){
        logWrite( 'View::setTplInfo( $info )' );

        if( !is_array( $info ) || !count( $info ) ){
            return false;
        }

        $this->setTplTitle( isset( $info['title'] ) ? $info['title'] : '' );
        $this->setTplKeywords( isset( $info['keywords'] ) ? $info['keywords'] : '' );
        $this->setTplDescription( isset( $info['description'] ) ? $info['description'] : '' );
        $this->setTplFavicon( isset( $info['favicon']['file'] ) ? $info['favicon']['file'] : '',
                              isset( $info['favicon']['cdn'] ) ? $info['favicon']['cdn'] : '' );
        $this->setTplCss( isset( $info['css']['files'] ) ? $info['css']['files'] : array(),
                          isset( $info['css']['cdn'] ) ? $info['css']['cdn'] : '' );
        $this->setTplJs( isset( $info['js']['files'] ) ? $info['js']['files'] : array(),
                         isset( $info['js']['cdn'] ) ? $info['js']['cdn'] : '' );

        return true;
    }

    /**
     * Setter for template title
     *
     * @access  public
     * @param   string  $title  template title
     * @return  void
     */
    public function setTplTitle( $title ){
        logWrite( 'View::setTplTitle( "' . $title . '" )' );

        $this->_tplTitle = htmlentities( $title );
    }

    /**
     * Setter for template keywords
     *
     * @access  public
     * @param   string  $key    template keywords
     * @return  void
     */
    public function setTplKeywords( $key ){
        logWrite( 'View::setTplKeywords( "' . $key . '" )' );

        $this->_tplKey = htmlentities( $key );
    }

    /**
     * Setter for template description
     *
     * @access  public
     * @param   string  $desc   template description
     * @return  void
     */
    public function setTplDescription( $desc ){
        logWrite( 'View::setTplDescription( "' . $desc . '" )' );

        $this->_tplDesc = htmlentities( $desc );
    }

    /**
     * Setter for template favicon
     *
     * @access  public
     * @param   string  $fav    template favicon
     * @param   string  $cdn    Content Delivery Network pattern
     * @return  void
     */
    public function setTplFavicon( $fav, $cdn = '' ){
        logWrite( 'View::setTplFavicon( "' . $fav . '" )' );

        $this->_tplFav      = htmlentities( $fav );
        $this->_tplFavCdn   = $cdn;
    }

    /**
     * Setter for template css
     *
     * @access  public
     * @param   mixed   $css    template css as string or array
     * @param   string  $cdn    Content Delivery Network pattern
     * @return  void
     */
    public function setTplCss( $css, $cdn = '' ){
        logWrite( 'View::setTplCss( "' . $css . '" )' );

        // create array of styles
        if( is_string( $css ) ){
            $css = array( $css );
        }

        $this->_tplCss      = array_merge_recursive( $this->_tplCss, $css );
        $this->_tplCssCdn   = $cdn;
    }

    /**
     * Setter for template js
     *
     * @access  public
     * @param   mixed   $js     template javascript as string or array
     * @param   string  $cdn    Content Delivery Network pattern
     * @return  void
     */
    public function setTplJs( $js, $cdn = '' ){
        logWrite( 'View::setTplJs( "' . $js . '" )' );

        // create array of styles
        if( is_string( $js ) ){
            $js = array( $js );
        }

        $this->_tplJs       = array_merge_recursive( $this->_tplJs, $js );
        $this->_tplJsCdn   = $cdn;
    }

    /**
     * Getter for template title
     *
     * @access  public
     * @return  string  template title
     */
    public function getTplTitle(){
        logWrite( 'View::getTplTitle()' );

        $html = "<title></title>\n";

        if( !empty( $this->_tplKey ) ){
            $html = "<title>" . $this->_tplTitle . "</title>\n";
        }

        return $html;
    }

    /**
     * Getter for template keywords
     *
     * @access  public
     * @return  string  template keywords
     */
    public function getTplKeywords(){
        logWrite( 'View::getTplKeywords()' );

        $html = '';

        if( !empty( $this->_tplKey ) ){
            $html .= "<meta name=\"keywords\" content=\"" . $this->_tplKey . "\" />\n";
        }

        return $html;
    }

    /**
     * Getter for template description
     *
     * @access  public
     * @return  string  template description
     */
    public function getTplDescription(){
        logWrite( 'View::getTplDescription()' );

        $html = '';

        if( !empty( $this->_tplDesc ) ){
            $html .= "<meta name=\"description\" content=\"" . $this->_tplDesc . "\" />\n";
        }

        return $html;
    }

    /**
     * Getter for template favicon
     *
     * @access  public
     * @return  string  template favicon
     */
    public function getTplFavicon(){
        logWrite( 'View::getTplFavicon()' );

        $html = '';

        // add CDN if any to file url
        $fileUrl = $this->addCdn( $this->_tplFav, $this->_tplFavCdn );

        if( !empty( $this->_tplDesc ) ){
            $html .= <<<EOF
<link rel="shortcut icon" type="img/png" href="{$fileUrl}" />
<link rel="apple-touch-icon" href="{$fileUrl}" />
    
EOF;
        }

        return $html;
    }
    
    /**
     * Getter for template css
     *
     * @access  public
     * @return  void
     */
    public function getTplCss(){
        logWrite( 'View::getTplCss()' );

        $html = '';

        // add each file to html
        if( count( $this->_tplCss ) ){
            foreach( $this->_tplCss as $file ){
                // add CDN if any to file url
                $fileUrl = $this->addCdn( $file, $this->_tplCssCdn );

                $html .= "<link type=\"text/css\" rel=\"stylesheet\" href=\"" . $fileUrl . "\" />\n";
            }
        }

        return $html;
    }

    /**
     * Getter for template js
     *
     * @access  public
     * @return  void
     */
    public function getTplJs(){
        logWrite( 'View::getTplJs()' );

        $html = '';

        // add each file to html
        if( count( $this->_tplJs ) ){
            foreach( $this->_tplJs as $file ){
                // add CDN if any to file url
                $fileUrl = $this->addCdn( $file, $this->_tplJsCdn );

                $html .= "<script type=\"text/javascript\" src=\"" . $fileUrl . "\"></script>\n";
            }
        }

        return $html;
    }

    /**
     * Add CDN (Content Delivery Network) subdomain to one url
     *
     * Example for 'cdn[0-9]':
     * http://example.com/file.ext
     * changed to:
     * http://cdn0.example.com/file.ext
     *
     * !OBS1: the new url should be cookie free domain
     * !OBS2: if CDN pattern is empty or invalid $this->url->get() will be applied
     *
     * @access  public
     * @param   string  $file   file to complete
     * @param   string  $cdn    pattern to generate CDN
     * @return  string  url prefixed with CDN
     */
    private function addCdn( $file, $cdn = '' ){
        logWrite( 'View::addCdn( $file, $pattern )' );

        $file = ltrim( $file, '/' );

        // load url helper for favicon url
        $collide =& thisInstance();
        
        if( is_string( $cdn ) && !empty( $cdn ) &&
            // if full url provided
            preg_match( '/^https?:\/\/[a-z0-9_-]+\.?[a-z0-9_-]+\.[a-z]{3,5}\/?$/i', $cdn ) ){
            return rtrim( $cdn, '/' ) . '/' . $file;
        }else if( is_array( $cdn ) && count( $cdn ) ){
            // if array of subdomains provided pick one
            $cdn = $cdn[mt_rand( 0, count( $cdn ) - 1 )];
            
            preg_match( '/^(https?:\/\/)([a-z0-9\._-]+\.[a-z]{3,5}[a-z0-9-_\/]*)$/i', $this->url->get(), $matches );
            return $matches[1] . $cdn . '.' . rtrim( $matches[2], '/' ) . '/' . $file;
        }

        return $this->url->get() . $file;
    }
}