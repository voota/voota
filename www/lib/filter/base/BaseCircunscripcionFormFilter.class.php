<?php

/**
 * Circunscripcion filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseCircunscripcionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'geo_id'           => new sfWidgetFormPropelChoice(array('model' => 'Geo', 'add_empty' => true)),
      'escanyos'         => new sfWidgetFormFilterInput(),
      'lista_calle_list' => new sfWidgetFormPropelChoice(array('model' => 'Convocatoria', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'geo_id'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Geo', 'column' => 'id')),
      'escanyos'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'lista_calle_list' => new sfValidatorPropelChoice(array('model' => 'Convocatoria', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('circunscripcion_filters[%s]');

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

    $criteria->addJoin(ListaCallePeer::CIRCUNSCRIPCION_ID, CircunscripcionPeer::ID);

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
    return 'Circunscripcion';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'geo_id'           => 'ForeignKey',
      'escanyos'         => 'Number',
      'lista_calle_list' => 'ManyKey',
    );
  }
}
