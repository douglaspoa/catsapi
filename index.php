<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require 'vendor/autoload.php';
$app = new \Slim\App();

$app->get('/',  function (Request $request, Response $response){
   $result =  (new \controllers\Cats($response))->getAll();
    return $response->withStatus($result['status'])
        ->withHeader('Content-Type', 'application/json')
        ->withJson($result['body']);
});

$app->get('/{id}',  function (Request $request, Response $response, $args){
    $result =  (new \controllers\Cats($response))->getCat($args['id']);
    return $response->withStatus($result['status'])
        ->withHeader('Content-Type', 'application/json')
        ->withJson($result['body']);
});

$app->post('/',  function (Request $request, Response $response){
    $body = $request->getParsedBody();
    $result =  (new \controllers\Cats($response))->insertCat($body);
    return $response->withStatus($result['status'])
        ->withHeader('Content-Type', 'application/json')
        ->withJson($result['body']);
});

$app->patch('/{id}',  function (Request $request, Response $response, $args){
    $body = $request->getParsedBody();
    $result =  (new \controllers\Cats($response))->updateCat($body, $args['id']);
    return $response->withStatus($result['status'])
        ->withHeader('Content-Type', 'application/json')
        ->withJson($result['body']);
});

$app->delete('/{id}',  function (Request $request, Response $response, $args){
    $result =  (new \controllers\Cats($response))->deleteCat($args['id']);
    return $response->withStatus($result['status'])
        ->withHeader('Content-Type', 'application/json');
});

$app->run();