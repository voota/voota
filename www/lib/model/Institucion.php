<?php

class Institucion extends BaseInstitucion
{
  public function __toString()
  {
    return $this->getNombre();  // getTitle() se hereda de BaseArticle
  }
}
