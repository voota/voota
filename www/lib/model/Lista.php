<?php

class Lista extends BaseLista
{
  public function __toString()
  {
    return $this->getPartido()->getNombre() . " a " . $this->getInstitucion()->getNombre();  // getTitle() se hereda de BaseArticle
  }
}
