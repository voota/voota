<?php

/**
 * EleccionI18n form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
class EleccionI18nForm extends BaseEleccionI18nForm
{
  public function configure()
  {
    $this->widgetSchema['descripcion'] = new sfWidgetFormTextarea(array(), array('style' => "width: 500px; height:200px"));
  }
}
