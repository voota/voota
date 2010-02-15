<?php

/**
 * Media filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseMediaFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'tipo'       => new sfWidgetFormFilterInput(),
      'idpolitico' => new sfWidgetFormFilterInput(),
      'idpartido'  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'tipo'       => new sfValidatorPass(array('required' => false)),
      'idpolitico' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'idpartido'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('media_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Media';
  }

  public function getFields()
  {
    return array(
      'idmedia'    => 'Number',
      'tipo'       => 'Text',
      'idpolitico' => 'Number',
      'idpartido'  => 'Number',
    );
  }
}
