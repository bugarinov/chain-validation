<?php
namespace Bugarinov\ChainValidation\Tests\Classes;

use Bugarinov\ChainValidation\AbstractLink;
use Bugarinov\ChainValidation\EvaluationResult;
use Bugarinov\ChainValidation\ResultFailed;
use Bugarinov\ChainValidation\ResultSuccess;

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

        // Return a result failure if the count reached 4
        if ($count == 4) {
            return new ResultFailed('LIMIT REACHED!');
        }

        // Add the number to the data
        $data[] = $count;

        return new ResultSuccess($data);
    }
}