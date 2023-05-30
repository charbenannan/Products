<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");

require_once 'autoload.php';

$method = $_SERVER['REQUEST_METHOD'];

$routes = [
    'POST' => 'addProduct',
    'GET' => 'getAllProducts',
    'DELETE' => 'deleteProduct',
];

$action = $routes[$method] ?? null;

$productController = new ProductController();

$method = new ReflectionMethod($productController, $action);
$method->invoke($productController);
?>
