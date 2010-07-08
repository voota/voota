<?php
class sfRequestHostCultureRoute extends sfRoute
{
	private function getCulture( $context ){
		$culture = false;
		$user = sfContext::getInstance()->getUser();
		if ($user)
  			$culture = $user->getCulture();
  		if (!$culture){
	    	if (preg_match("/\.([a-z]+)$/", $context['host'], $matches)){
	    		$culture = $matches[1];
	    	}
  		}
  		
  		return $culture;
	}
	
  public function matchesUrl($url, $context = array())
  {
  	$culture = $this->getCulture( $context );
  	
    if (isset($this->requirements['sf_host_culture'])) {
    	$sfHostCulture = $this->requirements['sf_host_culture'];
    	
    		if ($culture != $sfHostCulture){
    			return false;
    		}
    		
    }
    
    /*
    if (isset($this->requirements['reviewFilter'])) {
    	$reviewFilter = $this->requirements['reviewFilter'];
    	
    	return parent::matchesUrl(urldecode($url), $context);
    }
    */
    
    return parent::matchesUrl(urldecode($url), $context);    
  }
  
  public function matchesParameters($params, $context = array())
  {
  	$culture = $this->getCulture( $context );
  	
    if (isset($this->requirements['sf_host_culture'])) {
    	$sfHostCulture = $this->requirements['sf_host_culture'];
    	
    		if ($culture != $sfHostCulture){
    			return false;
    		}
    }
  	
    return parent::matchesParameters($params, $context);
  }
  
}