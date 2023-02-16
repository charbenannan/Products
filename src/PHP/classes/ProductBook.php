<?php 
namespace classes;


use classes\Product;
use classes\ProductFactory;





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

?>