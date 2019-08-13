<?php

use GraphAware\Neo4j\Client\ClientBuilder;

$container['neo4j'] = function($c) {
    if (
          !empty($c['settings']['neo4j']['user']) &&
          !empty($c['settings']['neo4j']['pass']) &&
          (
            !empty($c['settings']['neo4j']['http-addr']) ||
            !empty($c['settings']['neo4j']['https-addr']) ||
            !empty($c['settings']['neo4j']['bolt-addr'])
          )
        )
    {
      // generating user:pass string to add to addr
      $cred = $c['settings']['neo4j']['user'] . ':' . $c['settings']['neo4j']['pass'];
      // instantiate
      $client = new ClientBuilder;
      $client = $client->create();
      // add http connection
      if(!empty($c['settings']['neo4j']['http-addr']))
      {
        $client = $client->addConnection(
          'http', 'http://' . $cred . '@' . $c['settings']['neo4j']['http-addr']
        );
      }
      // add https connection
      if(!empty($c['settings']['neo4j']['httpS-addr']))
      {
        $client = $client->addConnection(
          'https', 'https://' . $cred . '@' . $c['settings']['neo4j']['https-addr']
        );
      }
      // tls check
      if (!empty($c['settings']['neo4j']['check-tls']) &&
          !empty($c['settings']['neo4j']['check-tls']) === true)
      {
        $tlsconfig = \GraphAware\Bolt\Configuration::newInstance()
          ->withTLSMode(\GraphAware\Bolt\Configuration::TLSMODE_REQUIRED);
      }else{
        $tlsconfig = null;
      }
      // add bolt connection
      if(!empty($c['settings']['neo4j']['bolt-addr']))
      {
        $client = $client->addConnection(
          'bolt', 'bolt://' . $cred . '@' . $c['settings']['neo4j']['bolt-addr']
           ,$tlsconfig
        );
      }
      // conenction timeout
      if (!empty($c['settings']['neo4j']['timeout']))
      {
        $client = $client->setDefaultTimeout($c['settings']['neo4j']['timeout']);
      }
      //connect and return handler
      $client = $client->build();
      return $client;
    }else{
      $c->logger->Critical('GDB failed! Unable to initialize Neo4j. Empty Config Values.');
      die('GDB Failed!');
    }
};

?>
