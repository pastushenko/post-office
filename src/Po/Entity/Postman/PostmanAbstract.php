<?php
namespace Po\Entity\Postman;

use Po\Entity\Item\ItemAbstract;
use Po\Entity\Item\Letter;
use Po\Entity\Item\Package;
use Po\Entity\Item\Wrapper;

abstract class PostmanAbstract
{
    private $itemLimit;

    private $letterLimit;
    private $wrapperLimit;
    private $packageLimit;

    private $letters = [];
    private $wrappers = [];
    private $packages = [];

    public function __construct($letterLimit, $wrapperLimit, $packageLimit, $itemLimit = 3)
    {
        $this->letterLimit = $letterLimit;
        $this->wrapperLimit = $wrapperLimit;
        $this->packageLimit = $packageLimit;

        $this->itemLimit = $itemLimit;
    }

    public function putItem(ItemAbstract $item)
    {
        switch($item->getType()) {
            case Letter::TYPE_ITEM:
                /** @var Letter $item */
                $this->putLetter($item);
                break;
            case Wrapper::TYPE_ITEM:
                /** @var Wrapper $item */
                $this->putWrapper($item);
                break;
            case Package::TYPE_ITEM:
                /** @var Package $item */
                $this->putPackage($item);
                break;
            default:
                throw new \LogicException(
                    sprintf(
                        'Type "%s" not supported. Available types: "%s".',
                        $item->getType(),
                        implode('", "', [Letter::TYPE_ITEM, Wrapper::TYPE_ITEM, Package::TYPE_ITEM])
                    )
                );
        }
    }

    public function putLetter(Letter $letter)
    {
        $this->checkItemTypeLimit(count($this->letters), $this->letterLimit, $letter->getType());
        $this->checkItemTotalLimit();

        $this->letters[] = $letter;
    }

    public function putWrapper(Wrapper $wrapper)
    {
        $this->checkItemTypeLimit(count($this->wrappers), $this->wrapperLimit, $wrapper->getType());
        $this->checkItemTotalLimit();

        $this->wrappers[] = $wrapper;
    }

    public function putPackage(Package $package)
    {
        $this->checkItemTypeLimit(count($this->packages), $this->packageLimit, $package->getType());
        $this->checkItemTotalLimit();

        $this->packages[] = $package;
    }

    public function unloadAllItems()
    {
        $allItems = $this->getAllItems();
        $this->clearAllItems();

        return $allItems;
    }

    public function isFull($itemType = false)
    {
        return ($this->getCountItems() == $this->itemLimit); 
    }

    public function isFullByItemType($itemType = false)
    {
    	switch ($itemType) {
    		case Letter::TYPE_ITEM:
    			if($this->letterLimit >= (count($this->letters) + 1)){
    				return false;
    			}
    			break;
    		case Wrapper::TYPE_ITEM:
    			if($this->wrapperLimit >= (count($this->wrappers) + 1)){
    				return false;
    			}
    			break;
    		case Package::TYPE_ITEM:
    			if($this->packageLimit >= (count($this->packages) + 1)){
    				return false;
    			}
    			break;
    	}
    	return true;
    }
    
    
    public function getCountItems()
    {
        return count($this->getAllItems());
    }

    /**
     * @return ItemAbstract[]
     */
    private function getAllItems()
    {
        return array_merge($this->letters, $this->wrappers, $this->packages);
    }

    private function clearAllItems()
    {
        $this->letters = [];
        $this->wrappers = [];
        $this->packages = [];
    }

    private function checkItemTypeLimit($countItems, $limit, $type)
    {
        if($countItems == $limit) {
            throw new \LogicException(
                sprintf(
                    'Postman can transfer only %s item(s) of type "%s". He already has %s item(s).',
                    $limit,
                    $type,
                    $countItems
                )
            );
        }
    }

    private function checkItemTotalLimit()
    {
        if($this->getCountItems() == $this->itemLimit) {
            throw new \LogicException('Postman can transfer only %s items.');
        }
    }
}