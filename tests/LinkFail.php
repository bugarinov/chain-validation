<?php
namespace Bugarinov\ChainValidation\Tests;

use Bugarinov\ChainValidation\AbstractLink;

class LinkFail extends AbstractLink
{
    public function execute(array $data): ?array
    {
        
        /**
         * Set the error message and return it if the validation
         * fails instead of calling the executeNext() method.
         * This will halt the chain execution and return a null data.
         * You can call the hasError() and getError() methods in the
         * Chain validation class to get the error info.
         */
        return $this->throwError('An error occured!');
    }
}