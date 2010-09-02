<?php if( !defined( 'ROOT_PATH' ) ) die( '403: Forbidden' );

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
 * @since       Version 0.1                                                   *
 *                                                                            *
 ******************************************************************************/

/**
 * BlogComments
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Collide MVC
 * @subpackage Model
 */
class BlogComments extends BaseBlogComments
{
    /**
     * Get all comments for one post
     *
     * @access  public
     * @param   integer $id post id
     * @return  array   all comments for this post
     */
    public function getAll( $id ){
        //log( 'BlogComments::getAll(' . $id . ')' );

        return Doctrine_Query::create()->
        from( 'BlogComments' )->
        where( 'post_id = ?', $id )->
        orderBy( 'id DESC')->
        fetchArray();
    }

    /**
     * Add comment to post
     *
     * @access  public
     * @param   array   $comment    comment info to insert
     * @return  boolean
     */
    public function add( $comment ){
        //log( 'BlogComments::add( $comment )' );

        $this->name     = $comment['name'];
        $this->message  = $comment['message'];
        $this->post_id  = $comment['post_id'];
        
        return $this->save();
    }

    /**
     * Delete comments by post id
     *
     * @access  public
     * @param   array   $id post id
     * @return  boolean
     */
    public function deleteByPostId( $id ){
        //log( 'BlogPosts::deleteByPostId( ' . $id . ' )' );

        return Doctrine_Query::create()->
            delete( 'BlogComments' )->
            where( 'post_id = ?', $id )->
            execute();
    }
}