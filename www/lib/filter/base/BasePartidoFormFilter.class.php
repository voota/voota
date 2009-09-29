<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Partido filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BasePartidoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'      => new sfWidgetFormFilterInput(),
      'abreviatura' => new sfWidgetFormFilterInput(),
      'color'       => new sfWidgetFormFilterInput(),
      'web'         => new sfWidgetFormFilterInput(),
      'created_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'partido_id'  => new sfWidgetFormPropelChoice(array('model' => 'Partido', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'nombre'      => new sfValidatorPass(array('required' => false)),
      'abreviatura' => new sfValidatorPass(array('required' => false)),
      'color'       => new sfValidatorPass(array('required' => false)),
      'web'         => new sfValidatorPass(array('required' => false)),
      'created_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'partido_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Partido', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('partido_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Partido';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'nombre'      => 'Text',
      'abreviatura' => 'Text',
      'color'       => 'Text',
      'web'         => 'Text',
      'created_at'  => 'Date',
      'partido_id'  => 'ForeignKey',
    );
  }
}
