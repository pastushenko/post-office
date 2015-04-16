<?php
namespace Po\Factory;

use Po\Entity\Item\Letter;
use Po\Entity\Item\Package;
use Po\Entity\Item\Wrapper;

class ItemFactory
{
    const LETTER_ITEM_TYPE = 'l';
    const WRAPPER_ITEM_TYPE = 'w';
    const PACKAGE_ITEM_TYPE = 'p';

    public function deserializeItems($currentDay, array $itemStringList)
    {
        $items = [];
        foreach($itemStringList as $itemString) {
            $itemsOfType = $this->deserializeOneTypeItems($currentDay, $itemString);
            $items = array_merge($items, $itemsOfType);
        }
        return $items;
    }

    private function deserializeOneTypeItems($currentDay, $typeItemString)
    {
        list($type, $count, $lifetime) = explode('-', $typeItemString, 3);
        $item = $this->buildItem($type, $currentDay, $lifetime);

        $items = [];
        for($i=0; $i<$count; $i++) {
            $items[] = clone $item;
        }

        return $items;
    }

    private function buildItem($type, $currentDay, $lifetime)
    {
        $expirationDay = $currentDay + $lifetime - 1;
        switch($type) {
            case self::LETTER_ITEM_TYPE:
                return new Letter($expirationDay);
            case self::WRAPPER_ITEM_TYPE:
                return new Wrapper($expirationDay);
            case self::PACKAGE_ITEM_TYPE:
                return new Package($expirationDay);
            default:
                throw new \LogicException(sprintf(
                    'Incorrect type of item "%s". Available types: "%s".',
                    $type,
                    implode('", "', [self::LETTER_ITEM_TYPE, self::WRAPPER_ITEM_TYPE, self::PACKAGE_ITEM_TYPE])
                ));
        }
    }
}