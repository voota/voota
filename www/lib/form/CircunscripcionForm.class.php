<?php

/**
 * Circunscripcion form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
class CircunscripcionForm extends BaseCircunscripcionForm
{
  public function configure()
  {
  	unset(
  		$this['lista_calle_list']
  	);
  }
}
