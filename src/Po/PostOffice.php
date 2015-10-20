<?php
namespace Po;

use Po\Entity\Item\ItemAbstract;
use Po\Entity\Item\Letter;
use Po\Entity\Item\Package;
use Po\Entity\Item\Wrapper;
use Po\Entity\Postman\Biker;
use Po\Entity\Postman\Driver;
use Po\Entity\Postman\Postman;

class PostOffice
{
    /** @var Postman */
    private $postman;
    /** @var Biker */
    private $biker;
    /** @var Driver */
    private $driver;
    /** @var ItemAbstract[] */
    private $itemsQueue = [];

    public function __construct(Postman $postman, Biker $biker, Driver $driver)
    {
        $this->postman = $postman;
        $this->biker = $biker;
        $this->driver = $driver;
    }

    public function startWorkDay()
    {
        $this->fillPostmen();
    }

    /**
     * @param ItemAbstract[] $items
     */
    public function pushItemsInQueue(array $items = [])
    {
        $this->checkItems($items);
        $this->itemsQueue = array_merge($this->itemsQueue, $items);
    }

    public function isEmptyItemsQueue()
    {
        return !count($this->itemsQueue);
    }

    public function getPostmen()
    {
        return [$this->postman, $this->biker, $this->driver];
    }

    private function checkItems(array $items)
    {
        foreach($items as $item) {
            if(!($item instanceof ItemAbstract)) {
                throw new \LogicException(
                    sprintf('Item must be an instance of ItemAbstract class. %s given.', get_class($item))
                );
            }
        }
    }

    private function fillPostmen()
    {
        foreach($this->itemsQueue as $index => $item) {
        	if($postman = $this->getFirstAvailablePostman($item->getType())){
               $postman->putItem($item);
        	   unset($this->itemsQueue[$index]);
        	}
        }
    }
    
    private function getFirstAvailablePostman($itemType){
    	foreach(array($this->postman, $this->biker, $this->driver) as $p){
    		if(!$p->isFull($itemType)){
    		    if(!$p->isFullByItemType($itemType)){
    		    	return $p;
    		    }
    		}
    	}
    	return false;
    }
}