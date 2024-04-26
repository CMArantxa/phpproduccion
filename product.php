<?php
class Product{
    public $idproduct;
    public $name;
    public $description;
    public $quantity;
    public $price;
    public function_construct($idproduct,$quantity)
    {
        $this->idproduct=$idproduct;
        $this->quantity=$quantity;
    }
}