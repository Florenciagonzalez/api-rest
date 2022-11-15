<?php

require_once 'libs/Router.php';
require_once 'app/controllers/products.controller.php';
require_once 'app/controllers/opinions.controller.php';
require_once 'app/controllers/api-controller.php';


$router = new Router();

$router->addRoute('products', 'GET', 'ProdController', 'getAll');
$router->addRoute('products/:ID', 'GET', 'ProdController', 'get');
$router->addRoute('opinions', 'GET', 'OpinionsController', 'getAll');
$router->addRoute('opinions/:ID', 'GET', 'OpinionsController', 'get');
$router->addRoute('opinions', 'POST', 'OpinionsController', 'add');
$router->addRoute('opinions/:ID', 'PUT', 'OpinionsController', 'update');
$router->addRoute('opinions/:ID', 'DELETE', 'OpinionsController', 'delete');


$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);

