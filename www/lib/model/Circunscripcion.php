<?php

require 'lib/model/om/BaseCircunscripcion.php';


/**
 * Skeleton subclass for representing a row from the 'circunscripcion' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Sun Oct 10 21:38:26 2010
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class Circunscripcion extends BaseCircunscripcion {
  public function __toString()
  {
    return $this->getGeo()->getNombre();
  }	
} // Circunscripcion