<?php
namespace Po;

use Po\Entity\Postman\PostmanAbstract;
use Po\Factory\ItemFactory;

class World
{
    /** @var ItemFactory */
    private $itemFactory;
    /** @var PostOffice */
    private $postOffice;

    /** @var int total of overdue days */
    private $totalDiscontentIndex;
    /** @var int */
    private $currentDay;
    /** @var int */
    private $itemsInCount;
    /** @var int */
    private $itemsOutCount;

    public function __construct(ItemFactory $itemFactory, PostOffice $postOffice)
    {
        $this->itemFactory = $itemFactory;
        $this->postOffice = $postOffice;
    }

    public function getCurrentDay()
    {
        return $this->currentDay;
    }

    public function getTotalDiscontent()
    {
        return $this->totalDiscontentIndex;
    }

    public function getItemsInCount()
    {
        return $this->itemsInCount;
    }

    public function getItemsOutCount()
    {
        return $this->itemsOutCount;
    }

    /**
     * @param array $dailyItemsStream Format [numberDay][] => serialized item (type-count-lifetime, for example l-10-3 => 10 letters with lifetime = 3 days)
     * @return int
     */
    public function run(array $dailyItemsStream)
    {
        $this->clearWorld();

        $this->deliverStreamItems($dailyItemsStream);
        $this->deliverRemainderItems();
    }

    private function deliverStreamItems($dailyItemsStream)
    {
        foreach($dailyItemsStream as $serializedItems) {
            $this->startNewDay();
            $this->supplyItemsInPostOffice($serializedItems);
            $this->startWorkDay();
            $this->deliverItemsByFullPostmen();
        }
    }

    private function deliverRemainderItems()
    {
        while(!$this->isAllItemsProcessed()) {
            $this->startNewDay();
            $this->startWorkDay();

            if($this->isAllItemsProcessed())  {
                $this->deliverItemsByAllPostmen();
                break;
            }

            $this->deliverItemsByFullPostmen();
        }
    }

    private function clearWorld()
    {
        $this->totalDiscontentIndex = 0;
        $this->currentDay = 0;
        $this->itemsInCount = 0;
        $this->itemsOutCount = 0;
    }

    private function startNewDay()
    {
        $this->currentDay++;
    }

    private function supplyItemsInPostOffice(array $serializedItems)
    {
        $items = $this->itemFactory->deserializeItems($this->currentDay, $serializedItems);
        $this->postOffice->pushItemsInQueue($items);
        $this->itemsInCount += count($items);
    }

    private function startWorkDay()
    {
        $this->postOffice->startWorkDay();
    }

    private function isAllItemsProcessed()
    {
        return $this->postOffice->isEmptyItemsQueue();
    }

    private function deliverItemsByFullPostmen()
    {
        $fullPostmen = $this->getFullPostmen();
        $this->deliverItemAndCalculateDiscontentOfUsers($fullPostmen);
    }

    private function deliverItemsByAllPostmen()
    {
        $postmen = $this->getAllPostmen();
        $this->deliverItemAndCalculateDiscontentOfUsers($postmen);
    }

    private function getFullPostmen()
    {
        $fullPostmen = [];
        /** @var PostmanAbstract $postman */
        foreach ($this->getAllPostmen() as $postman) {
            if($postman->isFull()) {
                $fullPostmen[] = $postman;
            }
        }

        return $fullPostmen;
    }

    private function getAllPostmen()
    {
        return $this->postOffice->getPostmen();
    }

    /**
     * @param PostmanAbstract[] $postmen
     */
    private function deliverItemAndCalculateDiscontentOfUsers(array $postmen)
    {
        foreach($postmen as $postman) {
            $items = $postman->unloadAllItems();
            foreach($items as $item) {
                $discontentIndex = $this->getCurrentDay() - $item->getExpirationDay();
                if($discontentIndex > 0) {
                    $this->totalDiscontentIndex += $discontentIndex;
                }
            }
            $this->itemsOutCount += count($items);
        }
    }
}