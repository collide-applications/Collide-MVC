<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseTest extends Doctrine_Record
{

  public function setTableDefinition()
  {
    $this->setTableName('test');
    $this->hasColumn('id', 'integer', 4, array('primary' => true, 'autoincrement' => true));
    $this->hasColumn('name', 'string', 255);
  }

  public function setUp()
  {
  }

}