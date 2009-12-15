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
	private $p;
	
  public function configure()
  {
    unset($this['algorithm'], $this['salt'], $this['password']);

    $this->widgetSchema['sf_guard_user_group_list']->setLabel('Groups');
    $this->widgetSchema['sf_guard_user_permission_list']->setLabel('Permissions');
    
    $this->p = new SfGuardUserProfileFormFilter();
      $this->mergeForm($this->p);
  }
  public function buildCriteria(array $values) {
  	$c1 = parent::buildCriteria($values);
  	
  	$c = $this->p->buildCriteria($values);
  	$c->addJoin("sf_guard_user.id", "sf_guard_user_profile.user_id");
  	$c->putAll($c1->getMap());
  	
  	return $c;
  }
}
