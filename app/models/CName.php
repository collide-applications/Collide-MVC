<?php

/**
 * CName
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class CName extends BaseCName
{
    public $log;

	/**
	 * Return framework name
	 *
	 * @access	public
	 * @return	string	framework name
	 */
	public function getName(){
        $this->log->write( 'CName::getName()' );

        $res = Doctrine_Query::create()->
        select( 'name' )->
        from( 'CName' )->
        where( 'id', 1 )->
        fetchOne();
        
        return ucfirst( $res->name );
    }
}
