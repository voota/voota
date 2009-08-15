<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Lista filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseListaFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'partido_id'          => new sfWidgetFormPropelChoice(array('model' => 'Partido', 'add_empty' => true)),
      'eleccion_id'         => new sfWidgetFormPropelChoice(array('model' => 'Eleccion', 'add_empty' => true)),
      'created_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'partido_lista_list'  => new sfWidgetFormPropelChoice(array('model' => 'Partido', 'add_empty' => true)),
      'politico_lista_list' => new sfWidgetFormPropelChoice(array('model' => 'Politico', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'partido_id'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Partido', 'column' => 'id')),
      'eleccion_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Eleccion', 'column' => 'id')),
      'created_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'partido_lista_list'  => new sfValidatorPropelChoice(array('model' => 'Partido', 'required' => false)),
      'politico_lista_list' => new sfValidatorPropelChoice(array('model' => 'Politico', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lista_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addPartidoListaListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(PartidoListaPeer::LISTA_ID, ListaPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(PartidoListaPeer::PARTIDO_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(PartidoListaPeer::PARTIDO_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function addPoliticoListaListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(PoliticoListaPeer::LISTA_ID, ListaPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(PoliticoListaPeer::POLITICO_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(PoliticoListaPeer::POLITICO_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Lista';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'partido_id'          => 'ForeignKey',
      'eleccion_id'         => 'ForeignKey',
      'created_at'          => 'Date',
      'partido_lista_list'  => 'ManyKey',
      'politico_lista_list' => 'ManyKey',
    );
  }
}
