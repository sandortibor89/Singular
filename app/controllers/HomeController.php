<?php
namespace app\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class HomeController extends Controller {

    public function index(Request $request, Response $response, array $args) {
        $response->getBody()->write('Hello World');
        return $response;
    }

}
?>