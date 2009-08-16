<?php

class SfGuardUserProfile extends BaseSfGuardUserProfile
{
  public function __toString()
  {
    return $this->getEmail();  // getTitle() se hereda de BaseArticle
  }
}
