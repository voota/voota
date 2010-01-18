<?php

/**
 * Imagen filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseImagenFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'tipo'        => new sfWidgetFormFilterInput(),
      'partido_id'  => new sfWidgetFormPropelChoice(array('model' => 'Partido', 'add_empty' => true)),
      'politico_id' => new sfWidgetFormPropelChoice(array('model' => 'Politico', 'add_empty' => true)),
      'opinion_id'  => new sfWidgetFormFilterInput(),
      'created_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'tipo'        => new sfValidatorPass(array('required' => false)),
      'partido_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Partido', 'column' => 'id')),
      'politico_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Politico', 'column' => 'id')),
      'opinion_id'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('imagen_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Imagen';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'tipo'        => 'Text',
      'partido_id'  => 'ForeignKey',
      'politico_id' => 'ForeignKey',
      'opinion_id'  => 'Number',
      'created_at'  => 'Date',
    );
  }
}
