<?php 
namespace classes;

use classes\Product;
use classes\ProductController;
use classes\ProductBook;
use classes\ProductDVD;
use classes\ProductFurniture;


class ProductFactory
{

    private $productMap = ['Book' => ProductBook::class , 'DVD' => ProductDVD::class , 'Furniture' => ProductFurniture::class];

    public function createProduct($productType)
    {
        if (!isset($this->productMap[$productType]))
        {
            throw new Exception('Invalid product type');
        }

        $class = $this->productMap[$productType];
        return new $class();
    }
}

?>