<?php

/**
 * PoliticoI18n filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePoliticoI18nFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'formacion'    => new sfWidgetFormFilterInput(),
      'presentacion' => new sfWidgetFormFilterInput(),
      'bio'          => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'formacion'    => new sfValidatorPass(array('required' => false)),
      'presentacion' => new sfValidatorPass(array('required' => false)),
      'bio'          => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('politico_i18n_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PoliticoI18n';
  }

  public function getFields()
  {
    return array(
      'id'           => 'ForeignKey',
      'culture'      => 'Text',
      'formacion'    => 'Text',
      'presentacion' => 'Text',
      'bio'          => 'Text',
    );
  }
}
