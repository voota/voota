<?php

/**
 * BaseAttachment
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $file_path
 * 
 * @method string     getFilePath()  Returns the current record's "file_path" value
 * @method Attachment setFilePath()  Sets the current record's "file_path" value
 * 
 * @package    symfony12
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseAttachment extends myDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('attachment');
        $this->hasColumn('file_path', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}