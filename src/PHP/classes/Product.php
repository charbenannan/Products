<?php 
namespace classes;

use  classes\DbConnection;


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

?>