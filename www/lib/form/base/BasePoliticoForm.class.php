<?php

/**
 * Politico form base class.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BasePoliticoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                       => new sfWidgetFormInputHidden(),
      'url_key'                  => new sfWidgetFormInput(),
      'alias'                    => new sfWidgetFormInput(),
      'nombre'                   => new sfWidgetFormInput(),
      'apellidos'                => new sfWidgetFormInput(),
      'email'                    => new sfWidgetFormInput(),
      'sexo'                     => new sfWidgetFormInput(),
      'fecha_nacimiento'         => new sfWidgetFormDate(),
      'pais'                     => new sfWidgetFormInput(),
      'formacion'                => new sfWidgetFormInput(),
      'residencia'               => new sfWidgetFormInput(),
      'presentacion'             => new sfWidgetFormInput(),
      'sf_guard_user_profile_id' => new sfWidgetFormPropelChoice(array('model' => 'SfGuardUserProfile', 'add_empty' => true)),
      'created_at'               => new sfWidgetFormDateTime(),
      'partido_id'               => new sfWidgetFormPropelChoice(array('model' => 'Partido', 'add_empty' => true)),
      'bio'                      => new sfWidgetFormTextarea(),
      'imagen'                   => new sfWidgetFormInput(),
      'politico_lista_list'      => new sfWidgetFormPropelChoiceMany(array('model' => 'Lista')),
    ));

    $this->setValidators(array(
      'id'                       => new sfValidatorPropelChoice(array('model' => 'Politico', 'column' => 'id', 'required' => false)),
      'url_key'                  => new sfValidatorString(array('max_length' => 45)),
      'alias'                    => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'nombre'                   => new sfValidatorString(array('max_length' => 45)),
      'apellidos'                => new sfValidatorString(array('max_length' => 150)),
      'email'                    => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'sexo'                     => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'fecha_nacimiento'         => new sfValidatorDate(array('required' => false)),
      'pais'                     => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'formacion'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'residencia'               => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'presentacion'             => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'sf_guard_user_profile_id' => new sfValidatorPropelChoice(array('model' => 'SfGuardUserProfile', 'column' => 'id', 'required' => false)),
      'created_at'               => new sfValidatorDateTime(array('required' => false)),
      'partido_id'               => new sfValidatorPropelChoice(array('model' => 'Partido', 'column' => 'id', 'required' => false)),
      'bio'                      => new sfValidatorString(array('required' => false)),
      'imagen'                   => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'politico_lista_list'      => new sfValidatorPropelChoiceMany(array('model' => 'Lista', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('politico[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Politico';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['politico_lista_list']))
    {
      $values = array();
      foreach ($this->object->getPoliticoListas() as $obj)
      {
        $values[] = $obj->getListaId();
      }

      $this->setDefault('politico_lista_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->savePoliticoListaList($con);
  }

  public function savePoliticoListaList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['politico_lista_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(PoliticoListaPeer::POLITICO_ID, $this->object->getPrimaryKey());
    PoliticoListaPeer::doDelete($c, $con);

    $values = $this->getValue('politico_lista_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new PoliticoLista();
        $obj->setPoliticoId($this->object->getPrimaryKey());
        $obj->setListaId($value);
        $obj->save();
      }
    }
  }

}
