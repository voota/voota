<?php
class sfRequestHostCultureRoute extends sfRoute
{

  public function matchesUrl($url, $context = array())
  {
    if (isset($this->requirements['sf_host_culture'])) {
    	$sfHostCulture = $this->requirements['sf_host_culture'];
    	if (preg_match("/\.([a-z]+)$/", $context['host'], $matches)){
    		if ($matches[1] != $sfHostCulture){
    			return false;
    		}
    	}
    }
    
    if (isset($this->requirements['reviewFilter'])) {
    	$reviewFilter = $this->requirements['reviewFilter'];
    	
    	return parent::matchesUrl(urldecode($url), $context);
    }
    
    return parent::matchesUrl($url, $context);    
  }
  
  public function matchesParameters($params, $context = array())
  {
    if (isset($this->requirements['sf_host_culture'])) {
    	$sfHostCulture = $this->requirements['sf_host_culture'];
    	if (preg_match("/\.([a-z]+)$/", $context['host'], $matches)){
    		if ($matches[1] != $sfHostCulture){
    			return false;
    		}
    	}
    }
  	
    return parent::matchesParameters($params, $context);
  }
  
}