<?php

class Politico extends BasePolitico
{
  public function __toString()
  {
    return $this->getNombre() . ' ' . $this->getApellidos();  // getTitle() se hereda de BaseArticle
  }
}
