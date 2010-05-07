<?php

/**
 * ConvocatoriaI18n form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
class ConvocatoriaI18nForm extends BaseConvocatoriaI18nForm
{
  public function configure()
  {
    $this->widgetSchema['descripcion'] = new sfWidgetFormTextarea(array(), array('style' => "width: 500px; height:200px"));
  }
}
