<?php

/**
 * Propuesta filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePropuestaFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'titulo'                  => new sfWidgetFormFilterInput(),
      'descripcion'             => new sfWidgetFormFilterInput(),
      'culture'                 => new sfWidgetFormFilterInput(),
      'imagen'                  => new sfWidgetFormFilterInput(),
      'doc'                     => new sfWidgetFormFilterInput(),
      'doc_size'                => new sfWidgetFormFilterInput(),
      'sf_guard_user_id'        => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'sumu'                    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'sumd'                    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_active'               => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'modified_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'vanity'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'etiqueta_propuesta_list' => new sfWidgetFormPropelChoice(array('model' => 'Etiqueta', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'titulo'                  => new sfValidatorPass(array('required' => false)),
      'descripcion'             => new sfValidatorPass(array('required' => false)),
      'culture'                 => new sfValidatorPass(array('required' => false)),
      'imagen'                  => new sfValidatorPass(array('required' => false)),
      'doc'                     => new sfValidatorPass(array('required' => false)),
      'doc_size'                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'sf_guard_user_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'sumu'                    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'sumd'                    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_active'               => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'modified_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'vanity'                  => new sfValidatorPass(array('required' => false)),
      'etiqueta_propuesta_list' => new sfValidatorPropelChoice(array('model' => 'Etiqueta', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('propuesta_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
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

    $criteria->addJoin(EtiquetaPropuestaPeer::PROPUESTA_ID, PropuestaPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(EtiquetaPropuestaPeer::ETIQUETA_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(EtiquetaPropuestaPeer::ETIQUETA_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Propuesta';
  }

  public function getFields()
  {
    return array(
      'id'                      => 'Number',
      'titulo'                  => 'Text',
      'descripcion'             => 'Text',
      'culture'                 => 'Text',
      'imagen'                  => 'Text',
      'doc'                     => 'Text',
      'doc_size'                => 'Number',
      'sf_guard_user_id'        => 'ForeignKey',
      'sumu'                    => 'Number',
      'sumd'                    => 'Number',
      'is_active'               => 'Boolean',
      'created_at'              => 'Date',
      'modified_at'             => 'Date',
      'vanity'                  => 'Text',
      'etiqueta_propuesta_list' => 'ManyKey',
    );
  }
}
