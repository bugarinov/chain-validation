<?php
namespace Bugarinov\ChainValidation\Tests;

use Bugarinov\ChainValidation\AbstractLink;

class LinkErrorCode extends AbstractLink
{
    public function execute(?array $data): ?array
    {
        // Get the number of items
        // in the array
        $count = count($data);

        // Throw an error message and error code. 
        // Also halt the execution of the chain if
        // the count reached 4
        if ($count == 4) {
            return $this->throwError('ERROR WITH CODE!', 401);
        }

        // Add the number to the data
        $data[] = $count;

        return $this->executeNext($data);
    }
}