<?php

/**
 * Lista form base class.
 *
 * @method Lista getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseListaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'partido_id'          => new sfWidgetFormPropelChoice(array('model' => 'Partido', 'add_empty' => false)),
      'convocatoria_id'     => new sfWidgetFormPropelChoice(array('model' => 'Convocatoria', 'add_empty' => false)),
      'circunscripcion_id'  => new sfWidgetFormInputHidden(),
      'created_at'          => new sfWidgetFormDateTime(),
      'politico_lista_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Politico')),
      'partido_lista_list'  => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Partido')),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorPropelChoice(array('model' => 'Lista', 'column' => 'id', 'required' => false)),
      'partido_id'          => new sfValidatorPropelChoice(array('model' => 'Partido', 'column' => 'id')),
      'convocatoria_id'     => new sfValidatorPropelChoice(array('model' => 'Convocatoria', 'column' => 'id')),
      'circunscripcion_id'  => new sfValidatorPropelChoice(array('model' => 'Circunscripcion', 'column' => 'id', 'required' => false)),
      'created_at'          => new sfValidatorDateTime(array('required' => false)),
      'politico_lista_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Politico', 'required' => false)),
      'partido_lista_list'  => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Partido', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Lista', 'column' => array('partido_id', 'convocatoria_id', 'circunscripcion_id')))
    );

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

    if (isset($this->widgetSchema['politico_lista_list']))
    {
      $values = array();
      foreach ($this->object->getPoliticoListas() as $obj)
      {
        $values[] = $obj->getPoliticoId();
      }

      $this->setDefault('politico_lista_list', $values);
    }

    if (isset($this->widgetSchema['partido_lista_list']))
    {
      $values = array();
      foreach ($this->object->getPartidoListas() as $obj)
      {
        $values[] = $obj->getPartidoId();
      }

      $this->setDefault('partido_lista_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->savePoliticoListaList($con);
    $this->savePartidoListaList($con);
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

    if (null === $con)
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

}
