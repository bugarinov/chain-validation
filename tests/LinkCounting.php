<?php
namespace Bugarinov\ChainValidation\Tests;

use Bugarinov\ChainValidation\AbstractLink;

class LinkCounting extends AbstractLink
{
    public function execute(?array $data): ?array
    {
        $count = count($data);

        $data[] = $count;

        return $this->executeNext($data);
    }
}