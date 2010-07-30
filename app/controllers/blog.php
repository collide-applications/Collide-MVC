<?php if( !defined( 'ROOT_PATH' ) ) die( NO_ACCESS_MSG );

/******************************************************************************
 *                                                                            *
 * Collide PHP Framework                                                      *
 *                                                                            *
 * MVC framework for PHP.                                                     *
 *                                                                            *
 * @package     Collide MVC App                                               *
 * @author      Collide Applications Development Team                         *
 * @copyright   Copyright (c) 2009, Collide Applications                      *
 * @license     http://mvc.collide-applications.com/license.txt               *
 * @link        http://mvc.collide-applications.com                           *
 * @since       Version 1.0                                                   *
 *                                                                            *
 ******************************************************************************/

/**
 * Blog demo page
 *
 * Demonstrates a simple blog CRUD application.
 * 
 * Features:
 * - view posts;
 * - add new post;
 * - add comments to post;
 * - edit post;
 * - delete post;
 *
 * @package     Collide MVC App
 * @subpackage  Controllers
 * @category    Welcome
 * @author      Collide Applications Development Team
 * @link        http://mvc.collide-applications.com/docs/
 */
class BlogController extends _Controller{
    /**
     * Main menu
     *
     * Initialized with values from blog config
     *
     * @access  private
     * @var     array   $_menu   main menu
     * @todo    initialize from constructor
     */
    private $_menu = array();

    /**
     * Constructor
     *
     * @access  public
     * @return  void
     */
    public function __construct(){
        parent::__construct();
        
        $this->log->write( 'BlogController::__construct()' );

        // get menu items from config
        $this->config->load( 'blog' );
        $this->_menu = $this->config->get( array( 'blog', 'menu' ) );

        $this->load->helper( 'url' );
        $this->load->model( 'posts' );
        $this->load->model( 'comments' );
    }

    /**
     * Show all posts
     *
     * @access  public
     * @return  void
     */
    public function index(){
        $this->log->write( 'BlogController::index()' );

        // get all posts using posts model
        $mainInfo['posts']      = $this->posts->getAll();
        $mainInfo['numPosts']   = count( $mainInfo['posts'] );

        // load view
        $info['main'] = $this->view->get( 'blog/posts', $mainInfo );

        // provide menu
        $info['menu'] = $this->_menu;
        
        // load template
        $this->view->template( $info );
    }

    /**
     * Show post and comments for this post
     *
     * @access  public
     * @param   integer $id post id
     * @return  void
     */
    public function post( $id ){
        $this->log->write( 'BlogController::post(' . $id . ')' );

        // get post and comments
        $mainInfo['post']       = $this->posts->getOne( $id );
        $mainInfo['comments']   = $this->comments->getAll( $id );

        // load view
        $info['main'] = $this->view->get( 'blog/post', $mainInfo );

        // provide menu
        $info['menu'] = $this->_menu;

        // load template
        $this->view->template( $info );
    }

    /**
     * Add new comment for this post
     *
     * @access  public
     * @return  void
     */
    public function comment(){
        $this->log->write( 'BlogController::comment()' );

        $this->comments->add( $_POST );

        redirect( 'blog/post/' . $_POST['post_id'] );
    }

    /**
     * Add new post
     *
     * Show add page if post array not set or insert post
     *
     * @access  public
     * @return  void
     */
    public function add(){
        $this->log->write( 'BlogController::add()' );
        
        // load add view
        if( !isset( $_POST['post'] ) ){
            // load view
            $info['main'] = $this->view->get( 'blog/add' );

            // provide menu
            $info['menu'] = $this->_menu;

            // load template
            $this->view->template( $info );
        }else{
            // insert post
            $this->posts->add( $_POST['post'] );

            redirect( 'blog' );
        }
    }

    /**
     * Edit post
     *
     * Show edit page if post array not set or insert post
     *
     * @access  public
     * @param   integer $id post id to edit
     * @return  void
     */
    public function edit( $id ){
        $this->log->write( 'BlogController::edit(' . $id . ')' );

        // load edit view
        if( !isset( $_POST['post'] ) ){
            // get post info
            $mainInfo['post'] = $this->posts->getOne( $id );

            // load view
            $info['main'] = $this->view->get( 'blog/edit', $mainInfo );

            // provide menu
            $info['menu'] = $this->_menu;

            // load template
            $this->view->template( $info );
        }else{
            // update post
            $this->posts->edit( $_POST['post'] );

            redirect( 'blog/post/' . $id );
        }
    }

    /**
     * Delete post
     *
     * @access  public
     * @param   integer $id post id to delete
     * @return  void
     */
    public function delete( $id ){
        $this->log->write( 'BlogController::delete(' . $id . ')' );

        // if post deleted delete comments too
        if( $this->posts->delete( $id ) ){
            $this->comments->deleteByPostId( $id );
        }

        redirect( 'blog' );
    }
}