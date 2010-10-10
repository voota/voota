<?php

/**
 * Geo filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseGeoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'geo_id'           => new sfWidgetFormPropelChoice(array('model' => 'Geo', 'add_empty' => true)),
      'codigo'           => new sfWidgetFormFilterInput(),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'lista_calle_list' => new sfWidgetFormPropelChoice(array('model' => 'Convocatoria', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'nombre'           => new sfValidatorPass(array('required' => false)),
      'geo_id'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Geo', 'column' => 'id')),
      'codigo'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'lista_calle_list' => new sfValidatorPropelChoice(array('model' => 'Convocatoria', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('geo_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addListaCalleListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(ListaCallePeer::GEO_ID, GeoPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(ListaCallePeer::CONVOCATORIA_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(ListaCallePeer::CONVOCATORIA_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Geo';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'nombre'           => 'Text',
      'geo_id'           => 'ForeignKey',
      'codigo'           => 'Number',
      'created_at'       => 'Date',
      'lista_calle_list' => 'ManyKey',
    );
  }
}
