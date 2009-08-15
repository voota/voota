<?php

class Eleccion extends BaseEleccion
{
  public function __toString()
  {
    return $this->getAbreviatura();  // getTitle() se hereda de BaseArticle
  }
}
