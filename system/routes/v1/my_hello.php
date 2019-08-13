<?php

$app->get('/hello/{name}', function ($request, $response, $args) {
    //$this->logger->addInfo('Something interesting happened');
    //$this->logger->error('1S2omething interesting happened');
    //$this->logger->Warning('222Something interesting happened');
    return $response->getBody()->write("Hello, " . $args['name']);
});

?>
