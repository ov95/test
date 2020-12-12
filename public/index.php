<?php

use Engine\Database\OPdo;
use Engine\Router\Router;
use Engine\Router\Request;
use Models\Comment;
use Models\Product;
use Views\Shop;
use Views\Cms;

try {
    // Takes raw data from the request
    $json = file_get_contents('php://input');
    // Converts it into a PHP object
    $data = json_decode($json);


    // autoload all project classes
    include '../src/bootstrap.php';

    // Uncomment to auto generate table structure
    // $tableBuilder = new \Engine\Database\TableBuilder(new OPdo());
    // $tableBuilder->createTables();

    $router = new Router(new Request($data));

    $router->get('/', function () {
        $shopView = new Shop();
        echo $shopView->render();
    });

    $router->get('/admin', function () {
        $shopView = new Cms();
        echo $shopView->render();
    });

    $router->post('/post', function () {

        $post = new Product();
        $post->create();

        header('Content-Type: text/json');
        echo json_encode($post->getAll());
    });


    $router->post('/comment', function ($request) {

        $comment = new Comment(new OPdo());
        $comment->create($request->data);

        header('Content-Type: text/json');
        echo json_encode($comment->getAll());
    });

    $router->post('/comment/togle', function ($request) {
        $comment = new Comment(new OPdo());
        header('Content-Type: text/json');
        return json_encode($comment->togle($request->data->id));
    });
} catch (\Throwable $th) {
    echo $th->getMessage();
}

die();
