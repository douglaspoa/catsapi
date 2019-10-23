<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require 'vendor/autoload.php';
$app = new \Slim\App();

$app->get('/', function (Request $request, Response $response) {
    $response->withStatus(200)->write("Welcome to the Adroit Library Demo.");
    return $response;
});

$app->get('/GET',  function (Request $request, Response $response){
   $result =  (new \controllers\Cats($response))->getAll();
   return $result;
});

$app->get('/GET/{id}',  function (Request $request, Response $response, $args){
    $result =  (new \controllers\Cats($response))->getCat($args['id']);
    return $result;
});

$app->post('/POST',  function (Request $request, Response $response){
    $body = $request->getParsedBody();
    $result =  (new \controllers\Cats($response))->insertCat($body);
    return $result;
});

$app->patch('/PATCH/{id}',  function (Request $request, Response $response, $args){
    $body = $request->getParsedBody();
    $result =  (new \controllers\Cats($response))->updateCat($body, $args['id']);
    return $result;
});

$app->delete('/DELETE/{id}',  function (Request $request, Response $response, $args){
    $result =  (new \controllers\Cats($response))->deleteCat($args['id']);
    return $result;
});

$app->run();