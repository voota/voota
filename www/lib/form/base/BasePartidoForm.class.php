<?php

/**
 * Partido form base class.
 *
 * @method Partido getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePartidoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'abreviatura'           => new sfWidgetFormInputText(),
      'color'                 => new sfWidgetFormInputText(),
      'created_at'            => new sfWidgetFormDateTime(),
      'partido_id'            => new sfWidgetFormPropelChoice(array('model' => 'Partido', 'add_empty' => true)),
      'imagen'                => new sfWidgetFormInputText(),
      'sumu'                  => new sfWidgetFormInputText(),
      'sumd'                  => new sfWidgetFormInputText(),
      'is_active'             => new sfWidgetFormInputCheckbox(),
      'is_main'               => new sfWidgetFormInputCheckbox(),
      'etiqueta_partido_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Etiqueta')),
      'partido_lista_list'    => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Lista')),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorPropelChoice(array('model' => 'Partido', 'column' => 'id', 'required' => false)),
      'abreviatura'           => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'color'                 => new sfValidatorString(array('max_length' => 8, 'required' => false)),
      'created_at'            => new sfValidatorDateTime(array('required' => false)),
      'partido_id'            => new sfValidatorPropelChoice(array('model' => 'Partido', 'column' => 'id', 'required' => false)),
      'imagen'                => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'sumu'                  => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'sumd'                  => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'is_active'             => new sfValidatorBoolean(),
      'is_main'               => new sfValidatorBoolean(),
      'etiqueta_partido_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Etiqueta', 'required' => false)),
      'partido_lista_list'    => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Lista', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Partido', 'column' => array('abreviatura')))
    );

    $this->widgetSchema->setNameFormat('partido[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Partido';
  }

  public function getI18nModelName()
  {
    return 'PartidoI18n';
  }

  public function getI18nFormClass()
  {
    return 'PartidoI18nForm';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['etiqueta_partido_list']))
    {
      $values = array();
      foreach ($this->object->getEtiquetaPartidos() as $obj)
      {
        $values[] = $obj->getEtiquetaId();
      }

      $this->setDefault('etiqueta_partido_list', $values);
    }

    if (isset($this->widgetSchema['partido_lista_list']))
    {
      $values = array();
      foreach ($this->object->getPartidoListas() as $obj)
      {
        $values[] = $obj->getListaId();
      }

      $this->setDefault('partido_lista_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveEtiquetaPartidoList($con);
    $this->savePartidoListaList($con);
  }

  public function saveEtiquetaPartidoList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['etiqueta_partido_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(EtiquetaPartidoPeer::PARTIDO_ID, $this->object->getPrimaryKey());
    EtiquetaPartidoPeer::doDelete($c, $con);

    $values = $this->getValue('etiqueta_partido_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new EtiquetaPartido();
        $obj->setPartidoId($this->object->getPrimaryKey());
        $obj->setEtiquetaId($value);
        $obj->save();
      }
    }
  }

  public function savePartidoListaList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['partido_lista_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(PartidoListaPeer::PARTIDO_ID, $this->object->getPrimaryKey());
    PartidoListaPeer::doDelete($c, $con);

    $values = $this->getValue('partido_lista_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new PartidoLista();
        $obj->setPartidoId($this->object->getPrimaryKey());
        $obj->setListaId($value);
        $obj->save();
      }
    }
  }

}
