<?php

class Region extends BaseRegion
{
  public function __toString()
  {
    return $this->getNombre();  // getTitle() se hereda de BaseArticle
  }
}
