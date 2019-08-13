<?php

$container['logger'] = function($c) {
  // get name from config
  $lName = $c['settings']['logger']['name'];
  if (empty($lName))
  {
    $lName = 'ALIPI_Logger';
  }
  // get address from config
  $lAddr = $c['settings']['logger']['addr'];
  if (empty($lAddr))
  {
    $lAddr = 'logs/app.log';
  }
  // init
  $logger = new \Monolog\Logger($lName);
  $logger->pushHandler(new \Monolog\Handler\StreamHandler($lAddr));
  // return handler
  return $logger;
};

?>
