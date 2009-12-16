<?php

/**
 * Partido form base class.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BasePartidoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'nombre'             => new sfWidgetFormInput(),
      'abreviatura'        => new sfWidgetFormInput(),
      'color'              => new sfWidgetFormInput(),
      'web'                => new sfWidgetFormInput(),
      'created_at'         => new sfWidgetFormDateTime(),
      'partido_id'         => new sfWidgetFormPropelChoice(array('model' => 'Partido', 'add_empty' => true)),
      'imagen'             => new sfWidgetFormInput(),
      'partido_lista_list' => new sfWidgetFormPropelChoiceMany(array('model' => 'Lista')),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorPropelChoice(array('model' => 'Partido', 'column' => 'id', 'required' => false)),
      'nombre'             => new sfValidatorString(array('max_length' => 150)),
      'abreviatura'        => new sfValidatorString(array('max_length' => 8, 'required' => false)),
      'color'              => new sfValidatorString(array('max_length' => 8, 'required' => false)),
      'web'                => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'created_at'         => new sfValidatorDateTime(array('required' => false)),
      'partido_id'         => new sfValidatorPropelChoice(array('model' => 'Partido', 'column' => 'id', 'required' => false)),
      'imagen'             => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'partido_lista_list' => new sfValidatorPropelChoiceMany(array('model' => 'Lista', 'required' => false)),
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


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

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

    $this->savePartidoListaList($con);
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
