<?php

/**
 * sfGuardUser filter form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfGuardUserFormFilter.class.php 12896 2008-11-10 19:02:34Z fabien $
 */
class sfGuardUserFormFilter extends BasesfGuardUserFormFilter
{
  public function configure()
  {
    unset($this['algorithm'], $this['salt'], $this['password']);

    $this->widgetSchema['sf_guard_user_group_list']->setLabel('Groups');
    $this->widgetSchema['sf_guard_user_permission_list']->setLabel('Permissions');
    
    $this->widgetSchema['nombre'] = new sfWidgetFormFilterInput(array('with_empty' => false));
    $this->validatorSchema['nombre'] = new sfValidatorPass(array('required' => false));
    
    $this->widgetSchema['apellidos'] = new sfWidgetFormFilterInput(array('with_empty' => false));
    $this->validatorSchema['apellidos'] = new sfValidatorPass(array('required' => false));
    
    
  }

  public function addNombreColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(sfGuardUserProfilePeer::USER_ID, sfGuardUserPeer::ID);

    $value = array_pop($values);
    if ($value)
    	$criterion = $criteria->getNewCriterion(sfGuardUserProfilePeer::NOMBRE, $value);

    foreach ($values as $value)
    {
    	if ($value)
    		$criterion->addOr($criteria->getNewCriterion(sfGuardUserProfilePeer::NOMBRE, $value));
    }

    if (isset($criterion))
    	$criteria->add($criterion);
  }
  public function addApellidosColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(sfGuardUserProfilePeer::USER_ID, sfGuardUserPeer::ID);

    $value = array_pop($values);
    if ($value)
    	$criterion = $criteria->getNewCriterion(sfGuardUserProfilePeer::APELLIDOS, $value);

    foreach ($values as $value)
    {
    	if ($value)
      		$criterion->addOr($criteria->getNewCriterion(sfGuardUserProfilePeer::APELLIDOS, $value));
    }

    if (isset($criterion))
    	$criteria->add($criterion);
  }
}
