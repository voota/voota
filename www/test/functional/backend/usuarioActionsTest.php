<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new sfGuardTestFunctional(new sfBrowser());

$browser->
  get('/sf_guard_user')->
  isStatusCode(401)->    
  signin()->  

  get('/sf_guard_user')->

  with('request')->begin()->
    isParameter('module', 'sfGuardUser')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '!/This is a temporary page/')->
  end()
;
