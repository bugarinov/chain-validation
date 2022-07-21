<?php
namespace Bugarinov\ChainValidation\Tests\Classes;

use Bugarinov\ChainValidation\AbstractLink;
use Bugarinov\ChainValidation\EvaluationResult;

class LinkErrorCode extends AbstractLink
{
    public function evaluate(?array $data): EvaluationResult
    {
        // Get the number of items
        // in the array
        $count = count($data);

        // Throw an error message and error code. 
        // Also halt the execution of the chain if
        // the count reached 4
        if ($count == 4) {
            return new EvaluationResult(null, 'ERROR WITH CODE!', 401);
        }

        // Add the number to the data
        $data[] = $count;

        return new EvaluationResult($data);
    }
}