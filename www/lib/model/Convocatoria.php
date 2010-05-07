<?php

require 'lib/model/om/BaseConvocatoria.php';


/**
 * Skeleton subclass for representing a row from the 'convocatoria' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Tue May  4 14:41:20 2010
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class Convocatoria extends BaseConvocatoria {

  public function __toString()
  {
    return $this->getEleccion(). " " .$this->getNombre();  // getTitle() se hereda de BaseArticle
  }
} // Convocatoria