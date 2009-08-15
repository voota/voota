<?php

class Partido extends BasePartido
{
  public function __toString()
  {
    return $this->getAbreviatura();  // getTitle() se hereda de BaseArticle
  }
}
