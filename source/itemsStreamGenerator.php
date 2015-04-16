<?php
require_once __DIR__ . '/../vendor/autoload.php';

$stream = [];

$itemTypes = [
    \Po\Factory\ItemFactory::LETTER_ITEM_TYPE,
    \Po\Factory\ItemFactory::WRAPPER_ITEM_TYPE,
    \Po\Factory\ItemFactory::PACKAGE_ITEM_TYPE,
];
$maxCount = 10;
$lifetimes = [1, 2, 2, 3, 3, 3, 4, 4, 5];

for($i=0; $i<366; $i++) {
    shuffle($itemTypes);
    $dayItems = [];

    for($j=0; $j<rand(1, count($itemTypes));$j++) {
        $currentItemType = $itemTypes[$j];
        $countItems = rand(1, $maxCount);
        shuffle($lifetimes);
        $lifetime = $lifetimes[0];
        $itemsString = "$currentItemType-$countItems-$lifetime";
        $dayItems[] = $itemsString;
    }

    $stream[] = $dayItems;
}

file_put_contents(__DIR__.'/stream_'.uniqid().'.php', '<?php return '.var_export($stream, true).';');