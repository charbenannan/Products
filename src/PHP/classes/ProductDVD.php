<?php 
namespace classes;


 use  classes\Product;


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

?>