<?php

class SfGuardUserProfile extends BaseSfGuardUserProfile
{
  public function __toString()
  {
    return $this->getSfGuardUser()->getUsername();
  }
}
