<?php
namespace Bugarinov\ChainValidation\Tests;

use Bugarinov\ChainValidation\AbstractLink;

class LinkCountingHalt extends AbstractLink
{
    public function execute(array $data): ?array
    {
        $count = count($data);

        if ($count == 4) {
            return $this->throwError('LIMIT REACHED!');
        }

        $data[] = $count;

        return $this->executeNext($data);
    }
}