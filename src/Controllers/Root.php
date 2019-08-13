<?php

namespace Controllers;

class Root
{
  /**
   * local container
   */
  private $cont;
  /**
   * constructor to get the DI container
   */
  function __construct($di)
  {
    $this->cont = $di;
  }
  /**
   * Invoke Method
   */
  public function __invoke($request, $response, $args) {
  	$payload = array();
  	$payload['api'] = 'ALIPI';
  	$payload['p'] = $this->cont['settings']['Project']['name'];
  	$payload['v'] = $this->cont['settings']['Project']['version'];
  	return $response->withStatus(200)->withJson($payload);
  }
}

?>
