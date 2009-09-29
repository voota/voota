<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new sfGuardTestFunctional(new sfBrowser());

$browser->
  get('/sfReview')->
  
  isStatusCode(401)->    
  signin()->  
  get('/sfReview')->

  with('request')->begin()->
    isParameter('module', 'sfReview')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '!/This is a temporary page/')->
  end()
;
