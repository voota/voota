<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new sfGuardTestFunctional(new sfBrowser());

$browser->
  get('/eleccion/index')->
  isStatusCode(401)->    
  signin()->  
  get('/eleccion/index')->

  with('request')->begin()->
    isParameter('module', 'eleccion')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '/Elecciones/')->
  end()
;
