<?php

/**
 * Institucion filter form.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class InstitucionFormFilter extends BaseInstitucionFormFilter
{
  public function configure()
  {
  	
    $this->widgetSchema['nombre'] = new sfWidgetFormInput();
    
    $this->validatorSchema['nombre'] = new sfValidatorPass(array('required' => false));
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

    $criteria->addJoin(InstitucionI18nPeer::ID, InstitucionPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(InstitucionI18nPeer::NOMBRE, "%$value%", Criteria::LIKE);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(InstitucionI18nPeer::NOMBRE, "%$value%", Criteria::LIKE));
    }

    $criteria->add($criterion);
  }
}
