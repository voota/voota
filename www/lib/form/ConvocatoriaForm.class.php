<?php

/**
 * Convocatoria form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
class ConvocatoriaForm extends BaseConvocatoriaForm
{
  public function configure()
  {
  	unset(
  		$this['created_at']
  	);
  }
}
