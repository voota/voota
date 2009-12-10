<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Politico filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BasePoliticoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'url_key'                   => new sfWidgetFormFilterInput(),
      'alias'                     => new sfWidgetFormFilterInput(),
      'nombre'                    => new sfWidgetFormFilterInput(),
      'apellidos'                 => new sfWidgetFormFilterInput(),
      'email'                     => new sfWidgetFormFilterInput(),
      'sexo'                      => new sfWidgetFormFilterInput(),
      'fecha_nacimiento'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'pais'                      => new sfWidgetFormFilterInput(),
      'formacion'                 => new sfWidgetFormFilterInput(),
      'residencia'                => new sfWidgetFormFilterInput(),
      'presentacion'              => new sfWidgetFormFilterInput(),
      'sf_guard_user_profile_id'  => new sfWidgetFormPropelChoice(array('model' => 'SfGuardUserProfile', 'add_empty' => true)),
      'created_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'partido_id'                => new sfWidgetFormPropelChoice(array('model' => 'Partido', 'add_empty' => true)),
      'partido_txt'               => new sfWidgetFormFilterInput(),
      'bio'                       => new sfWidgetFormFilterInput(),
      'imagen'                    => new sfWidgetFormFilterInput(),
      'vanity'                    => new sfWidgetFormFilterInput(),
      'lugar_nacimiento'          => new sfWidgetFormFilterInput(),
      'sumu'                      => new sfWidgetFormFilterInput(),
      'sumd'                      => new sfWidgetFormFilterInput(),
      'relacion'                  => new sfWidgetFormFilterInput(),
      'hijos'                     => new sfWidgetFormFilterInput(),
      'hijas'                     => new sfWidgetFormFilterInput(),
      'politico_institucion_list' => new sfWidgetFormPropelChoice(array('model' => 'Institucion', 'add_empty' => true)),
      'politico_lista_list'       => new sfWidgetFormPropelChoice(array('model' => 'Lista', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'url_key'                   => new sfValidatorPass(array('required' => false)),
      'alias'                     => new sfValidatorPass(array('required' => false)),
      'nombre'                    => new sfValidatorPass(array('required' => false)),
      'apellidos'                 => new sfValidatorPass(array('required' => false)),
      'email'                     => new sfValidatorPass(array('required' => false)),
      'sexo'                      => new sfValidatorPass(array('required' => false)),
      'fecha_nacimiento'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'pais'                      => new sfValidatorPass(array('required' => false)),
      'formacion'                 => new sfValidatorPass(array('required' => false)),
      'residencia'                => new sfValidatorPass(array('required' => false)),
      'presentacion'              => new sfValidatorPass(array('required' => false)),
      'sf_guard_user_profile_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'SfGuardUserProfile', 'column' => 'id')),
      'created_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'partido_id'                => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Partido', 'column' => 'id')),
      'partido_txt'               => new sfValidatorPass(array('required' => false)),
      'bio'                       => new sfValidatorPass(array('required' => false)),
      'imagen'                    => new sfValidatorPass(array('required' => false)),
      'vanity'                    => new sfValidatorPass(array('required' => false)),
      'lugar_nacimiento'          => new sfValidatorPass(array('required' => false)),
      'sumu'                      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'sumd'                      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'relacion'                  => new sfValidatorPass(array('required' => false)),
      'hijos'                     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'hijas'                     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'politico_institucion_list' => new sfValidatorPropelChoice(array('model' => 'Institucion', 'required' => false)),
      'politico_lista_list'       => new sfValidatorPropelChoice(array('model' => 'Lista', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('politico_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addPoliticoInstitucionListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(PoliticoInstitucionPeer::POLITICO_ID, PoliticoPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(PoliticoInstitucionPeer::INSTITUCION_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(PoliticoInstitucionPeer::INSTITUCION_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function addPoliticoListaListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(PoliticoListaPeer::POLITICO_ID, PoliticoPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(PoliticoListaPeer::LISTA_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(PoliticoListaPeer::LISTA_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Politico';
  }

  public function getFields()
  {
    return array(
      'id'                        => 'Number',
      'url_key'                   => 'Text',
      'alias'                     => 'Text',
      'nombre'                    => 'Text',
      'apellidos'                 => 'Text',
      'email'                     => 'Text',
      'sexo'                      => 'Text',
      'fecha_nacimiento'          => 'Date',
      'pais'                      => 'Text',
      'formacion'                 => 'Text',
      'residencia'                => 'Text',
      'presentacion'              => 'Text',
      'sf_guard_user_profile_id'  => 'ForeignKey',
      'created_at'                => 'Date',
      'partido_id'                => 'ForeignKey',
      'partido_txt'               => 'Text',
      'bio'                       => 'Text',
      'imagen'                    => 'Text',
      'vanity'                    => 'Text',
      'lugar_nacimiento'          => 'Text',
      'sumu'                      => 'Number',
      'sumd'                      => 'Number',
      'relacion'                  => 'Text',
      'hijos'                     => 'Number',
      'hijas'                     => 'Number',
      'politico_institucion_list' => 'ManyKey',
      'politico_lista_list'       => 'ManyKey',
    );
  }
}
