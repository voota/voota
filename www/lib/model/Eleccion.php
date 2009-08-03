<?php

class Eleccion extends BaseEleccion
{
  public function __toString()
  {
    return $this->getNombre();  // getTitle() se hereda de BaseArticle
  }
}
