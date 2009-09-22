<?php

class SfReviewType extends BaseSfReviewType
{
  public function __toString()
  {
    return $this->getName();
  }
}
