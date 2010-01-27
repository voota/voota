<?php

/**
 * PoliticoTemp filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasePoliticoTempFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'email'     => new sfWidgetFormFilterInput(),
      'partido'   => new sfWidgetFormFilterInput(),
      'nombre'    => new sfWidgetFormFilterInput(),
      'apellidos' => new sfWidgetFormFilterInput(),
      'bio'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'email'     => new sfValidatorPass(array('required' => false)),
      'partido'   => new sfValidatorPass(array('required' => false)),
      'nombre'    => new sfValidatorPass(array('required' => false)),
      'apellidos' => new sfValidatorPass(array('required' => false)),
      'bio'       => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('politico_temp_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PoliticoTemp';
  }

  public function getFields()
  {
    return array(
      'email'     => 'Text',
      'partido'   => 'Text',
      'nombre'    => 'Text',
      'apellidos' => 'Text',
      'bio'       => 'Text',
      'id'        => 'Number',
    );
  }
}
