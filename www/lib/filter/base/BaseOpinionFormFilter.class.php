<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Opinion filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseOpinionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'valor'       => new sfWidgetFormFilterInput(),
      'texto'       => new sfWidgetFormFilterInput(),
      'usuario_id'  => new sfWidgetFormPropelChoice(array('model' => 'Usuario', 'add_empty' => true)),
      'partido_id'  => new sfWidgetFormPropelChoice(array('model' => 'Partido', 'add_empty' => true)),
      'politico_id' => new sfWidgetFormPropelChoice(array('model' => 'Politico', 'add_empty' => true)),
      'opinion_id'  => new sfWidgetFormPropelChoice(array('model' => 'Opinion', 'add_empty' => true)),
      'created_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
    ));

    $this->setValidators(array(
      'valor'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'texto'       => new sfValidatorPass(array('required' => false)),
      'usuario_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Usuario', 'column' => 'id')),
      'partido_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Partido', 'column' => 'id')),
      'politico_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Politico', 'column' => 'id')),
      'opinion_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Opinion', 'column' => 'id')),
      'created_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('opinion_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Opinion';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'valor'       => 'Number',
      'texto'       => 'Text',
      'usuario_id'  => 'ForeignKey',
      'partido_id'  => 'ForeignKey',
      'politico_id' => 'ForeignKey',
      'opinion_id'  => 'ForeignKey',
      'created_at'  => 'Date',
    );
  }
}
