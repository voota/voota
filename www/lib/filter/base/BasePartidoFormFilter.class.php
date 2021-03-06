<?php

/**
 * Partido filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePartidoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'abreviatura'           => new sfWidgetFormFilterInput(),
      'color'                 => new sfWidgetFormFilterInput(),
      'created_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'partido_id'            => new sfWidgetFormPropelChoice(array('model' => 'Partido', 'add_empty' => true)),
      'imagen'                => new sfWidgetFormFilterInput(),
      'sumu'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'sumd'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_active'             => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_main'               => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'etiqueta_partido_list' => new sfWidgetFormPropelChoice(array('model' => 'Etiqueta', 'add_empty' => true)),
      'partido_lista_list'    => new sfWidgetFormPropelChoice(array('model' => 'Lista', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'abreviatura'           => new sfValidatorPass(array('required' => false)),
      'color'                 => new sfValidatorPass(array('required' => false)),
      'created_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'partido_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Partido', 'column' => 'id')),
      'imagen'                => new sfValidatorPass(array('required' => false)),
      'sumu'                  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'sumd'                  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_active'             => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_main'               => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'etiqueta_partido_list' => new sfValidatorPropelChoice(array('model' => 'Etiqueta', 'required' => false)),
      'partido_lista_list'    => new sfValidatorPropelChoice(array('model' => 'Lista', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('partido_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
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

    $criteria->addJoin(EtiquetaPartidoPeer::PARTIDO_ID, PartidoPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(EtiquetaPartidoPeer::ETIQUETA_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(EtiquetaPartidoPeer::ETIQUETA_ID, $value));
    }

    $criteria->add($criterion);
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

    $criteria->addJoin(PartidoListaPeer::PARTIDO_ID, PartidoPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(PartidoListaPeer::LISTA_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(PartidoListaPeer::LISTA_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Partido';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'abreviatura'           => 'Text',
      'color'                 => 'Text',
      'created_at'            => 'Date',
      'partido_id'            => 'ForeignKey',
      'imagen'                => 'Text',
      'sumu'                  => 'Number',
      'sumd'                  => 'Number',
      'is_active'             => 'Boolean',
      'is_main'               => 'Boolean',
      'etiqueta_partido_list' => 'ManyKey',
      'partido_lista_list'    => 'ManyKey',
    );
  }
}
