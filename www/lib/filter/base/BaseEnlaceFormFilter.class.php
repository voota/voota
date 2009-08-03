<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Enlace filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseEnlaceFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'url'         => new sfWidgetFormFilterInput(),
      'tipo'        => new sfWidgetFormFilterInput(),
      'partido_id'  => new sfWidgetFormPropelChoice(array('model' => 'Partido', 'add_empty' => true)),
      'politico_id' => new sfWidgetFormPropelChoice(array('model' => 'Politico', 'add_empty' => true)),
      'orden'       => new sfWidgetFormFilterInput(),
      'mostrar'     => new sfWidgetFormFilterInput(),
      'created_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
    ));

    $this->setValidators(array(
      'url'         => new sfValidatorPass(array('required' => false)),
      'tipo'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'partido_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Partido', 'column' => 'id')),
      'politico_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Politico', 'column' => 'id')),
      'orden'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'mostrar'     => new sfValidatorPass(array('required' => false)),
      'created_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('enlace_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Enlace';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'url'         => 'Text',
      'tipo'        => 'Number',
      'partido_id'  => 'ForeignKey',
      'politico_id' => 'ForeignKey',
      'orden'       => 'Number',
      'mostrar'     => 'Text',
      'created_at'  => 'Date',
    );
  }
}
