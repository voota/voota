<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new sfGuardTestFunctional(new sfBrowser());

$browser->
  get('/politico/index')->
  isStatusCode(401)->    
  signin()->  

  get('/politico/index')->

  with('request')->begin()->
    isParameter('module', 'politico')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '!/This is a temporary page/')->
  end()
;

$browser->
  get('/politico/1/edit')->
  with('request')->begin()->
    isParameter('module', 'politico')->
    isParameter('action', 'edit')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '/Político/')->
  end()
;


$browser->
  click('Save')->
    isRedirected()->   // Check that request is redirected
    followRedirect()->
  with('request')->begin()->
    isParameter('module', 'politico')->
    isParameter('action', 'edit')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '/The item was updated successfully./')->
  end()
;


