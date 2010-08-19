<?php

/**
 * Etiqueta filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseEtiquetaFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'texto'                   => new sfWidgetFormFilterInput(),
      'etiqueta_politico_list'  => new sfWidgetFormPropelChoice(array('model' => 'Politico', 'add_empty' => true)),
      'etiqueta_partido_list'   => new sfWidgetFormPropelChoice(array('model' => 'Partido', 'add_empty' => true)),
      'etiqueta_propuesta_list' => new sfWidgetFormPropelChoice(array('model' => 'Propuesta', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'texto'                   => new sfValidatorPass(array('required' => false)),
      'etiqueta_politico_list'  => new sfValidatorPropelChoice(array('model' => 'Politico', 'required' => false)),
      'etiqueta_partido_list'   => new sfValidatorPropelChoice(array('model' => 'Partido', 'required' => false)),
      'etiqueta_propuesta_list' => new sfValidatorPropelChoice(array('model' => 'Propuesta', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('etiqueta_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addEtiquetaPoliticoListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(EtiquetaPoliticoPeer::ETIQUETA_ID, EtiquetaPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(EtiquetaPoliticoPeer::POLITICO_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(EtiquetaPoliticoPeer::POLITICO_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function addEtiquetaPartidoListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(EtiquetaPartidoPeer::ETIQUETA_ID, EtiquetaPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(EtiquetaPartidoPeer::PARTIDO_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(EtiquetaPartidoPeer::PARTIDO_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function addEtiquetaPropuestaListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(EtiquetaPropuestaPeer::ETIQUETA_ID, EtiquetaPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(EtiquetaPropuestaPeer::PROPUESTA_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(EtiquetaPropuestaPeer::PROPUESTA_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Etiqueta';
  }

  public function getFields()
  {
    return array(
      'id'                      => 'Number',
      'texto'                   => 'Text',
      'culture'                 => 'Text',
      'etiqueta_politico_list'  => 'ManyKey',
      'etiqueta_partido_list'   => 'ManyKey',
      'etiqueta_propuesta_list' => 'ManyKey',
    );
  }
}
