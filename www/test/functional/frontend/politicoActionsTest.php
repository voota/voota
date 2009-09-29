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
    checkElement('body', '/Ranking de políticos/')->
    checkElement('body', '/Todas las instituciones/')->
    
    end()
;
$browser->test()->like($browser->getResponse()->getContent(), '/PSOE<label>/');

$browser->
  get('es/politicos/all/Congreso')->

  with('request')->begin()->
    isParameter('module', 'politico')->
    isParameter('action', 'ranking')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '/Ranking de políticos/')->
    
    end()
;
$browser->test()->like($browser->getResponse()->getContent(), '/class="flechita">Congreso<\/a>/');

$browser->
  get('es/politicos/PSOE/Congreso')->

  with('request')->begin()->
    isParameter('module', 'politico')->
    isParameter('action', 'ranking')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '/Ranking de políticos/')->
    
    end()
;
$browser->test()->like($browser->getResponse()->getContent(), '/PSOE<label>/');
$browser->test()->like($browser->getResponse()->getContent(), '/class="flechita">Congreso<\/a>/');

$browser->
  get('es/politico/1')->

  with('request')->begin()->
    isParameter('module', 'politico')->
    isParameter('action', 'show')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '/Campos Arteseros/')->
    
    end()
;

