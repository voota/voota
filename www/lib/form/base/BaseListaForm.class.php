<?php

/**
 * Lista form base class.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseListaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'partido_id'          => new sfWidgetFormPropelChoice(array('model' => 'Partido', 'add_empty' => false)),
      'eleccion_id'         => new sfWidgetFormPropelChoice(array('model' => 'Eleccion', 'add_empty' => false)),
      'created_at'          => new sfWidgetFormDateTime(),
      'partido_lista_list'  => new sfWidgetFormPropelChoiceMany(array('model' => 'Partido')),
      'politico_lista_list' => new sfWidgetFormPropelChoiceMany(array('model' => 'Politico')),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorPropelChoice(array('model' => 'Lista', 'column' => 'id', 'required' => false)),
      'partido_id'          => new sfValidatorPropelChoice(array('model' => 'Partido', 'column' => 'id')),
      'eleccion_id'         => new sfValidatorPropelChoice(array('model' => 'Eleccion', 'column' => 'id')),
      'created_at'          => new sfValidatorDateTime(array('required' => false)),
      'partido_lista_list'  => new sfValidatorPropelChoiceMany(array('model' => 'Partido', 'required' => false)),
      'politico_lista_list' => new sfValidatorPropelChoiceMany(array('model' => 'Politico', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lista[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Lista';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['partido_lista_list']))
    {
      $values = array();
      foreach ($this->object->getPartidoListas() as $obj)
      {
        $values[] = $obj->getPartidoId();
      }

      $this->setDefault('partido_lista_list', $values);
    }

    if (isset($this->widgetSchema['politico_lista_list']))
    {
      $values = array();
      foreach ($this->object->getPoliticoListas() as $obj)
      {
        $values[] = $obj->getPoliticoId();
      }

      $this->setDefault('politico_lista_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->savePartidoListaList($con);
    $this->savePoliticoListaList($con);
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

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(PartidoListaPeer::LISTA_ID, $this->object->getPrimaryKey());
    PartidoListaPeer::doDelete($c, $con);

    $values = $this->getValue('partido_lista_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new PartidoLista();
        $obj->setListaId($this->object->getPrimaryKey());
        $obj->setPartidoId($value);
        $obj->save();
      }
    }
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
    $c->add(PoliticoListaPeer::LISTA_ID, $this->object->getPrimaryKey());
    PoliticoListaPeer::doDelete($c, $con);

    $values = $this->getValue('politico_lista_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new PoliticoLista();
        $obj->setListaId($this->object->getPrimaryKey());
        $obj->setPoliticoId($value);
        $obj->save();
      }
    }
  }

}
