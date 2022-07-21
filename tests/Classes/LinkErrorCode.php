<?php
namespace Bugarinov\ChainValidation\Tests\Classes;

use Bugarinov\ChainValidation\AbstractLink;
use Bugarinov\ChainValidation\EvaluationResult;
use Bugarinov\ChainValidation\ResultFailed;
use Bugarinov\ChainValidation\ResultSuccess;

class LinkErrorCode extends AbstractLink
{
    public function evaluate(?array $data): EvaluationResult
    {
        // Get the number of items
        // in the array
        $count = count($data);

        // Return a result failure if the count reached 4
        // Also return an error code
        if ($count == 4) {
            return new ResultFailed('ERROR WITH CODE!', 401);
        }

        // Add the number to the data
        $data[] = $count;

        return new ResultSuccess($data);
    }
}