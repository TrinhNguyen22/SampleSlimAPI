<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '/../../app/vendor/autoload.php';

// Config setting
$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = true;

$config['db']['type'] = "sqlite";
$config['db']['file'] = '../../app/db/Pets.db';

// Create Slim app with config
$app = new \Slim\App(["settings" => $config]);

// Get DIC (Dependencies Injection Container)
$container = $app->getContainer();

$container['view'] = new \Slim\Views\PhpRenderer("../../templates/");

// Init Medoo
use Medoo\Medoo;

$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $md = new Medoo([
        'database_type' => $db['type'],
        'database_file' => $db['file']
    ]);

    return $md;
};

$app->get('/', function (Request $request, Response $response) {
    $libraryController = new PetsController($this->db);
    $result = $libraryController->getAll();
    return $response->withJson($result);
});

$app->get('/home', function (Request $request, Response $response) {
    $petsController = new PetsController($this->db);
    $pets = $petsController->getAll();

    $response = $this->view->render($response, "home.phtml", ["pets" => $pets, "router" => $this->router]);
    return $response;
});

$app->get('/pet/{_id}', function (Request $request, Response $response, $args) {
    $pet_id = (int)$args['_id'];
    $petsController = new PetsController($this->db);
    $p = $petsController->getPetById($pet_id);
    $response->getBody()->write(var_export($p, true));

//    $response = $this->view->render($response, "petdetail.phtml", ["p" => $p]);
    return $response->withJson($p);

})->setName('pet-detail');

$app->post('/pet/new', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $pet_data = [];
    $pet_data['name'] = filter_var($data['name'], FILTER_SANITIZE_STRING);
    $pet_data['species'] = filter_var($data['species'], FILTER_SANITIZE_STRING);
    $pet_data['favFoods'] = filter_var($data['favFoods'], FILTER_SANITIZE_STRING);
    $pet_data['birthYear'] = filter_var($data['birthYear'], FILTER_SANITIZE_NUMBER_INT);
    $pet_data['photo'] = filter_var($data['photo'], FILTER_SANITIZE_STRING);

    $pet = new Pets($pet_data);
    $petsController = new PetsController($this->db);
    $petsController->save($pet);
    $response = $response->withRedirect("/home");
    return $response;
//        ->WithJson($result);
});

$app->run();