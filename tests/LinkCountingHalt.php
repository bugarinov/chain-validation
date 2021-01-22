<?php
namespace Bugarinov\ChainValidation\Tests;

use Bugarinov\ChainValidation\AbstractLink;


/**
 * A link that will automatically halt the execution of
 * the chain once the number of items reached 4
 */
class LinkCountingHalt extends AbstractLink
{
    public function execute(?array $data): ?array
    {
        // Get the number of items
        // in the array
        $count = count($data);

        // Throw an error and halt the execution
        // of the chain if the count reached 4
        if ($count == 4) {
            return $this->throwError('LIMIT REACHED!');
        }

        // Add the number to the data
        $data[] = $count;

        return $this->executeNext($data);
    }
}