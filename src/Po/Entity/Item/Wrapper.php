<?php
namespace Po\Entity\Item;

class Wrapper extends ItemAbstract
{
    const TYPE_ITEM = 'Wrapper';

    public function __construct($expirationDay)
    {
        parent::__construct(self::TYPE_ITEM, $expirationDay);
    }
}