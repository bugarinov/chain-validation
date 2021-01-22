<?php
namespace Bugarinov\ChainValidation\Tests;

use Bugarinov\ChainValidation\AbstractLink;

class LinkSuccess extends AbstractLink
{
    public function execute(?array $data): ?array
    {
        /**
         * Do some data validations here.
         * You can alter the data depending on your condition.
         * Links are primarily used for complex validations but
         * can also be used to alter/mutate data depending on
         * the requirement. This will be handling the
         * business logic of the app.
         * 
         * Call the execute next function and pass the data through
         * it if all the validations succeed
         */

        return $this->executeNext($data);
    }
}