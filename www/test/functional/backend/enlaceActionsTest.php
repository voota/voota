<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new sfGuardTestFunctional(new sfBrowser());

$browser->
  get('/enlace/index')->
  isStatusCode(401)->    
  signin()->  
  get('/enlace/index')->
  

  with('request')->begin()->
    isParameter('module', 'enlace')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '!/This is a temporary page/')->
  end()
;
