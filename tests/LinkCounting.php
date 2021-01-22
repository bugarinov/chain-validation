<?php
namespace Bugarinov\ChainValidation\Tests;

use Bugarinov\ChainValidation\AbstractLink;

/**
 * A simple link which will get the number of items
 * in an array, and add that number as an item to the array.
 */
class LinkCounting extends AbstractLink
{
    public function execute(?array $data): ?array
    {
        // Get the current count of data
        $count = count($data);

        // Add that number to the data
        $data[] = $count;

        return $this->executeNext($data);
    }
}