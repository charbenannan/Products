<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE");

include 'DbConnection.php';

abstract class Product
{
    protected $conn;
    protected $sku;
    protected $productType;
    protected $name;
    protected $price;
    abstract protected function setProductAttrib($data);
    abstract protected function getProductAttrib();

    public function __construct()
    {
        $dbObj = new DbConnection;
        $this->conn = $dbObj->connect();

    }
    public function getConn()
    {
        return $this->conn;
    }

    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    public function setProductType($productType)
    {
        $this->productType = $productType;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function getProductType()
    {
        return $this->productType;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }
}

class ProductBook extends Product
{
    protected $weight;

    public function setProductAttrib($data)
    {
        $this->setWeight($data->weight);
    }

    public function getProductAttrib()
    {
        return array(
            'weight' => $this->weight
        );
    }
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    public function getWeight()
    {
        return $this->weight;
    }
}

class ProductDVD extends Product
{
    protected $size;

    public function setProductAttrib($data)
    {
        $this->setSize($data->size);
    }

    public function getProductAttrib()
    {
        return array(
            'size' => $this->size
        );
    }
    public function setSize($size)
    {
        $this->size = $size;
    }

    public function getSize()
    {
        return $this->size;
    }
}

class ProductFurniture extends Product
{
    protected $height;
    protected $width;
    protected $length;

    public function setProductAttrib($data)
    {
        $this->setHeight($data->height);
        $this->setWidth($data->width);
        $this->setLength($data->length);
    }

    public function getProductAttrib()
    {
        return array(
            'height' => $this->height,
            'width' => $this->width,
            'length' => $this->length
        );
    }
    public function setHeight($height)
    {
        $this->height = $height;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function setLength($length)
    {
        $this->length = $length;
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function getProductType()
    {
        return $this->productType;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function getLength()
    {
        return $this->length;
    }
}

class ProductFactory
{

    private $productMap = ['Book' => ProductBook::class , 'DVD' => ProductDVD::class , 'Furniture' => ProductFurniture::class , ];

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

switch ($_SERVER['REQUEST_METHOD'])
{

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
