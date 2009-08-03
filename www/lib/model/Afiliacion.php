<?php

class Afiliacion extends BaseAfiliacion
{
  public function __toString()
  {
    return $this->getPartido()->getNombre();
  }
}
