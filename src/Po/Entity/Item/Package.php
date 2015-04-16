<?php
namespace Po\Entity\Item;

class Package extends ItemAbstract
{
    const TYPE_ITEM = 'Package';

    public function __construct($expirationDay)
    {
        parent::__construct(self::TYPE_ITEM, $expirationDay);
    }
}