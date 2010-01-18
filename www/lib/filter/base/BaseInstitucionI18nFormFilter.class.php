<?php

/**
 * InstitucionI18n filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseInstitucionI18nFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'vanity'       => new sfWidgetFormFilterInput(),
      'nombre_corto' => new sfWidgetFormFilterInput(),
      'nombre'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'vanity'       => new sfValidatorPass(array('required' => false)),
      'nombre_corto' => new sfValidatorPass(array('required' => false)),
      'nombre'       => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('institucion_i18n_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'InstitucionI18n';
  }

  public function getFields()
  {
    return array(
      'id'           => 'ForeignKey',
      'culture'      => 'Text',
      'vanity'       => 'Text',
      'nombre_corto' => 'Text',
      'nombre'       => 'Text',
    );
  }
}
