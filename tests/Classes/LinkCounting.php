<?php
namespace Bugarinov\ChainValidation\Tests\Classes;

use Bugarinov\ChainValidation\AbstractLink;
use Bugarinov\ChainValidation\EvaluationResult;
use Bugarinov\ChainValidation\ResultSuccess;

/**
 * A simple link which will get the number of items
 * in an array, and add that number as an item to the array.
 */
class LinkCounting extends AbstractLink
{
    public function evaluate(?array $data): EvaluationResult
    {
        // Get the current count of data
        $count = count($data);

        // Add that number to the data
        $data[] = $count;

        return new ResultSuccess($data);
    }
}