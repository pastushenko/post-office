<?php
namespace Po\Factory;

use Po\Entity\Postman\Biker;
use Po\Entity\Postman\Driver;
use Po\Entity\Postman\Postman;
use Po\PostOffice;
use Po\World;

class WorldFactory
{
    public static function createWorld()
    {
        $itemFactory = new ItemFactory();

        $postman = new Postman();
        $biker = new Biker();
        $driver = new Driver();
        $postOffice = new PostOffice($postman, $biker, $driver);

        return new World($itemFactory, $postOffice);
    }
}