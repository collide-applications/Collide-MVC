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
 * BlogUsers
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Collide MVC
 * @subpackage Model
 */
class BlogUsers extends BaseBlogUsers{
    /**
     * Check if this user could be logged in
     *
     * Check username and password
     *
     * @access  public
     * @param   string  $user   username
     * @param   string  $pass   password
     * @param   array   $fields fields to return and keep in session after login
     * @return  boolean
     */
    public function login( $user, $pass, $fields ){
        logWrite( "BlogUsers::login( \$user, \$pass, \$fields )" );

        // get user by username and password
        $query = Doctrine_Query::create();

        // add fields to be selected (by default id)
        if( is_array( $fields ) && count( $fields ) ){
            foreach( $fields as $field ){
                $query->select( $field );
            }
        }else{
            $query->select( 'id' );
        }

        // execute query
        $res = $query->from( 'BlogUsers' )->
            where( 'user = ?', $user )->
            andWhere( 'pass = ?', $pass )->
            limit( 1 )->
            fetchArray();

        // check if user returned
        if( count( $res ) ){
            return $res[0];
        }

        return false;
    }
}