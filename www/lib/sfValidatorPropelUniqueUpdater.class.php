<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfValidatorPropelUnique validates that the uniqueness of a column.
 *
 * Warning: sfValidatorPropelUnique is susceptible to race conditions.
 * To avoid this issue, wrap the validation process and the model saving
 * inside a transaction.
 *
 * @package    symfony
 * @subpackage validator
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfValidatorPropelUnique.class.php 13249 2008-11-22 16:10:11Z fabien $
 */
class sfValidatorPropelUniqueUpdater extends sfValidatorPropelUnique
{
  protected $keywords = array(
  	'politico','politics','politic','politicos',
  	'politics','take','partit','partidos','partits','partido',
  	'user','logout','user','review','r','about','dos-and-donts','search','contact',
  	'a1'
  );
  
  /**
   * @see sfValidatorBase
   */
  protected function doClean($values)
  {
    if (!is_array($values))
    {
      throw new InvalidArgumentException('You must pass an array parameter to the clean() method (this validator can only be used as a post validator).');
    }

    if (!is_array($this->getOption('column')))
    {
      $this->setOption('column', array($this->getOption('column')));
    }

    if (!is_array($field = $this->getOption('field')))
    {
      $this->setOption('field', $field ? array($field) : array());
    }
    $fields = $this->getOption('field');

    $criteria = new Criteria();
    foreach ($this->getOption('column') as $i => $column)
    {
      $name = isset($fields[$i]) ? $fields[$i] : $column;
      if (!array_key_exists($name, $values))
      {
        // one of the column has be removed from the form
        return $values;
      }

      $colName = call_user_func(array(constant($this->getOption('model').'::PEER'), 'translateFieldName'), $column, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME);

      $criteria->add($colName, $values[$name]);
    }
    
    // UPDATE PATCH: Add primary key column yo avoid validating current record
    if (sfContext::getInstance()->getUser()){
    	if ($this->getOption('model') == 'sfGuardUserProfile'){
   		  	$criteria->add(SfGuardUserProfilePeer::USER_ID, sfContext::getInstance()->getUser()->getGuardUser()->getId(), Criteria::NOT_EQUAL);
       	}
       	else {
   		  	$criteria->add(SfGuardUserPeer::ID, sfContext::getInstance()->getUser()->getGuardUser()->getId(), Criteria::NOT_EQUAL);
       	}
    }
    // END UPDATE PATCH
    
    $object = call_user_func(array(constant($this->getOption('model').'::PEER'), 'doSelectOne'), $criteria, $this->getOption('connection'));

    // if no object or if we're updating the object, it's ok
    if ((is_null($object) || $this->isUpdate($object, $values)) && !in_array($values[$name], $this->keywords))
    {
    	return $values;
    }
    

    $error = new sfValidatorError($this, 'invalid', array('column' => implode(', ', $this->getOption('column'))));

    if ($this->getOption('throw_global_error'))
    {
      throw $error;
    }

    $columns = $this->getOption('column');

    throw new sfValidatorErrorSchema($this, array($columns[0] => $error));
  }

}
