<?php

use Slim\Http\Request;
use Slim\Http\Response;

class RouteSection
{
    public static function route($app)
    {
        $app->get('/{id}', function (Request $request, Response $response, array $args) {
            $db = new DbConnection();
            return $response->withJson($db->sectionRepository->get($args['id']));
        });

        $app->get('', function (Request $request, Response $response, array $args) {
            $search = $request->getParam('search');
            $db = new DbConnection();
            return $response->withJson($db->sectionRepository->find($search));
        });

        $app->put('/{id}', function (Request $request, Response $response, array $args){
            $id = $args['id'];
            $section = $request->getParsedBody();
            $section = Section::getFromJson($section);
            $db = new DbConnection();

            $db->sectionRepository->update($id, $section);

            return $response->withJson($db->sectionRepository->get($id));
        });

        $app->post('', function (Request $request, Response $response, array $args){

        });

        $app->delete('/{id}', function(Request $request, Response $response, array $args){
            $id = $request->getParam('id');
            $db = new DbConnection();
            $db->sectionRepository->delete($id);

            return $response->withStatus(200);
        });
    }}
