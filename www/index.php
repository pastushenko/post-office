<?php
ini_set('display_errors', true);
ini_set('display_startup_errors', true);
ini_set('date.timezone', 'UTC');
date_default_timezone_set('UTC');

require_once __DIR__ . '/../vendor/autoload.php';

$dailyItemsStream = include '../source/itemsStream.php';

$world = \Po\Factory\WorldFactory::createWorld();
$world->run($dailyItemsStream);

echo sprintf('Total discontent index: %d.<br/>', $world->getTotalDiscontent());
echo sprintf('Total days: %d.<br/>', $world->getCurrentDay());
//echo sprintf('Items in: %d.<br/>', $world->getItemsInCount());
//echo sprintf('Items out: %d.<br/>', $world->getItemsOutCount());