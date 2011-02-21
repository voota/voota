<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new sfGuardTestFunctional(new sfBrowser());

$browser->
  get('/institucion/index')->
  isStatusCode(401)->    
  signin()->  

  get('/institucion/index')->
  
  with('request')->begin()->
    isParameter('module', 'institucion')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '!/This is a temporary page/')->
  end()
;
