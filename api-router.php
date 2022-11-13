<?php

require_once 'libs/Router.php';
require_once 'app/controllers/products.controller.php';
require_once 'app/controllers/opinions.controller.php';
require_once 'app/controllers/api-controller.php';


define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/');
define('PRODUCTS', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/products');

$router = new Router();

$router->addRoute('products', 'GET', 'ProdController', 'getAll');
$router->addRoute('products/opinions', 'GET', 'OpinionsController', 'getAll');
$router->addRoute('products/:ID/opinions', 'GET', 'OpinionsController', 'getAllFor');
$router->addRoute('products/:ID/opinions/:IDOpinion', 'GET', 'OpinionsController', 'get');
$router->addRoute('products/opinions/:ID', 'GET', 'OpinionsController', 'get');
$router->addRoute('products/opinions', 'POST', 'OpinionsController', 'add');
$router->addRoute('products/opinions/:ID', 'PUT', 'OpinionsController', 'update');
$router->addRoute('products/opinions/:IDOpinion', 'DELETE', 'OpinionsController', 'delete');
$router->addRoute('products/:ID/opinions/:IDOpinion', 'DELETE', 'OpinionsController', 'delete');

$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);

