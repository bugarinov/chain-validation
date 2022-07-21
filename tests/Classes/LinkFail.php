<?php
namespace Bugarinov\ChainValidation\Tests\Classes;

use Bugarinov\ChainValidation\AbstractLink;
use Bugarinov\ChainValidation\EvaluationResult;
use Bugarinov\ChainValidation\ResultFailed;

class LinkFail extends AbstractLink
{
    public function evaluate(?array $data): EvaluationResult
    {
        /**
         * A link that always return a failed result.
         * You need to set the errorMessage OR errorCode in order to 'mark'
         * this specific link as 'hasError'.
         * 
         * This will halt the chain execution and return a null data.
         * You can call the hasError() and getError() methods in the
         * ChainValidation class to get the error info.
         */

        return new ResultFailed('error', 400);
    }
}