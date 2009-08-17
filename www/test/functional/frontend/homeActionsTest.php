<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new sfTestFunctional(new sfBrowser());

$browser->
  get('/es')->

  with('request')->begin()->
    isParameter('module', 'home')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '!/Coomparte opiniones sobre los políticos de España/')->
  end()
;

$browser->
  get('/ca')->

  with('request')->begin()->
    isParameter('module', 'home')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '!/Coomparteix opininions sobre els polítics d\'Espanya./')->
  end()
;

$browser->
  get('/')->

  with('request')->begin()->
    isParameter('module', 'home')->
    isParameter('action', 'indexWithoutCulture')->
  end()->

  with('response')->begin()->
    isStatusCode(302)->
    checkElement('body', '!/Coomparteix opininions sobre els polítics d\'Espanya./')->
  end()
;
