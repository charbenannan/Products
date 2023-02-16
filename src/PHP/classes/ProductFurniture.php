<?php 
namespace classes;

use classes\Product;

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

?>