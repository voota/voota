<?php

class Usuario extends BaseUsuario
{
  public function __toString()
  {
    return $this->getEmail();  // getTitle() se hereda de BaseArticle
  }
}
