<?php 
namespace classes;

use PDO;
use classes\DbConnection;
use classes\Product;
use classes\ProductFactory;
use classes\ProductBook;
use classes\ProductDVD;
use classes\ProductFurniture;


class ProductController
{

    protected $conn;
    protected $product;

    public function __construct()
    {
        $dbObj = new DbConnection;
        $this->conn = $dbObj->connect();
        $this->path = explode('/', $_SERVER['REQUEST_URI']);
        $this->skus = strlen($this->path[2]) > 1 ? explode(',', $this->path[2]) : [$this->path[2]];
        
    }

    public function getAllProducts()
    {
        $sql = "SELECT * FROM products ORDER BY id";
        $statement = $this
            ->conn
            ->prepare($sql);
        $statement->execute();
        $product = $statement->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($product);
    }

    public function deleteProduct()
    {
        $quoted_skus = array_map(function ($value)
        {
            return "'" . $value . "'";
        }
        , $this->skus);
        $skus = implode(',', $quoted_skus);
        $sql = "DELETE FROM products WHERE sku IN ($skus)";
        $statement = $this
            ->conn
            ->prepare($sql);
        $statement->execute();
        var_dump($this->path);
        $response = ($statement->rowCount() > 0) ? ['status' => 1, 'message' => 'Product deleted successfully'] : ['status' => 0, 'message' => 'Failed to delete product'];
    }

    public function addProduct()
    {
        $data = json_decode(file_get_contents('php://input'));
        $factory = new ProductFactory();
        $this->product = $factory->createProduct($data->productType);

        $this
            ->product
            ->setSku($data->sku);
        $this
            ->product
            ->setProductType($data->productType);
        $this
            ->product
            ->setName($data->name);
        $this
            ->product
            ->setPrice($data->price);
        $this
            ->product
            ->setProductAttrib($data);

        $productAttrib = $this
            ->product
            ->getProductAttrib();

        $sql = "INSERT INTO products (sku, name, price, product_type, size, width, weight,  height,  length) VALUES (:sku,  :name, :price, :productType, :size,  :width,:weight,  :height,  :length)";

        $check_query = "SELECT * FROM products WHERE sku = :sku";
        $check_statement = $this
            ->conn
            ->prepare($check_query);
        $sku = $this
            ->product
            ->getSku();
        $check_statement->bindParam(':sku', $sku);
        $check_statement->execute();
        $count = $check_statement->rowCount();

        if ($count == 0)
        {
            $statement = $this
                ->conn
                ->prepare($sql);
            $sku = $this
                ->product
                ->getSku();
            $productType = $this
                ->product
                ->getProductType();
            $name = $this
                ->product
                ->getName();
            $price = $this
                ->product
                ->getPrice();

            $statement->bindParam(':sku', $sku);
            $statement->bindParam(':name', $name);
            $statement->bindParam(':price', $price);
            $statement->bindParam(':productType', $productType);
            $statement->bindParam(':size', $productAttrib['size']);
            $statement->bindParam(':width', $productAttrib['width']);
            $statement->bindParam(':weight', $productAttrib['weight']);
            $statement->bindParam(':height', $productAttrib['height']);
            $statement->bindParam(':length', $productAttrib['length']);

            $statement->execute();

            $response = ['status' => 1, 'message' => 'Product added successfully'];

            echo json_encode($response);
            exit;
        }
        else
        {
            $response = ['status' => 0, 'message' => 'This product has already been added'];
            echo json_encode($response);
        }

    }
}

?>