<?php

/**
 * BlogComments
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Collide MVC
 * @subpackage Model
 * @author     Radu Graur <radu.graur@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class BlogComments extends BaseBlogComments
{
    public $log;

    /**
	 * Get all comments for one post
	 *
	 * @access	public
     * @param   integer $id post id
	 * @return	array   all comments for this post id
	 */
	public function getAll( $id ){
        $this->log->write( 'BlogComments::getAll(' . $id . ')' );

        $res = Doctrine_Query::create()->
        from( 'BlogComments' )->
        where( 'post_id = ?', array( $id ) )->
        orderBy( 'id DESC')->
        fetchArray();

		return $res;
    }

    /**
	 * Add comment to post
	 *
	 * @access	public
     * @param   array   $comment    comment info to insert
	 * @return	boolean
	 */
	public function add( $comment ){
        $this->log->write( 'BlogComments::add( $comment )' );

        $this->email    = $comment['email'];
        $this->message  = $comment['message'];
        $this->post_id  = $comment['post_id'];
        
        return $this->save();
    }

    /**
	 * Delete comments by post id
     *
	 * @access	public
     * @param   array   $id post id
	 * @return	boolean
	 */
	public function deleteByPostId( $id ){
        $this->log->write( 'BlogPosts::deleteByPostId( ' . $id . ' )' );

        return Doctrine_Query::create()->
            delete( 'BlogComments' )->
            where( 'post_id = ?', $id );
    }
}