<?php
namespace Po\Entity\Postman;

class Biker extends PostmanAbstract
{
    public function __construct()
    {
        parent::__construct(2, 3, 1);
    }
}