<?php

namespace Controllers\v1;

class MyHome
{
    public function __invoke($request, $response, $args) {
		$payload = array();
		$payload['api'] = 'v1';
		return $response->withStatus(200)->withJson($payload);
    }
}

?>
