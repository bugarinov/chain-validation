<?php
namespace Bugarinov\ChainValidation\Tests\Classes;

use Bugarinov\ChainValidation\AbstractLink;
use Bugarinov\ChainValidation\EvaluationResult;

/**
 * A link that will automatically halt the execution of
 * the chain once the number of items reached 4
 */
class LinkCountingHalt extends AbstractLink
{
    public function evaluate(?array $data): EvaluationResult
    {
        // Get the number of items
        // in the array
        $count = count($data);

        // Throw an error and halt the execution
        // of the chain if the count reached 4
        if ($count == 4) {
            return new EvaluationResult(null, 'LIMIT REACHED!');
        }

        // Add the number to the data
        $data[] = $count;

        return new EvaluationResult($data);
    }
}