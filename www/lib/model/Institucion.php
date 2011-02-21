<?php

class Institucion extends BaseInstitucion
{
  public function __toString()
  {
    return $this->getNombreCorto();
  }
}
