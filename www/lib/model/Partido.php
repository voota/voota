<?php

class Partido extends BasePartido
{
  public function __toString()
  {
    return $this->getNombre();  // getTitle() se hereda de BaseArticle
  }
}
