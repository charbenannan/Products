<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");

require_once 'autoload.php';

use classes\ProductController;

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $productController = new ProductController();
        $productController->addProduct();
        break;
    case 'GET':
        $productController = new ProductController();
        $productController->getAllProducts();
        break;
    case 'DELETE':
        $productController = new ProductController();
        $productController->deleteProduct();
        break;
    default:
        $response = ['status' => 0, 'message' => 'Invalid request method'];
        echo json_encode($response);
        break;
}

?>