<?php if( !defined( 'ROOT_PATH' ) ) die( '403: Forbidden' );

/******************************************************************************
 *                                                                            *
 * Collide MVC Framework                                                      *
 *                                                                            *
 * MVC framework for PHP.                                                     *
 *                                                                            *
 * @package     Collide MVC App                                               *
 * @author      Collide Applications Development Team                         *
 * @copyright   Copyright (c) 2009, Collide Applications                      *
 * @license     http://mvc.collide-applications.com/license.txt               *
 * @link        http://mvc.collide-applications.com                           *
 * @since       Version 0.1                                                   *
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
 * @category    Blog
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
        
        logWrite( 'BlogController::__construct()' );

        // get menu items from config
        $this->config->load( 'blog' );
        $this->_menu = $this->config->get( array( 'blog', 'menu' ) );

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
        logWrite( 'BlogController::index()' );

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
     * @param   integer $id     post id
     * @param   string  $error  errors
     * @return  void
     */
    public function post( $id, $error = '' ){
        logWrite( 'BlogController::post(' . $id . ')' );

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
        logWrite( 'BlogController::comment()' );

        // load validation library and array
        $this->load->lib( 'validation' );
        $this->validation->load( 'comments' );

        // add $_POST['post'] as parameter to add function
        $form = $this->globals->get();

        // validate input
        if( $this->validation->check( $form ) ){
            $this->comments->add( $form );
            $this->url->go( 'blog/post/' . $this->globals->get( 'post_id' ) );
        }else{
            $this->url->go( 'blog/post/' . $this->globals->get( 'post_id' ) . '/comment' );
        }
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
        logWrite( 'BlogController::add()' );
        
        // load add view
        if( is_null( $this->globals->get( 'post' ) ) ){
            // load view
            $info['main'] = $this->view->get( 'blog/add' );

            // provide menu
            $info['menu'] = $this->_menu;

            // load template
            $this->view->template( $info );
        }else{
            // insert post
            $this->posts->add( $this->globals->get( 'post' ) );

            $this->url->go( 'blog' );
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
        logWrite( 'BlogController::edit(' . $id . ')' );

        // load edit view
        if( is_null( $this->globals->get( 'post' ) ) ){
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
            $this->posts->edit( $this->globals->get( 'post' ) );

            $this->url->go( 'blog/post/' . $id );
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
        logWrite( 'BlogController::delete(' . $id . ')' );

        // if post deleted delete comments too
        if( $this->posts->delete( $id ) ){
            $this->comments->deleteByPostId( $id );
        }

        $this->url->go( 'blog' );
    }
}