<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$browser = new sfTestBrowser();

$browser->
  get('/stream/index')->
  isStatusCode(200)->
  isRequestParameter('module', 'stream')->
  isRequestParameter('action', 'index')->
  checkResponseElement('body', '!/This is a temporary page/');
