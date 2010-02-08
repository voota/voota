<?php

class Institucion extends BaseInstitucion
{
  public function __toString()
  {
    return $this->getId();  // getNombre() se hereda de BaseArticle
  }
}
