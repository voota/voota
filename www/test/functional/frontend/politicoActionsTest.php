<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new sfTestFunctional(new sfBrowser());


$browser->
  get('es/politicos')->

  with('request')->begin()->
    isParameter('module', 'politico')->
    isParameter('action', 'ranking')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '/Ranking de pol/')->
  end()
;


$browser->
  get('es/politicos/PSOE')->

  with('request')->begin()->
    isParameter('module', 'politico')->
    isParameter('action', 'ranking')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '/Ranking de pol/')->
    checkElement('body', '/Todas las instituciones/')->
    
    end()
;
$browser->test()->like($browser->getResponse()->getContent(), '/ticos, PSOE/');

$browser->
  get('es/politicos/all/Congreso')->

  with('request')->begin()->
    isParameter('module', 'politico')->
    isParameter('action', 'ranking')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '/Ranking de pol/')->
    
    end()
;
$browser->test()->like($browser->getResponse()->getContent(), '/<a class="flechita" href="\/(.*)es\/politicos\/all\/Congreso">Congreso<\/a>/');

$browser->
  get('es/politicos/PSOE/Congreso')->

  with('request')->begin()->
    isParameter('module', 'politico')->
    isParameter('action', 'ranking')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '/Ranking de pol/')->
    
    end()
;
$browser->test()->like($browser->getResponse()->getContent(), '/ticos, Congreso, PSOE/');
$browser->test()->like($browser->getResponse()->getContent(), '/<a class="flechita" href="\/(.*)es\/politicos\/PSOE\/Congreso">Congreso<\/a>/');

$browser->
  get('es/politico/Campos-Arteseros')->

  with('request')->begin()->
    isParameter('module', 'politico')->
    isParameter('action', 'show')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '/Campos Arteseros/')->
    
    end()
;

