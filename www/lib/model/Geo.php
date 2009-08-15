<?php

class Geo extends BaseGeo
{
  public function __toString()
  {
    return $this->getNombre();  // getTitle() se hereda de BaseArticle
  }
}
