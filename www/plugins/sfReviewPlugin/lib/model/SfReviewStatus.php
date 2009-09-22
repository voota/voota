<?php

class SfReviewStatus extends BaseSfReviewStatus
{
  public function __toString()
  {
    return $this->getName();
  }
}
