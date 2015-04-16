<?php
namespace Po\Entity\Item;

abstract class ItemAbstract
{
    /** @var int Index of day */
    private $expirationDay;
    /** @var string type of item */
    private $type;

    public function __construct($type, $expirationDay)
    {
        $this->type = $type;
        $this->expirationDay = $expirationDay;
    }

    public function getExpirationDay()
    {
        return $this->expirationDay;
    }

    public function getType()
    {
        return $this->type;
    }
}