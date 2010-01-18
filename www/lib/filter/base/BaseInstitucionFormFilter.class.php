<?php

/**
 * Institucion filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseInstitucionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'geo_id'                    => new sfWidgetFormPropelChoice(array('model' => 'Geo', 'add_empty' => true)),
      'created_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'disabled'                  => new sfWidgetFormFilterInput(),
      'orden'                     => new sfWidgetFormFilterInput(),
      'url'                       => new sfWidgetFormFilterInput(),
      'imagen'                    => new sfWidgetFormFilterInput(),
      'eleccion_institucion_list' => new sfWidgetFormPropelChoice(array('model' => 'Eleccion', 'add_empty' => true)),
      'politico_institucion_list' => new sfWidgetFormPropelChoice(array('model' => 'Politico', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'geo_id'                    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Geo', 'column' => 'id')),
      'created_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'disabled'                  => new sfValidatorPass(array('required' => false)),
      'orden'                     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'url'                       => new sfValidatorPass(array('required' => false)),
      'imagen'                    => new sfValidatorPass(array('required' => false)),
      'eleccion_institucion_list' => new sfValidatorPropelChoice(array('model' => 'Eleccion', 'required' => false)),
      'politico_institucion_list' => new sfValidatorPropelChoice(array('model' => 'Politico', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('institucion_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addEleccionInstitucionListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(EleccionInstitucionPeer::INSTITUCION_ID, InstitucionPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(EleccionInstitucionPeer::ELECCION_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(EleccionInstitucionPeer::ELECCION_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function addPoliticoInstitucionListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(PoliticoInstitucionPeer::INSTITUCION_ID, InstitucionPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(PoliticoInstitucionPeer::POLITICO_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(PoliticoInstitucionPeer::POLITICO_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Institucion';
  }

  public function getFields()
  {
    return array(
      'id'                        => 'Number',
      'geo_id'                    => 'ForeignKey',
      'created_at'                => 'Date',
      'disabled'                  => 'Text',
      'orden'                     => 'Number',
      'url'                       => 'Text',
      'imagen'                    => 'Text',
      'eleccion_institucion_list' => 'ManyKey',
      'politico_institucion_list' => 'ManyKey',
    );
  }
}
