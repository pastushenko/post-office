<?php
namespace Po\Entity\Item;

class Letter extends ItemAbstract
{
    const TYPE_ITEM = 'Letter';

    public function __construct($expirationDay)
    {
        parent::__construct(self::TYPE_ITEM, $expirationDay);
    }
}