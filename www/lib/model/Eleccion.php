<?php

class Eleccion extends BaseEleccion
{
  public function __toString()
  {
    return $this->getNombreCorto();
  }
}
