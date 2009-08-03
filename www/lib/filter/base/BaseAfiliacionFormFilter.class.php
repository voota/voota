<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Afiliacion filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseAfiliacionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'fecha_inicio'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'fecha_fin'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'partido_id'               => new sfWidgetFormPropelChoice(array('model' => 'Partido', 'add_empty' => true)),
      'created_at'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'politico_afiliacion_list' => new sfWidgetFormPropelChoice(array('model' => 'Politico', 'add_empty' => true)),
      'partido_afiliacion_list'  => new sfWidgetFormPropelChoice(array('model' => 'Partido', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'fecha_inicio'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'fecha_fin'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'partido_id'               => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Partido', 'column' => 'id')),
      'created_at'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'politico_afiliacion_list' => new sfValidatorPropelChoice(array('model' => 'Politico', 'required' => false)),
      'partido_afiliacion_list'  => new sfValidatorPropelChoice(array('model' => 'Partido', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('afiliacion_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addPoliticoAfiliacionListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(PoliticoAfiliacionPeer::AFILIACION_ID, AfiliacionPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(PoliticoAfiliacionPeer::POLITICO_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(PoliticoAfiliacionPeer::POLITICO_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function addPartidoAfiliacionListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(PartidoAfiliacionPeer::AFILIACION_ID, AfiliacionPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(PartidoAfiliacionPeer::PARTIDO_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(PartidoAfiliacionPeer::PARTIDO_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Afiliacion';
  }

  public function getFields()
  {
    return array(
      'id'                       => 'Number',
      'fecha_inicio'             => 'Date',
      'fecha_fin'                => 'Date',
      'partido_id'               => 'ForeignKey',
      'created_at'               => 'Date',
      'politico_afiliacion_list' => 'ManyKey',
      'partido_afiliacion_list'  => 'ManyKey',
    );
  }
}
