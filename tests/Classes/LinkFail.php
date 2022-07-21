<?php
namespace Bugarinov\ChainValidation\Tests\Classes;

use Bugarinov\ChainValidation\AbstractLink;
use Bugarinov\ChainValidation\EvaluationResult;

class LinkFail extends AbstractLink
{
    public function evaluate(?array $data): EvaluationResult
    {
        /**
         * Set the EvaluationResult as stated below when an error occured.
         * You need to set the errorMessage OR errorCode in order to specify
         * that there is an error on this specific link.
         * 
         * This will halt the chain execution and return a null data.
         * You can call the hasError() and getError() methods in the
         * Chain validation class to get the error info.
         */

        return new EvaluationResult(null, 'error', 400);
    }
}