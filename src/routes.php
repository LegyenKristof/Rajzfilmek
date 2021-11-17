<?php

use Korcsmaroskristof\Rajzfilmek\Rajzfilm;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

return function(Slim\App $app) {
    $app->get("/rajzfilmek", function(Request $request, Response $response){
        $rajzfilmek = Rajzfilm::osszes();
        $kimenet = json_encode($rajzfilmek);
        $response->getBody()->write($kimenet);    
        return $response->withHeader("Content-type", "application/json");
    });

    $app->post("/rajzfilmek", function(Request $request, Response $response){
        $input = json_decode($request->getBody(), true);
        $rajzfilm = new Rajzfilm();
        $rajzfilm->setAttributes($input);
        $rajzfilm->uj();

        $kimenet = json_encode($rajzfilm);

        $response->getBody()->write($kimenet);

        return $response
            ->withStatus(201)
            ->withHeader("Content-type", "application/json");
    });
};