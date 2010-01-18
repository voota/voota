<?php

/**
 * Eleccion filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseEleccionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'                    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'fecha'                     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'eleccion_institucion_list' => new sfWidgetFormPropelChoice(array('model' => 'Institucion', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'nombre'                    => new sfValidatorPass(array('required' => false)),
      'fecha'                     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'eleccion_institucion_list' => new sfValidatorPropelChoice(array('model' => 'Institucion', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('eleccion_filters[%s]');

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

    $criteria->addJoin(EleccionInstitucionPeer::ELECCION_ID, EleccionPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(EleccionInstitucionPeer::INSTITUCION_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(EleccionInstitucionPeer::INSTITUCION_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Eleccion';
  }

  public function getFields()
  {
    return array(
      'id'                        => 'Number',
      'nombre'                    => 'Text',
      'fecha'                     => 'Date',
      'created_at'                => 'Date',
      'eleccion_institucion_list' => 'ManyKey',
    );
  }
}
