<?php

class Lista extends BaseLista
{
  public function __toString()
  {
    return $this->getPartido()->getAbreviatura() . ", " . $this->getConvocatoria()->getEleccion() . " ". $this->getConvocatoria();  // getTitle() se hereda de BaseArticle
  }
}
